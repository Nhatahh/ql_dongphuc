<?php

namespace App\Http\Controllers\Dongphuc;

use App\Http\Controllers\Controller;  
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Notification;

class UserController extends Controller
{
    // load trang profile
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
            ->join('trangthai', 'hoadon.tt_id', '=', 'trangthai.tt_id')
            ->where('hoadon.tt_id', 1) 
            ->where('user_id', $user_id) 
            ->orderByDesc('created_at')
            ->select(
                'hoadon.hd_id', 
                'hoadon.created_at', 
                'hoadon.tongtien', 
                'trangthai.ten as trangthai', 
            )
            ->get();

        // dd($orders);

        //Load lịch sử mua hàng 
        $rawHistory = DB::table('hoadon')
            ->join('chitiethoadon as cthd', 'hoadon.hd_id', '=', 'cthd.hd_id')
            ->join('sanpham as sp', 'cthd.sp_id', '=', 'sp.sp_id')
            ->join('danhmuc as dm', 'sp.dm_id', '=', 'dm.dm_id')
            ->join('trangthai as tt', 'hoadon.tt_id', '=', 'tt.tt_id')
            ->whereIn('hoadon.tt_id',[2, 3] ) 
            ->where('hoadon.user_id', $user_id)
            ->select(
                'hoadon.hd_id',
                'hoadon.tongtien',
                'tt.ten',
                'hoadon.tt_id',
                'sp.tensp',
                'dm.ten as danhmuc',
                'cthd.soluong',
                'sp.image_url'
            )
            ->orderBy('hoadon.hd_id', 'desc')
            ->get()
            ->groupBy('hd_id')
            ->map(function ($items) {
                return [
                    'tongtien' => $items->first()->tongtien,
                    'trangthai' => $items->first()->ten,
                    'tt_id' => $items->first()->tt_id,
                    'sanphams' => $items->map(function ($item) {
                        return [
                            'tensp' => $item->tensp,
                            'danhmuc' => $item->danhmuc,
                            'soluong' => $item->soluong,
                            'hinhanh' => $item->image_url,
                        ];
                    })
                ];
            });

        

        return view('user.profile', [
            'userInfo' => $userInfo,
            'orders' => $orders,
            'groupedHistory' => $rawHistory
        ]);
    }

    // load form đăng nhập
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

    // Load modal thông báo
    public function getNotifications()
    {
        if (Auth::check()) {
            $user_id = Auth::user()->user_id;
        } else {
            return redirect()->route('login');
        }

        $notifications = Notification::where('user_id', $user_id)
                        ->orderBy('created_at', 'desc')->get();

        return response()->json($notifications);
    }

    // public function countUnread()
    // {
    //     if (Auth::check()) {
    //         $user_id = Auth::user()->user_id;
    //     } else {
    //         return redirect()->route('login');
    //     }
    //     $count = 0;
    //     $count = Notification::where('user_id', $user_id)
    //         ->where('is_read', false)
    //         ->count();

    //     return response()->json($count);
    // }
}
