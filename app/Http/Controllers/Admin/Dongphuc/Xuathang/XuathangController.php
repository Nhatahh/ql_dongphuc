<?php

namespace App\Http\Controllers\Admin\Dongphuc\Xuathang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class XuathangController extends Controller
{

    function index(){
        return view('admin.dongphuc.xuatsp');
    }


    function xuathang_alllop(Request $request)
    {
        $xuathang_alllop = $request->input('xuathang_alllop');
        $sql = "SELECT TTSV.id as id, mssv, ho_ten, cccd, MAJOR.lop FROM (SELECT l_users.id as id, l_go_mssv.mssv as mssv, l_info_users.name_user as ho_ten, l_users.id_card_users as cccd FROM `l_info_users` INNER JOIN l_go_mssv ON l_go_mssv.id_user = l_info_users.id_user INNER JOIN l_users ON l_users.id = l_info_users.id_user) AS TTSV INNER JOIN (SELECT l_wish.id_user, l_major.id, l_major.lop FROM l_wish INNER JOIN l_go_batch_pass ON l_go_batch_pass.id_wish = l_wish.id INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE pass_bo = 1 AND l_go_batch_pass.id_batch = 18 AND l_major.id = ".$xuathang_alllop.") AS MAJOR
        ON TTSV.id = MAJOR.id_user";
        $result = DB::select($sql);
        $json_data['data'] = $result;
        $data = json_encode($json_data);
        echo $data;
    }

    function show_xuathang()
    {
        $sql_product = "SELECT *,l_qldp_loai.id_loai as id_loai, l_qldp_loai.id as id, if(soluong is null, 0,soluong) as soluong1 FROM (SELECT l_qldp_loai.id_loai, l_qldp_nsx.name as name1 , l_qldp_loai.name as name, l_qldp_nsx.id as id FROM `l_qldp_loai` INNER JOIN l_qldp_nsx ON l_qldp_nsx.id = l_qldp_loai.id WHERE l_qldp_loai.trangthai = 1) AS l_qldp_loai LEFT JOIN (SELECT l_qldp_loai_nhap.id_loai, l_qldp_loai_nhap.id, if(sum(l_qldp_loai_nhap.soluong) is null,0,sum(l_qldp_loai_nhap.soluong)) as soluong FROM l_qldp_loai_nhap GROUP BY l_qldp_loai_nhap.id_loai,l_qldp_loai_nhap.id) as SL ON l_qldp_loai.id_loai = SL.id_loai AND l_qldp_loai.id = SL.id  LEFT JOIN
        (SELECT  l_qldp_ban.id_loai,l_qldp_ban.id_nsx, sum(soluong) as soluongban FROM l_qldp_ban GROUP BY l_qldp_ban.id_loai,l_qldp_ban.id_nsx) AS SLBAN ON l_qldp_loai.id_loai = SLBAN.id_loai AND l_qldp_loai.id = SLBAN.id_nsx";
        $list_product = DB::select($sql_product);
        foreach ($list_product as $key => $value) {
            $sql_size = "SELECT * FROM l_qldp_size WHERE id_loai = $value->id_loai AND l_qldp_size.id = $value->id";
            $list_size = DB::select($sql_size);
            $value->size = array(
                'size' =>$list_size,
                'id_loai' => $value->id_loai,
                'id_nsx' => $value->id
            );
        }

        $json_data['data'] = $list_product;
        $data = json_encode($json_data);
        echo  $data;
    }


    function change_size($id_loai,$id_nsx){
        $sqlnhap = "SELECT id_loai,id, SUM(soluong) as soluongnhap FROM l_qldp_loai_nhap WHERE id_loai = ".$id_loai." AND id = ".$id_nsx." GROUP BY id_loai, id";
        $sqlban = "SELECT l_qldp_ban.id_loai,l_qldp_ban.id_nsx, SUM(soluong) as soluongban FROM l_qldp_ban WHERE id_nsx = ".$id_nsx." AND  id_loai = ".$id_loai." GROUP BY id_nsx,id_nsx";
        $nhap = DB::select($sqlnhap);
        $ban = DB::select($sqlban);

        if(count($nhap) >0){
            $nhap = $nhap[0]->soluongnhap;
        }else{
            $nhap = 0;
        }

        count($ban) > 0 ? $ban = $ban[0]->soluongban : $ban = 0;

        return  $nhap - $ban;
    }

    //

    function xh_alllop(){
        $nsx = DB::table('l_major')
            ->select('l_major.id as id', 'lop as text')
            ->where('lop','!=','0')
            ->get();
        return $nsx;
    }
    function banhang(Request $request)
    {
        $list_banhang = $request->input('list_banhang');
        $idsv = $request->input('idsv');
        $name = DB::table('users')->where("id", Auth::user()->id)->get();
        $namehd= $name[0]->id;
        $tmp=0;
        //
        // $id_hd_new = 0;
        $id_hd ="SELECT MAX(id_hd) as id_hd FROM l_qldp_ban";
        $id_max = DB::select($id_hd)[0]->id_hd;
        // $sql_get_id_hd=DB::select($id_hd);

        $id_hd_new = $id_max + 1;//LẤY MAX ID
        //




        for ($i = 0; $i < count($list_banhang); $i++) {
            $id_loai = $list_banhang[$i][0];
            $id_nsx = $list_banhang[$i][1];
            $soluong = $list_banhang[$i][3];
            $ton = $this->change_size($id_loai,$id_nsx);
            $k = 0;
            if($ton - $soluong < 0){
                $k++;
                break;
            }
        }

        if($k == 0){
            DB::beginTransaction();
            try {
                for ($i = 0; $i < count($list_banhang); $i++) {

                    // Thêm mục vào mảng tạm thời
                    $sql_banhang =DB::table('l_qldp_ban')->insert([
                        'id_loai' => $list_banhang[$i][0],
                        'id_nsx' =>  $list_banhang[$i][1],
                        'id_size' => $list_banhang[$i][2],
                        'soluong' => $list_banhang[$i][3],
                        'id_sv' => $idsv,
                        'id_hd'=>$id_hd_new,
                        'idacc'=>$namehd,
                        ]);
                        $tmp=$tmp+1;
                }
                DB::commit();

                $res = array(
                    "active" => 1,
                    "id_hd" => $id_hd_new,
                );

            } catch (Exception $e) {
                DB::rollBack();
                $res = array(
                    "active" => 0,
                    "id_hd" => 0,
                );

            }
        }else{
            $res = array(
                "active" => 2,
                "id_hd" => 0,
            );
        }
        return $res;
    }
}
