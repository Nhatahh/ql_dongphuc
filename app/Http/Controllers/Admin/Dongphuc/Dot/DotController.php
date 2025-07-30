<?php

namespace App\Http\Controllers\Admin\Dongphuc\Dot;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class DotController extends Controller
{

    function index(){
        return view('admin.dongphuc.qldot');
    }

    function dot_them(Request $request)
    {
        try {
            $existingRecord = DB::table('l_qldp_dot')->where('ten_dot', $request->input('dot_ten'));
            if (!$existingRecord->exists()) {
                // Nếu không tồn tại, thì chèn một bản ghi mới
                $record = DB::table('l_qldp_dot')->insert([
                    'ngay_dot' => $request->input('dot_ngay'),
                    'ten_dot' => $request->input('dot_ten'),
                ]);
                if ($record > 0) {
                    return 1;
                }
            } else return 0;
        } catch (Exception $e) {
            return 2;
        }
    }
    function load_dot()
    {
        $dot = DB::table('l_qldp_dot')
            ->select('iddot as id', 'ten_dot as text')->orderBy('iddot', 'ASC')
            ->get();
        echo $dot;
    }
    function hienthidot()
    {
        $layten_nhap = "SELECT *, DATE_FORMAT(ngay_dot,'%d/%m/%Y') as ngay_dot
        FROM l_qldp_dot";
        $json_data['data'] = DB::select($layten_nhap);
        $data = json_encode($json_data);
        echo  $data;
    }
    function delete_dot($id)
    {
        try {
            $nsx = "DELETE FROM l_qldp_dot WHERE iddot = $id;";
            $result = DB::delete($nsx);
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }
    function edit_dot($id)
    {
        $dlt_dot = DB::table('l_qldp_dot')
            ->select(['*']) // Danh sách cột bạn muốn lấy
            ->where('iddot', $id)
            ->first(); // Lấy dữ liệu từ bảng 'ke'
        return response()->json($dlt_dot);
    }
    function submit_dot(Request $request)
    {
        try {
            $iddot = $request->iddot;
            $ten_dot = $request->ten_dot;
            $ngay_dot = $request->ngay_dot;
            // Kiểm tra xem có bất kỳ hàng nào được cập nhật không
            $updatedRows = DB::table('l_qldp_dot')
                ->where('iddot', $iddot)
                ->update([
                    'ten_dot' => $ten_dot,
                    'ngay_dot' => $ngay_dot,
                ]);
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }
}
