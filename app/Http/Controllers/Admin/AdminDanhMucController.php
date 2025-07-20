<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DanhMuc;
use DataTables;

class AdminDanhMucController extends Controller
{
    public function index()
    {
        return view('admin.danhmuc');
    }
    public function getData(Request $request)
    {
        $danhmucs = DanhMuc::select('id', 'dm_id', 'ten')->get();

        $data = $danhmucs->map(function ($item, $index) {
            return [
                'stt' => $index + 1,
                'dm_id' => $item->dm_id,
                'ten' => $item->ten,
            ];
        });

        return response()->json(['data' => $data]);
    }

    // Thêm loại sản phẩm
    public function getMaxDmId() 
    {
        $max = DanhMuc::max('dm_id');
        return response()->json(['max_dm_id' => $max ?? 0]);
    }
    public function add(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:255',
        ]);

        $maxDmId = DanhMuc::max('dm_id') ?? 0;

        $danhmuc = new DanhMuc();
        $danhmuc->dm_id = $maxDmId + 1;
        $danhmuc->ten = $request->ten;
        $danhmuc->save();

        return response()->json(['message' => 'Thêm thành công']);
    }

    // Lấy chi tiết 1 danh mục
    public function show($dm_id)
    {
        $dm = DanhMuc::where('dm_id', $dm_id)->firstOrFail();
        return response()->json($dm);
    }

    // Cập nhật danh mục
    public function update(Request $request, $dm_id)
    {
        $dm = DanhMuc::where('dm_id', $dm_id)->firstOrFail();
        $dm->update($request->only(['dm_id', 'ten']));
        return response()->json(['message' => 'Cập nhật thành công']);
    }

    // Xóa danh mục
    public function delete($dm_id)
    {
        $dm = DanhMuc::where('dm_id', $dm_id)->firstOrFail();
        $dm->delete();
        return response()->json(['success' => true]);
    }

    public function select2()
    {
        return Danhmuc::select('dm_id as id', 'ten as text')->get();
    }
}
