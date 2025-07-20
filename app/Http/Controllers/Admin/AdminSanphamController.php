<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sanpham;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class AdminSanphamController extends Controller
{
    public function sanpham() {
        return view('admin.sanpham');
    }
    public function getSanphamData(Request $request)
    {
        $data = Sanpham::with(['danhmuc', 'nhasanxuat'])->select([
            'sp_id', 'tensp', 'mota', 'gia', 'image_url', 'dm_id', 'nsx_id', 'created_at', 'updated_at'
        ]);

        return DataTables::of($data)
            ->editColumn('image_url', function ($sp) {
                return $sp->image_url; // chỉ trả về tên file, render ở JS
            })
            ->editColumn('mota', function ($sp) {
                return Str::limit(strip_tags($sp->mota), 100); // cắt khoảng 100 ký tự, tùy chỉnh theo ý bạn
            })
            ->addColumn('danhmuc', function ($sp) {
                return optional($sp->danhmuc)->ten ?? 'Không rõ';
            })
            ->addColumn('nhasanxuat', function ($sp) {
                return optional($sp->nhasanxuat)->ten ?? 'Không rõ';
            })
            ->addColumn('action', function ($sp) {
                return '<a href="#" class="btn btn-sm btn-primary">Sửa</a> 
                        <a href="#" class="btn btn-sm btn-danger">Xóa</a>';
            })
            ->editColumn('gia', function ($sp) {
                return number_format($sp->gia) . 'đ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
