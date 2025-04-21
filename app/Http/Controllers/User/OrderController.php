<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function cart() {
        // if (Auth::check()) {
        //     $user_id = Auth::user()->user_id;
        // } else {
        //     return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem giỏ hàng');
        // }
        $user_id = 'U01'; //Giả sử User có id là U01 đang đăng nhập
        $cartItems = DB::table('giohang as gh')
                    ->join('kho', 'gh.kho_id', '=', 'kho.kho_id')
                    ->join('sanpham', 'kho.sp_id', '=', 'sanpham.sp_id')
                    ->join('mau', 'kho.mau_id', '=', 'mau.mau_id')
                    ->join('size', 'kho.size_id', '=', 'size.size_id')
                    ->where('gh.user_id', $user_id)
                    ->select(
                        'gh.id as giohang_id',
                        'gh.soluong',
                        'sanpham.tensp',
                        'sanpham.gia',
                        'sanpham.image_url',
                        'mau.ten as tenmau',
                        'size.ten as tensize',
                        'gh.kho_id as kho_id'
                    )
                    ->get();

        return view('user.orders.cart', compact('cartItems'));
    }

    public function updateQuantity(Request $request)
    {
        $request->validate([
            'kho_id' => 'required|integer|exists:giohang,kho_id',
            'soluong' => 'required|integer|min:1',
        ], [
            'soluong.required' => 'Vui lòng nhập số lượng.',
            'soluong.min' => 'Số lượng tối thiểu là 1.',
        ]);

        $user_id = 'U01'; // giả sử người dùng đã đăng nhập với user_id = U01

        $exists = DB::table('giohang')->where([
            ['user_id', $user_id],
            ['kho_id', $request->kho_id]
        ])->exists();

        if (!$exists) return response("0");

        $updated = DB::table('giohang')
            ->where('user_id', $user_id)
            ->where('kho_id', $request->kho_id)
            ->update(['soluong' => $request->soluong]);

        return $updated ? response("1") : response("-1");
    }

    public function payment() {
        return view('user.orders.payment');
    }


}
