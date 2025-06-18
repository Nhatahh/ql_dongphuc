<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\cthd;
use App\Models\DanhGia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class DanhGiaController extends Controller
{
    public function danhgia(Request $request)
{
    $validator = Validator::make($request->all(), [
        'rating'    => 'required|integer|min:1|max:5',
        'comment'   => 'required|string',
        'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif',
        'order_id'  => 'required|integer',
    ],[
        'rating.required'   => 'Vui lòng chọn số sao đánh giá!',
        'rating.integer'    => 'Đánh giá không hợp lệ!',
        'rating.min'        => 'Số sao tối thiểu là 1!',
        'rating.max'        => 'Số sao tối đa là 5!',
        'comment.required'  => 'Vui lòng nhập nội dung đánh giá!',
        'image.image'       => 'File phải là hình ảnh!',
        'image.mimes'       => 'Ảnh phải có định dạng: jpeg, png, jpg, gif!',
        'image.max'         => 'Kích thước ảnh tối đa là 2MB!',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images/danhgia'), $imageName);
        }

        $khoIds = cthd::where('hd_id', $request->order_id)->pluck('sp_id');

        foreach ($khoIds as $sp_id) {
            DanhGia::create([
                'dg_id'     => DanhGia::max('dg_id') + 1,
                'sp_id'     => $sp_id,
                'user_id'   => auth()->id(),
                'binhluan'  => $request->comment,
                'anh_url'   => $imageName,
                'created_at'=> now(),
                'rating'    => $request->rating
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Cảm ơn bạn đã đánh giá!'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Có lỗi xảy ra, vui lòng thử lại!'
        ], 500);
    }
}


//     public function danhgia(Request $request)
// {
//     $request->validate([
//         'rating' => 'required|integer|min:1|max:5',
//         'comment' => 'required|string',
//         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
//         'order_id' => 'required|integer',
//     ],[
//         'rating.required' => ''
//     ]);



//     $imageName = null;
//     if ($request->hasFile('image')) {
//         $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
//         $request->file('image')->move(public_path('images/danhgia'), $imageName);
//     }

//     // ✅ Lấy tất cả các kho_id từ chi tiết hóa đơn
//     $khoIds = cthd::where('hd_id', $request->order_id)->pluck('sp_id');
//     \Log::info('SP IDs:', $khoIds->toArray());

//     foreach ($khoIds as $sp_id) {
//         $review = new DanhGia();
//         $review->dg_id = danhgia::max('dg_id') + 1;
//         $review->sp_id = $sp_id;
//         $review->user_id = auth()->id();
//         $review->binhluan = $request->comment;
//         $review->anh_url = $imageName;
//         $review->created_at = now();
//         $review->rating = $request->rating;
//         $review->save();
//     }

//     return redirect()->back()->with('success', 'Cảm ơn bạn đã đánh giá!');
// }
}
