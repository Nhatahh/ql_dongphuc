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

class ElectController extends Controller

{
    public function index(){
        return view('admin.elect.index',
        [
            'title' => "CTUT|Hệ thống đăng ký xét tuyển",
        ]);
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

        $batch0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Đợt tuyển sinh",
                'selected' => true
            ]
        );
        $batchs = DB::table('l_batch')
        ->select('id','name_batch as text')
        ->get();
        $batchs[] = $batch0;
        $result = array(
            'major' => $major_method,
            'batch' => $batchs,
        );
        return $result;
    }

    public function list_elect(Request $request){
        $batch = $request ->input('data')[0];
        $major = $request ->input('data')[1];
        $nvqs_id_card = $request ->input('data')[2];
        $elect_id = $request ->input('data')[3];


        if( $batch == 0){
            $batch = 'AND l_info_users.id_batch is not null';
        }else{
            $batch = 'AND l_info_users.id_batch  = '.$batch;
        }

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

        if( $elect_id == '' ){
            $elect_id = 'AND l_info_users.id_batch  is not null';
        }else{
            $elect_id = 'AND l_info_users.id_batch = '.$elect_id;
        }


        $sql = "SELECT if(l_info_users.maphieu is not null, maphieu, '') as maphieu, l_method.name_method, ROW_NUMBER() OVER(ORDER BY l_info_users.id_user) as stt, l_wish.mark, if(l_info_users.sex_user = 0,'Nam','Nữ') as sex_user, l_info_users.id_user, l_info_users.name_user, DATE_FORMAT(l_info_users.birth_user,'%d/%m/%Y') as birth_user, l_users.id_card_users,l_users.phone_users, l_users.email_users, l_major.name_major FROM `l_wish` INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_major.id = l_method_major.id_major INNER JOIN l_users ON l_users.id = l_wish.id_user INNER JOIN l_info_users ON l_info_users.id_user = l_users.id INNER JOIN l_method ON l_method.id = l_wish.id_method WHERE l_wish.id IN (SELECT l_go_batch_pass.id_wish FROM l_go_batch_pass WHERE l_go_batch_pass.id_batch = 18 AND l_go_batch_pass.pass_bo = 1)".$batch." ".$major." ".$nvqs_id_card." ".$elect_id;
        $infor = DB::select($sql);
        $json_data['data'] = $infor;
        $data = json_encode($json_data);
        echo  $data;
    }


    public function elect_print($where_base, $load_admin_sig){
        if($load_admin_sig == 0){
            $admin_sig = '';
        }else{
            $admin_sig = DB::table('l_file_qlsv_nvqs_sig')
            ->where('id',$load_admin_sig)
            ->get()[0]->name;
        }

        $where = base64_decode($where_base);
        $sql ="SELECT l_method.name_method, l_info_users.id_user, l_info_users.name_user, DATE_FORMAT(l_info_users.birth_user,'%d/%m/%Y') as birth_user, l_users.id_card_users, l_users.phone_users, l_major.name_major, l_major.id_major, l_wish.mark FROM `l_wish` INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_major.id = l_method_major.id_major INNER JOIN l_users ON l_users.id = l_wish.id_user INNER JOIN l_info_users ON l_info_users.id_user = l_users.id INNER JOIN l_method ON l_method.id = l_method_major.id_method WHERE l_wish.id IN (SELECT l_go_batch_pass.id_wish FROM l_go_batch_pass WHERE l_go_batch_pass.id_batch = 18 AND l_go_batch_pass.pass_bo = 1) AND l_info_users.id_user IN (".$where.") ORDER BY l_users.id ASC";
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
            foreach ($infor as $key => $value) {
                $check = DB::select("select * from `l_info_users` where `id_user` = ".$value->id_user." and `maphieu` is not null");
                if(count($check) == 1){
                    $maphieu = $check[0]->maphieu;
                }else{
                    $total = DB::select("SELECT Max(CONVERT(RIGHT(maphieu,4),SIGNED)) as max FROM `l_info_users` WHERE maphieu is not null");
                    if($total[0]->max>0){
                        $count = $total[0]->max;
                        $stt = 1+$count;
                    }else{
                        $count = 0;
                        $stt = 1;
                    }
                    $phandu =$count%500;
                    $phannguyen = ($count - $phandu)/500;
                    $box = $phannguyen + 1;
                    if($box <10){
                        $boxs = "0".$box;
                    }else{
                        $boxs = $box;
                    }
                    if($stt <10){
                        $stts = "000".$stt;
                    }else{
                        if($stt >=10 && $stt <=100 ){
                            $stts = "00".$stt;
                        }else{
                            if($stt >=10 && $stt <=100 ){
                                $stts = "0".$stt;
                            }else{
                                $stts = $stt;
                            }
                        }
                    }
                    $active_year = DB::table('l_year_active')
                    ->join('l_years','l_year_active.id_year','l_years.id')
                    ->get();
                    $maphieu = $active_year[0] ->course.".H".$boxs.".".$stts;

                    DB::table('l_info_users')
                    ->where('id_user',  $value->id_user)
                    ->update([
                        'maphieu' => $maphieu,
                    ]);
                }



                $data_tem = array(
                    'sodon' => $maphieu,
                    'id_user' =>  $value->id_user,
                    'name_user' =>  $value->name_user,
                    'birth_user' =>  $value->birth_user,
                    'id_card_users' =>  $value->id_card_users,
                    'name_major' =>  $value->name_major,
                    'id_major' =>  $value->id_major,
                    'name_method' =>  $value->name_method,
                    'mark' =>  $value->mark,
                    'day' =>  $day,
                    'month' => $month,
                    'year' =>  Carbon::today()->year,
                    'admin_sig' => $admin_sig,


                    'active' => 1,
                );
                $data[] = $data_tem;
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

        $pdf = PDF::loadView('pdf.phieutrungtuyen',$res);
        return $pdf->stream('PhieuTrungTuyen.pdf');
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



}
