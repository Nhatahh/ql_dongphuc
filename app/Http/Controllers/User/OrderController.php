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
        // if (Auth::check()) {
        //     $user_id = Auth::user()->user_id;
        // } else {
        //     return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem giỏ hàng');
        // }
        $user_id = '1'; //Giả sử User có id là U01 đang đăng nhập
        $cartItems = DB::table('giohang as gh')
                    ->join('sanpham', 'sanpham.sp_id', '=', 'gh.sp_id')
                    ->join('users', 'users.user_id', '=', 'gh.user_id')
                    ->join('kho', 'sanpham.kho_id', '=', 'kho.kho_id')
                    ->join('mau', 'gh.mau_id', '=', 'mau.mau_id')
                    ->join('size', 'gh.size_id', '=', 'size.size_id')
                    ->where('gh.user_id', $user_id)
                    ->select(
                        'gh.*',
                        'sanpham.tensp as tensp',
                        'sanpham.sp_id as sp_id',
                        'sanpham.gia',
                        'sanpham.image_url',
                        'mau.ten as tenmau',
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
    
            $updated = DB::table('giohang')
                ->where('gh_id', $request->gh_id)
                ->update([
                    'soluong' => $request->soluong,
                    'size_id' => $request->size_id,  // cập nhật size_id
                ]);
    
            if ($updated == 1) {
                DB::commit();
                return response("1", 200); // thành công
            } else {
                DB::rollBack();
                return response("0", 200); // không tìm thấy sản phẩm
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response("-1", 500); // lỗi hệ thống
        }
    }


    // Xóa sản phẩm
    public function deleteProduct($gh_id) {
        try {
            DB::beginTransaction();
            $deleted = DB::table('giohang')
                        ->where('gh_id', $gh_id)
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