<?php

namespace App\Http\Controllers\Nhapsp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class SpnhapController extends Controller
{
    function l_listsp()
    {

        $listallsize = DB::table('l_qldp_size')
        ->select('idsz as id', 'namesize as text')
        ->orderBy('idsz', 'ASC')
        ->get();

        $listallnsx = DB::table('l_qldp_nsx')
        ->select('id as id','name as text')->orderBy('id', 'ASC')
        ->get();
       
        $listallsp = DB::table('l_qldp_loai')
        ->select('id_loai as id','name as text')
        ->orderBy('id_loai', 'ASC')
        ->get();
     
        $listallke = DB::table('ke')
        ->select('idk as id','name as text')->orderBy('idk', 'ASC')
        ->get();
        $listalldot = DB::table('l_qldp_dot')
        ->select('iddot as id','ten_dot as text')->orderBy('iddot', 'ASC')
        ->get();
        $res = array(
            'listallsize' => $listallsize,
            'listallnsx' => $listallnsx,
            'listallsp' => $listallsp,
            'listallke' => $listallke,
            'listalldot' => $listalldot,
        );
        return $res;
    }
// i
function nsp_them(Request $request)
{
    //
    

    try {
        $sln = $request->input('sln');
        $ngaynhap = $request->input('ngaynhap');
        $size = $request->input('size');
        $sp = $request->input('sp');
        $nsx = $request->input('nsx');
        $dot = $request->input('dot');
        // $ke = $request->input('ke');
        // $existingRecord = DB::table('kho')->where('id_loai', $sp)->select(['*']);
        // $existingRecord1 = DB::table('kho')->where('idsz', $size)->select(['*']);
        // $existingRecord2 = DB::table('kho')->where('idk', $ke)->select(['*']);
        // $existingRecord3 = DB::table('kho')->where('id', $nsx)->select(['*']);
        // //

        // $checkton = DB::table('kho')
        //     ->where('id_loai', $sp)
        //     ->where('idsz', $size)
        //     ->where('idk', $ke)
        //     ->where('id', $nsx)
        //     ->select(['slt'])
        //     ->first();

        // $chkton = 0;

        // if ($checkton !== null) {
        //     $chkton = $checkton->slt;
        // }

        // $checkke = DB::table('ke')
        //     ->where('idk', $ke)
        //     ->select(['slmax'])
        //     ->first();

        // $chkslmax = $checkke !== null ? $checkke->slmax : 0;

        // $chk = $chkslmax - $chkton;

        // // $existingRecord->exists()&&
        // if ($chk >  $sln) {
            $tmp = DB::table('l_qldp_loai_nhap')
            ->insert([
                'id_loai' => $sp,
                'idsz' => $size,
                // 'idk' =>  $ke,
                'id' => $nsx,
                'soluong' => $sln,
                'iddot' => $dot,
                'ngaynhap' => $ngaynhap
            ]);
            // 
            // if ($existingRecord->exists() && $existingRecord1->exists() && $existingRecord2->exists() && $existingRecord3->exists()) {
            //     $record = DB::table('kho')
            //         ->where('id_loai', $sp)->where('idsz', $size)
            //         ->where('id', $nsx)
            //         ->where('idk', $ke)->select(['*'])->first();
            //     $soluong_cu = $record->slt;
            //     $tmp1 = DB::table('kho')
            //         ->where('id', $nsx)
            //         ->where('id_loai', $sp)
            //         ->where('idsz', $size)
            //         ->where('idk', $ke)
            //         ->update([
            //             'slt' => $sln + $soluong_cu,
            //         ]);
            // } else {
            //     $tmp1 = DB::table('kho')->insert([
            //         'id_loai' => $sp,
            //         'idsz' => $size,
            //         'idk' => $ke,
            //         'id' => $nsx,
            //         'slt' => $sln,
            //     ]);
            // }
            return  1;
        }catch(Exception $e){
            return 0;
        }
        
}
// 
    function l_listspn() {
        $sql = "SELECT l_qldp_loai_nhap.*, l_qldp_loai.name AS loai_name, l_qldp_size.namesize, l_qldp_nsx.name AS nsx_name, ke.name AS ke_name, l_qldp_dot.ten_dot AS dot
                FROM l_qldp_loai_nhap
                LEFT JOIN l_qldp_loai ON l_qldp_loai_nhap.id_loai = l_qldp_loai.id_loai
                LEFT JOIN l_qldp_size ON l_qldp_loai_nhap.idsz = l_qldp_size.idsz
                LEFT JOIN l_qldp_nsx ON l_qldp_loai_nhap.id = l_qldp_nsx.id
                LEFT JOIN l_qldp_dot ON l_qldp_loai_nhap.iddot = l_qldp_dot.iddot
                LEFT JOIN ke ON l_qldp_loai_nhap.idk = ke.idk;";
        $loai_nhap = DB::select($sql);
        $json_data['data'] = $loai_nhap;
        $data = json_encode($json_data);
        echo $data;
    }

    function delete_nhapsp($id) {
        $nsx = "DELETE FROM l_qldp_loai_nhap
        WHERE idn = $id;";
        $result = DB::delete($nsx);
        if ($result > 0) {
            return 1;
        } else return 0;
    }

    function edit_ttnhap() {
        $listallsize = DB::table('l_qldp_size')
        ->select('idsz as id', 'namesize as text')
        ->orderBy('idsz', 'ASC')
        ->get();

        $listallnsx = DB::select("select l_qldp_nsx.id as `id`, `name` as `text`,if(loai.id is null,'fasle','true') as selected from `l_qldp_nsx` LEFT JOIN (SELECT * FROM l_qldp_loai_nhap WHERE l_qldp_loai_nhap.id = 2) AS loai ON l_qldp_nsx.id = loai.id   order by l_qldp_nsx.id asc");
        // ->select('id as id','name as text','selected')->orderBy('id', 'ASC')
        // ->get();
       
        $listallsp = DB::table('l_qldp_loai')
        ->select('id_loai as id','name as text')
        ->orderBy('id_loai', 'ASC')
        ->get();
     
        $listallke = DB::table('ke')
        ->select('idk as id','name as text')->orderBy('idk', 'ASC')
        ->get();
       
        $res = array(
            'listallsize' => $listallsize,
            'listallnsx' => $listallnsx,
            'listallsp' => $listallsp,
            'listallke' => $listallke,
        );
        return $res;
    }

    // 
    function edit_nhapsp($id)
    {
        $sql = "SELECT * FROM l_qldp_loai_nhap WHERE l_qldp_loai_nhap.idn = ". $id;
        $info = DB::select($sql);
        $nsx = DB::select("select l_qldp_nsx.id as `id`, `name` as `text`,if(loai.id is null,'0','1') as selected from `l_qldp_nsx` LEFT JOIN (SELECT l_qldp_loai_nhap.id FROM l_qldp_loai_nhap WHERE l_qldp_loai_nhap.idn = ".$id.") AS loai ON l_qldp_nsx.id = loai.id   order by l_qldp_nsx.id asc");
        $size = DB::select("select l_qldp_size.idsz as `id`, `namesize` as `text`,if(loai.idsz is null,'0','1') as selected from `l_qldp_size` LEFT JOIN (SELECT l_qldp_loai_nhap.idsz FROM l_qldp_loai_nhap WHERE l_qldp_loai_nhap.idn = ".$id.") AS loai ON l_qldp_size.idsz = loai.idsz   order by l_qldp_size.idsz asc");
        $ke = DB::select("select ke.idk as `id`, `name` as `text`,if(loai.idk is null,'0','1') as selected from `ke` LEFT JOIN (SELECT l_qldp_loai_nhap.idk FROM l_qldp_loai_nhap WHERE l_qldp_loai_nhap.idn = ".$id.") AS loai ON ke.idk = loai.idk   order by ke.idk asc");
        $loai = DB::select("select l_qldp_loai.id_loai as `id`, `name` as `text`,if(l_qldp_loai1.id_loai is null,'0','1') as selected from `l_qldp_loai` LEFT JOIN (SELECT l_qldp_loai_nhap.id_loai FROM l_qldp_loai_nhap WHERE l_qldp_loai_nhap.idn = ".$id.") AS l_qldp_loai1 ON l_qldp_loai.id_loai = l_qldp_loai1.id_loai   order by l_qldp_loai.id_loai asc");
       
        foreach ($loai as $key => $value) {
            if($value->selected == 1){
                $value->selected = true;
            }else{
                $value->selected = false;
            }
        }
        // 
        foreach ($size as $key => $value) {
            if($value->selected == 1){
                $value->selected = true;
            }else{
                $value->selected = false;
            }
        }
        // 
        foreach ($nsx as $key => $value) {
            if($value->selected == 1){
                $value->selected = true;
            }else{
                $value->selected = false;
            }
        }
        // 
        foreach ($ke as $key => $value) {
            if($value->selected == 1){
                $value->selected = true;
            }else{
                $value->selected = false;
            }
        }
        // 

        $result = array(
            'info' => $info,
            'nsx'   => $nsx,
            'size'   => $size,
            'ke'   => $ke,
            'loai'   => $loai,
        );

        return $result;
    }
    
    function truyentt(Request $request) {
        $nsp_nsx = $request->nsp_nsx;
        $loai = "SELECT `id` as `idnsx`, `id_loai` as `id`, `name` as `text` FROM `l_qldp_loai` WHERE `id`= $nsp_nsx;";
        $result = DB::select($loai);
        return $result;
    }

    
    function truyenttloai(Request $request) {
        $nsp_loai = $request->input('nsp_loai');
        $loai = "SELECT `idsz` as `id`, `namesize` as `text`, `thongso`, `id_loai` FROM `l_qldp_size` WHERE `id_loai` = $nsp_loai";
        $result = DB::select($loai);
        return $result;
    }
    
    
    function capnhatnhapsp(Request $request)
    {
        // try {
            $id = $request->input('id');
            $editnhapsp_ngay = $request->input('editnhapsp_ngay');
            $editnhap_loai = $request->input('editnhap_loai');
            $editnhap_size = $request->input('editnhap_size');
            $editnhap_nsx = $request->input('editnhap_nsx');
            $editnhap_ke = $request->input('editnhap_ke');
            $editnhap_sl = $request->input('editnhap_sl');
            $nhapsp = "UPDATE `l_qldp_loai_nhap` SET `id_loai` = '" . $editnhap_loai . "', `idsz` = '" . $editnhap_size . "', `id` = '" . $editnhap_nsx . "', `soluong` = '" . $editnhap_sl . "', `ngaynhap` = '" . $editnhapsp_ngay . "', `idk` = '" . $editnhap_ke . "' WHERE `idn` = " . $id;
            $result = DB::update($nhapsp);
            return 1;
        // } catch (Exception $e) {
        //     return 0;
        // }
    }
}



