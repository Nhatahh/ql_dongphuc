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
use App\Models\nhaSX;
use App\Models\Danhmuc;

class AdminSanphamController extends Controller
{
    public function index() {
        $danhmucs = DanhMuc::all(); // Lấy toàn bộ danh mục
        $nhasanxuats = nhaSX::all(); // Lấy toàn bộ nhà sản xuất

        return view('admin.sanpham', compact('danhmucs', 'nhasanxuats'));
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
                return number_format($sp->gia) . ' VND';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // Xóa sản phẩm
    public function delete($sp_id)
    {
        // try{
            $size = Sanpham::where('sp_id', $sp_id)->firstOrFail();
            $size->delete();
            return response()->json(['success' => true]);
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'Lỗi xóa size: ' . $e->getMessage()], 500);
        // }
    }

    // Thêm sản phẩm
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tensp' => [
                'required',
                'regex:/^[\p{L}\p{N}\s]+$/u'  // không chứa ký tự đặc biệt
            ],
            'mota' => [
                'nullable',
                // 'regex:/^[\p{L}\p{N}\s]*$/u' // có thể null, nhưng nếu có thì không chứa kí tự đặc biệt
            ],
            'gia' => 'required|numeric|min:0',
            'dm_id' => 'required|exists:danhmuc,dm_id',
            'nsx_id' => 'required|exists:nhasanxuat,nsx_id',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'tensp.required' => 'Tên sản phẩm không được để trống.',
            'tensp.regex' => 'Tên sản phẩm không được chứa ký tự đặc biệt.',
            // 'mota.regex' => 'Mô tả không được chứa ký tự đặc biệt.',
            'gia.required' => 'Giá sản phẩm không được để trống.',
            'gia.numeric' => 'Giá phải là một số.',
            'gia.min' => 'Giá không được âm.',
            'dm_id.required' => 'Vui lòng chọn danh mục.',
            'dm_id.exists' => 'Danh mục không hợp lệ.',
            'nsx_id.required' => 'Vui lòng chọn nhà sản xuất.',
            'nsx_id.exists' => 'Nhà sản xuất không hợp lệ.',
            'image_url.required' => 'Vui lòng chọn hình ảnh.',
            'image_url.image' => 'Tệp phải là hình ảnh.',
            'image_url.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg hoặc gif.',
            'image_url.max' => 'Hình ảnh không được lớn hơn 10MB.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $maxSpId = DB::table('sanpham')->max('sp_id');
        $newSpId = $maxSpId ? $maxSpId + 1 : 1;

        if ($request->hasFile('image_url')) {
            $imageFile = $request->file('image_url');
            $imageName = time() . '_' . $imageFile->getClientOriginalName();
            $imageFile->move(public_path('images'), $imageName);
        }

        DB::table('sanpham')->insert([
            'sp_id' => $newSpId,
            'tensp' => $request->tensp,
            'mota' => $request->mota,
            'gia' => $request->gia,
            'image_url' => $imageName,
            'dm_id' => $request->dm_id,
            'nsx_id' => $request->nsx_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => 'Thêm sản phẩm thành công']);
    }

    // Hiển thị modal cập nhật
    public function edit($sp_id)
    {
        $sp = Sanpham::where('sp_id', $sp_id)->firstOrFail();
        return response()->json($sp);
    }
    // Cập nhật sản phẩm
    public function update(Request $request, $sp_id)
    {
        $validator = Validator::make($request->all(), [
            'tensp' => [
                'required',
                'regex:/^[\p{L}\p{N}\s]+$/u'  // không chứa ký tự đặc biệt
            ],
            'mota' => [
                'nullable',
                // 'regex:/^[\p{L}\p{N}\s]*$/u' // có thể null, nhưng nếu có thì không chứa kí tự đặc biệt
            ],
            'gia' => 'required|numeric|min:0',
            'dm_id' => 'required|exists:danhmuc,dm_id',
            'nsx_id' => 'required|exists:nhasanxuat,nsx_id',
            'image_url' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'tensp.required' => 'Tên sản phẩm không được để trống.',
            'tensp.regex' => 'Tên sản phẩm không được chứa ký tự đặc biệt.',
            // 'mota.regex' => 'Mô tả không được chứa ký tự đặc biệt.',
            'gia.required' => 'Giá sản phẩm không được để trống.',
            'gia.numeric' => 'Giá phải là một số.',
            'gia.min' => 'Giá không được âm.',
            'dm_id.required' => 'Vui lòng chọn danh mục.',
            'dm_id.exists' => 'Danh mục không hợp lệ.',
            'nsx_id.required' => 'Vui lòng chọn nhà sản xuất.',
            'nsx_id.exists' => 'Nhà sản xuất không hợp lệ.',
            'image_url.image' => 'Tệp phải là hình ảnh.',
            'image_url.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg hoặc gif.',
            'image_url.max' => 'Hình ảnh không được lớn hơn 10MB.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $sanpham = Sanpham::where('sp_id', $sp_id)->firstOrFail();

        $sanpham->tensp = $request->tensp;
        $sanpham->mota = $request->mota;
        $sanpham->gia = $request->gia;
        $sanpham->dm_id = $request->dm_id;
        $sanpham->nsx_id = $request->nsx_id;

        // Nếu có upload ảnh mới
        if ($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName); // dùng thư mục public/images
            $sanpham->image_url = $imageName;
        } else {
            // Nếu không có ảnh mới => giữ ảnh cũ
            $sanpham->image_url = $request->input('image_old');
        }

        $sanpham->save();

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật sản phẩm thành công!',
            'data' => $sanpham
        ]);
    }

    // Get data select2 Danh muc va Nha san xuat
    public function getDanhmucNhasanxuat()
    {
            return response()->json([
            'danhmucs' => Danhmuc::all(),
            'nsxs' => nhaSX::all()
        ]);
    }
}
