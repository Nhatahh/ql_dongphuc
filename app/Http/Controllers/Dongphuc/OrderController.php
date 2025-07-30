<?php

namespace App\Http\Controllers\Dongphuc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;



class OrderController extends Controller
{
    public function cart()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user_id = Auth::user()->user_id;

        $cartItems = DB::table('giohang as gh')
            ->join('sanpham', 'sanpham.sp_id', '=', 'gh.sp_id')
            ->join('size', 'gh.size_id', '=', 'size.size_id')
            ->join('kho', function ($join) {
                $join->on('kho.sp_id', '=', 'gh.sp_id')
                    ->on('kho.size_id', '=', 'gh.size_id');
            })
            ->where('gh.user_id', $user_id)
            ->select(
                'gh.*',
                'sanpham.tensp as tensp',
                'sanpham.sp_id',
                'sanpham.gia',
                'sanpham.image_url',
                'size.ten as tensize',
                'kho.kho_id',
                'kho.tonkho as tonkho'
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

    public function getTonkho(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sp_id' => 'required|integer|exists:sanpham,sp_id',
            'size_id' => 'required|integer|exists:size,size_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        $tonkho = DB::table('kho')
            ->where('sp_id', $request->sp_id)
            ->where('size_id', $request->size_id)
            ->value('tonkho');

        return response()->json([
            'status' => 'success',
            'tonkho' => $tonkho ?? 0,
        ]);
    }

    // Cập nhật số lượng sản phẩm
    public function updateQuantity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gh_id' => 'required|integer|exists:giohang,gh_id',
            'soluong' => 'required|integer|min:1',
            'size_id' => 'required|integer|exists:size,size_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $giohang = DB::table('giohang')->where('gh_id', $request->gh_id)->first();
            if (!$giohang) {
                DB::rollBack();
                return response()->json(['status' => 'not_found']);
            }

            $user_id = $giohang->user_id;
            $sp_id = $giohang->sp_id;

            // Kiểm tra có bản ghi trùng khác không
            $existing = DB::table('giohang')
                ->where('user_id', $user_id)
                ->where('sp_id', $sp_id)
                ->where('size_id', $request->size_id)
                ->where('gh_id', '!=', $request->gh_id)
                ->first();

            if ($existing) {
                // Gộp số lượng
                DB::table('giohang')
                    ->where('gh_id', $existing->gh_id)
                    ->update([
                        'soluong' => $existing->soluong + $request->soluong,
                        'created_at' => now(),
                    ]);

                DB::table('giohang')
                    ->where('gh_id', $request->gh_id)
                    ->delete();
            } else {
                // Cập nhật dòng hiện tại
                DB::table('giohang')
                    ->where('gh_id', $request->gh_id)
                    ->update([
                        'soluong' => $request->soluong,
                        'size_id' => $request->size_id,
                        'created_at' => now(),
                    ]);
            }

            // Lấy lại tồn kho từ DB
            $tonkho = DB::table('kho')
                ->where('sp_id', $sp_id)
                ->where('size_id', $request->size_id)
                ->value('tonkho');

            DB::commit();

            return response()->json([
                'status' => 'success',
                'new_quantity' => $request->soluong,
                'new_size_id' => $request->size_id,
                'tonkho' => $tonkho,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Lỗi hệ thống'], 500);
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

    // Thanh toán
    public function checkout(Request $request)
    {
        $items = $request->input('items');
        $pttt_id = $request->input('pttt_id');

        if (empty($items)) {
            return response("0", 200);
        }

        foreach ($items as $item) {
            if (empty($item['size_id'])) {
                return response("0", 200); 
            }
        }

        DB::beginTransaction();
        try {
            // $user_id = $items[0]['user_id']; 

            if (Auth::check()) {
                $user_id = Auth::user()->user_id;
            } else {
                return redirect()->route('login');
            }

            // Tính tổng tiền
            $tongtien = 0;

            foreach ($items as $item) {
                $giohang = DB::table('giohang')->where('gh_id', $item['gh_id'])->first();
            
                if ($giohang) {
                    $sanpham = DB::table('sanpham')->where('sp_id', $giohang->sp_id)->first();
                    if ($sanpham) {
                        $gia = $sanpham->gia;
                        $tongtien += $giohang->soluong * $gia;
                    }
                }
            }

            $maxId_hd = DB::table('hoadon')->max('hd_id');
            $newId_hd = $maxId_hd + 1;
            // Tạo hóa đơn
            DB::table('hoadon')
                ->insert([
                    'hd_id' => $newId_hd,
                    'user_id' => $user_id,
                    'tongtien' => $tongtien,
                    'tt_id' => 1, // Trạng thái mặc định: Chờ xác nhận
                    'pttt_id' => $pttt_id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            
            $maxId_noti = DB::table('thongbao')->max('noti_id');
            $newId_noti = $maxId_noti + 1;
            DB::table('thongbao')->insert([
                'noti_id' => $newId_noti,
                'user_id' => $user_id,
                'title' => 'Đặt hàng thành công',
                'message' => 'Bạn đã đặt đơn hàng mã HD' . $newId_hd,
                'is_read' => false,
            ]);

            // Duyệt qua từng item để tạo chi tiết hóa đơn
            foreach ($items as $item) {
                $maxId_cthd = DB::table('chitiethoadon')->max('cthd_id');
                $newId_cthd = $maxId_cthd + 1;
                $giohang = DB::table('giohang')
                                ->where('gh_id', $item['gh_id'])
                                ->first();
                if ($giohang) {
                    DB::table('chitiethoadon')->insert([
                        'cthd_id' => $newId_cthd,
                        'hd_id' => $newId_hd,
                        'sp_id' => $giohang->sp_id,
                        'size_id' => $giohang->size_id,
                        'soluong' => $giohang->soluong,
                        'gia' => $gia,
                    ]);

                    // kiểm tra tồn kho đủ trước khi trừ
                    $tonkho = DB::table('kho')
                        ->where('sp_id', $giohang->sp_id)
                        ->where('size_id', $giohang->size_id)
                        ->value('tonkho');
                    if ($giohang->soluong > $tonkho) {
                        DB::rollBack();
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Sản phẩm ' . $sanpham->tensp . ' size không đủ tồn kho.',
                        ], 400);
                    }
                    // Cập nhật tồn kho - trừ số lượng đã đặt
                    DB::table('kho')
                        ->where('sp_id', $giohang->sp_id)
                        ->where('size_id', $giohang->size_id)
                        ->decrement('tonkho', $giohang->soluong);
                    
                    // Xóa khỏi giỏ hàng
                    DB::table('giohang')->where('gh_id', $item['gh_id'])->delete();
                }
            }

            DB::commit();
            return response("1", 200);
            // return response()->json(['message' => 'Đặt hàng thành công', 'redirect_url' => route('orders.index')]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Lỗi xử lý đơn hàng',
                'error' => $e->getMessage(), 
                'line' => $e->getLine(),     
                'file' => $e->getFile(),    
            ], 500);
            // return response("-1", 500);
        }
    }

}