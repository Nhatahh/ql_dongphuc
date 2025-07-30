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
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;
use App\Exports\GoSta;
use App\Exports\ExportStudentGo;
use App\Exports\ExportWishGo;
use App\Exports\ExportWishGoFail;
use App\Exports\ExportGoFail;


use App\PHPExcel\PHPExcel_IOFactory;
use App\Http\Controllers\Admin\CheckInfoController;


// use App\PHPExcel\IOFactory\PHPExcel_IOFactory;

use Exception;
use Illuminate\Support\Arr;

//  Include thư viện PHPExcel_IOFactory vào
// include 'C:\laragon\www\xettuyentest\app\PHPExcel\IOFactory.php';


// C:\laragon\www\xettuyentest\app\PHPExcel\IOFactory.php


class GoBoController extends Controller

{
    public function index(){
        return view('admin.go_bo.index',
        [
            'title' => "CTUT|Hệ thống đăng ký xét tuyển",
        ]);
    }

    // public function ex_list_go($id){
    //    $a =  PHPExcel_IOFactory::test();
    //    return $a;
    // }


    // public function load_search(){
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

    //     $result = array(
    //         // 'year' => $years,
    //         'batch' => $batchs,
    //         // 'user' => $user,
    //     );
    //     return $result;
    // }

    // function check_type($id){
    //     $check = DB::table('l_year_batch')
    //     ->where('active_year_batch',1)
    //     ->where('id',$id)
    //     ->get();
    //     if(count($check)>0){
    //         if(count($check) == 1){
    //             return $check[0] ->method_mark;
    //         }else{
    //             return 0;
    //         }
    //     }else{
    //         return 0;
    //     }
    // }


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

    //     $major_method = DB::select('SELECT l_major.id as id, l_major.name_major FROM l_method_major INNER JOIN l_major ON l_major.id = l_method_major.id_major  INNER JOIN l_batch_method ON l_method_major.id_method = l_batch_method.id_method WHERE id_batch = '.(int)$id.' GROUP BY l_major.id');

    //     $reg_all =  DB::select('SELECT COUNT(*) as val, l_method_major.id_major as id FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major '.$block.' WHERE l_wish.id_batch = '.(int)$id.' '.$where.' GROUP BY l_method_major.id_major');
    //     $reg_hb1 =  DB::select('SELECT COUNT(*) as val, l_method_major.id_major as id FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major '.$block.' WHERE l_wish.id_batch = '.(int)$id.' '.$where.'  AND l_wish.id_method = 1 GROUP BY l_method_major.id_major');
    //     $reg_hb2 =  DB::select('SELECT COUNT(*) as val, l_method_major.id_major as id FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major '.$block.' WHERE l_wish.id_batch = '.(int)$id.' '.$where.'  AND l_wish.id_method = 2 GROUP BY l_method_major.id_major');
    //     $reg_nl =  DB::select('SELECT COUNT(*) as val, l_method_major.id_major as id FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major '.$block.' WHERE l_wish.id_batch = '.(int)$id.' '.$where.'  AND l_wish.id_method = 3 GROUP BY l_method_major.id_major');
    //     $reg_all_1 =  DB::select('SELECT COUNT(*) as val, l_method_major.id_major as id FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major '.$block.' WHERE l_wish.number = 1 AND l_wish.id_batch = '.(int)$id.' '.$where.' GROUP BY l_method_major.id_major');

    //     $min_major =  DB::select('SELECT l_method_major.id_major as id, SUM(l_method_major.min_major) as val FROM l_method_major INNER JOIN l_batch_method ON l_batch_method.id_method = l_method_major.id_method WHERE l_batch_method.id_batch = '.(int)$id.' GROUP BY l_method_major.id_major');
    //     $min_majorhb1 =  DB::select('SELECT l_method_major.id_major as id, min_major as val FROM l_method_major INNER JOIN l_batch_method ON l_batch_method.id_method = l_method_major.id_method WHERE l_batch_method.id_batch = '.(int)$id.' AND l_method_major.id_method = 1');
    //     $min_majorhb2 =  DB::select('SELECT l_method_major.id_major as id, min_major as val FROM l_method_major INNER JOIN l_batch_method ON l_batch_method.id_method = l_method_major.id_method WHERE l_batch_method.id_batch = '.(int)$id.' AND l_method_major.id_method = 2');
    //     $min_majornl =  DB::select('SELECT l_method_major.id_major as id, min_major as val FROM l_method_major INNER JOIN l_batch_method ON l_batch_method.id_method = l_method_major.id_method WHERE l_batch_method.id_batch = '.(int)$id.' AND l_method_major.id_method = 3');

    //     $min_mark_hb1 =  DB::select('SELECT l_method_major.id_major as id, l_method_major.min_mark as val FROM l_method_major INNER JOIN l_batch_method ON l_batch_method.id_method = l_method_major.id_method WHERE l_batch_method.id_batch = '.(int)$id.' AND l_method_major.id_method = 1');
    //     $min_mark_hb2 =  DB::select('SELECT l_method_major.id_major as id, l_method_major.min_mark as val FROM l_method_major INNER JOIN l_batch_method ON l_batch_method.id_method = l_method_major.id_method WHERE l_batch_method.id_batch = '.(int)$id.' AND l_method_major.id_method = 2');
    //     $min_mark_nl =  DB::select('SELECT l_method_major.id_major as id, l_method_major.min_mark as val FROM l_method_major INNER JOIN l_batch_method ON l_batch_method.id_method = l_method_major.id_method WHERE l_batch_method.id_batch = '.(int)$id.' AND l_method_major.id_method = 3');

    //     $method_1=  DB::select('SELECT l_method_major.id_major as id, l_go_setup.id as val FROM `l_go_setup` INNER JOIN l_method_major ON l_method_major.id = l_go_setup.id_major INNER JOIN l_batch_method  ON l_batch_method.id_method = l_method_major.id_method WHERE l_method_major.id_method = 1 AND l_batch_method.id_batch = '.(int)$id);
    //     $method_2 =  DB::select('SELECT l_method_major.id_major as id, l_go_setup.id as val FROM `l_go_setup` INNER JOIN l_method_major ON l_method_major.id = l_go_setup.id_major INNER JOIN l_batch_method  ON l_batch_method.id_method = l_method_major.id_method WHERE l_method_major.id_method = 2 AND l_batch_method.id_batch = '.(int)$id);
    //     $method_3 =  DB::select('SELECT l_method_major.id_major as id, l_go_setup.id as val FROM `l_go_setup` INNER JOIN l_method_major ON l_method_major.id = l_go_setup.id_major INNER JOIN l_batch_method  ON l_batch_method.id_method = l_method_major.id_method WHERE l_method_major.id_method = 3 AND l_batch_method.id_batch = '.(int)$id);

    //     $min_major_hb1 =  DB::select('SELECT l_method_major.id_major as id, l_go_setup.mark_basic as val FROM l_go_setup INNER JOIN l_method_major ON l_method_major.id = l_go_setup.id_major INNER JOIN l_batch_method ON l_batch_method.id_method = l_method_major.id_method WHERE l_method_major.id_method = 1 AND l_batch_method.id_batch = '.(int)$id);
    //     $min_major_hb2 =  DB::select('SELECT l_method_major.id_major as id, l_go_setup.mark_basic as val FROM l_go_setup INNER JOIN l_method_major ON l_method_major.id = l_go_setup.id_major INNER JOIN l_batch_method ON l_batch_method.id_method = l_method_major.id_method WHERE l_method_major.id_method = 2 AND l_batch_method.id_batch = '.(int)$id);
    //     $min_major_nl =  DB::select('SELECT l_method_major.id_major as id, l_go_setup.mark_basic as val FROM l_go_setup INNER JOIN l_method_major ON l_method_major.id = l_go_setup.id_major INNER JOIN l_batch_method ON l_batch_method.id_method = l_method_major.id_method WHERE l_method_major.id_method = 3 AND l_batch_method.id_batch = '.(int)$id);

    //     $reg_all_ct = DB::select('SELECT l_major.id as id, SUM(l_method_major.max_go) as val FROM l_method_major INNER JOIN l_major ON l_method_major.id_major = l_major.id GROUP BY l_major.id');
    //     $reg_hb1_ct = DB::select('SELECT l_major.id as id, l_method_major.max_go as val FROM l_method_major INNER JOIN l_major ON l_method_major.id_major = l_major.id WHERE id_method = 1');
    //     $reg_hb2_ct = DB::select('SELECT l_major.id as id, l_method_major.max_go as val FROM l_method_major INNER JOIN l_major ON l_method_major.id_major = l_major.id WHERE id_method = 2');
    //     $reg_nl_sum_ct = DB::select('SELECT l_major.id as id, l_method_major.max_go as val FROM l_method_major INNER JOIN l_major ON l_method_major.id_major = l_major.id WHERE id_method = 3');



    //     $type = $this->check_type($id);

    //     switch ($type) {
    //         case '1':
    //             $reg_pas =  DB::select('SELECT l_method_major.id_major as id, COUNT(*) as val FROM (SELECT l_wish.id_user, MIN(l_wish.number) as number FROM l_wish INNER JOIN l_go_setup ON l_go_setup.id_major = l_wish.id_major '.$block.' WHERE l_wish.mark >= l_go_setup.mark_basic '.$where.' AND l_wish.id_batch = '.(int)$id.' GROUP BY l_wish.id_user) AS result INNER JOIN l_wish ON l_wish.number = result.number AND result.id_user = l_wish.id_user INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major GROUP BY l_method_major.id_major');
    //             $reg_pas_nv1 =  DB::select('SELECT l_method_major.id_major as id, COUNT(*) as val FROM (SELECT l_wish.id_user, MIN(l_wish.number) as number FROM l_wish INNER JOIN l_go_setup ON l_go_setup.id_major = l_wish.id_major '.$block.' WHERE l_wish.mark >= l_go_setup.mark_basic '.$where.' AND l_wish.id_batch = '.(int)$id.' GROUP BY l_wish.id_user) AS result INNER JOIN l_wish ON l_wish.number = result.number AND result.id_user = l_wish.id_user INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major WHERE result.number = 1 GROUP BY l_method_major.id_major');
    //             $reg_pas_nv2 =  DB::select('SELECT l_method_major.id_major as id, COUNT(*) as val FROM (SELECT l_wish.id_user, MIN(l_wish.number) as number FROM l_wish INNER JOIN l_go_setup ON l_go_setup.id_major = l_wish.id_major '.$block.' WHERE l_wish.mark >= l_go_setup.mark_basic '.$where.' AND l_wish.id_batch = '.(int)$id.' GROUP BY l_wish.id_user) AS result INNER JOIN l_wish ON l_wish.number = result.number AND result.id_user = l_wish.id_user INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major WHERE result.number = 2 GROUP BY l_method_major.id_major');
    //             $reg_pas_nv3 =  DB::select('SELECT l_method_major.id_major as id, COUNT(*) as val FROM (SELECT l_wish.id_user, MIN(l_wish.number) as number FROM l_wish INNER JOIN l_go_setup ON l_go_setup.id_major = l_wish.id_major '.$block.' WHERE l_wish.mark >= l_go_setup.mark_basic '.$where.' AND l_wish.id_batch = '.(int)$id.' GROUP BY l_wish.id_user) AS result INNER JOIN l_wish ON l_wish.number = result.number AND result.id_user = l_wish.id_user INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major WHERE result.number = 3 GROUP BY l_method_major.id_major');

    //             $reg_pas_hb1 =  DB::select('SELECT l_method_major.id_major as id, COUNT(*) as val FROM (SELECT l_wish.id_user, MIN(l_wish.number) as number FROM l_wish INNER JOIN l_go_setup ON l_go_setup.id_major = l_wish.id_major '.$block.' WHERE l_wish.mark >= l_go_setup.mark_basic '.$where.' AND l_wish.id_batch = '.(int)$id.' GROUP BY l_wish.id_user) AS result INNER JOIN l_wish ON l_wish.number = result.number AND result.id_user = l_wish.id_user INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major WHERE l_method_major.id_method = 1 GROUP BY l_method_major.id_major');
    //             $reg_pas_hb2 =  DB::select('SELECT l_method_major.id_major as id, COUNT(*) as val FROM (SELECT l_wish.id_user, MIN(l_wish.number) as number FROM l_wish INNER JOIN l_go_setup ON l_go_setup.id_major = l_wish.id_major '.$block.' WHERE l_wish.mark >= l_go_setup.mark_basic '.$where.' AND l_wish.id_batch = '.(int)$id.' GROUP BY l_wish.id_user) AS result INNER JOIN l_wish ON l_wish.number = result.number AND result.id_user = l_wish.id_user INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major WHERE l_method_major.id_method = 2 GROUP BY l_method_major.id_major');
    //             $reg_pas_nl =  DB::select('SELECT l_method_major.id_major as id, COUNT(*) as val FROM (SELECT l_wish.id_user, MIN(l_wish.number) as number FROM l_wish INNER JOIN l_go_setup ON l_go_setup.id_major = l_wish.id_major '.$block.' WHERE l_wish.mark >= l_go_setup.mark_basic '.$where.' AND l_wish.id_batch = '.(int)$id.' GROUP BY l_wish.id_user) AS result INNER JOIN l_wish ON l_wish.number = result.number AND result.id_user = l_wish.id_user INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major WHERE l_method_major.id_method = 3 GROUP BY l_method_major.id_major');
    //             break;

    //         case '2':
    //             $number = DB::table('l_year_batch')
    //             ->where('active_year_batch',1)
    //             ->where('method_mark',2)
    //             ->where('id',$id)
    //             ->get();
    //             $max = 0;
    //             $del = '';
    //             $go_user = '';
    //             $method = DB::select('SELECT * FROM l_method_major WHERE id_method IN (SELECT id FROM l_batch_method WHERE id_batch IN (SELECT id FROM l_year_batch WHERE id = '.$id.'))');
    //             for($i = 1; $i<= $number[0]->number;$i++){
    //                 $where_del = "";
    //                 $del = trim($del,',');
    //                 if($del == ''){
    //                     $where_del = "WHERE";
    //                 }else{
    //                     $where_del = 'WHERE l_wish.id_user NOT IN ('.$del .') AND';
    //                 }
    //                 $list = DB::select('SELECT l_wish.id as id,l_wish.id_major as id_major, l_wish.id_user as id_user, l_wish.number as number ,l_wish.mark as mark FROM `l_wish` '.$block.' '.$where_del.' l_wish.number = '.$i.' '.$where.' ORDER BY mark DESC');
    //                 $dem_lan1 = 0;
    //                 $del_major = '';
    //                 foreach ($method as $key => $major) {
    //                     $max = $major->max_go;
    //                     $list2 = DB::select('SELECT l_wish.id as id FROM `l_wish` '.$block.' WHERE number = '.$i.' '.$where.' AND l_wish.id_major = '.$major->id);
    //                     foreach ($list as $key => $student) {
    //                         if($student ->id_major == $major->id){
    //                             $res = array(
    //                                 'id_wish' => $student ->id,
    //                                 'major' => $student->id_major,
    //                                 'id_user' => $student->id_user,
    //                                 'number' => $student->number
    //                             );
    //                             $major->max_go = $major->max_go - 1;
    //                             $go_user .= $student ->id.',';
    //                             $del .= $student->id_user.',';
    //                             $del_major .= $student->id_user.',';
    //                             $diem = $student->mark;
    //                             $dem_lan1++;
    //                         }

    //                         if((int)$dem_lan1 == (int)count($list2) || $dem_lan1 >= $max ){
    //                             // $data[] = $res_major;
    //                             $del_major = trim($del_major,',');
    //                             if($del_major == ""){
    //                                 $where1 = "WHERE";
    //                             }else{
    //                                 $where1 = 'WHERE l_wish.id_user NOT IN ('.$del_major.') AND';
    //                             }
    //                             $list1 = DB::select('SELECT l_wish.id as id,l_wish.id_major as id_major, l_wish.id_user as id_user, l_wish.number as number ,l_wish.mark as mark FROM `l_wish` '.$block.' '.$where1.' number = '.$i.' '.$where.' AND mark = '.$diem.' AND l_wish.id_major = '.$major->id);
    //                             if(count($list1)>0){
    //                                 foreach ($list1 as $key => $student1) {
    //                                     $res = array(
    //                                         'id_wish' => $student1 ->id,
    //                                         'major' => $student1->id_major,
    //                                         'id_user' => $student1->id_user,
    //                                         'number' => $student1->number
    //                                     );
    //                                     $major->max_go = $major->max_go - 1;
    //                                     $go_user .= $student1 ->id.',';
    //                                     $del .= $student1->id_user.',';
    //                                     $dem_lan1++;
    //                                     $resutl2[] = $res;
    //                                 }
    //                             }
    //                             if($dem_lan1 == 0){
    //                                 $diem_db = DB::table('l_method_major')
    //                                 ->where('id',$major->id)
    //                                 ->select('min_mark')
    //                                 ->get();
    //                                 $diem = $diem_db[0] ->min_mark;
    //                             }
    //                             $dem_lan1 = 0;
    //                             $del_major = '';
    //                             break;
    //                         }
    //                     }

    //                 }
    //             }
    //             $go_user = trim($go_user,',');
    //             $reg_pas =  DB::select('SELECT l_major.id as id, COUNT(*) as val  FROM `l_wish` INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_wish.id IN ('.$go_user.') GROUP BY l_major.id');
    //             $reg_pas_nv1 =  DB::select('SELECT l_major.id as id, COUNT(*) as val  FROM `l_wish` INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_wish.id IN ('.$go_user.') AND l_wish.number = 1 GROUP BY l_major.id');
    //             $reg_pas_nv2 =  DB::select('SELECT l_major.id as id, COUNT(*) as val  FROM `l_wish` INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_wish.id IN ('.$go_user.') AND number = 2 GROUP BY l_major.id');
    //             $reg_pas_nv3 =  DB::select('SELECT l_major.id as id, COUNT(*) as val  FROM `l_wish` INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_wish.id IN ('.$go_user.') AND number = 3 GROUP BY l_major.id');

    //             $reg_pas_hb1 =  DB::select('SELECT l_major.id as id, COUNT(*) as val  FROM `l_wish` INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_wish.id IN ('.$go_user.') AND l_wish.id_method = 1 GROUP BY l_major.id');
    //             $reg_pas_hb2 =  DB::select('SELECT l_major.id as id, COUNT(*) as val  FROM `l_wish` INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_wish.id IN ('.$go_user.') AND l_wish.id_method = 2 GROUP BY l_major.id');
    //             $reg_pas_nl =  DB::select('SELECT l_major.id as id, COUNT(*) as val  FROM `l_wish` INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_wish.id IN ('.$go_user.') AND  l_wish.id_method = 3 GROUP BY l_major.id');
    //             // $data = $dem_lan1.'xxx'.count($list2).'xxx'.$max;
    //             // $data = $major_min_mark;
    //             break;
    //         default:
    //             # code...
    //             break;
    //     }

    //     foreach ($major_method as $value) {
    //         $data[] = array(
    //             'id' =>$value ->id,

    //             'name_major' => $value ->name_major,
    //             'min_major' =>$this ->join($value ->id,$min_major),

    //             'min_majorhb1' =>$this ->join($value ->id,$min_majorhb1),
    //             'min_majorhb2' =>$this ->join($value ->id,$min_majorhb2),
    //             'min_majornl' =>$this ->join($value ->id,$min_majornl),

    //             'min_major_hb1' =>$this ->join($value ->id,$min_major_hb1),
    //             'min_major_hb2' =>$this ->join($value ->id,$min_major_hb2),
    //             'min_major_nl' =>$this ->join($value ->id,$min_major_nl),

    //             'method_1' =>$this ->join($value ->id,$method_1),
    //             'method_2' =>$this ->join($value ->id,$method_2),
    //             'method_3' =>$this ->join($value ->id,$method_3),

    //             'reg_hb1' =>$this ->join($value ->id,$reg_hb1),
    //             'reg_hb2' =>$this ->join($value ->id,$reg_hb2),
    //             'reg_nl' =>$this ->join($value ->id,$reg_nl),
    //             'reg_all' =>$this ->join($value ->id,$reg_all),
    //             'reg_all_1' =>$this ->join($value ->id,$reg_all_1),

    //             'reg_pas' =>$this ->join($value ->id,$reg_pas),
    //             'reg_pas_nv1' =>$this ->join($value ->id,$reg_pas_nv1),
    //             'reg_pas_nv2' =>$this ->join($value ->id,$reg_pas_nv2),
    //             'reg_pas_nv3' =>$this ->join($value ->id,$reg_pas_nv3),

    //             'min_mark_hb1' =>$this ->join($value ->id,$min_mark_hb1),
    //             'min_mark_hb2' =>$this ->join($value ->id,$min_mark_hb2),
    //             'min_mark_nl' =>$this ->join($value ->id,$min_mark_nl),

    //             'reg_pas_hb1' =>$this ->join($value ->id,$reg_pas_hb1),
    //             'reg_pas_hb2' =>$this ->join($value ->id,$reg_pas_hb2),
    //             'reg_pas_nl' =>$this ->join($value ->id,$reg_pas_nl),


    //             'reg_all_ct' => $this ->join($value ->id,$reg_all_ct),
    //             'reg_hb1_ct' => $this ->join($value ->id,$reg_hb1_ct),
    //             'reg_hb2_ct' => $this ->join($value ->id,$reg_hb2_ct),
    //             'reg_nl_sum_ct' => $this ->join($value ->id,$reg_nl_sum_ct),


    //         );
    //     }
    //     return $data;
    // }

    // public function go_virtual(Request $request){
    //     $check = DB::table('l_year_batch')
    //     ->where('active_year_batch',1)
    //     ->where('id',$request ->input('id'))
    //     ->get();

    //     $id = $request ->input('id');
    //     $type = $check[0] ->method_mark;
    //     switch ($type) {
    //         case '1':
    //             $data =  $request ->input('arr_mark');
    //             DB::beginTransaction();
    //             try{
    //                 foreach ($data as $min_mark) {
    //                     DB::table('l_go_setup')
    //                     ->where('id',$min_mark[0])
    //                     ->update([
    //                         'mark_basic' =>$min_mark[1]
    //                     ]);
    //                 }

    //                 $batch = DB::table('l_year_batch')
    //                 ->join('l_batch','l_year_batch.id_batch','l_batch.id')
    //                 ->where('l_year_batch.id',$id)
    //                 ->get();

    //                 $user_agent = $_SERVER['HTTP_USER_AGENT'];
    //                 DB::table('l_history')
    //                 ->insert([
    //                     'id_student'    =>  0,
    //                     'id_user'       =>  Auth::user()->id,
    //                     'name_history'  =>  "Chạy lọc ảo",
    //                     'content'       =>  'Đợt: '.$batch[0] ->name_batch.'. Cách lấy: Theo ưu tiên điểm',
    //                     'ip'            => request()->ip(),
    //                     'info_client'   => $user_agent
    //                 ]);
    //                 DB::commit();
    //                 echo 1;
    //             }catch(Exception $e){
    //                 DB::rollBack();
    //                 echo 0;
    //             }
    //             break;
    //         case '2':
    //             $act = $request ->input('active');
    //             switch ($act) {
    //                 case '1':
    //                     $where = "";
    //                     $block = "";
    //                     break;
    //                 case '2':
    //                     $where = "";
    //                     $block = "INNER JOIN l_block_wish ON l_block_wish.id_user = l_wish.id_user";
    //                     break;
    //                 case '3':
    //                     $where = "";
    //                     $block = "INNER JOIN l_expenses_admin ON l_expenses_admin.id_wish = l_wish.id";
    //                     break;
    //                 case '4':
    //                     $where = 'AND l_check_assuser.pass = 1';
    //                     $block = "INNER JOIN l_check_assuser ON l_check_assuser.id_student = l_wish.id_user";
    //                     break;
    //                 case '5':
    //                     $where = 'AND l_check_assuser.pass = 1';
    //                     $block = "INNER JOIN l_check_assuser ON l_check_assuser.id_student = l_wish.id_user INNER JOIN l_expenses_admin ON l_expenses_admin.id_wish = l_wish.id";
    //                     break;
    //                 default:
    //                     # code...
    //                     break;
    //             }

    //             $number = DB::table('l_year_batch')
    //             ->where('active_year_batch',1)
    //             ->where('method_mark',2)
    //             ->where('id',$id)
    //             ->get();
    //             $max = 0;
    //             $del = '';
    //             $go_user = '';
    //             $method = DB::select('SELECT * FROM l_method_major WHERE id_method IN (SELECT id FROM l_batch_method WHERE id_batch IN (SELECT id FROM l_year_batch WHERE id = '.$id.'))');
    //             for($i = 1; $i<= $number[0]->number;$i++){
    //                 $where_del = "";
    //                 $del = trim($del,',');
    //                 if($del == ''){
    //                     $where_del = "WHERE";
    //                 }else{
    //                     $where_del = 'WHERE l_wish.id_user NOT IN ('.$del .') AND';
    //                 }
    //                 $list = DB::select('SELECT l_wish.id as id,l_wish.id_major as id_major, l_wish.id_user as id_user, l_wish.number as number ,l_wish.mark as mark FROM `l_wish` '.$block.' '.$where_del.' l_wish.number = '.$i.' '.$where.' ORDER BY mark DESC');
    //                 $dem_lan1 = 0;
    //                 $del_major = '';
    //                 foreach ($method as $key => $major) {
    //                     $max = $major->max_go;
    //                     $list2 = DB::select('SELECT l_wish.id as id FROM `l_wish` '.$block.' WHERE number = '.$i.' '.$where.' AND l_wish.id_major = '.$major->id);
    //                     foreach ($list as $key => $student) {
    //                         if($student ->id_major == $major->id){
    //                             $res = array(
    //                                 'id_wish' => $student ->id,
    //                                 'major' => $student->id_major,
    //                                 'id_user' => $student->id_user,
    //                                 'number' => $student->number
    //                             );
    //                             $major->max_go = $major->max_go - 1;
    //                             $go_user .= $student ->id.',';
    //                             $del .= $student->id_user.',';
    //                             $del_major .= $student->id_user.',';
    //                             $diem = $student->mark;
    //                             $dem_lan1++;
    //                         }

    //                         if((int)$dem_lan1 == (int)count($list2) || $dem_lan1 >= $max ){
    //                             // $data[] = $res_major;
    //                             $del_major = trim($del_major,',');
    //                             if($del_major == ""){
    //                                 $where1 = "WHERE";
    //                             }else{
    //                                 $where1 = 'WHERE l_wish.id_user NOT IN ('.$del_major.') AND';
    //                             }
    //                             $list1 = DB::select('SELECT l_wish.id as id,l_wish.id_major as id_major, l_wish.id_user as id_user, l_wish.number as number ,l_wish.mark as mark FROM `l_wish` '.$block.' '.$where1.' number = '.$i.' '.$where.' AND mark = '.$diem.' AND l_wish.id_major = '.$major->id);
    //                             if(count($list1)>0){
    //                                 foreach ($list1 as $key => $student1) {
    //                                     $res = array(
    //                                         'id_wish' => $student1 ->id,
    //                                         'major' => $student1->id_major,
    //                                         'id_user' => $student1->id_user,
    //                                         'number' => $student1->number
    //                                     );
    //                                     $major->max_go = $major->max_go - 1;
    //                                     $go_user .= $student1 ->id.',';
    //                                     $del .= $student1->id_user.',';
    //                                     $dem_lan1++;
    //                                     $resutl2[] = $res;
    //                                 }
    //                             }
    //                             if($dem_lan1 == 0){
    //                                 $diem_db = DB::table('l_method_major')
    //                                 ->where('id',$major->id)
    //                                 ->select('min_mark')
    //                                 ->get();
    //                                 $diem = $diem_db[0] ->min_mark;
    //                             }
    //                             $dem_lan1 = 0;
    //                             $del_major = '';
    //                             break;
    //                         }
    //                     }

    //                 }
    //             }
    //             $go_user = trim($go_user,',');

    //             $danhsach = DB::select('SELECT l_method_major.id as id, MIN(l_wish.mark) as val  FROM `l_wish` INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major WHERE l_wish.id IN ('.$go_user.') GROUP BY l_method_major.id');
    //             DB::beginTransaction();
    //             try{
    //                 foreach ($danhsach as $key => $value) {
    //                     DB::table('l_go_setup')
    //                     ->where('id_major',$value ->id)
    //                     ->update(
    //                         ['mark_basic' =>$value ->val]
    //                     );
    //                 }

    //                 $batch = DB::table('l_year_batch')
    //                 ->join('l_batch','l_year_batch.id_batch','l_batch.id')
    //                 ->where('l_year_batch.id',$id)
    //                 ->get();

    //                 $user_agent = $_SERVER['HTTP_USER_AGENT'];
    //                 DB::table('l_history')
    //                 ->insert([
    //                     'id_student'    =>  0,
    //                     'id_user'       =>  Auth::user()->id,
    //                     'name_history'  =>  "Chạy lọc ảo",
    //                     'content'       =>  'Đợt: '.$batch[0] ->name_batch. 'Cách lấy: Theo ưu tiên NV',
    //                     'ip'            => request()->ip(),
    //                     'info_client'   => $user_agent
    //                 ]);
    //                 DB::commit();
    //                 echo 1;
    //             }catch(Exception $e){
    //                 DB::rollBack();
    //                 echo 0;
    //             }
    //             break;
    //         default:
    //             # code...
    //             break;
    //     }


    // }

    // public function load_go_number_wish($batch){
    //     $batch = DB::table('l_year_batch')
    //     ->where('id',$batch)
    //     ->get();
    //     if(count($batch) >0){
    //         if(count($batch) == 1){
    //             return  $batch[0] ->number;
    //         }else{
    //             return -1;
    //         }
    //     }else{
    //         return -1;
    //     }
    // }

    // public function go_number_wish($id,$batch){
    //     DB::beginTransaction();
    //     try{
    //         DB::table('l_year_batch')
    //         ->where('id',$batch)
    //         ->update(
    //             [
    //                 'number' => $id,
    //             ]
    //         );
    //         $batch = DB::table('l_year_batch')
    //         ->join('l_batch','l_year_batch.id_batch','l_batch.id')
    //         ->where('l_year_batch.id',$batch)
    //         ->get();

    //         $user_agent = $_SERVER['HTTP_USER_AGENT'];
    //         DB::table('l_history')
    //         ->insert([
    //             'id_student'    =>  0,
    //             'id_user'       =>  Auth::user()->id,
    //             'name_history'  =>  "Chạy lọc ảo",
    //             'content'       =>  'Đợt: '.$batch[0] ->name_batch. 'Cách lấy: Cài đặt nguyện vọng',
    //             'ip'            => request()->ip(),
    //             'info_client'   => $user_agent
    //         ]);
    //         DB::commit();
    //         echo 1;
    //     }catch(Exception $e){
    //         DB::rollBack();
    //         echo 0;
    //     }
    // }



    // public function save_go($id,$act){
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
    //     $check = DB::table('l_year_batch')
    //     ->where('active_year_batch',1)
    //     ->where('id',$id)
    //     ->get();

    //     $type = $check[0] ->method_mark;



    //     switch ($type) {
    //         case '1':
    //             $data_del = DB::select('SELECT l_go.id_wish as id_wish FROM `l_go` INNER JOIN l_wish ON l_wish.id = l_go.id_wish WHERE l_wish.id_batch = '.(int)$id);
    //             if(count($data_del) >0 ){
    //                 $arr = '';
    //             $i = 0;
    //                 foreach ($data_del as $key => $value) {
    //                     if($i < count($data_del)-1){
    //                         $arr .= $value ->id_wish.",";
    //                         $i++;
    //                     }else{
    //                         $arr .= $value ->id_wish;
    //                     }
    //                 }
    //             }

    //             $reg_pas =  DB::select('SELECT l_wish.id as id, l_wish.id as id_batch FROM l_wish INNER JOIN (SELECT l_wish.id_user, MIN(l_wish.number) as number FROM l_wish INNER JOIN l_go_setup ON l_go_setup.id_major = l_wish.id_major '.$block.' WHERE l_wish.mark >= l_go_setup.mark_basic AND l_wish.id_batch = '.$id.' '.$where.' GROUP BY l_wish.id_user) AS result ON l_wish.id_user = result.id_user AND l_wish.number = result.number');
    //             if(count($reg_pas)>0){
    //                 foreach ($reg_pas as $key => $value) {
    //                     $a = array(
    //                         'id_wish' => $value ->id,
    //                         'id_batch' => $id,
    //                         'active' => 1,
    //                     );
    //                     $data[] = $a;
    //                 }
    //             }

    //             if(count($reg_pas)>0){
    //                 if(count($data_del) >0 ){
    //                     DB::beginTransaction();
    //                     try{
    //                         DB::table('l_year_batch')
    //                         ->where('id',$id)
    //                         ->update([
    //                             'active_go' => $act,
    //                         ]);
    //                         DB::select('DELETE FROM l_go WHERE id_wish IN ('.$arr.')');
    //                         DB::table('l_go')->insert($data);
    //                         DB::commit();
    //                         echo 1;
    //                     }catch(Exception $e){
    //                         DB::rollBack();
    //                         echo 0;
    //                     }
    //                 }else{
    //                     DB::beginTransaction();
    //                     try{
    //                         DB::table('l_year_batch')
    //                         ->where('id',$id)
    //                         ->update([
    //                             'active_go' => $act,
    //                         ]);
    //                         DB::table('l_go')->insert($data);
    //                         DB::commit();
    //                         echo 1;
    //                     }catch(Exception $e){
    //                         DB::rollback();
    //                         echo 0;
    //                     }
    //                 }
    //             }else{
    //                 echo 2;
    //             }
    //             break;
    //         case '2':
    //             $number = DB::table('l_year_batch')
    //             ->where('active_year_batch',1)
    //             ->where('method_mark',2)
    //             ->where('id',$id)
    //             ->get();

    //             DB::table('l_go')
    //             ->where('id_batch',$id)
    //             ->delete();

    //             $max = 0;
    //             $del = '';
    //             $go_user = '';
    //             $method = DB::select('SELECT * FROM l_method_major WHERE id_method IN (SELECT id FROM l_batch_method WHERE id_batch IN (SELECT id FROM l_year_batch WHERE id = '.$id.'))');
    //             for($i = 1; $i<= $number[0]->number;$i++){
    //                 $where_del = "";
    //                 $del = trim($del,',');
    //                 if($del == ''){
    //                     $where_del = "WHERE";
    //                 }else{
    //                     $where_del = 'WHERE l_wish.id_user NOT IN ('.$del .') AND';
    //                 }
    //                 $list = DB::select('SELECT l_wish.id as id,l_wish.id_major as id_major, l_wish.id_user as id_user, l_wish.number as number ,l_wish.mark as mark FROM `l_wish` '.$block.' '.$where_del.' l_wish.number = '.$i.' '.$where.' ORDER BY mark DESC');

    //                 $diem = 0;
    //                 $dem_lan1 = 0;
    //                 $del_major = '';
    //                 foreach ($method as $key => $major) {
    //                     $max = $major->max_go;
    //                     $list2 = DB::select('SELECT l_wish.id as id FROM `l_wish` '.$block.' WHERE number = '.$i.' '.$where.' AND l_wish.id_major = '.$major->id);
    //                     foreach ($list as $key => $student) {
    //                         if($student ->id_major == $major->id){
    //                             $res = array(
    //                                 'id_wish' => $student ->id,
    //                                 // 'major' => $student->id_major,
    //                                 // 'id_user' => $student->id_user,
    //                                 'number' => $student->number,
    //                                 'active' => 1,
    //                                 'id_batch' => 1

    //                             );
    //                             $major->max_go = $major->max_go - 1;
    //                             $go_user .= $student ->id.',';
    //                             $del .= $student->id_user.',';
    //                             $del_major .= $student->id_user.',';
    //                             $diem = $student->mark;
    //                             $dem_lan1++;
    //                             $resutl2[] = $res;
    //                         }

    //                         if((int)$dem_lan1 == (int)count($list2) || $dem_lan1 >= $max ){
    //                             // $data[] = $res_major;
    //                             $del_major = trim($del_major,',');
    //                             if($del_major == ""){
    //                                 $where1 = "WHERE";
    //                             }else{
    //                                 $where1 = 'WHERE l_wish.id_user NOT IN ('.$del_major.') AND';
    //                             }
    //                             $list1 = DB::select('SELECT l_wish.id as id,l_wish.id_major as id_major, l_wish.id_user as id_user, l_wish.number as number ,l_wish.mark as mark FROM `l_wish` '.$block.' '.$where1.' number = '.$i.' '.$where.' AND mark = '.$diem.' AND l_wish.id_major = '.$major->id);
    //                             if(count($list1)>0){
    //                                 foreach ($list1 as $key => $student1) {
    //                                     $res = array(
    //                                         'id_wish' => $student1 ->id,
    //                                         // 'major' => $student1->id_major,
    //                                         // 'id_user' => $student1->id_user,
    //                                         'number' => $student1->number,
    //                                         'active' => 1,
    //                                         'id_batch' => 1
    //                                     );
    //                                     $major->max_go = $major->max_go - 1;
    //                                     $go_user .= $student1 ->id.',';
    //                                     $del .= $student1->id_user.',';
    //                                     $dem_lan1++;
    //                                     // $diem = 12;
    //                                     $resutl2[] = $res;
    //                                 }
    //                             }
    //                             $dem_lan1 = 0;
    //                             $del_major = '';
    //                             break;
    //                         }
    //                     }
    //                 }
    //             }

    //             $go_user = trim($go_user,',');

    //             // return $resutl2[0]['id_wish'];
    //             if(count($resutl2)>0){
    //                 DB::beginTransaction();
    //                 try{
    //                     DB::table('l_year_batch')
    //                     ->where('id',$id)
    //                     ->update([
    //                         'active_go' => $act,
    //                     ]);
    //                     DB::table('l_go')->insert($resutl2);

    //                     $batch = DB::table('l_year_batch')
    //                         ->join('l_batch','l_year_batch.id_batch','l_batch.id')
    //                         ->where('l_year_batch.id',$id)
    //                         ->get();

    //                         $user_agent = $_SERVER['HTTP_USER_AGENT'];
    //                         DB::table('l_history')
    //                         ->insert([
    //                             'id_student'    =>  0,
    //                             'id_user'       =>  Auth::user()->id,
    //                             'name_history'  =>  "Chạy lọc ảo",
    //                             'content'       =>  'Đợt: '.$batch[0] ->name_batch. '. Lưu danh sách trúng tuyển',
    //                             'ip'            => request()->ip(),
    //                             'info_client'   => $user_agent
    //                         ]);
    //                     DB::commit();
    //                     echo 1;
    //                 }catch(Exception $e){
    //                     DB::rollBack();
    //                     echo 0;
    //                 }
    //             }else{
    //                 echo 2;
    //             }
    //             break;

    //         default:
    //             # code...
    //             break;
    //     }


    // }


    // public function ex_list_go($id){
    //     date_default_timezone_set("Asia/Ho_Chi_Minh");
    //     $title = 'DSTT_'.$id.'_'.date("d-m-Y H:i:s").'.xlsx';
    //     return Excel::download(new UserExport($id),$title);
    // }

    // public function ex_list_student(){
    //     date_default_timezone_set("Asia/Ho_Chi_Minh");
    //     $title = 'DanhSachThiSinh_'.date("d-m-Y H:i:s").'.xlsx';
    //     return Excel::download(new ExportStudentGo(),$title);
    // }


    // public function ex_list_wish(){
    //     date_default_timezone_set("Asia/Ho_Chi_Minh");
    //     $title = 'DanhSachNguyenVong_'.date("d-m-Y H:i:s").'.xlsx';
    //     return Excel::download(new ExportWishGo(),$title);
    // }

    // public function ex_list_wish_fail(){
    //     date_default_timezone_set("Asia/Ho_Chi_Minh");
    //     $title = 'DanhSachNguyenVongKhongDat_'.date("d-m-Y H:i:s").'.xlsx';
    //     return Excel::download(new ExportWishGoFail(),$title);
    // }

    // public function ex_list_fail(){
    //     date_default_timezone_set("Asia/Ho_Chi_Minh");
    //     $title = 'DanhSachThiSinhKhongDat_'.date("d-m-Y H:i:s").'.xlsx';
    //     return Excel::download(new ExportGoFail(),$title);
    // }

    // public function go_sta($id){
    //     $act = DB::table('l_year_batch')
    //     ->where('id',$id)
    //     ->get();

    //     $data = $this ->load_go($id,$act[0]->active_go);
    //     date_default_timezone_set("Asia/Ho_Chi_Minh");
    //     $title = 'Thong_Ke_Trung_Tuyen_'.$id.'_'.date("d-m-Y H:i:s").'.xlsx';
    //     $datas = new Collection([
    //         ['STT','Ngành xét tuyển','Tổng_Chỉ tiêu','Tổng_Đăng ký','Tổng_Trúng tuyển','Tổng_Trúng tuyển NV1','Tổng_Trúng tuyển NV2','Tổng_Trúng tuyển NV3','Tỉ lệ canh tranh','Tỉ lệ','HB1_Chỉ tiêu','HB1_Đăng ký','HB1_Ngưỡng','HB1_Điểm chuẩn','HB1_Trúng tuyển','Tỉ lệ','HB2_Chỉ tiêu','HB2_Đăng ký','HB2_Ngưỡng','HB2_Điểm chuẩn','HB2_Trúng tuyển','Tỉ lệ','NL_Chỉ tiêu','NL_Đăng ký','NL_Ngưỡng','NL_Điểm chuẩn','NL_Trúng tuyển','Tỉ lệ']
    //     ]);
    //     foreach ($data as $key => $value) {
    //         if($value['reg_all'] == 0 || $value['reg_pas'] == 0 ){
    //             $tlct = '';
    //             $tl = '';
    //         }else{
    //             $tlct = '1:'.round($value['reg_all']/$value['reg_pas'],2);
    //             $tl = round(($value['reg_pas']/$value['min_major'])*100,2);
    //         }

    //         if($value['reg_pas_hb1'] == 0 || $value['min_majorhb1'] == 0 ){
    //             $tl_hb1 = '';
    //         }else{
    //             $tl_hb1 = round(($value['reg_pas_hb1']/$value['min_majorhb1'])*100,2);
    //         }

    //         if($value['reg_pas_hb2'] == 0 || $value['min_majorhb2'] == 0 ){
    //             $tl_hb2 = '';
    //         }else{
    //             $tl_hb2 = round(($value['reg_pas_hb2']/$value['min_majorhb2'])*100,2);
    //         }

    //         if($value['reg_pas_nl'] == 0 || $value['min_majornl'] == 0  ){
    //             $tl_nl = 0;
    //         }else{
    //             $tl_nl = round(($value['reg_pas_nl']/$value['min_majornl'])*100,2);
    //         }
    //         // $tl_nl = 1;
    //         $a = [$value['id'],$value['name_major'],$value['min_major'],$value['reg_all'],$value['reg_pas'],$value['reg_pas_nv1'],$value['reg_pas_nv2'],$value['reg_pas_nv3'],$tlct,$tl,$value['min_majorhb1'],$value['reg_hb1'],$value['min_mark_hb1'],$value['min_major_hb1'],$value['reg_pas_hb1'],$tl_hb1,$value['min_majorhb2'],$value['reg_hb2'],$value['min_mark_hb2'],$value['min_major_hb2'],$value['reg_pas_hb2'],$tl_hb2,$value['min_majornl'],$value['reg_nl'],$value['min_mark_nl'],$value['min_major_nl'],$value['reg_pas_nl'],$tl_nl];
    //         // $a = [$value['id'],$tl_nl];
    //         $datas[] = $a;
    //     }
    //     // $datas = new Collection([
    //     //     [1,2,3,4]
    //     // ]);
    //     return Excel::download(new GoSta($id,$datas),$title);
    //     // return  $datas;
    // }

    // public function load_go_block($id){
    //     $act = DB::table('l_year_batch')
    //     ->where('id',(int)$id)
    //     ->get();
    //     if(count($act)>0){
    //         return $act[0]->block;
    //     }else{
    //         return 0;
    //     }
    // }


    // public function load_go_active($id){
    //     $act = DB::table('l_year_batch')
    //     ->where('id',(int)$id)
    //     ->get();
    //     if(count($act)>0){
    //         return $act[0]->active_go;
    //     }else{
    //         return 0;
    //     }
    // }

    // public function go_block($id){
    //     try{
    //         $act = DB::table('l_year_batch')
    //         ->where('id',(int)$id)
    //         ->update([
    //             'block' => 1
    //         ]);
    //         DB::commit();
    //         echo 1;
    //     }catch(Exception $e){
    //         DB::rollback();
    //         echo 0;
    //     }
    // }

    // public function clear_check(){

    //     // $oldPath = 'images/1.jpg'; // publc/images/1.jpg

    //     //  $cccd1 =  DB::table('l_image_hocba')
    //     // ->where('type_img',2)
    //     // ->where('id_img',9)
    //     // ->where('id_user',">",4000)
    //     // ->where('id_user',"<=",4000)

    //     // ->get();


    //     // $cccd =  DB::table('l_image_hocba')
    //     // ->where('type_img',0)
    //     // ->where('id_user',"<",4000)
    //     // // ->where('id_user',"<=",4000)
    //     // ->get();

    //     // $count = 0;
    //     // foreach ($cccd as $key => $value) {
    //     //     $oldPath = ltrim($value ->link_img,'/');
    //     //     if(File::exists($oldPath)){
    //     //         $path = public_path().'/img_orc/'.$value->id_user;
    //     //         if(!File::exists($path)) {
    //     //             File::makeDirectory($path);
    //     //         }
    //     //         // $newName = 'HB.png';
    //     //         $newName = 'CCCD.png';

    //     //         $newPathWithName = 'img_orc/'.$value->id_user.'/'.$newName;
    //     //         $a = File::copy($oldPath , $newPathWithName);
    //     //         $count = $count + $a;
    //     //     }
    //     // }
    //     // return $count;


    //     $cccd =  DB::table('l_image_hocba')
    //     ->where('id_user',">=",4000)
    //     // ->where('id_user',"<",4000)
    //     ->get();
    //     $count = 0;
    //     foreach ($cccd as $key => $value ) {
    //         $path =  'img_orc/'.$value ->id_user;
    //     if (File::exists($path)) {
    //         $files = File::allFiles( $path);
    //         $countFiles = 0;
    //         if ($files !== false) {
    //             $countFiles = count($files);
    //             if($countFiles != 2){
    //                 $a =  File::deleteDirectory($path);
    //                 $count = $count + $a;
    //              }
    //         }
    //     }
    //     }
    //     return $count;
    // }




}
