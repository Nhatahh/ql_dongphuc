<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;  
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        if (Auth::check()) {
            $user_id = Auth::user()->user_id;
        } else {
            return redirect()->route('login');
        }

        // Thông tin người dùng
        $userInfo = DB::table('users')
                        ->where('user_id', $user_id)->first();

        // dd($user_id);

        // Load đơn hàng chờ xác nhận
        $orders = DB::table('hoadon')
            ->where('tt_id', 1) 
            ->where('user_id', $user_id) 
            ->orderByDesc('created_at')
            ->get();

        // dd($orders);

        return view('user.profile', [
            'userInfo' => $userInfo,
            'orders' => $orders,
        ]);
    }

    public function formSignIn()
    {
        return view('user.form.sign_in');
    }

    // API để lấy chi tiết hóa đơn theo id (cho modal)
    public function getOrderDetails($hd_id)
    {
        $details = DB::table('chitiethoadon as cthd')
            ->join('sanpham as sp', 'cthd.sp_id', '=', 'sp.sp_id')
            ->join('hoadon as hd', 'cthd.hd_id', '=', 'hd.hd_id')
            ->join('size', 'cthd.size_id', '=', 'size.size_id')
            ->where('cthd.hd_id', $hd_id)
            ->select(
                'sp.sp_id', 
                'sp.tensp', 
                'sp.image_url', 
                'cthd.soluong', 
                'cthd.gia', 
                'size.ten as size' 
            )
            ->get();

        // dd($details);

        return response()->json($details);
    }

    // Hủy đơn hàng
    public function cancelOrder(Request $request)
    {
        try {
            DB::beginTransaction();
            $hd_id = $request->input('hd_id');
            $order = DB::table('hoadon')
                        ->where('hoadon.hd_id', $hd_id)
                        ->update([
                            'tt_id' => 3,
                            'updated_at' => now(),
                        ]);

            if (!$order) {
                return response("0", 200);
            }

            DB::commit();
            return response("1", 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response("-1", 500); 
        }
    }

}
