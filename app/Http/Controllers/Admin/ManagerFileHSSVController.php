<?php

namespace App\Http\Controllers\Admin;

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
use App\Exports\DanhSachHSSV;

use \App\Http\Controllers\User\Main\RegisterWishController;
use Exception;
use LDAP\Result;
use Psy\Command\WhereamiCommand;

use function PHPUnit\Framework\countOf;

class ManagerFileHSSVController extends Controller

{
    public function index(){
        return view('admin.manager_hssv.index',
        [
            'title' => "CTUT|Hệ thống đăng ký xét tuyển",
        ]);
    }
    //Load Search
    public function load_search(){
        //Batch
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
        $user0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Người thu",
                'selected' => true
            ]
        );
        $users = DB::table('users')
        ->select('id','name as text')
        ->get();
        $users[] = $user0;
        $result = array(
            'batch' => $batchs,
            'user' => $users,
        );
        return $result;
    }

    public function file_hssv_list ( $batch, $start, $end, $user){
        if(($start == 0 && $end != 0) || ($start != 0 && $end == 0)){
            return -1;
        }else{
            if($start == 0 && $end == 0){
                $day = '';
            }else{
                $day = "AND update_at >=  STR_TO_DATE('".$start." 00:00:00', '%Y-%m-%d %H:%i:%s') AND update_at <=  STR_TO_DATE( '".$end." 23:59:59', '%Y-%m-%d %H:%i:%s')";
            }

            if($user == 0){
                $user =  "WHERE id_admin is not null";
            }else{
                $user = "WHERE id_admin = ".$user;
            }

            $files = DB::select('SELECT * FROM l_file_list_hssv WHERE l_file_list_hssv.id_year IN (SELECT l_year_batch.id_year FROM l_year_batch WHERE l_year_batch.id_batch = '.$batch.')');
            $sql = "SELECT l_info_users.name_user as 'Họ và tên', DATE_FORMAT(l_info_users.birth_user,'%d/%m/%Y') as 'Ngày sinh' ,l_users.id_card_users as 'CMND/CCCD', l_users.phone_users as 'Điện thoại', HS.*, if(l_go_mssv.mssv is null, '', l_go_mssv.mssv)  as MSSV, if(l_file_hssv_block.id_user is null,0,1) as 'Khóa'  FROM l_users INNER JOIN l_info_users ON l_info_users.id_user = l_users.id INNER JOIN  (SELECT id_user as IDXT,";
            $i = 1;

            foreach ($files as $key => $value) {
                if($i == count($files)){
                    $sql .= "IF(COUNT(CASE WHEN l_file_list_student_hssv.id_file = ".$value->id." AND l_file_list_student_hssv.active = 1 THEN l_file_list_student_hssv.id_file ELSE NULL END) >0,'x','') AS '".$value->id_file."' ";
                }else{
                    $sql .= "IF(COUNT(CASE WHEN l_file_list_student_hssv.id_file = ".$value->id." AND l_file_list_student_hssv.active = 1 THEN l_file_list_student_hssv.id_file ELSE NULL END) >0,'x','') AS '".$value->id_file."', ";
                }
                $i++;
            }
            $sql .= " ,DATE_FORMAT(MAX(update_at),'%d/%m/%Y') as 'Ngày thu' FROM l_file_list_student_hssv ".$user." ".$day."  GROUP BY l_file_list_student_hssv.id_user) AS HS ON HS.IDXT = l_info_users.id_user LEFT JOIN l_file_hssv_block ON l_file_hssv_block.id_user = HS.IDXT INNER JOIN l_go_mssv ON l_go_mssv.id_user = HS.IDXT WHERE l_users.id_batch = " .$batch;
            $data = DB::select($sql);
            return $data;
        }
    }



    public function file_hssv_excel($batch,$start,$end,$user){
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DanhSachHSSV'.date("d-m-Y H:i:s").'.xlsx';
        return Excel::download(new DanhSachHSSV($batch,$start,$end,$user),$title);
    }



}
