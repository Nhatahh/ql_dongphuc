<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use App\Models\Sanpham;


class UniformController extends Controller
{
    public function store() {
        $sanphams = Sanpham::withSum('chitiethoadon as so_luong_da_ban', 'soluong')
            ->orderByDesc('so_luong_da_ban')
            ->limit(8) // số lượng muốn gợi ý
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
            ->leftJoin('danhgia', 'danhgia.sp_id', '=', 'sp.sp_id')
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

        $danhgias = DB::table('danhgia')
        ->join('users', 'danhgia.user_id', '=', 'users.user_id')
        ->where('danhgia.sp_id', $sp_id)
        ->select('danhgia.*', 'users.hoten as user_name', 'users.avt_url as avt_url')
        ->orderByDesc('danhgia.created_at')
        ->paginate(5);

        return view('user.uniforms.show_detail', compact('ct_sp', 'sizes', 'sanphams', 'sp_id', 'danhgias'));
    }

    // Thêm sản phẩm
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
            return response("-1", 500);
        }
    }

    public function filter(Request $request)
    {
        $query = DB::table('sanpham')
            ->leftJoin('kho', 'sanpham.sp_id', '=', 'kho.sp_id')
            ->leftJoin('size', 'kho.size_id', '=', 'size.size_id')
            ->leftJoin('danhmuc', 'sanpham.dm_id', '=', 'danhmuc.dm_id')
            ->leftJoin(DB::raw('(SELECT sp_id, SUM(soluong) AS so_luong_da_ban FROM chitiethoadon GROUP BY sp_id) AS ban'), function ($join) {
                $join->on('sanpham.sp_id', '=', 'ban.sp_id');
            })
            ->leftJoin(DB::raw('(SELECT sp_id, COUNT(*) AS rating_count, AVG(rating) AS avg_rating FROM danhgia GROUP BY sp_id) AS dg'), function ($join) {
                $join->on('sanpham.sp_id', '=', 'dg.sp_id');
            })
            ->select(
                'sanpham.sp_id',
                'sanpham.tensp',
                'sanpham.gia',
                'sanpham.image_url',
                'sanpham.mota',
                'sanpham.created_at',
                'sanpham.updated_at',
                DB::raw('MAX(size.ten) as size'),
                DB::raw('MAX(danhmuc.ten) as danhmuc'),
                DB::raw('IFNULL(MAX(ban.so_luong_da_ban), 0) as so_luong_da_ban'),
                DB::raw('IFNULL(MAX(dg.rating_count), 0) as rating_count'),
                DB::raw('IFNULL(MAX(dg.avg_rating), 0) as avg_rating')
            )
            ->groupBy(
                'sanpham.sp_id',
                'sanpham.tensp',
                'sanpham.gia',
                'sanpham.image_url',
                'sanpham.mota',
                'sanpham.created_at',
                'sanpham.updated_at'
            )
            ->orderBy('sanpham.created_at', 'desc');
            // ->get();

                // Lọc theo danh mục
        if ($request->filled('danhmuc') && $request->danhmuc != 0) {
            $query->where('sanpham.dm_id', $request->danhmuc);
        }

        // Lọc theo NSX
        if ($request->filled('nsx_id') && $request->nsx_id != 0) {
            $query->where('sanpham.nsx_id', $request->nsx_id);
        }

        // Sắp xếp theo giá
        if ($request->gia === '1') {
            $query->orderBy('sanpham.gia', 'desc');
        } elseif ($request->gia === '2') {
            $query->orderBy('sanpham.gia', 'asc');
        }

        // Sắp xếp theo loại
        if ($request->sort === 'moi-nhat') {
            $query->orderBy('sanpham.created_at', 'desc');
        } elseif ($request->sort === 'ban-chay') {
            $query->orderByDesc('so_luong_da_ban');
        } elseif ($request->sort === 'pho-bien') {
            $query->orderByDesc('rating_count');
        }

        $sanphams = $query->get();

        return view('user.uniforms.store', compact('sanphams'));
    }

    public function muaLai($hd_id)
    {
        try {
            $user_id = Auth::id();

            if (!$user_id) {
                return response()->json(['success' => false, 'error' => 'Chưa đăng nhập'], 401);
            }

            $sanphams = DB::table('chitiethoadon')
                ->where('hd_id', $hd_id)
                ->get();

            if ($sanphams->isEmpty()) {
                return response()->json(['success' => false, 'error' => 'Không tìm thấy sản phẩm trong hóa đơn'], 404);
            }

            foreach ($sanphams as $sp) {
                $gio = DB::table('giohang')
                    ->where('user_id', $user_id)
                    ->where('sp_id', $sp->sp_id)
                    ->first();

                if ($gio) {
                    DB::table('giohang')
                        ->where('id', $gio->id)
                        ->update(['soluong' => $gio->soluong + $sp->soluong]);
                } else {
                    $maxId = DB::table('giohang')->max('gh_id');
                $newId = $maxId + 1;
                $result = DB::table('giohang')
                    ->insert([
                        'gh_id' => $newId,
                        'user_id' => $user_id,
                        'sp_id' => $sp->sp_id,
                        'size_id' => $sp->size_id,
                        'soluong' => $sp->soluong,
                        'created_at' => now(),
                    ]);
                }
            }

            return response()->json(['success' => true]);

        }catch (\Exception $e) {
                DB::rollBack();
                return response("-1", 500);
            }
        // catch (\Exception $e) {
        //     // Ghi log lỗi chi tiết
        //     \Log::error('Lỗi khi mua lại: ' . $e->getMessage());
        //     return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        // }
    }
}