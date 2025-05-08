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
        $user_id = 'U01'; //Giả sử User có id là U01 đang đăng nhập
        $cartItems = DB::table('giohang as gh')
                    ->join('sanpham', 'sanpham.sp_id', '=', 'gh.sp_id')
                    ->join('users', 'users.user_id', '=', 'gh.user_id')
                    ->join('kho', 'sanpham.kho_id', '=', 'kho.kho_id')
                    ->join('mau', 'gh.mau_id', '=', 'mau.mau_id')
                    ->join('size', 'gh.size_id', '=', 'size.size_id')
                    ->where('gh.user_id', $user_id)
                    ->select(
                        'gh.*',
                        'sanpham.tensp',
                        'sanpham.gia',
                        'sanpham.image_url',
                        'mau.ten as tenmau',
                        'size.ten as tensize',
                    )
                    ->get();

        return view('user.orders.cart', compact('cartItems'));
    }

    // Cập nhật số lượng sản phẩm
    public function updateQuantity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gh_id' => 'required|integer|exists:giohang,gh_id',
            'soluong' => 'required|integer|min:1',
        ],
        [
            'gh_id.required' => 'Thiếu gh_id',
            'gh_id.integer' => 'Sai định dạng gh_id',
            'gh_id.exists' => 'Sản phẩm không tồn tại trong giỏ hàng',

            'soluong.required' => 'Vui lòng nhập số lượng',
            'soluong.integer' => 'Số lượng phải là số nguyên',
            'soluong.min' => 'Số lượng tối thiểu là 1',
        ]);

        $user_id = 'U01'; // giả sử người dùng đã đăng nhập với user_id = U01

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        try {
            DB::beginTransaction();
            $id = $user_id;

            $updated = DB::table('giohang')
            ->where('gh_id', $request->gh_id)
            ->update(['soluong' => $request->soluong]);

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