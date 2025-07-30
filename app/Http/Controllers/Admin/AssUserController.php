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
use Psy\Command\WhereamiCommand;

use function PHPUnit\Framework\countOf;

class AssUserController extends Controller

{
    public function index(){
        return view('admin.assuser.index',
        [
            'title' => "CTUT|Hệ thống đăng ký xét tuyển",
        ]);
    }

    //Check đăng ký

    function check_block($id){
        $check = DB::table('l_check_assuser')
        ->where('id_student',$id)
        ->get();
        if(count($check) == 1){
            if($check[0]->check_user == 3){
                $check1 = 1;
            }else{
                $check1 = 0;
            }
        }else{
            $check1 = 0;
        }
        return $check1;
    }


    function check_feedback($id_student){
        $check = DB::table('l_check_assuser')
        ->where('id_student',$id_student)
        ->get();
        if(count($check) == 1){
            if($check[0]->check_user == 2){
                $check1 = 1;
            }else{
                $check1 = 0;
            }
        }else{
            $check1 = 0;
        }
        return $check1;
    }

    //Load năm tuyển sinh, đợt tuyển sinh
    public function load_search(){
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
        $batchs[] = $batch0;

        $user0 =new Collection( [
            'id' => 0,
            'text' =>"Chọn nhân viên",
            'selected' => true
        ]);
        $sql ="SELECT users.name as text,users.id as id FROM `users` INNER JOIN l_check_ass ON users.id = l_check_ass.id_user ORDER BY users.id ASC";
        $user = DB::select($sql);
        $user[] = $user0;

        $result = array(
            'year' => $years,
            'batch' => $batchs,
            'user' => $user,
        );
        return $result;
    }
        // lOAD NHAN VIEN
    public function load_list_ass(Request $request){
        $sql ="SELECT *,users.id as id FROM `users` INNER JOIN l_check_ass ON users.id = l_check_ass.id_user ORDER BY users.id ASC";
        $infor = DB::select($sql);
        $json_data['data'] = $infor;
        $data = json_encode($json_data);
        echo  $data;
    }

    public function load_list_assstudent($id_year,$id_batch,$day,$day_reg,$user,$ass,$check,$pass){

        if($id_year == 0){
            echo 0;
        }else{
            if($id_batch == 0){
                $id_batch = 'l_batch.id is not null';
            }else{
                $id_batch = 'l_batch.id = '.$id_batch;
            }

            if( $user == 0){
                $user  = 'l_block_wish.id_user is not null';
            }else{
                $user  = "l_check_assuser.id_user = ".$user;
            }


            if( $ass == 0){
                $ass  = 'l_block_wish.id_user is not null';
            }else{
                if($ass == 2){
                    $ass  = 'l_check_assuser.id_user is not null';
                }else{
                    $ass  = 'l_check_assuser.id_user is null';
                }
            }


            if( $check == 0){
                $check  = 'l_block_wish.id_user is not null';
            }else{
                $check  = 'l_check_assuser.check_user =' .$check;
            }

            if( $pass == 0){
                $pass  = 'l_block_wish.id_user is not null';
            }else{
                if($pass == 1){
                    $pass  = 'l_check_assuser.pass = 0';
                }else{
                    $pass  = 'l_check_assuser.pass = 1';
                }

            }

            if( $day == 0){
                $day  = 'l_block_wish.id_user is not null';
            }else{
                $day  = "l_check_assuser.ass_at LIKE  '".$day."%'";
            }

            if( $day_reg == 0){
                $day_reg  = 'l_block_wish.id_user is not null';
            }else{
                $day_reg  = "l_block_wish.create_at LIKE  '".$day_reg."%'";
            }
           // $sql ="SELECT l_check_assuser.pass as pass,IF(l_check_assuser.id_student >0,l_check_block.pass,0) as block,CONCAT(if(l_check_assuser.update_at is null,'',DATE_FORMAT(l_check_assuser.update_at,'%d/%m/%Y')),'-',l_users.id) as update_at,CONCAT(if(users.name is not null,users.name,''),'-', l_info_users.id_user) as name, CONCAT(l_info_users.id_user,'-',IF(l_check_assuser.id_student > 0,1,0),'-',IF(l_check_assuser.id_user >0,l_check_assuser.id_user,0),'-',IF(l_check_assuser.id >0, l_check_assuser.id,0),'-',IF(l_check_block.pass >0,l_check_block.pass,0),'-',IF(l_check_block.id >0,l_check_block.id,0)) as active, l_users.id as id, l_users.phone_users, l_users.email_users as email_users, l_users.id_card_users as id_card_users, l_info_users.name_user as name_user,l_info_users.graduation_year_user as year_user,l_batch.name_batch FROM l_users INNER JOIN l_info_users ON l_info_users.id_user = l_users.id INNER JOIN l_block_wish ON l_block_wish.id_user = l_users.id INNER JOIN l_batch ON l_batch.id = l_users.id_batch LEFT JOIN l_check_assuser ON l_check_assuser.id_student = l_info_users.id_user LEFT JOIN users ON users.id = l_check_assuser.id_user LEFT JOIN l_check_block ON l_check_block.id_student = l_users.id  WHERE l_users.id_batch = ". $id_batch." AND l_users.id_year = ".$id_year." AND ".$day." AND ".$user." AND ".$ass." AND ".$day_reg;

            // $sql =" SELECT CONCAT(if(l_check_assuser.check_user >0,l_check_assuser.check_user,0),'-',l_block_wish.id_user) as block,l_block_wish.id_user as id, l_info_users.name_user as name_user,l_users.phone_users,l_batch.name_batch as name_batch, CONCAT(if(l_check_assuser.ass_at is null,'',DATE_FORMAT(l_check_assuser.ass_at,'%d/%m/%Y')),'-',l_block_wish.id_user) as update_at,CONCAT(if(l_check_assuser.name is not null,l_check_assuser.name,''),'-',l_block_wish.id_user) as name, CONCAT(l_block_wish.id_user,'-',if(l_check_assuser.id >0,1,0),'-',if(l_check_assuser.id_user > 0,l_check_assuser.id_user,0),'-',if(l_check_assuser.id >0,l_check_assuser.id,0),'-',if(l_check_assuser.check_user >0,1,0),'-',if(l_check_assuser.pass>0,1,0)) as active FROM l_block_wish INNER JOIN l_info_users ON l_info_users.id_user = l_block_wish.id_user INNER JOIN l_users ON l_users.id = l_block_wish.id_user INNER JOIN l_batch ON l_batch.id = l_users.id_batch LEFT JOIN (SELECT l_check_assuser.id as id, l_check_assuser.check_user as check_user,l_check_assuser.id_student as id_student,l_check_assuser.id_user, name,l_check_assuser.ass_at,l_check_assuser.pass as pass FROM l_check_assuser INNER JOIN users ON users.id = l_check_assuser.id_user) AS l_check_assuser ON l_block_wish.id_user = l_check_assuser.id_student WHERE l_users.id_year = ".$id_year." AND ". $id_batch." AND ". $user." AND ". $ass." AND ". $check." AND ". $pass." AND ". $day." AND ". $day_reg ;
            $sql =" SELECT if(B.name is null,'',B.name) as name_pass,CONCAT(if(l_check_assuser.check_user >0,l_check_assuser.check_user,0),'-',l_block_wish.id_user) as block,l_block_wish.id_user as id, l_info_users.name_user as name_user,l_users.phone_users,l_batch.name_batch as name_batch, CONCAT(if(l_check_assuser.ass_at is null,'',DATE_FORMAT(l_check_assuser.ass_at,'%d/%m/%Y')),'-',l_block_wish.id_user) as update_at,CONCAT(if(l_check_assuser.name is not null,l_check_assuser.name,''),'-',l_block_wish.id_user) as name, CONCAT(l_block_wish.id_user,'-',if(l_check_assuser.id >0,1,0),'-',if(l_check_assuser.id_user > 0,l_check_assuser.id_user,0),'-',if(l_check_assuser.id >0,l_check_assuser.id,0),'-',if(l_check_assuser.check_user >0,1,0),'-',if(l_check_assuser.pass>0,1,0)) as active FROM l_block_wish INNER JOIN l_info_users ON l_info_users.id_user = l_block_wish.id_user INNER JOIN l_users ON l_users.id = l_block_wish.id_user INNER JOIN l_batch ON l_batch.id = l_users.id_batch LEFT JOIN (SELECT l_check_assuser.id as id, l_check_assuser.check_user as check_user,l_check_assuser.id_student as id_student,l_check_assuser.id_user, name,l_check_assuser.ass_at,l_check_assuser.pass as pass, l_check_assuser.pass_user as pass_user FROM l_check_assuser INNER JOIN users ON users.id = l_check_assuser.id_user) AS l_check_assuser ON l_block_wish.id_user = l_check_assuser.id_student LEFT JOIN (SELECT users.id as id, users.name as name FROM users) AS B ON B.id = l_check_assuser.pass_user WHERE l_users.id_year = ".$id_year." AND ". $id_batch." AND ". $user." AND ". $ass." AND ". $check." AND ". $pass." AND ". $day." AND ". $day_reg ;

            $infor = DB::select($sql);
            $json_data['data'] = $infor;
            $data = json_encode($json_data);
            echo  $data;
        }
        // echo $pass;
    }

    public function add_ass_user_student(Request $request){
        $id_student = $request->input('id_student');
        $id_user = $request->input('id_user');
        $active = $request->input('active');
        $id_check = $request->input('id_check');

        if($this ->check_block($id_student) == 1){
            echo 3;
        }else{
            DB::beginTransaction();

            try
            {
                date_default_timezone_set("Asia/Ho_Chi_Minh");
                if($id_check == 0){
                    $active = "Phân công";
                    DB::table('l_check_assuser')
                    ->insert(
                        [
                            'id_student' => $id_student,
                            'id_user' => $id_user,
                            'ass' => 1 ,
                            'check_user' => 1,
                            'pass' => 0 ,
                            // 'pass_at' => '0',
                            'ass_at' =>date("Y-m-d H:i:s")
                        ]
                    );
                }else{
                    $active = "Cập nhật";
                    DB::table('l_check_assuser')
                    ->where('id',$id_check)
                    ->update([
                        'id_student' => $id_student,
                        'id_user' => $id_user,
                        'ass' => 1 ,
                        'check_user' => 1,
                        'pass' => 0 ,
                        // 'pass_at' => date('2008-03-28 12:00:00'),
                        'ass_at' =>date("Y-m-d H:i:s")
                    ]);
                }

                $name = DB::table('users')
                ->where('id',$id_user)
                ->get();

                $name_student = DB::table('l_info_users')
                ->where('id_user',$id_student)
                ->get();

                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                DB::table('l_history')
                ->insert([
                    'id_student'    =>  $id_student,
                    'id_user'       =>  Auth::user()->id,
                    'name_history'  =>  "Kiểm tra hồ sơ: ",
                    'content'       =>  $active." ".$name[0]->name." kiểm tra hồ sơ của ".$name_student[0]->name_user,
                    'ip'            => request()->ip(),
                    'info_client'   => $user_agent
                 ]);


                DB::commit();
                $check = DB::table('l_check_assuser')
                ->select('id',DB::raw("DATE_FORMAT(l_check_assuser.ass_at,'%d/%m/%Y') as update_at"))
                ->where('id_student',$id_student)
                ->get();

                if(count($check) == 1){
                    $sus =  1;
                }else{
                    $sus =  2;
                }
                $result = array(
                    'sus' => $sus,
                    'name' =>$name[0]->name,
                    'id_user' => $id_user,
                    'id_check' => $check[0] ->id,
                    'update_at' => $check[0] ->update_at
                );
                return $result;
            }catch(Exception $e){
                DB::rollBack();
                echo 0;
            }
        }

    }


    public function del_assuser($id_check,$id_student){
        if($this ->check_feedback($id_student) == 1){
            echo 3;
        }else{
            if($this ->check_block($id_student) == 1){
                echo 3;
            }else{
                if($id_check == 0){
                    echo 2;
                }else{
                    DB::beginTransaction();
                    try{
                        DB::table('l_check_assuser')
                        ->where('id',$id_check)
                        ->delete();

                        $name_student = DB::table('l_info_users')
                        ->where('id_user',$id_student)
                        ->get();

                        $user_agent = $_SERVER['HTTP_USER_AGENT'];
                        DB::table('l_history')
                        ->insert([
                            'id_student'    =>  $id_student,
                            'id_user'       =>  Auth::user()->id,
                            'name_history'  =>  "Kiểm tra hồ sơ ",
                            'content'       =>  "Hủy phân công: Thí sinh ". $name_student[0]->name_user,
                            'ip'            => request()->ip(),
                            'info_client'   => $user_agent
                        ]);
                        DB::commit();
                        $check = DB::table('l_check_assuser')
                        ->where('id',$id_student)
                        ->get();

                        if(count($check) > 0){
                            echo 0;
                        }else{
                            echo 1;
                        }
                    }catch(Exception $e){
                        DB::rollback();
                        echo 0;
                    }
                }
            }
        }
    }


    public function auto_ass(Request $request){
        $ass =  $request ->input('ass');
        $users =  $request ->input('data_user');
        switch ($ass) {
            case '1':
                $batch = $request ->input('batch');
                $students = DB::select('SELECT l_block_wish.id_user as id_user FROM `l_block_wish` INNER JOIN l_users ON l_users.id = l_block_wish.id_user WHERE id_user NOT IN (SELECT l_check_assuser.id_student FROM l_check_assuser WHERE l_check_assuser.ass =0) AND l_users.id_batch ='.$batch);

                if(count($students) >0){

                    foreach ($students as $key => $value) {
                        $student[] = $value->id_user;
                    }

                    $fail = 1;

                }else{

                    $fail = 2;

                }

                break;
            case '2':
                $student =  $request ->input('data_student');
                if(count($student) >0){
                    $fail = 1;
                }else{
                    $fail = 2;
                }

                break;
            default:
                # code...
                break;
        }

        if($fail == 1){
            $year =  $request ->input('year');
            $step = floor(count($student)/count($users));
            if($step > 0){
                $start = 0;
                $end = $step;
                for($i = 0; $i <count($users); $i++){
                    for($j = $start ;$j<$end;$j++){
                        $datas[] = [$users[$i],$student[$j]];
                    }
                    $start = ($i+1)*$step;
                    $end =  $start + $step;
                }

                $i = 0;
                for($j = count($datas); $j <count($student);$j++){
                    $datas[] = [$users[$i],$student[$j]];
                    $i++;
                }
            }else{
                $i = 0;
                for($j = 0; $j <count($student);$j++){
                    $datas[] = [$users[$i],$student[$j]];
                    $i++;
                }
            }
            DB::beginTransaction();
            try{
                foreach ($datas as $key => $data) {
                    DB::table('l_check_assuser')
                    ->insert(
                    [
                        'id_student' => $data[1],
                        'id_user' => $data[0],
                        'check_user' => 1,
                        'ass' => 1 ,
                        'pass' => 0 ,
                        // 'pass_at' => 0,
                        'ass_at' => date("Y-m-d H:i:s")
                    ]
                    );

                    $name = DB::table('users')
                    ->where('id',$data[0])
                    ->get();

                    $name_student = DB::table('l_info_users')
                    ->where('id_user',$data[1])
                    ->get();

                    $user_agent = $_SERVER['HTTP_USER_AGENT'];
                    DB::table('l_history')
                    ->insert([
                        'id_student'    =>  $data[1],
                        'id_user'       =>  Auth::user()->id,
                        'name_history'  =>  "Kiểm tra hồ sơ: ",
                        'content'       =>  "Phân công ".$name[0]->name." kiểm tra hồ sơ của ".$name_student[0]->name_user,
                        'ip'            =>  request()->ip(),
                        'info_client'   =>  $user_agent
                    ]);
                }
                DB::commit();
                $sus = 1;
            }catch(Exception $e){
                DB::rollBack();
                $sus = 0;
            }
        }else{
            $sus = 0;
        }
        $result = array(
            'fail' => $fail,
            'sus' => $sus,
        );
        return $result;
    }

    public function send_user_assuser(Request $request)
    {
        $id = $request ->input('id');
        $active = $request ->input('active');
        $id_student = $request ->input('id_student');
        $user = $request ->input('user');

        $check = $this->check_block($id_student);
        if($check == 0 && $this ->check_feedback($id_student) == 0){
            $fail = 0;
            $mes = 2;
        }else{
            if($this ->check_feedback($id_student) == 1  && $check == 0){
                $fail = 0;
                $mes = 3;
            }else{
                date_default_timezone_set("Asia/Ho_Chi_Minh");

                DB::beginTransaction();
                try
                {
                    if($active == 0){
                        $pass = 1;
                        $mes = 1; // Đã duyệt
                        $act = "Duyệt";
                    }else{
                        $pass = 0;
                        $mes = 0; //Chưa duyệt
                        $act = "Hủy duyệt";
                    }
                    DB::table('l_check_assuser')
                    ->where('id',$id)
                    ->update(
                        ['pass' => $pass,
                        'pass_at' => date("Y-m-d H:i:s"),
                        'pass_user' => Auth::user()->id,
                        ]

                    );

                    $name_student = DB::table('l_info_users')
                    ->where('id_user',$id_student)
                    ->get();

                    $name = DB::table('users')
                    ->where('id',$user)
                    ->get();

                    $user_agent = $_SERVER['HTTP_USER_AGENT'];
                    DB::table('l_history')
                    ->insert([
                        'id_student'    =>  $id_student,
                        'id_user'       =>  Auth::user()->id,
                        'name_history'  =>  "Duyệt hồ sơ: ",
                        'content'       =>  $act.' hồ sơ TS '.$name_student[0]->name_user. ' do NV '.$name[0]->name.' kiểm tra',
                        'ip'            =>  request()->ip(),
                        'info_client'   =>  $user_agent
                    ]);
                    DB::commit();
                    $fail = 0;
                }catch(Exception $e){
                    DB::rollBack();
                    $fail = 1;
                    $mes = 4;
                }
            }
        }

        $result = array(
            'fail' => $fail,
            'mes'   => $mes,
        );
        return $result;
    }

    public function ass_pass(Request $request){
        $data = $request ->input('data');
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        DB::beginTransaction();
        try
        {
            foreach ($data as $value) {
                DB::table('l_check_assuser')
                ->where('id',$value[0])
                ->where('id_student',$value[2])
                ->where('id_user',$value[1])
                ->update([
                    'pass' => 1,
                    'pass_at' => date("Y-m-d H:i:s"),
                    'pass_user' => Auth::user()->id,
                ]);

                $name_student = DB::table('l_info_users')
                ->where('id_user',$value[2])
                ->get();

                $name = DB::table('users')
                ->where('id',$value[1])
                ->get();

                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                DB::table('l_history')
                ->insert([
                    'id_student'    =>  $value[2],
                    'id_user'       =>  Auth::user()->id,
                    'name_history'  =>  "Duyệt tự động hồ sơ: ",
                    'content'       =>  'Duyệt hồ sơ TS '.$name_student[0]->name_user. ' do NV '.$name[0]->name.' kiểm tra',
                    'ip'            =>  request()->ip(),
                    'info_client'   =>  $user_agent
                ]);
            }
            DB::commit();
            echo 1;
        }catch(Exception $e){
            DB::rollBack();
            echo 2;
        }

    }

    // public function history($id_student){
    //     $history = DB::table('l_history')
    //     ->where('id_student',$id_student)
    //     ->get();

    // }


//   public function   load_user_assuser($id_user,$id_student){
//         $check = DB::table('l_check_assuser')
//         // ->where('id_user',$id_user)
//         ->where('id_student',$id_student)
//         ->get();
//         if(count($check) == 1){
//             echo 1;
//         }else{
//             echo 0;
//         }
//     }


    // public function add_user_ass(Request $request){
    //     $id = $request->input('id');
    //     $check =  DB::table('l_check_ass')
    //     ->where('id_user',$id)
    //     ->get();
    //     DB::beginTransaction();
    //     try
    //     {
    //         if(count($check) > 0){
    //             DB::table('l_check_ass')
    //             ->where('id_user',$id)
    //             ->delete();
    //         }
    //         if($request ->input('active') == 1){
    //             $active = "Hủy phân công";
    //         }else{
    //             $active = "Phân công";
    //             DB::table('l_check_ass')
    //             ->insert(
    //                 [
    //                     'id_user' => $id,
    //                 ]
    //             );
    //         }
    //         $name = DB::table('users')
    //         ->where('id',$id)
    //         ->get();
    //         $user_agent = $_SERVER['HTTP_USER_AGENT'];
    //         DB::table('l_history')
    //         ->insert([
    //             'id_student'    =>  $id,
    //             'id_user'       =>  Auth::user()->id,
    //             'name_history'  =>  "Phân công hồ sơ",
    //             'content'       =>  $active." ".$name[0]->name." kiểm tra hồ sơ",
    //             'ip'            => request()->ip(),
    //             'info_client'   => $user_agent
    //          ]);

    //         DB::commit();
    //         echo 1;
    //     }catch(Exception $e){
    //         DB::rollBack();
    //         echo 0;
    //     }
    // }

    // public function load_user_ass($id){
    //     $check = DB::table('l_check_ass')
    //     ->where('id_user',$id)
    //     ->get();
    //     if(count($check)==1){
    //         echo 1;
    //     }else{
    //         echo 0;
    //     }
    // }

}
