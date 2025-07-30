<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportGoList;
use App\Imports\ImportGoInfoList;
use App\Imports\ImportGoPolicyList;
use App\Exports\GoDataList;
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

class GoDataBoController extends Controller

{
    public function index(){
        return view('admin.go_data.index',
        [
            'title' => "CTUT|Hệ thống đăng ký xét tuyển",
        ]);
    }

    //Check đăng ký



    public function load_go_year(){
        $year0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Năm Tuyển sinh",
                'selected' => true
            ]
        );
        $years = DB::table('l_years')
        ->select('id','course as text')
        ->get();
        $years[] = $year0;
        $result = array(
            'year' => $years,
        );
        return $result;
    }

    public function import_go_data_list(Request $request){
        $year = DB::table('l_year_active')
        ->get();
        if($year[0]->open_go_bo == 1){
            DB::beginTransaction();
            try{
                Excel::import(new ImportGoList, $request->file('import_go_data_list'));
                $year = DB::table('l_year_active')
                ->join('l_years','l_years.id','l_year_active.id_year')
                ->get();
                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                DB::table('l_history')
                ->insert([
                    'id_student'    =>  0,
                    'id_user'       =>  Auth::user()->id,
                    'name_history'  =>  'Import danh sách tài khoản',
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

    public function import_go_info_list(Request $request){
        $year = DB::table('l_year_active')
        ->get();
        if($year[0]->open_go_bo == 1){
            DB::beginTransaction();
            try{
                Excel::import(new ImportGoInfoList, $request->file('import_go_info_list'));
                $year = DB::table('l_year_active')
                ->join('l_years','l_years.id','l_year_active.id_year')
                ->get();
                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                DB::table('l_history')
                ->insert([
                    'id_student'    =>  0,
                    'id_user'       =>  Auth::user()->id,
                    'name_history'  =>  'Import danh sách thí sinh',
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

    public function import_go_policy_list(Request $request){
        $year = DB::table('l_year_active')
        ->get();
        if($year[0]->open_go_bo == 1){
            DB::beginTransaction();
            try{
                Excel::import(new ImportGoPolicyList, $request->file('import_go_policy_list'));
                $year = DB::table('l_year_active')
                ->join('l_years','l_years.id','l_year_active.id_year')
                ->get();
                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                DB::table('l_history')
                ->insert([
                    'id_student'    =>  0,
                    'id_user'       =>  Auth::user()->id,
                    'name_history'  =>  'Import đối tượng ưu tiên',
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

    public function load_go_data_acc(){
        $year = DB::table('l_year_active')
        ->get();
        $infor = DB::table('l_users')
        ->select('l_users.id as id','id_card_users','name_user','birth_user','phone_users','email_users','course','name_policy_user','id_priority_area')
        ->join('l_years','l_years.id','l_users.id_year')

        ->leftJoin('l_policy_users_reg','l_policy_users_reg.id_user','l_users.id')
        ->leftJoin('l_policy_users','l_policy_users.id','l_policy_users_reg.id_policy_users')
        ->leftJoin('l_info_users','l_info_users.id_user','l_users.id')
        ->leftJoin('l_priority_area','l_priority_area.id','l_info_users.id_priority_area_user')
        ->where('l_users.id_batch',$year[0] ->id_batch)
        ->where('l_users.id_year', $year[0] ->id_year)
        ->get();

        $json_data['data'] = $infor;
        $data = json_encode($json_data);
        echo  $data;

    }


    public function download_go_data_list(){
        $year = DB::table('l_year_active')
        ->get();

        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DanhSachTaiKhoan_'.date("d-m-Y H:i:s").'.xlsx';
        return Excel::download(new GoDataList(1,$year[0] ->id_year,$year[0]->id_batch),$title);
    }



}
