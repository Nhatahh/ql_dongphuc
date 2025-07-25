<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Models\Hoadon;
use App\Models\Trangthai;
use App\Models\Chitiethoadon;
use App\Models\User;

class AdminDonHangController extends Controller
{
    public function index()
    {
        return view('admin.donhang');
    }

    public function getData()
    {
        $hoadon = Hoadon::with(['user', 'trangThai', 'chitietHoadon.sanpham', 'ptThanhToan'])
            ->select(['hd_id', 'user_id', 'tongtien', 'tt_id', 'pttt_id', 'created_at']);

        return DataTables::of($hoadon)
            ->addColumn('username', function ($hd) {
                return optional($hd->user)->username;
            })
            ->editColumn('tongtien', function ($hd) {
                return number_format($hd->tongtien) . 'VND';
            })
            ->addColumn('pttt', function ($hd) {
                return optional($hd->ptThanhToan)->ten ?? 'Không rõ';
            })
            ->addColumn('trangthai', function ($hd) {
                $options = Trangthai::whereIn('tt_id', [1, 2, 3])->get()->map(function ($tt) use ($hd) {
                    $selected = $hd->tt_id == $tt->tt_id ? 'selected' : '';
                    return "<option value='{$tt->tt_id}' {$selected}>{$tt->ten}</option>";
                })->implode('');

                return "<select class='form-select form-select-sm trangthai-select' data-id='{$hd->hd_id}'>
                            {$options}
                        </select>";
            })
            ->editColumn('created_at', function ($hd) {
                return Carbon::parse($hd->created_at)->format('d-m-Y H:i:s');
            })
            ->addColumn('action', function ($hd) {
                $btnEdit = '<a href="#" class="btn btn-sm btn-primary">Sửa</a> ';
                $btnDelete = '<a href="#" class="btn btn-sm btn-danger">Xóa</a> ';
                $btnDetail = '<button class="btn btn-info btn-sm view-details" data-id="' . $hd->hd_id . '">Xem chi tiết</button>';

                return $btnEdit . $btnDelete . $btnDetail;
            })
            ->rawColumns(['action', 'trangthai'])
            ->make(true);
    }

    public function getChitietHoadon($hd_id)
    {
        $chitiets = Chitiethoadon::with(['sanpham', 'size'])
            ->where('hd_id', $hd_id)
            ->get();

        return response()->json($chitiets);
    }

    public function updateTrangthai(Request $request, $hd_id)
    {
        $request->validate([
            'tt_id' => 'required|integer|exists:trangthai,tt_id',
        ]);

        try {
            DB::table('hoadon')
                ->where('hd_id', $hd_id)
                ->update(['tt_id' => $request->tt_id]);

            return response()->json(['message' => 'Cập nhật trạng thái thành công.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi khi cập nhật trạng thái'], 500);
        }
    }
}
