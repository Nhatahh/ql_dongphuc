<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\nhaSX;
use DataTables;

class AdminNSXController extends Controller
{
    public function index()
    {
        return view('admin.nhasanxuat');
    }
    public function getData(Request $request)
    {
        $nhasanxuats = nhaSX::select('id', 'nsx_id', 'ten')->get();

        $data = $nhasanxuats->map(function ($item, $index) {
            return [
                'stt' => $index + 1,
                'nsx_id' => $item->nsx_id,
                'ten' => $item->ten,
            ];
        });

        return response()->json(['data' => $data]);
    }

    // Thêm Nhà sản xuất
    public function getMaxNSXId() 
    {
        $max = nhaSX::max('nsx_id');
        return response()->json(['max_nsx_id' => $max ?? 0]);
    }
    public function add(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:255',
        ]);

        $maxNSXId = nhaSX::max('nsx_id') ?? 0;

        $nhasanxuat = new nhaSX();
        $nhasanxuat->nsx_id = $maxNSXId + 1;
        $nhasanxuat->ten = $request->ten;
        $nhasanxuat->save();

        return response()->json(['message' => 'Thêm thành công']);
    }

    // Lấy chi tiết 1 nhà sản xuất
    public function show($nsx_id)
    {
        $nsx = nhaSX::where('nsx_id', $nsx_id)->firstOrFail();
        return response()->json($nsx);
    }
    // Cập nhật nhà sản xuất
    public function update(Request $request, $nsx_id)
    {
        $nsx = nhaSX::where('nsx_id', $nsx_id)->firstOrFail();
        $nsx->update($request->only(['nsx_id', 'ten']));
        return response()->json(['message' => 'Cập nhật thành công']);
    }

    // Xóa nhà sản xuất
    public function delete($nsx_id)
    {
        // try{
            $nsx = nhaSX::where('nsx_id', $nsx_id)->firstOrFail();
            $nsx->delete();
            return response()->json(['success' => true]);
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'Lỗi xóa NSX: ' . $e->getMessage()], 500);
        // }
    }

    public function select2()
    {
        return nhaSX::select('nsx_id', 'ten')->get();
    }
}
