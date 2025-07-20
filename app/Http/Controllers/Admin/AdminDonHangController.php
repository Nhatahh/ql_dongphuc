<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hoadon;
use App\Models\Chitiethoadon;
use Yajra\DataTables\Facades\DataTables;

class AdminDonHangController extends Controller
{
    public function index()
    {
        return view('admin.donhang');
    }

    public function getData()
    {
        $hoadon = Hoadon::with(['user', 'trangthai', 'chitietHoadon.sanpham'])
            ->select(['hd_id', 'user_id', 'tongtien', 'tt_id', 'created_at']);

        return DataTables::of($hoadon)
            ->addColumn('username', function ($hd) {
                return optional($hd->user)->username;
            })
            ->addColumn('sanpham', function ($hd) {
                $items = $hd->chitietHoadon->map(function ($ct) {
                    return $ct->sanpham->tensp ?? '[Sản phẩm đã xóa]';
                });
                return $items->implode(', ');
            })
            ->addColumn('soluong', function ($hd) {
                return $hd->chitietHoadon->sum('soluong');
            })
            ->editColumn('tongtien', function ($hd) {
                return number_format($hd->tongtien) . 'đ';
            })
            ->addColumn('trangthai', function ($hd) {
                return optional($hd->trangthai)->ten ?? 'Không rõ';
            })
            ->addColumn('action', function ($hd) {
                $btnEdit = '<a href="#" class="btn btn-sm btn-primary">Sửa</a> ';
                $btnDelete = '<a href="#" class="btn btn-sm btn-danger">Xóa</a> ';
                $btnDetail = '<button class="btn btn-info btn-sm view-details" data-id="' . $hd->hd_id . '">Xem chi tiết</button>';

                return $btnEdit . $btnDelete . $btnDetail;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function getDonhangData()
    {
        $hoadons = Hoadon::with('user', 'trangthai')
            ->select(['hd_id', 'user_id', 'tongtien', 'tt_id', 'created_at']);

        return DataTables::of($hoadons)
            ->addColumn('khachhang', fn($hd) => $hd->user->hoten ?? 'Không rõ')
            ->addColumn('trangthai', fn($hd) => $hd->trangthai->ten ?? 'Không rõ')
            ->addColumn('action', fn($hd) => '<button class="btn btn-info btn-sm view-details" data-id="' . $hd->hd_id . '">Xem chi tiết</button>')
            ->editColumn('tongtien', fn($hd) => number_format($hd->tongtien) . 'đ')
            ->editColumn('created_at', fn($hd) => $hd->created_at->format('d/m/Y H:i'))
            ->rawColumns(['action'])
            ->make(true);
    }
    public function getChitietHoadon($hd_id)
    {
        $chitiets = Chitiethoadon::with(['sanpham', 'size'])
            ->where('hd_id', $hd_id)
            ->get();

        return response()->json($chitiets);
    }

}
