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

class GoSetupController extends Controller

{
    public function index(){
        return view('admin.go_setup.index',
        [
            'title' => "CTUT|Hệ thống đăng ký xét tuyển",
        ]);
    }



    public function load_search(){
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
            // 'year' => $years,
            'batch' => $batchs,
            // 'user' => $user,
        );
        return $result;
    }


    public function load_go_setup($id){
        $data = DB::table('l_method_major')
        ->join('l_batch_method','l_batch_method.id_method','l_method_major.id_method')
        ->join('l_method','l_method.id','l_method_major.id_method')
        ->join('l_major','l_method_major.id_major','l_major.id')
        ->select('*',DB::raw("CONCAT(l_method_major.id,'-',l_method_major.max_go) as max_go"),DB::raw("CONCAT(l_method_major.id,'-',l_method_major.min_major) as min_major"),DB::raw("CONCAT(l_method_major.id,'-',ROUND((l_method_major.max_go/l_method_major.min_major)*100,2)) as tl"))
        ->where('l_batch_method.id_batch',$id)
        ->orderBy('l_method_major.id_method','asc')
        ->get();
        $i=1;
        foreach ($data as $value) {
            $value ->stt = $i;
            $i++;
            // $value ->tl = (float)($value ->min_major)/(float)($value ->max_go);
        }
        $json_data['data'] = $data;
        $data = json_encode($json_data);
        echo  $data;
    }

    public function go_setup_save(Request $request){
        $datas = $request ->input('data');
        if(count($datas) > 0 ){
            DB::beginTransaction();
            try{
                foreach ($datas as $key => $data) {
                    DB::table('l_method_major')
                    ->where('id',$data[0])
                    ->update([
                        'min_major' => $data[1],
                        'max_go' => $data[3],
                    ]);
                }
                $batch = DB::table('l_method_major')
                ->join('l_batch_method','l_batch_method.id_method','l_method_major.id_method')
                ->join('l_batch','l_batch.id','l_batch_method.id_batch')
                ->where('l_method_major.id',$data[0])
                ->select('l_batch.name_batch')
                ->get();

                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                DB::table('l_history')
                ->insert([
                    'id_student'    =>  0,
                    'id_user'       =>  Auth::user()->id,
                    'name_history'  =>  "Cài đặt xét tuyển ",
                    'content'       =>  'Đợt: '.$batch[0] ->name_batch,
                    'ip'            => request()->ip(),
                    'info_client'   => $user_agent
                ]);
                DB::commit();
                echo 1;
            }catch(Exception $e){
                DB::rollBack();
                echo 0;
            }

        }else{
            echo 0;
        }
    }


    function join($data,$b){
        $col = count($data[0]);
        $count = 0;
        for($i = 0;$i < count($data);$i++){
            foreach ($b as $v_count) {
                if($data[$i][0] == $v_count ->id){
                    // if($v_count ->number >0){
                        $data[$i][$col] =  $v_count ->number;
                        $count++;
                    //     break;
                    // }
                }
            }
            if ($count == 0){
                $data[$i][$col] = 0;
            }
            $count = 0;
        }
        return $data;
    }

    public function barChart_go_setup($id){
        // $sql_major = "SELECT l_major.name_major as name_major, l_major.id as id FROM l_major";
        // $major = DB::select($sql_major);


        $major = DB::table('l_method_major')
        ->select('l_major.id','l_major.name_major')
            ->join('l_batch_method','l_batch_method.id_method','l_method_major.id_method')
            ->join('l_method','l_method.id','l_method_major.id_method')
            ->join('l_major','l_method_major.id_major','l_major.id')
            ->where('l_batch_method.id_batch',$id)
            ->groupBy('l_major.id')
            ->get();

        foreach ($major as $value) {
            $data[] = [$value ->id ,$value ->name_major];
        }


        // $sql_cou0 ="SELECT l_method_major.id_major as id, SUM(l_method_major.min_major) as number FROM l_method_major GROUP BY l_method_major.id_major";
        // $count0 = DB::select($sql_cou0);

        $sql_cou1 ="SELECT l_method_major.id_major as id, ROUND(((SUM(l_method_major.max_go)/SUM(l_method_major.min_major)-1)*100),2) as number FROM l_method_major GROUP BY l_method_major.id_major ";
        $count1 = DB::select($sql_cou1);



        // $data = $this -> join($data,$count0);
        $data = $this -> join($data,$count1);
        return $data;
    }

    public function load_email($id){
        $email = DB::table('l_go_setup_mail')
        ->where('id_batch',$id)
        ->get();


        $split = explode("_", $email[0]->content);
        $html = '';
        for($i = 0; $i<count($split);$i++){
            if($split[$i] == '$Nganh'){
                $html .= 'Tu dong hoa';

            }else{
                if($split[$i] == '$Hoten'){
                    $html .= 'Nguyen phan Tú';
                }else{
                    $html .= $split[$i];
                }

            }

        }


        return $html;
    }

    public function email(Request $request){
        DB::table('l_go_setup_mail')
        ->updateOrInsert([
            'id_batch' => $request ->input('batch')
        ],
        [
            'content' => $request ->input('data'),
            'title' => $request ->input('title')
        ]);
        return 1;
    }

    public function load_method_mark($id){
        $id_batch = DB::table('l_year_batch')
        ->where('id',$id)
        ->get();
        return $id_batch;
    }


    public function add_method_mark($id_batch,$method_mark){
        DB::beginTransaction();
        try{
            DB::table('l_year_batch')
            ->where('id',$id_batch)
            ->update([
                'method_mark' => $method_mark,
            ]);

            $batch = DB::table('l_year_batch')
            ->join('l_batch','l_batch.id','l_year_batch.id_batch')
            ->where('l_year_batch.id',$id_batch)
            ->select('l_batch.name_batch')
            ->get();

            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            DB::table('l_history')
            ->insert([
                'id_student'    =>  0,
                'id_user'       =>  Auth::user()->id,
                'name_history'  =>  "Cài đặt xét tuyển ",
                'content'       =>  'Cách lấy đanh sách: '.$batch[0] ->name_batch,
                'ip'            => request()->ip(),
                'info_client'   => $user_agent
            ]);

            DB::commit();
            return 1;
        }catch(Exception $e){
            DB::rollback();
            return 0;
        }
    }




    // function join($id,$arrs){
    //     $count = 0;
    //     foreach ($arrs as $arr) {
    //         if($id == $arr ->id){
    //             $val = $arr ->val;
    //             $count ++;
    //             break;
    //             }
    //     }
    //     if ($count == 0){
    //         $val = 0;
    //     }
    //     $count = 0;
    //     return $val;
    // }




    // public function load_go($id,$act){
    //     // $act = 5;
    //     switch ($act) {
    //         case '1':
    //             $where = "";
    //             $block = "";
    //             break;
    //         case '2':
    //             $where = "";
    //             $block = "INNER JOIN l_block_wish ON l_block_wish.id_user = l_wish.id_user";
    //             break;
    //         case '3':
    //             $where = "";
    //             $block = "INNER JOIN l_expenses_admin ON l_expenses_admin.id_wish = l_wish.id";
    //             break;
    //         case '4':
    //             $where = 'AND l_check_assuser.pass = 1';
    //             $block = "INNER JOIN l_check_assuser ON l_check_assuser.id_student = l_wish.id_user";
    //             break;
    //         case '5':
    //             $where = 'AND l_check_assuser.pass = 1';
    //             $block = "INNER JOIN l_check_assuser ON l_check_assuser.id_student = l_wish.id_user INNER JOIN l_expenses_admin ON l_expenses_admin.id_wish = l_wish.id";
    //             break;
    //         default:
    //             # code...
    //             break;
    //     }



    //     $major = DB::select('SELECT l_major.id as id, l_major.name_major FROM l_method_major INNER JOIN l_major ON l_major.id = l_method_major.id_major  INNER JOIN l_batch_method ON l_method_major.id_method = l_batch_method.id_method WHERE id_batch = '.(int)$id.' GROUP BY l_major.id');
    //     $min_major =  DB::select('SELECT l_method_major.id_major as id, SUM(l_method_major.min_major) as val FROM l_method_major INNER JOIN l_batch_method ON l_batch_method.id_method = l_method_major.id_method WHERE l_batch_method.id_batch = '.(int)$id.' GROUP BY l_method_major.id_major');

    //     $min_majorhb1 =  DB::select('SELECT l_method_major.id_major as id, min_major as val FROM l_method_major INNER JOIN l_batch_method ON l_batch_method.id_method = l_method_major.id_method WHERE l_batch_method.id_batch = '.(int)$id.' AND l_method_major.id_method = 1');
    //     $min_majorhb2 =  DB::select('SELECT l_method_major.id_major as id, min_major as val FROM l_method_major INNER JOIN l_batch_method ON l_batch_method.id_method = l_method_major.id_method WHERE l_batch_method.id_batch = '.(int)$id.' AND l_method_major.id_method = 2');
    //     $min_majornl =  DB::select('SELECT l_method_major.id_major as id, min_major as val FROM l_method_major INNER JOIN l_batch_method ON l_batch_method.id_method = l_method_major.id_method WHERE l_batch_method.id_batch = '.(int)$id.' AND l_method_major.id_method = 3');
    //     $reg_all =  DB::select('SELECT COUNT(*) as val, l_method_major.id_major as id FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major '.$block.' WHERE l_wish.id_batch = '.(int)$id.' '.$where.' GROUP BY l_method_major.id_major');
    //     $reg_pas =  DB::select('SELECT l_method_major.id_major as id, COUNT(*) as val FROM (SELECT l_wish.id_user, MIN(l_wish.number) as number FROM l_wish INNER JOIN l_go_setup ON l_go_setup.id_major = l_wish.id_major '.$block.' WHERE l_wish.mark >= l_go_setup.mark_basic '.$where.' AND l_wish.id_batch = '.(int)$id.' GROUP BY l_wish.id_user) AS result INNER JOIN l_wish ON l_wish.number = result.number AND result.id_user = l_wish.id_user INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major GROUP BY l_method_major.id_major');
    //     $reg_pas_nv1 =  DB::select('SELECT l_method_major.id_major as id, COUNT(*) as val FROM (SELECT l_wish.id_user, MIN(l_wish.number) as number FROM l_wish INNER JOIN l_go_setup ON l_go_setup.id_major = l_wish.id_major '.$block.' WHERE l_wish.mark >= l_go_setup.mark_basic '.$where.' AND l_wish.id_batch = '.(int)$id.' GROUP BY l_wish.id_user) AS result INNER JOIN l_wish ON l_wish.number = result.number AND result.id_user = l_wish.id_user INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major WHERE result.number = 1 GROUP BY l_method_major.id_major');
    //     $reg_pas_nv2 =  DB::select('SELECT l_method_major.id_major as id, COUNT(*) as val FROM (SELECT l_wish.id_user, MIN(l_wish.number) as number FROM l_wish INNER JOIN l_go_setup ON l_go_setup.id_major = l_wish.id_major '.$block.' WHERE l_wish.mark >= l_go_setup.mark_basic '.$where.' AND l_wish.id_batch = '.(int)$id.' GROUP BY l_wish.id_user) AS result INNER JOIN l_wish ON l_wish.number = result.number AND result.id_user = l_wish.id_user INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major WHERE result.number = 2 GROUP BY l_method_major.id_major');
    //     $reg_pas_nv3 =  DB::select('SELECT l_method_major.id_major as id, COUNT(*) as val FROM (SELECT l_wish.id_user, MIN(l_wish.number) as number FROM l_wish INNER JOIN l_go_setup ON l_go_setup.id_major = l_wish.id_major '.$block.' WHERE l_wish.mark >= l_go_setup.mark_basic '.$where.' AND l_wish.id_batch = '.(int)$id.' GROUP BY l_wish.id_user) AS result INNER JOIN l_wish ON l_wish.number = result.number AND result.id_user = l_wish.id_user INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major WHERE result.number = 3 GROUP BY l_method_major.id_major');


    //     $reg_hb1 =  DB::select('SELECT COUNT(*) as val, l_method_major.id_major as id FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major '.$block.' WHERE l_wish.id_batch = '.(int)$id.' '.$where.'  AND l_wish.id_method = 1 GROUP BY l_method_major.id_major');
    //     $min_mark_hb1 =  DB::select('SELECT l_method_major.id_major as id, l_method_major.min_mark as val FROM l_method_major INNER JOIN l_batch_method ON l_batch_method.id_method = l_method_major.id_method WHERE l_batch_method.id_batch = '.(int)$id.' AND l_method_major.id_method = 1');
    //     $min_major_hb1 =  DB::select('SELECT l_method_major.id_major as id, l_go_setup.mark_basic as val FROM l_go_setup INNER JOIN l_method_major ON l_method_major.id = l_go_setup.id_major INNER JOIN l_batch_method ON l_batch_method.id_method = l_method_major.id_method WHERE l_method_major.id_method = 1 AND l_batch_method.id_batch = '.(int)$id);
    //     $reg_pas_hb1 =  DB::select('SELECT l_method_major.id_major as id, COUNT(*) as val FROM (SELECT l_wish.id_user, MIN(l_wish.number) as number FROM l_wish INNER JOIN l_go_setup ON l_go_setup.id_major = l_wish.id_major '.$block.' WHERE l_wish.mark >= l_go_setup.mark_basic '.$where.' AND l_wish.id_batch = '.(int)$id.' GROUP BY l_wish.id_user) AS result INNER JOIN l_wish ON l_wish.number = result.number AND result.id_user = l_wish.id_user INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major WHERE l_method_major.id_method = 1 GROUP BY l_method_major.id_major');

    //     $reg_hb2 =  DB::select('SELECT COUNT(*) as val, l_method_major.id_major as id FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major '.$block.' WHERE l_wish.id_batch = '.(int)$id.' '.$where.'  AND l_wish.id_method = 2 GROUP BY l_method_major.id_major');
    //     $min_mark_hb2 =  DB::select('SELECT l_method_major.id_major as id, l_method_major.min_mark as val FROM l_method_major INNER JOIN l_batch_method ON l_batch_method.id_method = l_method_major.id_method WHERE l_batch_method.id_batch = '.(int)$id.' AND l_method_major.id_method = 2');
    //     $min_major_hb2 =  DB::select('SELECT l_method_major.id_major as id, l_go_setup.mark_basic as val FROM l_go_setup INNER JOIN l_method_major ON l_method_major.id = l_go_setup.id_major INNER JOIN l_batch_method ON l_batch_method.id_method = l_method_major.id_method WHERE l_method_major.id_method = 2 AND l_batch_method.id_batch = '.(int)$id);
    //     $reg_pas_hb2 =  DB::select('SELECT l_method_major.id_major as id, COUNT(*) as val FROM (SELECT l_wish.id_user, MIN(l_wish.number) as number FROM l_wish INNER JOIN l_go_setup ON l_go_setup.id_major = l_wish.id_major '.$block.' WHERE l_wish.mark >= l_go_setup.mark_basic '.$where.' AND l_wish.id_batch = '.(int)$id.' GROUP BY l_wish.id_user) AS result INNER JOIN l_wish ON l_wish.number = result.number AND result.id_user = l_wish.id_user INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major WHERE l_method_major.id_method = 2 GROUP BY l_method_major.id_major');

    //     $reg_nl =  DB::select('SELECT COUNT(*) as val, l_method_major.id_major as id FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major '.$block.' WHERE l_wish.id_batch = '.(int)$id.' '.$where.'  AND l_wish.id_method = 3 GROUP BY l_method_major.id_major');
    //     $min_mark_nl =  DB::select('SELECT l_method_major.id_major as id, l_method_major.min_mark as val FROM l_method_major INNER JOIN l_batch_method ON l_batch_method.id_method = l_method_major.id_method WHERE l_batch_method.id_batch = '.(int)$id.' AND l_method_major.id_method = 3');
    //     $min_major_nl =  DB::select('SELECT l_method_major.id_major as id, l_go_setup.mark_basic as val FROM l_go_setup INNER JOIN l_method_major ON l_method_major.id = l_go_setup.id_major INNER JOIN l_batch_method ON l_batch_method.id_method = l_method_major.id_method WHERE l_method_major.id_method = 3 AND l_batch_method.id_batch = '.(int)$id);
    //     $reg_pas_nl =  DB::select('SELECT l_method_major.id_major as id, COUNT(*) as val FROM (SELECT l_wish.id_user, MIN(l_wish.number) as number FROM l_wish INNER JOIN l_go_setup ON l_go_setup.id_major = l_wish.id_major '.$block.' WHERE l_wish.mark >= l_go_setup.mark_basic '.$where.' AND l_wish.id_batch = '.(int)$id.' GROUP BY l_wish.id_user) AS result INNER JOIN l_wish ON l_wish.number = result.number AND result.id_user = l_wish.id_user INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major WHERE l_method_major.id_method = 3 GROUP BY l_method_major.id_major');

    //     $method_1=  DB::select('SELECT l_method_major.id_major as id, l_go_setup.id as val FROM `l_go_setup` INNER JOIN l_method_major ON l_method_major.id = l_go_setup.id_major INNER JOIN l_batch_method  ON l_batch_method.id_method = l_method_major.id_method WHERE l_method_major.id_method = 1 AND l_batch_method.id_batch = '.(int)$id);
    //     $method_2 =  DB::select('SELECT l_method_major.id_major as id, l_go_setup.id as val FROM `l_go_setup` INNER JOIN l_method_major ON l_method_major.id = l_go_setup.id_major INNER JOIN l_batch_method  ON l_batch_method.id_method = l_method_major.id_method WHERE l_method_major.id_method = 2 AND l_batch_method.id_batch = '.(int)$id);
    //     $method_3 =  DB::select('SELECT l_method_major.id_major as id, l_go_setup.id as val FROM `l_go_setup` INNER JOIN l_method_major ON l_method_major.id = l_go_setup.id_major INNER JOIN l_batch_method  ON l_batch_method.id_method = l_method_major.id_method WHERE l_method_major.id_method = 3 AND l_batch_method.id_batch = '.(int)$id);

    //     foreach ($major as $value) {
    //         $data[] = array(
    //             'id' =>$value ->id,
    //             'name_major' => $value ->name_major,
    //             'min_major' =>$this ->join($value ->id,$min_major),
    //             'min_majorhb1' =>$this ->join($value ->id,$min_majorhb1),
    //             'min_majorhb2' =>$this ->join($value ->id,$min_majorhb2),
    //             'min_majornl' =>$this ->join($value ->id,$min_majornl),
    //             'reg_all' =>$this ->join($value ->id,$reg_all),
    //             'reg_pas' =>$this ->join($value ->id,$reg_pas),
    //             'reg_hb1' =>$this ->join($value ->id,$reg_hb1),
    //             'min_mark_hb1' =>$this ->join($value ->id,$min_mark_hb1),
    //             'min_major_hb1' =>$this ->join($value ->id,$min_major_hb1),
    //             'reg_pas_hb1' =>$this ->join($value ->id,$reg_pas_hb1),

    //             'reg_hb2' =>$this ->join($value ->id,$reg_hb2),
    //             'min_mark_hb2' =>$this ->join($value ->id,$min_mark_hb2),
    //             'min_major_hb2' =>$this ->join($value ->id,$min_major_hb2),
    //             'reg_pas_hb2' =>$this ->join($value ->id,$reg_pas_hb2),

    //             'reg_nl' =>$this ->join($value ->id,$reg_nl),
    //             'min_mark_nl' =>$this ->join($value ->id,$min_mark_nl),
    //             'min_major_nl' =>$this ->join($value ->id,$min_major_nl),
    //             'reg_pas_nl' =>$this ->join($value ->id,$reg_pas_nl),
    //             'method_1' =>$this ->join($value ->id,$method_1),
    //             'method_2' =>$this ->join($value ->id,$method_2),
    //             'method_3' =>$this ->join($value ->id,$method_3),


    //             'reg_pas_nv1' =>$this ->join($value ->id,$reg_pas_nv1),
    //             'reg_pas_nv2' =>$this ->join($value ->id,$reg_pas_nv2),
    //             'reg_pas_nv3' =>$this ->join($value ->id,$reg_pas_nv3),
    //         );
    //     }
    //     return $data;
    // }

    // public function go_virtual(Request $request){
    //     $data =  $request ->input('arr_mark');
    //     DB::beginTransaction();
    //     try{
    //         foreach ($data as $min_mark) {
    //             DB::table('l_go_setup')
    //             ->where('id',$min_mark[0])
    //             ->update([
    //                 'mark_basic' =>$min_mark[1]
    //             ]);
    //         }
    //         DB::commit();
    //         echo 1;
    //     }catch(Exception $e){
    //         DB::rollBack();
    //         echo 0;
    //     }
    // }


    // function join($data,$b){
    //     $col = count($data[0]);
    //     $count = 0;
    //     for($i = 0;$i < count($data);$i++){
    //         foreach ($b as $v_count) {
    //             if($data[$i][0] == $v_count ->id){
    //                 if($v_count ->number >0){
    //                     $data[$i][$col] =  $v_count ->number;
    //                     $count++;
    //                     break;
    //                 }
    //             }
    //         }
    //         if ($count == 0){
    //             $data[$i][$col] = 0;
    //         }
    //         $count = 0;
    //     }
    //     return $data;
    // }




    // //Check đăng ký
    // public function barChart_reg_sta($act){
    //     $sql_major = "SELECT l_major.name_major as name_major, l_major.id as id FROM l_major";
    //     $major = DB::select($sql_major);

    //     foreach ($major as $value) {
    //         $data[] = [$value ->id ,$value ->name_major];
    //     }
    //     $sql_cou0 ="SELECT l_method_major.id_major as id, SUM(l_method_major.min_major) as number FROM l_method_major GROUP BY l_method_major.id_major";
    //     $count0 = DB::select($sql_cou0);
    //     // $act = 1;
    //     switch ($act) {
    //         case '1':

    //             $sql_cou1 ="SELECT l_method_major.id_major as id, COUNT(*) as number FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major WHERE l_wish.number = 1 GROUP BY l_method_major.id_major";
    //             $count = DB::select($sql_cou1);

    //             $sql_cou2 = "SELECT l_method_major.id_major as id, COUNT(*) as number FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major WHERE l_wish.number = 2 GROUP BY l_method_major.id_major";
    //             $count2 = DB::select($sql_cou2);

    //             $sql_cou3 = "SELECT l_method_major.id_major as id, COUNT(*) as number FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major WHERE l_wish.number = 3 GROUP BY l_method_major.id_major";
    //             $count3 = DB::select($sql_cou3);
    //             break;
    //         case '2':
    //             $sql_cou1 ="SELECT l_method_major.id_major as id, COUNT(*) as number FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_block_wish ON l_block_wish.id_user = l_wish.id_user WHERE l_wish.number = 1 GROUP BY l_method_major.id_major";
    //             $count = DB::select($sql_cou1);

    //             $sql_cou2 = "SELECT l_method_major.id_major as id, COUNT(*) as number FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_block_wish ON l_block_wish.id_user = l_wish.id_user WHERE l_wish.number = 2 GROUP BY l_method_major.id_major";
    //             $count2 = DB::select($sql_cou2);

    //             $sql_cou3 = "SELECT l_method_major.id_major as id, COUNT(*) as number FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_block_wish ON l_block_wish.id_user = l_wish.id_user WHERE l_wish.number = 3 GROUP BY l_method_major.id_major";
    //             $count3 = DB::select($sql_cou3);

    //             break;
    //         case '3':

    //             $sql_cou1 ="SELECT l_method_major.id_major as id, COUNT(*) as number FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN (SELECT DISTINCT id_user AS id_user FROM l_expenses_user) AS A ON A.id_user = l_wish.id_user WHERE l_wish.number = 1 GROUP BY l_method_major.id_major";
    //             $count = DB::select($sql_cou1);

    //             $sql_cou2 = "SELECT l_method_major.id_major as id, COUNT(*) as number FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN (SELECT DISTINCT id_user AS id_user FROM l_expenses_user) AS A ON A.id_user = l_wish.id_user WHERE l_wish.number = 2 GROUP BY l_method_major.id_major";
    //             $count2 = DB::select($sql_cou2);

    //             $sql_cou3 = "SELECT l_method_major.id_major as id, COUNT(*) as number FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN (SELECT DISTINCT id_user AS id_user FROM l_expenses_user) AS A ON A.id_user = l_wish.id_user WHERE l_wish.number = 3 GROUP BY l_method_major.id_major";
    //             $count3 = DB::select($sql_cou3);
    //             break;

    //         case '4':

    //             $sql_cou1 ="SELECT l_method_major.id_major as id, COUNT(*) as number FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_check_assuser ON l_check_assuser.id_student = l_wish.id_user WHERE l_wish.number = 1 AND l_check_assuser.pass = 1 GROUP BY l_method_major.id_major";
    //             $count = DB::select($sql_cou1);

    //             $sql_cou2 = "SELECT l_method_major.id_major as id, COUNT(*) as number FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_check_assuser ON l_check_assuser.id_student = l_wish.id_user WHERE l_wish.number = 2 AND l_check_assuser.pass = 1 GROUP BY l_method_major.id_major";
    //             $count2 = DB::select($sql_cou2);

    //             $sql_cou3 = "SELECT l_method_major.id_major as id, COUNT(*) as number FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_check_assuser ON l_check_assuser.id_student = l_wish.id_user WHERE l_wish.number = 3 AND l_check_assuser.pass = 1 GROUP BY l_method_major.id_major";
    //             $count3 = DB::select($sql_cou3);
    //             break;

    //         case '5 ':
    //             $sql_cou1 = "SELECT l_method_major.id_major as id, COUNT(*) as number FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_check_assuser ON l_check_assuser.id_student = l_wish.id_user INNER JOIN (SELECT DISTINCT id_user AS id_user FROM l_expenses_user) AS A ON A.id_user = l_wish.id_user WHERE l_wish.number = 1 AND l_check_assuser.pass = 1 GROUP BY l_method_major.id_major";
    //             $count = DB::select($sql_cou1);

    //             $sql_cou2 = "SELECT l_method_major.id_major as id, COUNT(*) as number FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_check_assuser ON l_check_assuser.id_student = l_wish.id_user INNER JOIN (SELECT DISTINCT id_user AS id_user FROM l_expenses_user) AS A ON A.id_user = l_wish.id_user WHERE l_wish.number = 2 AND l_check_assuser.pass = 1 GROUP BY l_method_major.id_major";
    //             $count2 = DB::select($sql_cou2);

    //             $sql_cou3 = "SELECT l_method_major.id_major as id, COUNT(*) as number FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_check_assuser ON l_check_assuser.id_student = l_wish.id_user INNER JOIN (SELECT DISTINCT id_user AS id_user FROM l_expenses_user) AS A ON A.id_user = l_wish.id_user WHERE l_wish.number = 3 AND l_check_assuser.pass = 1 GROUP BY l_method_major.id_major";
    //             $count3 = DB::select($sql_cou3);
    //             break;
    //         default:


    //             break;
    //     }

    //     $data = $this -> join($data,$count);
    //     $data = $this -> join($data,$count2);
    //     $data = $this -> join($data,$count3);
    //     $data = $this -> join($data,$count0);




    //     return $data;
    // }

    // public function chart_reg_sta_basic(){

    //     $sql_batch = "SELECT l_batch.id as id, l_batch.name_batch as name_batch FROM `l_year_batch` INNER JOIN l_batch ON l_batch.id = l_year_batch.id_batch WHERE id_year = 1";
    //     $batch = DB::select($sql_batch);

    //     foreach ($batch as $value) {
    //         $data[] = [$value ->id ,$value ->name_batch];
    //     }

    //     $sql_cou1 ="SELECT id_batch as id,COUNT(DISTINCT id_user) as number FROM l_wish WHERE id_batch = 1 GROUP BY id_batch";
    //     $count = DB::select($sql_cou1);

    //     $sql_cou2 ="SELECT l_block_wish.id_batch as id, COUNT(DISTINCT l_wish.id_user) as number FROM `l_wish` INNER JOIN l_block_wish ON l_block_wish.id_user = l_wish.id_user WHERE l_block_wish.id_batch = 1 AND l_block_wish.id_block = 1 GROUP BY l_wish.id_batch";
    //     $count2 = DB::select($sql_cou2);

    //     $sql_cou3 ="SELECT COUNT(DISTINCT l_wish.id_user) as number,id_batch as id FROM l_wish INNER JOIN l_expenses_user ON l_expenses_user.id_user = l_wish.id_user WHERE id_batch = 1 GROUP BY l_wish.id_batch";
    //     $count3 = DB::select($sql_cou3);

    //     $sql_cou3 ="SELECT COUNT(DISTINCT l_wish.id_user) as number,id_batch as id FROM l_wish INNER JOIN l_expenses_user ON l_expenses_user.id_user = l_wish.id_user WHERE id_batch = 1 GROUP BY l_wish.id_batch";
    //     $count3 = DB::select($sql_cou3);

    //     $data = $this -> join($data,$count);
    //     $data = $this -> join($data,$count2);
    //     $data = $this -> join($data,$count3);
    //     return $data;
    // }



    // public function chart_reg_sta_basic(){


    //     $sql_cou1 ="SELECT COUNT(*) as val FROM l_users WHERE id_year = 1";
    //     $count = DB::select($sql_cou1);

    //     $sql_cou2 ="SELECT COUNT(DISTINCT id_user) as val FROM `l_wish` WHERE id_year = 2023";
    //     $count2 = DB::select($sql_cou2);

    //     $sql_cou6 ="SELECT COUNT(DISTINCT id_user) as val FROM l_block_wish";
    //     $count6 = DB::select($sql_cou6);

    //     $sql_cou3 ="SELECT COUNT(DISTINCT id_user) as val FROM l_expenses_user WHERE id_year =1";
    //     $count3 = DB::select($sql_cou3);

    //     $sql_cou4 ="SELECT COUNT(*) as val FROM l_check_assuser WHERE l_check_assuser.pass = 1";
    //     $count4 = DB::select($sql_cou4);

    //     $sql_cou5 ="SELECT COUNT(DISTINCT l_expenses_user.id_user) as val FROM l_expenses_user INNER JOIN l_check_assuser ON l_expenses_user.id_user = l_check_assuser.id_student WHERE pass = 1";
    //     $count5 = DB::select($sql_cou5);

    //     $result = array(
    //         'users' => $count[0] ->val,
    //         'wish' => $count2[0] ->val,
    //         'exp'=> $count3[0] ->val,
    //         'pass'=> $count4[0] ->val,
    //         'go'=> $count5[0] ->val,
    //         'block'=> $count6[0] ->val,
    //     );

    //     return $result;
    // }



}
