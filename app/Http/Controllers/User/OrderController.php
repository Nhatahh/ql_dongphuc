<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class OrderController extends Controller
{
    public function cart() {
        if (Auth::check()) {
            $user_id = Auth::user()->user_id;
        } else {
            return redirect()->route('login');
        }
        // $user_id = Auth::user()->user_id; 
        $cartItems = DB::table('giohang as gh')
                    ->join('sanpham', 'sanpham.sp_id', '=', 'gh.sp_id')
                    ->join('users', 'users.user_id', '=', 'gh.user_id')
                    ->join('kho', 'sanpham.kho_id', '=', 'kho.kho_id')
                    ->join('size', 'gh.size_id', '=', 'size.size_id')
                    ->where('gh.user_id', $user_id)
                    ->select(
                        'gh.*',
                        'sanpham.tensp as tensp',
                        'sanpham.sp_id as sp_id',
                        'sanpham.gia',
                        'sanpham.image_url',
                        'size.ten as tensize',
                        'kho.kho_id as kho_id',                        
                    )
                    ->get();

        return view('user.orders.cart', compact('cartItems'));
    }

    public function getSizes(Request $request)
    {
        $ghId = $request->input('gh_id');

        $cartSize = DB::table('giohang')
            ->join('size', 'giohang.size_id', '=', 'size.size_id')
            ->where('giohang.gh_id', $ghId)
            ->select('giohang.size_id as id', 'size.ten as text')
            ->first();
    
        if (!$cartSize) {
            return response()->json([]);
        }
        return response()->json([$cartSize]);
    }

    // Cập nhật số lượng sản phẩm
    public function updateQuantity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gh_id' => 'required|integer|exists:giohang,gh_id',
            'soluong' => 'required|integer|min:1',
            'size_id' => 'required|integer|exists:size,size_id', // validate size_id
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        try {
            DB::beginTransaction();

            $giohang = DB::table('giohang')->where('gh_id', $request->gh_id)->first();

            if (!$giohang) {
                DB::rollBack();
                return response("0", 200); // không tồn tại
            }

            $user_id = $giohang->user_id;
            $sp_id = $giohang->sp_id;

            // Kiểm tra có dòng nào khác giống sp_id + size_id không?
            $existing = DB::table('giohang')
                        ->where('user_id', $user_id)
                        ->where('sp_id', $sp_id)
                        ->where('size_id', $request->size_id)
                        ->where('gh_id', '!=', $request->gh_id)
                        ->first();
    
            if ($existing) {
                // Gộp số lượng
                $tongSoluong = $existing->soluong + $request->soluong;
    
                // Cập nhật dòng còn lại
                DB::table('giohang')
                    ->where('gh_id', $existing->gh_id)
                    ->update([
                        'soluong' => $tongSoluong,
                        'created_at' => now(),
                    ]);
    
                // Xóa dòng hiện tại
                DB::table('giohang')
                    ->where('gh_id', $request->gh_id)
                    ->delete();
            } else {
                // Cập nhật bình thường
                DB::table('giohang')
                    ->where('gh_id', $request->gh_id)
                    ->update([
                        'soluong' => $request->soluong,
                        'size_id' => $request->size_id,
                        'created_at' => now(),
                    ]);
            }

            DB::commit();
            return response("1", 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response("-1", 500); // lỗi hệ thống
        }
    }

    // Xóa sản phẩm
    public function deleteSP(Request $request) {
        try {
            DB::beginTransaction();
            $deleted = DB::table('giohang')
                        ->where('gh_id', $request->gh_id)
                        ->delete();
            if ($deleted == 1) {
                DB::commit();
                return 1;
            } else {
                DB::rollBack();
                return 0;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return -1;
        }
    }

    public function payment() {
        return view('user.orders.payment');
    }


}