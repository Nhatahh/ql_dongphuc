<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;




// use Exception;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::middleware('apikey')->get('thongtincanhansinhvien/{cccd}', function ($cccd) {
    try {
        // Lấy dữ liệu sinh viên
        $sinhVien = DB::table('api_sinhvien')->where('cccd', $cccd)->first();

        // Kiểm tra nếu không tìm thấy sinh viên
        if (!$sinhVien) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy sinh viên',
                'id' => 404,
            ], 404);
        }

        // Giải mã JSON (nếu có dữ liệu)
        $sinhVien->json_noisinh = json_decode($sinhVien->json_noisinh, true) ?? [];
        $sinhVien->json_quequan = json_decode($sinhVien->json_quequan, true) ?? [];
        $sinhVien->json_hktt = json_decode($sinhVien->json_hktt, true) ?? [];
        $sinhVien->json_truongthpt = json_decode($sinhVien->json_truongthpt, true) ?? [];

        return response()->json([
            'status' => 'success',
            'data' => $sinhVien,
            'id' => 200,
        ], 200);
    } catch (\Exception $e) {
        Log::error('Lỗi API lấy thông tin sinh viên: ' . $e->getMessage());

        return response()->json([
            'status' => 'error',
            'message' => 'Lỗi hệ thống! Vui lòng thử lại sau.',
            'id' => 500,
        ], 500);
    }
});


Route::middleware('apikey')->put('update_thongtincanhansinhvien/{cccd}', function ($cccd){
    try {

        // Dữ liệu cập nhật (chỉ lấy những trường có trong request)
        // $data = $request->only(['hoten', 'ngaysinh', 'json_noisinh', 'json_quequan', 'json_hktt', 'json_truongthpt']);

        // // Nếu có dữ liệu JSON thì mã hóa lại trước khi lưu
        // foreach (['json_noisinh', 'json_quequan', 'json_hktt', 'json_truongthpt'] as $field) {
        //     if (isset($data[$field])) {
        //         $data[$field] = json_encode($data[$field]);
        //     }
        // }

        $sinhVien = DB::table('api_sinhvien')->where('cccd', $cccd)->first();

        // Kiểm tra nếu không tìm thấy sinh viên
        if (!$sinhVien) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy sinh viên',
                'id' => 404,
            ], 404);
        }
        // Cập nhật vào database
        $updatedRows = DB::table('api_sinhvien')->where('cccd', $cccd)->update(
            [
                'hoten' => "Bình Trọng Gâu Gâu"
            ]
        );
        if($updatedRows === 0 ){
            return response()->json([
                'status' => 'success',
                'message' => 'Không có dữ liệu mới',
                'id' => 200,
            ], 200);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật thông tin thành công',
            'id' => 200,
        ], 200);
    } catch (\Exception $e) {
        Log::error('Lỗi API cập nhật sinh viên: ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Lỗi hệ thống! Vui lòng thử lại sau.',
            'id' => 500,
        ], 500);
    }


});



