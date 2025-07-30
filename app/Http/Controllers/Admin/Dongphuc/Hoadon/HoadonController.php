<?php

namespace App\Http\Controllers\Admin\Dongphuc\Hoadon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

class HoadonController extends Controller
{
    function index(){
        return view('admin.dongphuc.qlhoadon');
    }
    function show_bill()
    {
        $get_hd = "SELECT DISTINCT(l_qldp_ban.id_hd) as id_hd, CONCAT(DATE_FORMAT(l_qldp_ban.update_at,'%Y'),DATE_FORMAT(l_qldp_ban.update_at,'%m'),DATE_FORMAT(l_qldp_ban.update_at,'%d'),'.',l_qldp_ban.id_hd) as ngayhd,  users.name as nguoiphat, l_info_users.name_user as ho_ten, l_go_mssv.mssv as mssv, DATE_FORMAT(l_qldp_ban.update_at, '%d/%m/%Y') as update_at FROM l_qldp_ban INNER JOIN users ON users.id = l_qldp_ban.idacc INNER JOIN l_info_users ON l_qldp_ban.id_sv = l_info_users.id_user INNER JOIN l_go_mssv ON l_go_mssv.id_user = l_qldp_ban.id_sv";
        // $loai_nhap = DB::table('loai_nhap')
        //     // ->select('id_loai as id','name as text')
        //     // ->orderBy('id_loai', 'ASC')
        //     ->get();
        $json_data['data'] = DB::select($get_hd);
        $data = json_encode($json_data);
        echo  $data;
    }



    function printhd($id_hd)
    {
        $sql = "SELECT l_users.id_card_users as cccd, users.name as nguoiphat, DATE_FORMAT(l_info_users.birth_user,'%d/%m/%Y') as ngaysinh, CONCAT(DATE_FORMAT(l_qldp_ban.update_at,'%Y'),DATE_FORMAT(l_qldp_ban.update_at,'%m'),DATE_FORMAT(l_qldp_ban.update_at,'%d'),'.',".$id_hd.") as ngayhd, l_qldp_size.namesize as tensz, l_qldp_loai.name as tensp, l_qldp_ban.soluong, l_info_users.name_user as tensv, l_go_mssv.mssv as mssv, DATE_FORMAT(l_qldp_ban.update_at,'%d') as ngay,DATE_FORMAT(l_qldp_ban.update_at,'%m') as thang, DATE_FORMAT(l_qldp_ban.update_at,'%Y') as nam FROM `l_qldp_ban` INNER JOIN l_users ON l_users.id = l_qldp_ban.id_sv INNER JOIN users ON users.id = l_qldp_ban.idacc INNER JOIN  l_qldp_loai ON l_qldp_loai.id_loai = l_qldp_ban.id_loai INNER JOIN l_qldp_size ON l_qldp_ban.id_size = l_qldp_size.idsz INNER JOIN l_go_mssv ON l_qldp_ban.id_sv = l_go_mssv.id_user INNER JOIN l_info_users ON l_info_users.id_user = l_qldp_ban.id_sv WHERE  id_hd = ".$id_hd;
        $hoadon = DB::select($sql);
        $data = array(
            'hoadon' => $hoadon,
        );
        $pdf = PDF::loadView('admin.dongphuc.test', $data);
        return $pdf->stream('document.pdf');
    }

    function xoahoadon(Request $request){
        $id = $request->input('id');
        $del = DB::table('l_qldp_ban')
        ->where('id_hd',$id)
        ->delete();
        return $del;
    }
}
