<?php

namespace App\Http\Controllers\Admin\Dongphuc\Quanlysanpham;

use Illuminate\Http\Request;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class QuanlysanphamController extends Controller
{

    function index(){
        return view('admin.dongphuc.qlsp');
    }

    function addsp_tennsx($id)
    {
        $record = DB::table('l_qldp_loai')->where('id_loai', $id)->get();
        return $record;
    }
    function add_product(Request $request)
    {
        $tensp = $request->input('tensp');
        $addsp_tennsx = $request->input('addsp_tennsx');
        try {
            $existingRecord = DB::table('l_qldp_loai')->where('name', $request->input('tensp'));
            if (!$existingRecord->exists()) {
            // Nếu không tồn tại, thì chèn một bản ghi mới
                $record = DB::table('l_qldp_loai')->insert([
                    'name' => $tensp,
                    'id' => $addsp_tennsx,
                ]);
                if ($record > 0) {
                    return 1;
                }
            }
            else{
                return 0;
            }
        } catch (Exception $e) {
            return 2;
        }
    }

    function show_product()
    {
        $list_product = "SELECT l_qldp_loai.id_loai,l_qldp_loai.name as loai ,l_qldp_nsx.name as nsx,l_qldp_loai.trangthai as trangthai  FROM `l_qldp_loai`,`l_qldp_nsx` WHERE l_qldp_loai.id=l_qldp_nsx.id and l_qldp_loai.id_loai!=0 and l_qldp_nsx.id!=0";
        $json_data['data'] = DB::select($list_product);
        $data = json_encode($json_data);
        echo  $data;
    }

    function edit_product($id)
    {
        $sql = "SELECT * FROM l_qldp_loai WHERE l_qldp_loai.id_loai = " . $id;
        $info = DB::select($sql);
        $nsx = DB::select("select l_qldp_nsx.id as `id`, `name` as `text`,if(l_qldp_loai.id is null,'0','1') as selected from `l_qldp_nsx` LEFT JOIN (SELECT l_qldp_loai.id FROM l_qldp_loai WHERE l_qldp_loai.id_loai = $id) AS l_qldp_loai ON l_qldp_nsx.id = l_qldp_loai.id   order by l_qldp_nsx.id asc");
        foreach ($nsx as $key => $value) {
            if ($value->selected == 1) {
                $value->selected = true;
            } else {
                $value->selected = false;
            }
        }
        $result = array(
            'info' => $info,
            'nsx'   => $nsx,
        );

        return $result;
    }
    //
    function delete_product($id)
    {
        try {
            $loai = "DELETE FROM l_qldp_loai
            WHERE id_loai = $id;";
            $result = DB::delete($loai);
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }

    function capnhatloai(Request $request)
    {
        // try {
        $id = $request->input('id');
        $editproduct_loai = $request->input('editproduct_loai');
        $editproduct_nsx = $request->input('editproduct_nsx');
        $editproduct_trangthai = (int) $request->input('editproduct_trangthai');
        $nsx = "UPDATE `l_qldp_loai` SET `name` = '" . $editproduct_loai . "', `id` = '" . $editproduct_nsx . "',`trangthai`=$editproduct_trangthai WHERE `id_loai` = " . $id;
        $result = DB::update($nsx);
        return 1;
        // } catch (Exception $e) {
        //     return 0;
        // }
    }
}
