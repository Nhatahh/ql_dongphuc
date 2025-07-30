<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

use \App\Http\Controllers\User\Main\RegisterWishController;
use Exception;
use LDAP\Result;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Trim;
use Psy\Command\WhereamiCommand;

use function PHPUnit\Framework\countOf;

class GoBatchBoController extends Controller

{
    public function index(){
        return view('admin.go_batch_bo.index',
        [
            'title' => "CTUT|Hệ thống đăng ký xét tuyển",
        ]);
    }

    //Check đăng ký


    public function load_go_batch_bo(){
        $batch = DB::table('l_go_batch_bo')
        ->orderBy('id','ASC')
        ->get();
        $json_data['data'] = $batch;
        $data = json_encode($json_data);
        echo  $data;
    }

    public function go_batch_bo_ts($id){
        $batchs_check = DB::table('l_go_batch_bo')
            ->where('id',$id)
            ->get();
        if(count($batchs_check) == 1){
            if($batchs_check[0] ->id_batch_ts != 0){
                $selected =  false;
                $type = 1;
            }else{
                $selected =  true;
                $type = 0;
            }
        }else{
            $selected =  true;
            $type = 0;

        }
        $batch0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Đợt tuyển sinh",
                'selected' => $selected
            ]
        );
        $batchs = DB::table('l_batch')
        ->select('id','name_batch as text')
        ->get();
        if($type == 1){
            foreach ($batchs as  $value) {
                if($batchs_check[0] ->id_batch_ts == $value->id){
                    $value ->selected = true;
                }else{
                    $value ->selected = false;
                }
            }
        }else{
            foreach ($batchs as  $value) {
                $value ->selected = false;
            }
        }
        $batchs[] =  $batch0;
        $result = array(
            // 'year' => $years,
            'batch' => $batchs,
            // 'user' => $user,
        );
        return $result;
    }

    public function add_go_batch_bo(Request $request){
        $validator = Validator::make($request->all(),
            [
                'id_batch' => 'required|unique:l_go_batch_bo,id_batch',
                'name_batch' => 'required|unique:l_go_batch_bo,name_go',
                'id_batch_ts' => 'required'
            ],
            [
                'id_batch.unique'         =>"Đã tồn tại mã đợt",
                'id_batch.required'      =>"Mã đợt không được trống",
                'name_batch.unique'         =>"Đã tồn tại tên đợt",
                'name_batch.required'      =>"Tên đợt đợt không được trống",
                'id_batch_ts.required'      =>"Chọn đợt tuyển sinh",
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }else{
            DB::beginTransaction();
            // try {

                $id_batch = (int)trim($request->input('id_batch')," ");
                $name_batch = (int)trim( $request->input('name_batch')," ");
                $id_batch_ts = (int)trim( $request->input('id_batch_ts')," ");
                DB::table('l_go_batch_bo')
                ->insert([
                    'id_batch' => $id_batch,
                    'name_go'   =>  $name_batch,
                    'id_batch_ts'   =>  $id_batch_ts,
                ]);

                $batch = DB::table('l_go_batch_bo')
                ->where('id_batch',$id_batch)
                ->get();

                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                DB::table('l_history')
                ->insert([
                    'id_student'    =>  0,
                    'id_user'       =>  Auth::user()->id,
                    'name_history'  =>  "Thêm đợt lọc ảo Bộ",
                    'content'       =>  'Đợt: '.$batch[0] ->name_go,
                    'ip'            => request()->ip(),
                    'info_client'   => $user_agent
                ]);

                DB::commit();
                echo  1;
            // }catch(Exception $e){
            //     DB::rollBack();
            //     echo 0;
            // }
        }
    }





    public function remove_go_batch(Request $request){
        $validator = Validator::make($request->all(),
            [
                'id_batch' => 'alpha_num|required'
            ],
            [
                'id_batch.required'      =>"Mã đợt không được trống",
                'id_batch.alpha_num'     =>"Không có đợt đang chọn",
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }else{
            DB::beginTransaction();
            try {

                $id = $request->input('id_batch');

                $batch = DB::table('l_go_batch_bo')
                ->where('id',$id)
                ->get();

                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                DB::table('l_history')
                ->insert([
                    'id_student'    =>  0,
                    'id_user'       =>  Auth::user()->id,
                    'name_history'  =>  "Xóa đợt lọc ảo Bộ",
                    'content'       =>  'Đợt: '.$batch[0] ->name_go,
                    'ip'            => request()->ip(),
                    'info_client'   => $user_agent
                ]);

                DB::table('l_go_batch_bo')
                ->where('id',$id)
                ->delete();

                DB::commit();
                echo 1;
            }catch(Exception $e){
                DB::rollBack();
                echo 0;
            }
        }
    }

    public function edit_go_batch($id){
        $batch = DB::table('l_go_batch_bo')
        ->where('id',$id)
        ->get();
        return $batch;
    }

    public function add_go_batch_bo_edit(Request $request){
        $validator = Validator::make($request->all(),
            [
                // 'id_batch'   => 'required|unique:l_go_batch_bo,id_batch',
                'id_batch'   => 'required',
                'name_batch' => 'required',
                'id'         => 'alpha_num|required'
            ],
            [
                // 'id_batch.unique'      =>"Đã tồn tại mã đợt",
                'id_batch.required'    =>"Mã đợt không được trống",
                'name_batch.required'  =>"Tên đợt đợt không được trống",
                'id.alpha_num'         =>"Có lỗi xảy ra, vui lòng load lại hệ thống",
            ],
        );

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }else{
            DB::beginTransaction();
            try {
                $id_batch = trim($request->input('id_batch')," ");
                $name_batch = trim( $request->input('name_batch')," ");
                $id = trim( $request->input('id')," ");
                DB::table('l_go_batch_bo')
                ->where('id',$id)
                ->update([
                    'id_batch' => $id_batch,
                    'name_go'   =>  $name_batch,
                ]);

                $batch = DB::table('l_go_batch_bo')
                ->where('id_batch',$id_batch)
                ->get();

                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                DB::table('l_history')
                ->insert([
                    'id_student'    =>  0,
                    'id_user'       =>  Auth::user()->id,
                    'name_history'  =>  "Cập nhật lọc ảo Bộ",
                    'content'       =>  'ID đợt: '.$batch[0] ->id_batch.' Tên đợt: '.$batch[0] ->name_go,
                    'ip'            => request()->ip(),
                    'info_client'   => $user_agent
                ]);

                DB::commit();
                echo  1;
            }catch(Exception $e){
                DB::rollBack();
                echo 0;
            }
        }
    }
    //Load năm tuyển sinh, đợt tuyển sinh
    // public function load_search(){
    //     $year0 = new Collection(
    //         [
    //             'id' => 0,
    //             'text' =>"Chọn Năm Tuyển sinh",
    //             'selected' => true
    //         ]
    //     );
    //     $years = DB::table('l_years')
    //     ->select('id','course as text')
    //     ->get();
    //     $years[] = $year0;

    //     //Batch
    //     $batch0 = new Collection(
    //         [
    //             'id' => 0,
    //             'text' =>"Chọn Đợt tuyển sinh",
    //             'selected' => true
    //         ]
    //     );
    //     $batchs = DB::table('l_batch')
    //     ->select('id','name_batch as text')
    //     ->get();
    //     $batchs[] = $batch0;

    //     $user0 =new Collection( [
    //         'id' => 0,
    //         'text' =>"Chọn nhân viên",
    //         'selected' => true
    //     ]);
    //     $sql ="SELECT users.name as text,users.id as id FROM `users` INNER JOIN l_check_ass ON users.id = l_check_ass.id_user ORDER BY users.id ASC";
    //     $user = DB::select($sql);
    //     $user[] = $user0;

    //     $result = array(
    //         'year' => $years,
    //         'batch' => $batchs,
    //         'user' => $user,
    //     );
    //     return $result;
    // }
        // lOAD NHAN VIEN









}
