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

class RegStaController extends Controller

{
    public function index(){
        return view('admin.reg_sta.index',
        [
            'title' => "CTUT|Hệ thống đăng ký xét tuyển",
        ]);
    }

    function join($data,$b){
        $col = count($data[0]);
        $count = 0;
        for($i = 0;$i < count($data);$i++){
            foreach ($b as $v_count) {
                if($data[$i][0] == $v_count ->id){
                    if($v_count ->number >0){
                        $data[$i][$col] =  $v_count ->number;
                        $count++;
                        break;
                    }
                }
            }
            if ($count == 0){
                $data[$i][$col] = 0;
            }
            $count = 0;
        }
        return $data;
    }




    //Check đăng ký
    public function barChart_reg_sta($act){
        $sql_major = "SELECT l_major.name_major as name_major, l_major.id as id FROM l_major";
        $major = DB::select($sql_major);

        foreach ($major as $value) {
            $data[] = [$value ->id ,$value ->name_major];
        }
        $sql_cou0 ="SELECT l_method_major.id_major as id, SUM(l_method_major.min_major) as number FROM l_method_major GROUP BY l_method_major.id_major";
        $count0 = DB::select($sql_cou0);
        // $act = 1;
        switch ($act) {
            case '1':

                $sql_cou1 ="SELECT l_method_major.id_major as id, COUNT(*) as number FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major WHERE l_wish.number = 1 GROUP BY l_method_major.id_major";
                $count = DB::select($sql_cou1);

                $sql_cou2 = "SELECT l_method_major.id_major as id, COUNT(*) as number FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major WHERE l_wish.number = 2 GROUP BY l_method_major.id_major";
                $count2 = DB::select($sql_cou2);

                $sql_cou3 = "SELECT l_method_major.id_major as id, COUNT(*) as number FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major WHERE l_wish.number = 3 GROUP BY l_method_major.id_major";
                $count3 = DB::select($sql_cou3);
                break;
            case '2':
                $sql_cou1 ="SELECT l_method_major.id_major as id, COUNT(*) as number FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_block_wish ON l_block_wish.id_user = l_wish.id_user WHERE l_wish.number = 1 GROUP BY l_method_major.id_major";
                $count = DB::select($sql_cou1);

                $sql_cou2 = "SELECT l_method_major.id_major as id, COUNT(*) as number FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_block_wish ON l_block_wish.id_user = l_wish.id_user WHERE l_wish.number = 2 GROUP BY l_method_major.id_major";
                $count2 = DB::select($sql_cou2);

                $sql_cou3 = "SELECT l_method_major.id_major as id, COUNT(*) as number FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_block_wish ON l_block_wish.id_user = l_wish.id_user WHERE l_wish.number = 3 GROUP BY l_method_major.id_major";
                $count3 = DB::select($sql_cou3);

                break;
            case '3':

                $sql_cou1 ="SELECT l_method_major.id_major as id, COUNT(*) as number FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN (SELECT DISTINCT id_user AS id_user FROM l_expenses_user) AS A ON A.id_user = l_wish.id_user WHERE l_wish.number = 1 GROUP BY l_method_major.id_major";
                $count = DB::select($sql_cou1);

                $sql_cou2 = "SELECT l_method_major.id_major as id, COUNT(*) as number FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN (SELECT DISTINCT id_user AS id_user FROM l_expenses_user) AS A ON A.id_user = l_wish.id_user WHERE l_wish.number = 2 GROUP BY l_method_major.id_major";
                $count2 = DB::select($sql_cou2);

                $sql_cou3 = "SELECT l_method_major.id_major as id, COUNT(*) as number FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN (SELECT DISTINCT id_user AS id_user FROM l_expenses_user) AS A ON A.id_user = l_wish.id_user WHERE l_wish.number = 3 GROUP BY l_method_major.id_major";
                $count3 = DB::select($sql_cou3);
                break;

            case '4':

                $sql_cou1 ="SELECT l_method_major.id_major as id, COUNT(*) as number FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_check_assuser ON l_check_assuser.id_student = l_wish.id_user WHERE l_wish.number = 1 AND l_check_assuser.pass = 1 GROUP BY l_method_major.id_major";
                $count = DB::select($sql_cou1);

                $sql_cou2 = "SELECT l_method_major.id_major as id, COUNT(*) as number FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_check_assuser ON l_check_assuser.id_student = l_wish.id_user WHERE l_wish.number = 2 AND l_check_assuser.pass = 1 GROUP BY l_method_major.id_major";
                $count2 = DB::select($sql_cou2);

                $sql_cou3 = "SELECT l_method_major.id_major as id, COUNT(*) as number FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_check_assuser ON l_check_assuser.id_student = l_wish.id_user WHERE l_wish.number = 3 AND l_check_assuser.pass = 1 GROUP BY l_method_major.id_major";
                $count3 = DB::select($sql_cou3);
                break;

            case '5 ':
                $sql_cou1 = "SELECT l_method_major.id_major as id, COUNT(*) as number FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_check_assuser ON l_check_assuser.id_student = l_wish.id_user INNER JOIN (SELECT DISTINCT id_user AS id_user FROM l_expenses_user) AS A ON A.id_user = l_wish.id_user WHERE l_wish.number = 1 AND l_check_assuser.pass = 1 GROUP BY l_method_major.id_major";
                $count = DB::select($sql_cou1);

                $sql_cou2 = "SELECT l_method_major.id_major as id, COUNT(*) as number FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_check_assuser ON l_check_assuser.id_student = l_wish.id_user INNER JOIN (SELECT DISTINCT id_user AS id_user FROM l_expenses_user) AS A ON A.id_user = l_wish.id_user WHERE l_wish.number = 2 AND l_check_assuser.pass = 1 GROUP BY l_method_major.id_major";
                $count2 = DB::select($sql_cou2);

                $sql_cou3 = "SELECT l_method_major.id_major as id, COUNT(*) as number FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_check_assuser ON l_check_assuser.id_student = l_wish.id_user INNER JOIN (SELECT DISTINCT id_user AS id_user FROM l_expenses_user) AS A ON A.id_user = l_wish.id_user WHERE l_wish.number = 3 AND l_check_assuser.pass = 1 GROUP BY l_method_major.id_major";
                $count3 = DB::select($sql_cou3);
                break;
            default:


                break;
        }

        $data = $this -> join($data,$count);
        $data = $this -> join($data,$count2);
        $data = $this -> join($data,$count3);
        $data = $this -> join($data,$count0);




        return $data;
    }




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



    public function chart_reg_sta_basic(){


        $sql_cou1 ="SELECT COUNT(*) as val FROM l_users WHERE id_year = 1";
        $count = DB::select($sql_cou1);

        $sql_cou2 ="SELECT COUNT(DISTINCT id_user) as val FROM `l_wish` WHERE id_year = 2023";
        $count2 = DB::select($sql_cou2);

        $sql_cou6 ="SELECT COUNT(DISTINCT id_user) as val FROM l_block_wish";
        $count6 = DB::select($sql_cou6);

        $sql_cou3 ="SELECT COUNT(DISTINCT id_user) as val FROM l_expenses_user WHERE id_year =1";
        $count3 = DB::select($sql_cou3);

        $sql_cou4 ="SELECT COUNT(*) as val FROM l_check_assuser WHERE l_check_assuser.pass = 1";
        $count4 = DB::select($sql_cou4);

        $sql_cou5 ="SELECT COUNT(DISTINCT l_expenses_user.id_user) as val FROM l_expenses_user INNER JOIN l_check_assuser ON l_expenses_user.id_user = l_check_assuser.id_student WHERE pass = 1";
        $count5 = DB::select($sql_cou5);

        $result = array(
            'users' => $count[0] ->val,
            'wish' => $count2[0] ->val,
            'exp'=> $count3[0] ->val,
            'pass'=> $count4[0] ->val,
            'go'=> $count5[0] ->val,
            'block'=> $count6[0] ->val,
        );

        return $result;
    }



}
