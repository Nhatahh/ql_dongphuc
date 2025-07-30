<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportGoMarkHB;
use App\Imports\ImportGoMarkTHPT;



use App\Exports\GoMark;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use PhpOption\Option;
use PhpParser\Node\Expr\FuncCall;
use \App\Http\Controllers\User\Main\InfoUserController;
use \App\Http\Controllers\Admin\YearBatchController;

use \App\Http\Controllers\User\Main\RegisterWishController;
use Exception;
use LDAP\Result;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Trim;
use Psy\Command\WhereamiCommand;

use function PHPUnit\Framework\countOf;

class GoDataMark extends Controller

{
    public function index(){
        return view('admin.go_mark.index',
        [
            'title' => "CTUT|Hệ thống đăng ký xét tuyển",
        ]);
    }

    //Check đăng ký

    public function import_go_mark_hb(Request $request){
        $year = DB::table('l_year_active')
        ->get();
        if($year[0]->open_go_bo == 1){
            DB::beginTransaction();
            try{
                Excel::import(new ImportGoMarkHB, $request->file('import_go_mark_hb'));
                $year = DB::table('l_year_active')
                ->join('l_years','l_years.id','l_year_active.id_year')
                ->get();
                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                DB::table('l_history')
                ->insert([
                    'id_student'    =>  0,
                    'id_user'       =>  Auth::user()->id,
                    'name_history'  =>  'Import điểm học bạ THPT',
                    'content'       =>  'Năm: '.$year[0] ->course,
                    'ip'            => request()->ip(),
                    'info_client'   => $user_agent
                ]);
                DB::commit();
                return 1;
            }catch(Exception $e){
                DB::rollBack();
                return 0;
            }
        }else{
            return 2;
        }
    }

    public function import_go_mark_thpt(Request $request){
        $year = DB::table('l_year_active')
        ->get();
        if($year[0]->open_go_bo == 1){
            DB::beginTransaction();
            try{
                Excel::import(new ImportGoMarkTHPT, $request->file('import_go_mark_thpt'));
                $year = DB::table('l_year_active')
                ->join('l_years','l_years.id','l_year_active.id_year')
                ->get();
                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                DB::table('l_history')
                ->insert([
                    'id_student'    =>  0,
                    'id_user'       =>  Auth::user()->id,
                    'name_history'  =>  'Import điểm THPT',
                    'content'       =>  'Năm: '.$year[0] ->course,
                    'ip'            => request()->ip(),
                    'info_client'   => $user_agent
                ]);
                DB::commit();
                return 1;
            }catch(Exception $e){
                DB::rollBack();
                return 0;
            }
        }else{
            return 2;
        }
    }

    public function load_go_mark(){
        $year = DB::table('l_year_active')
        ->get();
        $infor = DB::select('SELECT * FROM l_result INNER JOIN l_subject ON l_subject.id = l_result.id_subject INNER JOIN (SELECT l_users.id as id, l_users.id_card_users,l_info_users.name_user,l_years.course FROM l_users LEFT JOIN l_info_users ON l_users.id = l_info_users.id_user INNER JOIN l_years ON l_years.id = l_users.id_year WHERE l_users.id_batch = '.$year[0]->id_batch.' AND l_years.id = 1) as USER ON USER.id = l_result.id_student_result WHERE l_result.id_batch = '.$year[0]->id_batch.' AND l_result.id > 550000 ORDER BY USER.id ASC, l_result.id_class_result ASC, l_result.id_semester_result ASC, l_result.id_subject ASC');
        $json_data['data'] = $infor;
        $data = json_encode($json_data);
        echo  $data;
    }

    public function download_go_mark(){
        $year = DB::table('l_year_active')
        ->get();
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DanhSachDiem_'.date("d-m-Y H:i:s").'.xlsx';
        return Excel::download(new GoMark(1,$year[0] ->id_year,$year[0]->id_batch),$title);
    }
}
