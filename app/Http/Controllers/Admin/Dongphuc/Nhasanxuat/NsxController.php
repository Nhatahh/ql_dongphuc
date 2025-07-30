<?php

namespace App\Http\Controllers\Admin\Dongphuc\Nhasanxuat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class NsxController extends Controller
{


    function index(){
        return view('admin.dongphuc.qlnsx');
    }

    function nsx_tennsx()
    {
        $nsx = DB::table('l_qldp_nsx')
            ->select('id as id', 'name as text')
            ->orderBy('id', 'ASC')
            ->get();
        echo $nsx;
    }

    function nsx_them(Request $request)
    {
        DB::table('l_qldp_nsx')->insert([
            'name' => $request->input('ten'),
            'diachi' => $request->input('diachi'),

            'chucoso' => $request->input('chucoso'),

            'dienthoai' => $request->input('dienthoai'),

            'email' => $request->input('email'),
        ]);
        return 1;
    }



    function danhsachnsx()
    {
        $nsx = "SELECT id,name, chucoso, diachi, dienthoai, email FROM `l_qldp_nsx` WHERE id != 0";
        $json_data['data'] = DB::select($nsx);
        $data = json_encode($json_data);
        echo  $data;
    }

    //

    function delete_nsx($id)
    {
        try {
            $nsx = "DELETE FROM l_qldp_nsx
            WHERE id = $id;";
            $result = DB::delete($nsx);
            return 1;
        } catch (Exception $e) {
            return 0;
        };
    }

    //
    function edit_nsx($id)
    {
        $nsx = "SELECT * FROM l_qldp_nsx
        WHERE id = $id;";
        $result = DB::select($nsx);
        return $result;
    }

    function capnhatnsx(Request $request)
    {
        try {
            $id = $request->input('id');
            $editnsx_ten = $request->input('editnsx_ten');
            $editnsx_diachi = $request->input('editnsx_diachi');
            $editnsx_chucoso = $request->input('editnsx_chucoso');
            $editnsx_dienthoai = $request->input('editnsx_dienthoai');
            $editnsx_email = $request->input('editnsx_email');
            $nsx = "UPDATE `l_qldp_nsx` SET `name` = '" . $editnsx_ten . "', `diachi` = '" . $editnsx_diachi . "', `chucoso` = '" . $editnsx_chucoso . "', `dienthoai` = '" . $editnsx_dienthoai . "', `email` = '" . $editnsx_email . "' WHERE `id` = " . $id;
            $result = DB::update($nsx);
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }
}
