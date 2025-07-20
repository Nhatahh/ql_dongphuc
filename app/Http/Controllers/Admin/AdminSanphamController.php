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
                return Str::limit(strip_tags($sp->mota), 100); 
            })
            ->addColumn('danhmuc', function ($sp) {
                return optional($sp->danhmuc)->ten ?? 'Không rõ';
            })
            ->addColumn('nhasanxuat', function ($sp) {
                return optional($sp->nhasanxuat)->ten ?? 'Không rõ';
            })
            ->addColumn('action', function ($sp) {
                return '<button class="btn btn-sm btn-primary edit-btn" 
                            data-id="' . $sp->sp_id . '" 
                            data-tensp="' . e($sp->tensp) . '"
                            data-mota="' . e($sp->mota) . '"
                            data-gia="' . $sp->gia . '"
                            data-image="' . $sp->image_url . '"
                            data-danhmuc="' . $sp->dm_id . '"
                            data-nhasanxuat="' . $sp->nsx_id . '"
                        >Sửa</button>
                        <a href="#" class="btn btn-sm btn-danger">Xóa</a>';
            })
            ->editColumn('gia', function ($sp) {
                return number_format($sp->gia) . 'đ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function edit($sp_id)
    {
        $sanpham = Sanpham::with(['danhmuc', 'nhasanxuat'])->find($sp_id);

        if (!$sanpham) {
            return response()->json(['message' => 'Không tìm thấy sản phẩm'], 404);
        }

        return response()->json($sanpham);
    }

    public function update(Request $request, $sp_id)
    {
        $sp = Sanpham::findOrFail($sp_id);

        $sp->tensp = $request->tensp;
        $sp->gia = $request->gia;
        $sp->mota = $request->mota;
        $sp->dm_id = $request->dm_id;
        $sp->nsx_id = $request->nsx_id;

        if ($request->hasFile('image')) {
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images'), $filename);
            $sp->image_url = $filename;
        }

        $sp->save();

        return response()->json(['message' => 'Cập nhật thành công']);
    }

    public function delete($sp_id)
    {
        $sp = Sanpham::findOrFail($sp_id);
        $sp->delete();
        return response()->json(['message' => 'Đã xóa']);
    }

}
