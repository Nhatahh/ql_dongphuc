<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;
use DataTables;

class AdminSizeController extends Controller
{
    public function index()
    {
        return view('admin.size');
    }
    public function getData(Request $request)
    {
        $sizes = Size::select('id', 'size_id', 'ten')->get();

        $data = $sizes->map(function ($item, $index) {
            return [
                'stt' => $index + 1,
                'size_id' => $item->size_id,
                'ten' => $item->ten,
            ];
        });

        return response()->json(['data' => $data]);
    }

    // Thêm size
    public function getMaxSizeId() 
    {
        $max = Size::max('size_id');
        return response()->json(['max_size_id' => $max ?? 0]);
    }
    public function add(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:255',
        ]);

        $maxSizeId = Size::max('size_id') ?? 0;

        $size = new Size();
        $size->size_id = $maxSizeId + 1;
        $size->ten = $request->ten;
        $size->save();

        return response()->json(['message' => 'Thêm thành công']);
    }

    // Lấy chi tiết 1 size
    public function show($size_id)
    {
        $size = Size::where('size_id', $size_id)->firstOrFail();
        return response()->json($size);
    }
    // Cập nhật size
    public function update(Request $request, $size_id)
    {
        $size = Size::where('size_id', $size_id)->firstOrFail();
        $size->update($request->only(['size_id', 'ten']));
        return response()->json(['message' => 'Cập nhật thành công']);
    }

    // Xóa size
    public function delete($size_id)
    {
        // try{
            $size = Size::where('size_id', $size_id)->firstOrFail();
            $size->delete();
            return response()->json(['success' => true]);
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'Lỗi xóa size: ' . $e->getMessage()], 500);
        // }
    }
}
