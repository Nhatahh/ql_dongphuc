<?php

namespace App\Http\Controllers\Admin;
use PDF;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Mail\Check_user;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use PhpOption\Option;
use PhpParser\Node\Expr\FuncCall;
use \App\Http\Controllers\User\Main\InfoUserController;
use \App\Http\Controllers\Admin\YearBatchController;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportInvestigateController;

use \App\Http\Controllers\User\Main\RegisterWishController;
use Exception;
use LDAP\Result;
use Nette\Utils\Strings;
use Psy\Command\WhereamiCommand;

use function PHPUnit\Framework\countOf;

class QlsvNvqsController extends Controller

{
    public function index(){
        return view('admin.qlsv_nvqs.index',
        [
            'title' => "CTUT|Hệ thống đăng ký xét tuyển",
        ]);
    }

    public function nvqs_print_nvqs($where, $load_admin_sig){
        if($load_admin_sig == 0){
            $admin_sig = '';
        }else{
            $admin_sig = DB::table('l_file_qlsv_nvqs_sig')
            ->where('id',$load_admin_sig)
            ->get()[0]->name;
        }

        $sql ="SELECT if(l_info_users.sex_user = 0,'Nữ','Nam') as sex_user,l_go_mssv.mssv, l_major.khoa, l_major.lop,l_major.tgnhaphoc, l_major.tgratruong, l_major.thoigian, DATE_FORMAT(l_info_users.date_card ,'%d/%m/%Y') as date_card, noicap.name_province as noicap, CONCAT(l_province3.name_province3,', ',l_province2.name_province2,', ',l_province.name_province) as hktt, l_info_users.id_user, l_info_users.name_user,DATE_FORMAT(l_info_users.birth_user,'%d/%m/%Y') as birth_user, l_info_users.address_user, l_users.id_card_users,l_users.phone_users, l_users.email_users, l_major.name_major FROM `l_wish` INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_major.id = l_method_major.id_major INNER JOIN l_users ON l_users.id = l_wish.id_user INNER JOIN l_info_users ON l_info_users.id_user = l_users.id INNER JOIN l_go_mssv ON l_go_mssv.id_user = l_info_users.id_user LEFT JOIN l_province ON l_province.id = l_info_users.id_khttprovince_user LEFT JOIN l_province2 ON l_info_users.id_khttprovince2_user = l_province2.id LEFT JOIN l_province3 ON l_info_users.id_khttprovince3_user = l_province3.id LEFT JOIN (SELECT l_province.id as id, l_province.name_province FROM l_province) as noicap ON noicap.id = l_info_users.id_place_card WHERE l_wish.id IN (SELECT l_go_batch_pass.id_wish FROM l_go_batch_pass WHERE l_go_batch_pass.id_batch = 18 AND l_go_batch_pass.pass_bo = 1) AND l_info_users.id_user IN (".$where.")";

        $infor = DB::select($sql);
        $i = 0;

        foreach ($infor as $key => $value) {
            if($value->sex_user == 1){
                $i++;
                break;
            }
        }
        if($i > 0){
            return 0;
        }else{
            if((int)Carbon::today()->day<10){
            $day = "0".Carbon::today()->day;
            }else{
                $day = Carbon::today()->day;
            }
            if((int)Carbon::today()->month<3){
                $month = "0".Carbon::today()->month;
            }else{
                $month = Carbon::today()->month;
            }
            $id_start1 = DB::select("SELECT if(max(id) is null,0, max(id)) as max FROM `l_file_qlsv_nvqs` WHERE id_year = ".Carbon::today()->year." ORDER BY id DESC LIMIT 1")[0]->max;
            $id_start = 1+$id_start1;
            foreach ($infor as $key => $value) {
                if($id_start < 10){
                        $sodon = "0000".$id_start;
                }elseif($id_start>=10 && $id_start <100){
                        $sodon = "000".$id_start;
                    }elseif($id_start>=100 && $id_start <1000){
                        $sodon = "00".$id_start;
                        }elseif($id_start>=100 && $id_start <1000){
                            $sodon = "0".$id_start;
                        }else{
                            $sodon = $id_start;
                        }
                $lan = DB::select("SELECT count(*) as lan FROM `l_file_qlsv_nvqs` WHERE id_user = ".$value->id_user)[0]->lan;
                $maphieu =  "Số L".(1+$lan).".".$sodon.".2023.NVQS";
                $data_tem = array(
                    'sodon' => $maphieu,
                    'id_user' =>  $value->id_user,
                    'name_user' =>  $value->name_user,
                    'birth_user' =>  $value->birth_user,
                    'phone_users' =>  $value->phone_users,
                    'id_card_users' =>  $value->id_card_users,
                    'id_card_users' =>  $value->id_card_users,
                    'noicap' =>  $value->noicap,
                    'date_card' =>  $value->date_card,
                    'hktt' =>  $value->hktt,
                    'name_major' =>  $value->name_major,
                    'khoa' =>  $value->khoa,
                    'lop' =>  $value->lop,
                    'tgnhaphoc' =>  $value->tgnhaphoc,
                    'tgratruong' =>  $value->tgratruong,
                    'thoigian' =>  $value->thoigian,
                    'mssv' =>  $value->mssv,
                    'day' =>  $day,
                    'month' => $month,
                    'year' =>  Carbon::today()->year,
                    'admin_sig' => $admin_sig,
                );
                $data[] = $data_tem;
                DB::table('l_file_qlsv_nvqs')
                ->insert(
                    [
                        'id_user' => $value->id_user,
                        'id_year' => Carbon::today()->year,
                        'maphieu' => $maphieu,
                        'id_admin' => Auth::user()->id,
                        'admin_sig' =>  $load_admin_sig,
                    ],
                );
                $id_start++;
            }
            $res = [
                'infor' => $data
            ];
            $pdf = PDF::loadView('pdf.qlsv_nvqs',$res);
            return $pdf->stream('GXNNghiaVuQuanSu.pdf');
        }
    }

    // public function nvqs_print_vv($major, $nvqs_id_card, $mssv, $load_admin_sig, $sex ){
    public function nvqs_print_vv($where, $load_admin_sig){
        if($load_admin_sig == 0){
            $admin_sig = '';
        }else{
            $admin_sig = DB::table('l_file_qlsv_nvqs_sig')
            ->where('id',$load_admin_sig)
            ->get()[0]->name;
        }

        // return $where;
        $sql ="SELECT if(l_info_users.sex_user = 1,'Nữ','Nam') as sex_user,l_go_mssv.mssv, l_major.khoa, l_major.lop,l_major.tgnhaphoc, l_major.tgratruong, l_major.thoigian, DATE_FORMAT(l_info_users.date_card ,'%d/%m/%Y') as date_card, noicap.name_province as noicap, CONCAT(l_province3.name_province3,', ',l_province2.name_province2,', ',l_province.name_province) as hktt, l_info_users.id_user, l_info_users.name_user,DATE_FORMAT(l_info_users.birth_user,'%d/%m/%Y') as birth_user, l_info_users.address_user, l_users.id_card_users,l_users.phone_users, l_users.email_users, l_major.name_major FROM `l_wish` INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_major.id = l_method_major.id_major INNER JOIN l_users ON l_users.id = l_wish.id_user INNER JOIN l_info_users ON l_info_users.id_user = l_users.id INNER JOIN l_go_mssv ON l_go_mssv.id_user = l_info_users.id_user LEFT JOIN l_province ON l_province.id = l_info_users.id_khttprovince_user LEFT JOIN l_province2 ON l_info_users.id_khttprovince2_user = l_province2.id LEFT JOIN l_province3 ON l_info_users.id_khttprovince3_user = l_province3.id LEFT JOIN (SELECT l_province.id as id, l_province.name_province FROM l_province) as noicap ON noicap.id = l_info_users.id_place_card WHERE l_wish.id IN (SELECT l_go_batch_pass.id_wish FROM l_go_batch_pass WHERE l_go_batch_pass.id_batch = 18 AND l_go_batch_pass.pass_bo = 1) AND l_info_users.id_user IN (".$where.")";
        $infor = DB::select($sql);
        if(count($infor)>0){
            if((int)Carbon::today()->day<10){
                $day = "0".Carbon::today()->day;
            }else{
                $day = Carbon::today()->day;
            }
            if((int)Carbon::today()->month<3){
                $month = "0".Carbon::today()->month;
            }else{
                $month = Carbon::today()->month;
            }
            $id_start1 = DB::select("SELECT if(max(id) is null,0, max(id)) as max FROM `l_file_qlsv_vv` WHERE id_year = ".Carbon::today()->year." ORDER BY id DESC LIMIT 1")[0]->max;
            $id_start = 1+$id_start1;
            foreach ($infor as $key => $value) {
                if($id_start < 10){
                        $sodon = "0000".$id_start;
                }elseif($id_start>=10 && $id_start <100){
                        $sodon = "000".$id_start;
                    }elseif($id_start>=100 && $id_start <1000){
                        $sodon = "00".$id_start;
                        }elseif($id_start>=100 && $id_start <1000){
                            $sodon = "0".$id_start;
                        }else{
                            $sodon = $id_start;
                        }
                $lan = DB::select("SELECT count(*) as lan FROM `l_file_qlsv_vv` WHERE id_user = ".$value->id_user)[0]->lan;
                $maphieu =  "Số L".(1+$lan).".".$sodon.".2023.VV";
                if( $value->thoigian == "4.5 năm"){
                    $thang = "54 tháng";
                }else{
                    $thang = "48 tháng";
                }
                $data_tem = array(
                    'sodon' => $maphieu,
                    'id_user' =>  $value->id_user,
                    'name_user' =>  $value->name_user,
                    'birth_user' =>  $value->birth_user,
                    'phone_users' =>  $value->phone_users,
                    'id_card_users' =>  $value->id_card_users,
                    'id_card_users' =>  $value->id_card_users,
                    'noicap' =>  $value->noicap,
                    'date_card' =>  $value->date_card,
                    'hktt' =>  $value->hktt,
                    'name_major' =>  $value->name_major,
                    'khoa' =>  $value->khoa,
                    'lop' =>  $value->lop,
                    'tgnhaphoc' =>  $value->tgnhaphoc,
                    'tgratruong' =>  $value->tgratruong,
                    'thoigian' =>  $value->thoigian,
                    'mssv' =>  $value->mssv,
                    'day' =>  $day,
                    'month' => $month,
                    'year' =>  Carbon::today()->year,
                    'admin_sig' => $admin_sig,
                    'sex_user' => $value->sex_user,
                    'thang' => $thang,
                    'active' => 1,
                );
                $data[] = $data_tem;
                DB::table('l_file_qlsv_vv')
                ->insert(
                    [
                        'id_user' => $value->id_user,
                        'id_year' => Carbon::today()->year,
                        'maphieu' => $maphieu,
                        'id_admin' => Auth::user()->id,
                        'admin_sig' =>  $load_admin_sig,
                    ],
                );
                $id_start++;
            }
        }else{
            $data_tem = array(
                'active' => 0,
            );
            $data[] = $data_tem;
        }
        $res = [
            'infor' => $data
        ];
        $pdf = PDF::loadView('pdf.qlsv_vv',$res);
        return $pdf->stream('GXNVayVonSinhVien.pdf');
    }
    //Load Search
    public function load_search(){
        $major0 = new Collection(
            [
                'id' => 0,
                'text' =>"Ngành tuyển sinh",
                'selected' => true
            ]
        );
        $major_method = DB::select('SELECT l_major.id as id,l_major.name_major as text FROM l_year_batch INNER JOIN l_batch_method ON l_year_batch.id = l_batch_method.id_batch INNER JOIN l_method_major ON l_batch_method.id = l_method_major.id_method INNER JOIN l_major ON l_major.id = l_method_major.id_major GROUP BY l_major.id');
        $major_method[] = $major0;
        return $major_method;
    }


    public function load_admin_sig(){
        $sig0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn người ký",
                'selected' => true
            ]
        );
        $sig = DB::table('l_file_qlsv_nvqs_sig')
        ->select('id','name as text')
        ->get();
        $sig[] = $sig0;
        return $sig;
    }
    // public function change_batch($id_batch){
    //     $major0 = new Collection(
    //         [
    //             'id' => 0,
    //             'text' =>"Ngành tuyển sinh",
    //             'selected' => true
    //         ]
    //     );
    //     $major_method = DB::select('SELECT l_major.id as id,l_major.name_major as text FROM l_year_batch INNER JOIN l_batch_method ON l_year_batch.id = l_batch_method.id_batch INNER JOIN l_method_major ON l_batch_method.id = l_method_major.id_method INNER JOIN l_major ON l_major.id = l_method_major.id_major GROUP BY l_major.id');
    //     $major_method[] = $major0;
    //     return $major_method;
    // }

    public function list_nvqs(Request $request){
        $major = $request ->input('data')[0];
        $nvqs_id_card = $request ->input('data')[1];
        $mssv = $request ->input('data')[2];
        $sex = $request ->input('data')[3];

        if( $major == 0){
            $major = 'AND l_major.id  is not null';
        }else{
            $major = 'AND l_major.id  = '.$major;
        }

        if( $nvqs_id_card == '' ){
            $nvqs_id_card = 'AND l_major.id  is not null';
        }else{
            $nvqs_id_card = 'AND l_users.id_card_users = '.$nvqs_id_card;
        }

        if( $mssv == ''){
            $mssv = 'AND l_go_mssv.mssv is not null';
        }else{
            $mssv = 'AND l_go_mssv.mssv = "'.$mssv.'"';
        }

        if( $sex == 0){
            $sex = 'AND l_info_users.sex_user is not null';
        }else{
            if($sex == 1){
                $sex = "AND l_info_users.sex_user = 0";
            }else{
                $sex = "AND l_info_users.sex_user = 1";
            }
        }


        $sql = "SELECT ROW_NUMBER() OVER(ORDER BY  l_go_mssv.mssv) as stt, if(l_info_users.sex_user = 0,'Nam','Nữ') as sex_user , l_go_mssv.mssv, l_major.khoa, l_major.lop,l_major.tgnhaphoc, l_major.tgratruong, l_major.thoigian, DATE_FORMAT(l_info_users.date_card ,'%d/%m/%Y') as date_card, noicap.name_province as noicap, CONCAT(l_province3.name_province3,', ',l_province2.name_province2,', ',l_province.name_province) as hktt, l_info_users.id_user, l_info_users.name_user,DATE_FORMAT(l_info_users.birth_user,'%d/%m/%Y') as birth_user, l_info_users.address_user, l_users.id_card_users,l_users.phone_users, l_users.email_users, l_major.name_major FROM `l_wish` INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_major.id = l_method_major.id_major INNER JOIN l_users ON l_users.id = l_wish.id_user INNER JOIN l_info_users ON l_info_users.id_user = l_users.id INNER JOIN l_go_mssv ON l_go_mssv.id_user = l_info_users.id_user LEFT JOIN l_province ON l_province.id = l_info_users.id_khttprovince_user LEFT JOIN l_province2 ON l_info_users.id_khttprovince2_user = l_province2.id LEFT JOIN l_province3 ON l_info_users.id_khttprovince3_user = l_province3.id LEFT JOIN (SELECT l_province.id as id, l_province.name_province FROM l_province) as noicap ON noicap.id = l_info_users.id_place_card WHERE l_wish.id IN (SELECT l_go_batch_pass.id_wish FROM l_go_batch_pass WHERE l_go_batch_pass.id_batch = 18 AND l_go_batch_pass.pass_bo = 1) ".$sex." ".$major." ".$nvqs_id_card." ".$mssv;

        $infor = DB::select($sql);
        $json_data['data'] = $infor;
        $data = json_encode($json_data);
        echo  $data;
    }

}
