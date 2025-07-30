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
use App\Exports\ExportAdmissionController;
use App\Exports\ExportAdmissionTTSVController;


use \App\Http\Controllers\User\Main\RegisterWishController;
use Exception;
use LDAP\Result;
use Nette\Utils\Strings;
use Psy\Command\WhereamiCommand;

use function PHPSTORM_META\type;
use function PHPUnit\Framework\countOf;

class AdmissionController extends Controller

{
    public function index(){
        return view('admin.admission.index',
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

        $method0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Phương thức",
                'selected' => true
            ]
        );

        $methods = DB::table('l_method')
        ->select('id','name_method as text')
        ->get();
        $methods[] = $method0;

        $years0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Năm tuyển sinh",
                'selected' => true
            ]
        );

        $years = DB::table('l_years')
        ->select('id','course as text')
        ->get();
        $years[] = $years0;

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

        $hktt0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Tỉnh/Thành Phố",
                'selected' => true
            ]
        );
        $hktts = DB::table('l_province')
        ->select('id','name_province as text')
        ->get();
        $hktts[] = $hktt0;

        $result = array(
            'major' => $major_method,
            'batch' => $batchs,
            'year' => $years,
            'method' => $methods,
            'hktt' => $hktts,
        );
        return $result;
    }

    public function list_elect(Request $request){
        $year = $request ->input('data')[0];
        $batch = $request ->input('data')[1];
        $method = $request ->input('data')[2];
        $major = $request ->input('data')[3];
        $nvqs_id_card = $request ->input('data')[4];
        $elect_id = $request ->input('data')[5];
        $type_top = $request ->input('data')[6];
        $hktt = $request ->input('data')[7];

        if( $hktt == 0){
            $hktt = 'AND l_info_users.id_khttprovince_user is not null';
        }else{
            $hktt = 'AND l_info_users.id_khttprovince_user  = '.$hktt;
        }


        if( $year == 0){
            $year = 'AND l_users.id_year is not null';
        }else{
            $year = 'AND l_users.id_year  = '.$year;
        }

        if( $batch == 0){
            $batch = 'AND l_info_users.id_batch is not null';
        }else{
            $batch = 'AND l_info_users.id_batch  = '.$batch;
        }

        if( $method == 0){
            $method1 = 'AND l_method.id is not null';
            $method2 = 'l_wish.id_method is not null';
        }else{
            $method1 = 'AND l_method.id  = '.$method;
            $method2 = 'l_wish.id_method  = '.$method;
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
            $elect_id = 'AND l_info_users.id_user is not null';
        }else{
            $elect_id = 'AND l_info_users.id_user = '.$elect_id;
        }

        if($type_top == 1){
            $sql = "SELECT if(l_info_users.maphieu is not null, maphieu, '') as maphieu, l_method.name_method, ROW_NUMBER() OVER(ORDER BY l_info_users.id_user) as stt, l_wish.mark, if(l_info_users.sex_user = 0,'Nam','Nữ') as sex_user, l_info_users.id_user, l_info_users.name_user, DATE_FORMAT(l_info_users.birth_user,'%d/%m/%Y') as birth_user, l_users.id_card_users,l_users.phone_users, l_users.email_users, l_major.name_major FROM `l_wish` INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_major.id = l_method_major.id_major INNER JOIN l_users ON l_users.id = l_wish.id_user INNER JOIN l_info_users ON l_info_users.id_user = l_users.id INNER JOIN l_method ON l_method.id = l_wish.id_method WHERE l_wish.id IN (SELECT l_go_batch_pass.id_wish FROM l_go_batch_pass WHERE l_go_batch_pass.id_batch = 18 AND l_go_batch_pass.pass_bo = 1) AND l_wish.id_user IN (SELECT l_go_mssv.id_user FROM l_go_mssv)".$batch." ".$major." ".$nvqs_id_card." ".$elect_id." ".$year." ".$method1." ".$hktt." ORDER BY l_wish.mark DESC";
            $infor = DB::select($sql);
        }else{
            $sql = " SELECT l_method.name_method, ROW_NUMBER() OVER(ORDER BY l_info_users.id_user) as stt, l_wish.mark, if(l_info_users.sex_user = 0,'Nam','Nữ') as sex_user, l_info_users.id_user, l_info_users.name_user, DATE_FORMAT(l_info_users.birth_user,'%d/%m/%Y') as birth_user, l_users.id_card_users,l_users.phone_users, l_users.email_users, l_major.name_major FROM `l_wish` INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_major.id = l_method_major.id_major INNER JOIN l_users ON l_users.id = l_wish.id_user INNER JOIN l_info_users ON l_info_users.id_user = l_users.id INNER JOIN l_method ON l_method.id = l_wish.id_method  INNER JOIN (SELECT * FROM l_go_mssv INNER JOIN (SELECT l_wish.id_user as id_user1, l_major.id as id1 FROM l_go_batch_pass INNER JOIN l_wish ON l_wish.id = l_go_batch_pass.id_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_go_batch_pass.id_batch = 18 AND l_go_batch_pass.pass_bo = 1) AS TT ON TT.id_user1 = l_go_mssv.id_user) AS NH ON l_wish.id_user = NH.id_user1 AND l_major.id = NH.id1 WHERE ".$method2." ".$batch." ".$major." ".$nvqs_id_card." ".$elect_id." ".$year." ".$hktt." ORDER BY l_wish.mark DESC";
            $infor = DB::select($sql);
        }
        $json_data['data'] = $infor;
        $data = json_encode($json_data);
        echo  $data;
    }

    public function elect_exp($elect_year,$elect_batch,$elect_method,$elect_majo,$elect_id_card,$elect_id,$elect_hktt,$type_tops){
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DanhSachNhapHocDiem_'.date("d-m-Y H:i:s").'.xlsx';
        return Excel::download(new ExportAdmissionController($elect_year,$elect_batch,$elect_method,$elect_majo,$elect_id_card,$elect_id,$elect_hktt,$type_tops),$title);
    }



    public function elect_ttsv($elect_year,$elect_id_card,$elect_id,$elect_hktt){
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DanhSachNhapHocTTSV_'.date("d-m-Y H:i:s").'.xlsx';
        return Excel::download(new ExportAdmissionTTSVController($elect_year,$elect_id_card,$elect_id,$elect_hktt),$title);
    }



}
