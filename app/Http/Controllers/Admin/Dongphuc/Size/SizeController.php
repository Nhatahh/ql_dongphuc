<?php
namespace App\Http\Controllers\Admin\Dongphuc\Size;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class SizeController extends Controller
{

    function index(){
        return view('admin.dongphuc.qlsize');
    }


    function addsize_tennsx()
    {
        $addsize_nsx = DB::table('l_qldp_nsx')
            ->select('id as id', 'name as text')
            ->orderBy('id', 'asc')
            ->get();
        $addsize_loai = DB::table('l_qldp_loai')
            ->select('id_loai as id', 'name as text')
            ->orderBy('id_loai', 'asc')
            ->get();
        $res = array(
            'addsize_nsx' => $addsize_nsx,
            'addsize_loai' => $addsize_loai,
        );
        return $res;
    }

    //
    function themsize(Request $request)
    {
        try {


            $tensize = $request->input('tensize');
            $addsize_tennsx = $request->input('addsize_tennsx');
            $addsize_loai = $request->input('addsize_loai');
            $addsize_thongso = $request->input('addsize_thongso');
            $qsl = "SELECT * FROM `l_qldp_size` WHERE namesize='$tensize' and id=$addsize_tennsx and id_loai=$addsize_loai";
            $existingRecord = DB::select($qsl);
            if (count($existingRecord) <= 0) {
                // Nếu không tồn tại, thì chèn một bản ghi mới
                $record = DB::table('l_qldp_size')->insert([
                    'namesize' => $tensize,
                    'id' => $addsize_tennsx,
                    'id_loai' => $addsize_loai,
                    'thongso' => $addsize_thongso,
                ]);
                return 1;
            } else return 3;
        } catch (Exception $e) {
            return 2;
        }
    }

    //
    function hienthi_size()
    {
        $sql = "SELECT l_qldp_size.*, l_qldp_loai.name AS loai_name, l_qldp_nsx.name AS nsx_name FROM l_qldp_size LEFT JOIN l_qldp_loai ON l_qldp_size.id_loai = l_qldp_loai.id_loai LEFT JOIN l_qldp_nsx ON l_qldp_size.id = l_qldp_nsx.id;";
        $size = DB::select($sql);
        $json_data['data'] = $size;
        $data = json_encode($json_data);
        echo $data;
    }

    //
    function xoasize($id)
    {
        try {
            $size = "DELETE FROM l_qldp_size WHERE idsz = $id;";
            $result = DB::delete($size);
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }


    //
    function sua_size($id)
    {
        $sql = "SELECT * FROM l_qldp_size WHERE l_qldp_size.idsz = " . $id;
        $info = DB::select($sql);
        $nsx = DB::select("select l_qldp_nsx.id as `id`, `name` as `text`,if(l_qldp_size.id is null,'0','1') as selected from `l_qldp_nsx` LEFT JOIN (SELECT l_qldp_size.id FROM l_qldp_size WHERE l_qldp_size.idsz = " . $id . ") AS l_qldp_size ON l_qldp_nsx.id = l_qldp_size.id   order by l_qldp_nsx.id asc");

        $loai = DB::select("SELECT id,text,if(id_loai is null,0,1) as selected FROM (SELECT l_qldp_loai.id_loai as id, l_qldp_loai.name as text FROM `l_qldp_loai` WHERE l_qldp_loai.id IN (SELECT l_qldp_size.id FROM l_qldp_size WHERE l_qldp_size.idsz = ".$id.")) AS DANHMUCLOAI LEFT JOIN (SELECT l_qldp_size.id_loai FROM l_qldp_size WHERE l_qldp_size.idsz= ".$id.") SIZELOAI ON DANHMUCLOAI.id = SIZELOAI.id_loai");

        foreach ($loai as $key => $value) {
            if ($value->selected == 1) {
                $value->selected = true;
            } else {
                $value->selected = false;
            }
        }
        //

        //
        foreach ($nsx as $key => $value) {
            if ($value->selected == 1) {
                $value->selected = true;
            } else {
                $value->selected = false;
            }
        }
        //

        //

        $result = array(
            'info' => $info,
            'nsx'   => $nsx,
            'loai'   => $loai,
        );

        return $result;
    }
    function update_size(Request $request)
    {
        try {
            $id = $request->input('id');
            $sua_size_loai = $request->input('sua_size_loai');
            $sua_size_ten = $request->input('sua_size_ten');
            $sua_size_nsx = $request->input('sua_size_nsx');
            $sua_size_thongso = $request->input('sua_size_thongso');
            $nsx = "UPDATE `l_qldp_size` SET `id_loai` =  $sua_size_loai, `id` = $sua_size_nsx ,`thongso`=$sua_size_thongso,`namesize`=$sua_size_ten WHERE `idsz` =  $id";
            // Kiểm tra xem có bất kỳ hàng nào được cập nhật không
            $updatedRows = DB::table('l_qldp_size')
                ->where('idsz', $id)
                ->update([
                    'id_loai' => $sua_size_loai,
                    'namesize' => $sua_size_ten,
                    'id' => $sua_size_nsx,
                    'thongso' => $sua_size_thongso,
                ]);
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }

    function change_nsx($id){
        $res = DB::select("SELECT l_qldp_loai.id_loai as id, l_qldp_loai.name as text  FROM l_qldp_loai WHERE l_qldp_loai.id = ".$id);
        return $res;
    }
}
