<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;


class UniformController extends Controller
{
    public function store() {
        $sanphams = DB::table('sanpham')
            ->get();
        return view('user.uniforms.store', compact('sanphams'));
    }

    public function showDetail($sp_id)
    {
        $ct_sp = DB::table('sanpham as sp')
            ->leftJoin('danhmuc', 'sp.dm_id', '=', 'danhmuc.dm_id')
            ->leftJoin('nhasanxuat', 'sp.nsx_id', '=', 'nhasanxuat.nsx_id')
            ->leftJoin('kho', 'kho.sp_id', '=', 'sp.sp_id')
            ->leftJoin('size', 'size.size_id', '=', 'kho.size_id')
            ->leftJoin('danhgia', 'danhgia.kho_id', '=', 'kho.kho_id')
            ->leftJoin('users', 'users.user_id', '=', 'danhgia.user_id')
            ->where('sp.sp_id', $sp_id)
            ->select(
                'sp.*', 
                'danhmuc.ten as ten_danhmuc', 
                'nhasanxuat.ten as ten_nsx', 
                'kho.tonkho', 
                'size.ten as ten_size',
                'users.username as username',
                'danhgia.created_at as created_at',
                
            )
            ->first();

        if (!$ct_sp) {
            abort(404, 'Không tìm thấy sản phẩm');
        }
        $sanphams = DB::table('sanpham')->get();

        $sizes = DB::table('size')->get();

        $danhgias = DB::table('danhgia as dg')
            ->leftJoin('kho', 'kho.kho_id', '=', 'dg.kho_id')
            ->where('sp_id', $sp_id)
            ->get();

        return view('user.uniforms.show_detail', compact('ct_sp', 'sizes', 'danhgias','sanphams'));
    }

    public function addSP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sp_id' => 'required|exists:sanpham,sp_id',
            'soluong' => 'required|integer|min:1',
            'size_id' => 'required|integer|exists:size,size_id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            DB::beginTransaction();

            if (Auth::check()) {
                $user_id = Auth::user()->user_id;
            } else {
                return redirect()->route('login');
            }

            // Kiểm tra sản phẩm đã tồn tại trong giỏ chưa (cùng size)
            $exists = DB::table('giohang')
                ->where('user_id', $user_id)
                ->where('sp_id', $request->sp_id)
                ->where('size_id', $request->size_id)
                ->first();

            if ($exists) {
                DB::table('giohang')
                    ->where('gh_id', $exists->gh_id)
                    ->increment('soluong', $request->soluong);
                DB::commit();
                return response("1", 200); // thành công
            } 

            $maxId = DB::table('giohang')->max('gh_id');
            $newId = $maxId + 1;
            $result = DB::table('giohang')
                ->insert([
                    'gh_id' => $newId,
                    'user_id' => $user_id,
                    'sp_id' => $request->sp_id,
                    'size_id' => $request->size_id,
                    'soluong' => $request->soluong,
                    'created_at' => now(),
                ]);

            if ($result == 1) {
                DB::commit();
                return response("1", 200); // thành công
            } else {
                DB::rollBack();
                return response("0", 200); // không tìm thấy sản phẩm
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // return response("-1", 500);
            return response("-1", 500);
        }
    }

    public function filter(Request $request)
    {
        $query = DB::table('sanpham')
            ->leftJoin('kho', 'sanpham.sp_id', '=', 'kho.sp_id')
            ->leftJoin('size', 'kho.size_id', '=', 'size.size_id')
            ->leftJoin('danhmuc', 'sanpham.dm_id', '=', 'danhmuc.dm_id')
            ->select('sanpham.*', 'size.ten as size', 'danhmuc.ten as danhmuc');

        // Lọc theo danh mục
        if ($request->filled('danhmuc') && $request->danhmuc != 0) {
            $query->where('sanpham.dm_id', $request->danhmuc);
        }

        // Lọc theo nsx
        if ($request->filled('nsx_id') && $request->nsx_id != 0) {
            $query->where('sanpham.nsx_id', $request->nsx_id);
        }

        // Lọc theo giá
        if ($request->gia === '2') {
            $query->orderBy('sanpham.gia', 'asc');
        } elseif ($request->gia === '1') {
            $query->orderBy('sanpham.gia', 'desc');
        }

        // Sắp xếp theo "sort"
        if ($request->sort === 'moi-nhat') {
            $query->orderBy('sanpham.created_at', 'desc');
        // } elseif ($request->sort === 'pho-bien') {
        //     $query->leftJoin('danhgia', 'danhgia.kho_id', '=', 'kho.kho_id')
        //   ->select(
        //       'sanpham.sp_id',
        //       'sanpham.tensp',
        //       'sanpham.gia',
        //       'sanpham.image_url',
        //       'sanpham.mota',
        //       'sanpham.updated_at',
        //       'size.ten as size',
        //       'danhmuc.ten as danhmuc',
        //       DB::raw('COUNT(danhgia.id) as rating_count')
        //   )
        //   ->groupBy(
        //       'sanpham.sp_id',
        //       'sanpham.tensp',
        //       'sanpham.gia',
        //       'sanpham.image_url',
        //       'sanpham.mota',
        //       'sanpham.updated_at',
        //       'size.ten',
        //       'danhmuc.ten'
        //   )
        //   ->orderByDesc('rating_count');

        } elseif ($request->sort === 'ban-chay') {
            $query = DB::table('sanpham')
        ->leftJoin('chitiethoadon', 'chitiethoadon.sp_id', '=', 'sanpham.sp_id')
        ->leftJoin('kho', 'sanpham.sp_id', '=', 'kho.sp_id')
        ->leftJoin('size', 'kho.size_id', '=', 'size.size_id')
        ->leftJoin('danhmuc', 'sanpham.dm_id', '=', 'danhmuc.dm_id')
        ->select(
            'sanpham.sp_id',
            'sanpham.tensp',
            'sanpham.gia',
            'sanpham.image_url',
            'sanpham.mota',
            'sanpham.updated_at',
            'size.ten as size',
            'danhmuc.ten as danhmuc',
            DB::raw('SUM(chitiethoadon.soluong) as total_sold')
        )
        ->groupBy(
            'sanpham.sp_id',
            'sanpham.tensp',
            'sanpham.gia',
            'sanpham.image_url',
            'sanpham.mota',
            'sanpham.updated_at',
            'size.ten',
            'danhmuc.ten'
        )
        ->orderByDesc('total_sold');

        }

        $sanphams = $query->distinct()->get();

        return view('user.uniforms.store', compact('sanphams'));
    }
}