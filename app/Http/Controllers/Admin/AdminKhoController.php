<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\Sanpham;
use App\Models\Tonkho;
use App\Models\Size;

class AdminKhoController extends Controller
{
    public function index()
    {
        return view('admin.kho');
    }

    public function getKhoData(Request $request)
    {
        // Lấy danh sách sản phẩm
        $sanphams = Sanpham::with(['tonkho.size'])->get();

        // Chuẩn bị dữ liệu
        $data = $sanphams->map(function ($sp) {
            $stock = ['S' => 0, 'M' => 0, 'L' => 0, 'XL' => 0];

            foreach ($sp->tonkho as $item) {
                $sizeName = $item->size->ten;
                if (isset($stock[$sizeName])) {
                    $stock[$sizeName] = $item->tonkho;
                }
            }

            return [
                'sp_id'   => $sp->sp_id,
                'image_url' => $sp->image_url,
                'tensp'   => $sp->tensp,
                'sizeS' => '<input type="number" value="' . $stock['S'] . '" class="form-control form-control-sm text-center stock-input" data-size="S" data-sp-id="' . $sp->sp_id . '">',
                'sizeM' => '<input type="number" value="' . $stock['M'] . '" class="form-control form-control-sm text-center stock-input" data-size="M" data-sp-id="' . $sp->sp_id . '">',
                'sizeL' => '<input type="number" value="' . $stock['L'] . '" class="form-control form-control-sm text-center stock-input" data-size="L" data-sp-id="' . $sp->sp_id . '">',
                'sizeXL'=> '<input type="number" value="' . $stock['XL'] . '" class="form-control form-control-sm text-center stock-input" data-size="XL" data-sp-id="' . $sp->sp_id . '">',
            ];
        });

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                return '
                    <button class="btn btn-sm btn-warning me-1 btn-edit" data-id="' . $row['sp_id'] . '">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <button class="btn btn-sm btn-danger btn-delete" data-id="' . $row['sp_id'] . '">
                        <i class="bi bi-trash"></i>
                    </button>';
            })
            ->rawColumns(['sizeS', 'sizeM', 'sizeL', 'sizeXL', 'action'])
            ->make(true);
    }

    public function updateStock(Request $request)
    {
        $validated = $request->validate([
            'sp_id' => 'required|integer',
            'size'  => 'required|string|in:S,M,L,XL',
            'value' => 'required|integer|min:0',
        ], [
            'value.required' => 'Vui lòng nhập số lượng tồn kho.',
            'value.integer'  => 'Số lượng tồn kho phải là số nguyên.',
            'value.min'      => 'Số lượng tồn kho phải lớn hơn hoặc bằng 0.',
        ]);

        $size = Size::where('ten', $validated['size'])->first();
        if (!$size) return response()->json(['success' => false, 'message' => 'Size không hợp lệ']);

        $tonkho = Tonkho::where('sp_id', $validated['sp_id'])->where('size_id', $size->size_id)->first();
        if (!$tonkho) {
            // Nếu chưa tồn tại, tạo mới
            Tonkho::create([
                'sp_id'   => $validated['sp_id'],
                'size_id' => $size->size_id,
                'tonkho'  => $validated['value'],
            ]);
        } else {
            $tonkho->update(['tonkho' => $validated['value']]);
        }

        return response()->json(['success' => true, 'message' => 'Cập nhật thành công']);
    }
}
