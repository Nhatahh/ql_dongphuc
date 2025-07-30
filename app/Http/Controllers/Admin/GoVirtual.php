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



use App\Exports\GoPassAoExport;
use App\Exports\GoPassTT;


use App\Imports\ImportPassNhom;
use App\Imports\ImportPassBo;


// use App\PHPExcel\IOFactory\PHPExcel_IOFactory;

use Exception;
use Illuminate\Bus\Batch;
use Illuminate\Support\Arr;

//  Include thư viện PHPExcel_IOFactory vào
// include 'C:\laragon\www\xettuyentest\app\PHPExcel\IOFactory.php';


// C:\laragon\www\xettuyentest\app\PHPExcel\IOFactory.php


class GoVirtual extends Controller

{
    public function index(){
        return view('admin.go_virtual.index',
        [
            'title' => "CTUT|Hệ thống đăng ký xét tuyển",
        ]);
    }


    public function go_virtual_batch_ts(){
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

    public function go_virtual_batch($id){
        $batch0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Đợt tuyển sinh",
                'selected' => true
            ]
        );

        $batchs = DB::table('l_go_batch_bo')
        ->where('id_batch_ts',$id)
        ->select('id',DB::raw("CONCAT(id_batch,'-',name_go) as text"))
        ->get();
        $batchs[] = $batch0;

        $result = array(
            // 'year' => $years,
            'batch' => $batchs,
            // 'user' => $user,
        );
        return $result;
    }

    function join($id,$arrs){
        $count = 0;
        foreach ($arrs as $arr) {
            if($id == $arr ->id){
                $val = $arr ->val;
                $count ++;
                break;
                }
        }
        if ($count == 0){
            $val = 0;
        }
        $count = 0;
        return $val;
    }


    public function go_virtual_load($id_batch_ts,$id_batch){
        $major_method = DB::select('SELECT l_major.id as id, l_major.name_major FROM l_method_major INNER JOIN l_major ON l_major.id = l_method_major.id_major GROUP BY l_major.id');
        $min_major =  DB::select('SELECT l_major.id as id, SUM(l_go_setup.min_major) as val FROM l_method_major INNER JOIN l_go_setup ON l_go_setup.id_major = l_method_major.id INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_go_setup.id_batch = '.$id_batch_ts.' GROUP BY l_major.id');
        $reg_all =  DB::select('SELECT COUNT(*) as val, l_method_major.id_major as id FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major WHERE l_wish.id_batch = '.$id_batch_ts.' GROUP BY l_method_major.id_major');
        $reg_pas =  DB::select('SELECT l_major.id as id, COUNT(*) as val FROM l_go_batch_pass INNER JOIN l_wish ON l_wish.id = l_go_batch_pass.id_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_method_major.id_major = l_major.id  WHERE l_go_batch_pass.id_batch = '.(int)$id_batch.' AND l_go_batch_pass.id_batch_ts = '.(int)$id_batch_ts.' GROUP BY l_major.id');
        $reg_pas_nv1_tts =  DB::select('SELECT l_major.id as id, COUNT(*) as val FROM l_go_batch_pass INNER JOIN l_wish ON l_wish.id = l_go_batch_pass.id_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_method_major.id_major = l_major.id  WHERE l_go_batch_pass.id_batch = '.(int)$id_batch.' AND l_go_batch_pass.id_batch_ts = '.(int)$id_batch_ts.' AND l_wish.number_bo = 1 AND l_wish.tts = 1 GROUP BY l_major.id');
        $reg_pas_nv1 =  DB::select('SELECT l_major.id as id, COUNT(*) as val FROM l_go_batch_pass INNER JOIN l_wish ON l_wish.id = l_go_batch_pass.id_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_method_major.id_major = l_major.id  WHERE l_go_batch_pass.id_batch = '.(int)$id_batch.' AND l_go_batch_pass.id_batch_ts = '.(int)$id_batch_ts.' AND l_wish.number_bo = 1 AND l_wish.tts = 0 GROUP BY l_major.id');
        $reg_pas_nv2_tts =  DB::select('SELECT l_major.id as id, COUNT(*) as val FROM l_go_batch_pass INNER JOIN l_wish ON l_wish.id = l_go_batch_pass.id_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_method_major.id_major = l_major.id  WHERE l_go_batch_pass.id_batch = '.(int)$id_batch.' AND l_go_batch_pass.id_batch_ts = '.(int)$id_batch_ts.' AND l_wish.number_bo = 2 AND l_wish.tts = 1 GROUP BY l_major.id');
        $reg_pas_nv2 =  DB::select('SELECT l_major.id as id, COUNT(*) as val FROM l_go_batch_pass INNER JOIN l_wish ON l_wish.id = l_go_batch_pass.id_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_method_major.id_major = l_major.id  WHERE l_go_batch_pass.id_batch = '.(int)$id_batch.' AND l_go_batch_pass.id_batch_ts = '.(int)$id_batch_ts.' AND l_wish.number_bo = 2 AND l_wish.tts = 0 GROUP BY l_major.id');
        $reg_pas_nv3_tts =  DB::select('SELECT l_major.id as id, COUNT(*) as val FROM l_go_batch_pass INNER JOIN l_wish ON l_wish.id = l_go_batch_pass.id_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_method_major.id_major = l_major.id  WHERE l_go_batch_pass.id_batch = '.(int)$id_batch.' AND l_go_batch_pass.id_batch_ts = '.(int)$id_batch_ts.' AND l_wish.number_bo = 3 AND l_wish.tts = 1 GROUP BY l_major.id');
        $reg_pas_nv3 =  DB::select('SELECT l_major.id as id, COUNT(*) as val FROM l_go_batch_pass INNER JOIN l_wish ON l_wish.id = l_go_batch_pass.id_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_method_major.id_major = l_major.id  WHERE l_go_batch_pass.id_batch = '.(int)$id_batch.' AND l_go_batch_pass.id_batch_ts = '.(int)$id_batch_ts.' AND l_wish.number_bo = 3 AND l_wish.tts = 0 GROUP BY l_major.id');
        //Học bạ
        $id_major_hb = DB::select('SELECT l_major.id as id, l_method_major.id as val FROM l_method_major INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_method_major.id_method = 1');
        $min_major_hb = DB::select('SELECT l_major.id as id, SUM(l_go_setup.min_major) as val FROM l_method_major INNER JOIN l_go_setup ON l_go_setup.id_major = l_method_major.id INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_go_setup.id_batch =  '.$id_batch_ts.' AND l_method_major.id_method = 1 GROUP BY l_major.id');
        $reg_tts =  DB::select('SELECT COUNT(*) as val, l_method_major.id_major as id FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major WHERE l_wish.id_batch = '.$id_batch_ts.' AND l_wish.tts = 1 AND l_method_major.id_method = 1 GROUP BY l_method_major.id_major');
        $reg_tts_pas =  DB::select('SELECT l_major.id as id, COUNT(*) as val FROM l_go_batch_pass INNER JOIN l_wish ON l_wish.id = l_go_batch_pass.id_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_method_major.id_major = l_major.id  WHERE l_go_batch_pass.id_batch = '.(int)$id_batch.' AND l_go_batch_pass.id_batch_ts = '.(int)$id_batch_ts.' AND l_wish.id_method = 1 AND l_wish.tts = 1 GROUP BY l_major.id');
        $reg_hb_dkm =  DB::select('SELECT COUNT(*) as val, l_method_major.id_major as id FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major WHERE l_wish.id_batch = '.$id_batch_ts.' AND l_wish.tts = 0 AND l_method_major.id_method = 1 GROUP BY l_method_major.id_major');
        $reg_hb_dkm_mark = DB::select('SELECT l_go_setup_bo.mark_basic as val,l_major.id as id FROM l_go_setup_bo INNER JOIN l_method_major ON l_method_major.id = l_go_setup_bo.id_major INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_method_major.id_method = 1 AND l_go_setup_bo.id_batch = '.(int)$id_batch);
        $reg_hb_dkm_pas =  DB::select('SELECT l_major.id as id, COUNT(*) as val FROM l_go_batch_pass INNER JOIN l_wish ON l_wish.id = l_go_batch_pass.id_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_method_major.id_major = l_major.id  WHERE l_go_batch_pass.id_batch = '.(int)$id_batch.' AND l_go_batch_pass.id_batch_ts = '.(int)$id_batch_ts.' AND l_wish.id_method = 1 AND l_wish.tts = 0 GROUP BY l_major.id');
        $reg_hb_pas =  DB::select('SELECT l_major.id as id, COUNT(*) as val FROM l_go_batch_pass INNER JOIN l_wish ON l_wish.id = l_go_batch_pass.id_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_method_major.id_major = l_major.id  WHERE l_go_batch_pass.id_batch = '.(int)$id_batch.' AND l_go_batch_pass.id_batch_ts = '.(int)$id_batch_ts.' AND l_wish.id_method = 1 GROUP BY l_major.id');
        //Trung học phổ thông
        $id_major_thpt = DB::select('SELECT l_major.id as id, l_method_major.id as val FROM l_method_major INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_method_major.id_method = 2');
        $min_major_thpt = DB::select('SELECT l_major.id as id, SUM(l_go_setup.min_major) as val FROM l_method_major INNER JOIN l_go_setup ON l_go_setup.id_major = l_method_major.id INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_go_setup.id_batch =  '.$id_batch_ts.' AND l_method_major.id_method = 2 GROUP BY l_major.id');
        $reg_thpt =  DB::select('SELECT COUNT(*) as val, l_method_major.id_major as id FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major WHERE l_wish.id_batch = '.$id_batch_ts.' AND l_wish.id_method = 2 GROUP BY l_method_major.id_major');
        $reg_thpt_mark = DB::select('SELECT l_go_setup_bo.mark_basic as val,l_major.id as id FROM l_go_setup_bo INNER JOIN l_method_major ON l_method_major.id = l_go_setup_bo.id_major INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_method_major.id_method = 2 AND l_go_setup_bo.id_batch = '.(int)$id_batch);
        $reg_thpt_pas =  DB::select('SELECT l_major.id as id, COUNT(*) as val FROM l_go_batch_pass INNER JOIN l_wish ON l_wish.id = l_go_batch_pass.id_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_method_major.id_major = l_major.id  WHERE l_go_batch_pass.id_batch = '.(int)$id_batch.' AND l_go_batch_pass.id_batch_ts = '.(int)$id_batch_ts.' AND l_wish.id_method = 2 GROUP BY l_major.id');

        //Đánh giá năng lực
        $id_major_nl = DB::select('SELECT l_major.id as id, l_method_major.id as val FROM l_method_major INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_method_major.id_method = 3');
        $min_major_nl = DB::select('SELECT l_major.id as id, SUM(l_go_setup.min_major) as val FROM l_method_major INNER JOIN l_go_setup ON l_go_setup.id_major = l_method_major.id INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_go_setup.id_batch =  '.$id_batch_ts.' AND l_method_major.id_method = 3 GROUP BY l_major.id');
        $reg_tts_nl =  DB::select('SELECT COUNT(*) as val, l_method_major.id_major as id FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major WHERE l_wish.id_batch = '.$id_batch_ts.' AND l_wish.tts = 1 AND l_method_major.id_method = 3 GROUP BY l_method_major.id_major');
        $reg_tts_nl_pas =  DB::select('SELECT l_major.id as id, COUNT(*) as val FROM l_go_batch_pass INNER JOIN l_wish ON l_wish.id = l_go_batch_pass.id_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_method_major.id_major = l_major.id  WHERE l_go_batch_pass.id_batch = '.(int)$id_batch.' AND l_go_batch_pass.id_batch_ts = '.(int)$id_batch_ts.' AND l_wish.id_method = 3 AND l_wish.tts = 1 GROUP BY l_major.id');
        $reg_nl_dkm =  DB::select('SELECT COUNT(*) as val, l_method_major.id_major as id FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major WHERE l_wish.id_batch = '.$id_batch_ts.' AND l_wish.tts = 0 AND l_method_major.id_method = 3 GROUP BY l_method_major.id_major');
        $reg_nl_dkm_mark = DB::select('SELECT l_go_setup_bo.mark_basic as val,l_major.id as id FROM l_go_setup_bo INNER JOIN l_method_major ON l_method_major.id = l_go_setup_bo.id_major INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_method_major.id_method = 3 AND l_go_setup_bo.id_batch = '.(int)$id_batch);
        $reg_nl_dkm_pas =  DB::select('SELECT l_major.id as id, COUNT(*) as val FROM l_go_batch_pass INNER JOIN l_wish ON l_wish.id = l_go_batch_pass.id_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_method_major.id_major = l_major.id  WHERE l_go_batch_pass.id_batch = '.(int)$id_batch.' AND l_go_batch_pass.id_batch_ts = '.(int)$id_batch_ts.' AND l_wish.id_method = 3 AND l_wish.tts = 0 GROUP BY l_major.id');
        $reg_nl_pas =  DB::select('SELECT l_major.id as id, COUNT(*) as val FROM l_go_batch_pass INNER JOIN l_wish ON l_wish.id = l_go_batch_pass.id_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_method_major.id_major = l_major.id  WHERE l_go_batch_pass.id_batch = '.(int)$id_batch.' AND l_go_batch_pass.id_batch_ts = '.(int)$id_batch_ts.' AND l_wish.id_method = 3 GROUP BY l_major.id');

        foreach ($major_method as $value) {
            $data[] = array(
                'id' =>$value ->id,
                'name_major' => $value ->name_major,
                'min_major' =>$this ->join($value ->id,$min_major),
                'reg_all' =>$this ->join($value ->id,$reg_all),
                'reg_pas' =>$this ->join($value ->id,$reg_pas),
                'reg_pas_nv1_tts' =>$this ->join($value ->id,$reg_pas_nv1_tts),
                'reg_pas_nv1' =>$this ->join($value ->id,$reg_pas_nv1),
                'reg_pas_nv2_tts' =>$this ->join($value ->id,$reg_pas_nv2_tts),
                'reg_pas_nv2' =>$this ->join($value ->id,$reg_pas_nv2),
                'reg_pas_nv3_tts' =>$this ->join($value ->id,$reg_pas_nv3_tts),
                'reg_pas_nv3' =>$this ->join($value ->id,$reg_pas_nv3),

                //Học bạ
                'id_major_hb' =>$this ->join($value ->id,$id_major_hb),
                'min_major_hb' =>$this ->join($value ->id,$min_major_hb),
                'reg_tts' =>$this ->join($value ->id,$reg_tts),
                'reg_tts_pas' =>$this ->join($value ->id,$reg_tts_pas),
                'reg_hb_dkm' =>$this ->join($value ->id,$reg_hb_dkm),
                'reg_hb_dkm_mark' =>$this ->join($value ->id,$reg_hb_dkm_mark),
                'reg_hb_dkm_pas' =>$this ->join($value ->id,$reg_hb_dkm_pas),
                'reg_hb_pas' =>$this ->join($value ->id,$reg_hb_pas),

                //Trung học phổn thông
                'id_major_thpt' =>$this ->join($value ->id,$id_major_thpt),
                'min_major_thpt' =>$this ->join($value ->id,$min_major_thpt),
                'reg_thpt' =>$this ->join($value ->id,$reg_thpt),
                'reg_thpt_mark' =>$this ->join($value ->id,$reg_thpt_mark),
                'reg_thpt_pas' =>$this ->join($value ->id,$reg_thpt_pas),

                //Đánh giá năng lực
                'id_major_nl' =>$this ->join($value ->id,$id_major_nl),
                'min_major_nl' =>$this ->join($value ->id,$min_major_nl),
                'reg_tts_nl' =>$this ->join($value ->id,$reg_tts_nl),
                'reg_tts_nl_pas' =>$this ->join($value ->id,$reg_tts_nl_pas),
                'reg_nl_dkm' =>$this ->join($value ->id,$reg_nl_dkm),
                'reg_nl_dkm_mark' =>$this ->join($value ->id,$reg_nl_dkm_mark),
                'reg_nl_dkm_pas' =>$this ->join($value ->id,$reg_nl_dkm_pas),
                'reg_nl_pas' =>$this ->join($value ->id,$reg_nl_pas),
            );
        }
        return $data;
    }

    static function check_block($id_batch_ts,$id){
        $block = DB::table('l_go_batch_bo')
        ->where('id_batch_ts',$id_batch_ts)
        ->where('id',$id)
        ->where('block',1)
        ->get();
        if(count($block) == 1){
            return 1; //Đã khóa
        }else{
            return 0; //Chưa khóa
        }
    }

    public function go_virtual_load_check_block(Request $request){
        $id_batch_ts = (int)$request ->input('id_batch_ts');
        $id =  (int)$request ->input('id');
        return $this ->check_block($id_batch_ts,$id);
    }

    public function go_virtual_batch_pass(Request $request){
        $marks = $request ->input('data');
        if($this->check_block($marks[0][2],$marks[0][3]) == 0){ //Đợt lọc ảo chưa khóa
            $year = DB::table('l_year_active')
            ->get();
            if(count($year)>0){
                if($year[0]->id_batch == $marks[0][2]){
                    DB::beginTransaction();
                    try{
                        for ($i=0; $i < count($marks); $i++) {
                            DB::table('l_go_setup_bo')
                            ->updateOrInsert(
                                [
                                    'id_major' => $marks[$i][0],
                                    'id_batch' => $marks[$i][3],
                                ],
                                [
                                    'mark_basic' => $marks[$i][1],
                                ],
                            );
                        }

                        DB::table('l_go_batch_pass')
                            ->where('id_batch',$marks[0][3])
                            ->delete();
                        $id_wishs = DB::select("SELECT TT3.id as id FROM (SELECT l_wish.*,CONCAT(l_wish.id_user,'x',l_wish.number) as id_noi FROM l_wish WHERE l_wish.id_batch = 2) AS TT3 INNER JOIN (SELECT CONCAT(id_user,'x',MIN(number)) as id_noi FROM (SELECT l_wish.number, l_wish.id_user, l_wish.mark, BATCH.mark_basic, l_wish.tts FROM `l_wish` INNER JOIN (SELECT * FROM l_go_setup_bo WHERE id_batch = ".$marks[0][3].") AS BATCH ON BATCH.id_major = l_wish.id_major HAVING l_wish.mark >= BATCH.mark_basic OR l_wish.tts = 1)  AS TT GROUP BY TT.id_user) AS TT2 ON TT2.id_noi =  TT3.id_noi");
                        if(count($id_wishs) >0){
                            foreach ($id_wishs as $key => $wish) {
                                $wish = array(
                                    'id_batch_ts' => $marks[0][2],
                                    'id_batch' => $marks[0][3],
                                    'id_wish' => $wish->id,
                                );
                                $ins_wish[] = $wish;
                            }
                        }
                        DB::table('l_go_batch_pass')
                        ->insert($ins_wish);

                        $batch = DB::table('l_go_batch_bo')
                        ->where('id',$marks[0][3])
                        ->where('id_batch_ts',$marks[0][2])
                        ->get();
                        $user_agent = $_SERVER['HTTP_USER_AGENT'];
                        DB::table('l_history')
                        ->insert([
                            'id_student'    =>  0,
                            'id_user'       =>  Auth::user()->id,
                            'name_history'  =>  'Lọc ảo',
                            'content'       =>  'Đợt lọc ảo: '.$batch[0] ->name_go,
                            'ip'            => request()->ip(),
                            'info_client'   => $user_agent
                        ]);
                        DB::commit();
                        return 1;
                    }catch(Exception $e){
                        DB::commit();
                        return 0;
                    }
                }else{
                    return 3;
                }
            }else{
                return 2;
            }
        }else{
            return 4;
        }
    }

    public function   go_virtual_batch_list_dowload($id_batch_ts,$id_batch){
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DanhSachTrungTuyen_Dot'.$id_batch_ts.'_DotLocAo_'.$id_batch.date("d-m-Y H:i:s").'.xlsx';
        return Excel::download(new GoPassTT($id_batch_ts,$id_batch),$title);
    }

    public function go_virtual_batch_block(Request $request){
        $id_batch_ts = (int)$request ->input('id_batch_ts');
        $id =  (int)$request ->input('id');
        DB::beginTransaction();
        try{
            DB::table('l_go_batch_bo')
            ->where('id_batch_ts',$id_batch_ts)
            ->where('id',$id)
            ->update([
                'block' => 1,
            ]);
            $batch = DB::table('l_go_batch_bo')
            ->where('id',$id)
            ->where('id_batch_ts',$id_batch_ts)
            ->get();
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            DB::table('l_history')
            ->insert([
                'id_student'    =>  0,
                'id_user'       =>  Auth::user()->id,
                'name_history'  =>  'Khóa đợt lọc ảo',
                'content'       =>  'Đợt: '.$batch[0] ->name_go,
                'ip'            => request()->ip(),
                'info_client'   => $user_agent
            ]);


            DB::commit();
            return 1;
        }catch(Exception $e){
            DB::rollBack();
            return 0;
        }
    }

    public function go_virtual_batch_list_bo(Request $request){
        $id_batch_ts =  $request->input('id_batch_ts');
        $id_batch = $request->input('id_batch');
        return $this ->check_block($id_batch_ts,$id_batch);
    }

    public function go_virtual_batch_list_bo_dowload($id_batch_ts,$id_batch){
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DanhSachUpLoad_Dot'.$id_batch_ts.'_DotLocAo_'.$id_batch.date("d-m-Y H:i:s").'.xlsx';
        return Excel::download(new GoPassAoExport($id_batch_ts,$id_batch),$title);
    }

    public function submit_go_virtual_batch_ip_list_nhom(Request $request){
        $id_batch_ts = $request -> input('import_go_virtual_batch_ip_list_id_batch_ts');
        $id_batch = $request -> input('import_go_virtual_batch_ip_list_id_batch');
        $year = DB::table('l_year_active')
        ->get();
        $check_batch = DB::table("l_go_batch_pass")
        ->where('id_batch_ts',$id_batch_ts)
        ->where('id_batch',$id_batch)
        ->get();

        // $year = DB::table('l_year_active')
        // ->get();
        // if($year[0] ->id_batch ==  $id_batch_ts){
            if(count($year) > 0){
                if($year[0]->open_go_bo == 0){
                    if($year[0]->open_go_bo == 1){
                        if(count($check_batch) > 0){
                            DB::beginTransaction();
                            try {
                                Excel::import(new ImportPassNhom($id_batch_ts,$id_batch), $request->file('import_go_virtual_batch_ip_list_nhom'));
                                DB::commit();
                                return 1;
                            } catch (Exception $e) {
                                DB::rollBack();
                                return 0;
                            }
                        }else{
                            return 3;
                        }
                    }else{
                        return 2;
                    }
                }else{
                    return 4;
                }

            }else{
                return 2;
            }
        // }
    }

    public function submit_go_virtual_batch_ip_list_bo(Request $request){
        $id_batch_ts = $request -> input('go_virtual_batch_ip_list_bo_id_batch_ts');
        $id_batch = $request -> input('go_virtual_batch_ip_list_bo_id_batch');
        $year = DB::table('l_year_active')
        ->get();
        $check_batch = DB::table("l_go_batch_pass")
        ->where('id_batch_ts',$id_batch_ts)
        ->where('id_batch',$id_batch)
        ->get();
        if(count($year) > 0){
            if($year[0]->block == 0){
                if($year[0]->open_go_bo == 1){
                    if(count($check_batch) > 0){
                        DB::beginTransaction();
                        try {
                            Excel::import(new ImportPassBo($id_batch_ts,$id_batch), $request->file('import_go_virtual_batch_ip_list_bo'));
                            DB::commit();
                            return 1;
                        } catch (Exception $e) {
                            DB::rollBack();
                            return 0;
                        }
                    }else{
                        return 3;
                    }
                }else{
                    return 2;
                }
            }else{
                return 4;
            }
        }else{
            return 2;
        }
    }

    public function add_go_virtual_chart_major($id,$id_batch_ts,$id_batch){
        // $major_method = DB::select('SELECT l_major.id as id, l_major.name_major FROM l_method_major INNER JOIN l_major ON l_major.id = l_method_major.id_major GROUP BY l_major.id');
        // $min_major =  DB::select('SELECT l_major.id as id, SUM(l_go_setup.min_major) as val FROM l_method_major INNER JOIN l_go_setup ON l_go_setup.id_major = l_method_major.id INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_go_setup.id_batch = '.$id_batch_ts.' GROUP BY l_major.id');
        // $reg_all =  DB::select('SELECT COUNT(*) as val, l_method_major.id_major as id FROM l_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major WHERE l_wish.id_batch = '.$id_batch_ts.' GROUP BY l_method_major.id_major');
        $stt = DB::select('SELECT stt FROM l_go_batch_bo WHERE id = '.$id_batch)[0] ->stt;
        $start = $stt - 3;
        $end = $stt + 2;

        $batch =  DB::select('SELECT id,id_batch FROM `l_go_batch_bo` WHERE id_batch_ts = '.(int)$id_batch_ts.' AND stt <= '.$end.' AND stt >='.$start .' ORDER BY stt ASC LIMIT 0,6');
        $pass_tr1 =  DB::select('SELECT l_major.id as id_t,l_go_batch_pass.id_batch as id, COUNT(*) as val FROM `l_go_batch_pass` INNER JOIN l_wish ON l_go_batch_pass.id_wish = l_wish.id INNER JOIN l_method_major ON l_wish.id_major = l_method_major.id INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_wish.id_method = 1 AND l_major.id = '.(int)$id.' AND l_go_batch_pass.id_batch_ts = '.(int)$id_batch_ts.' GROUP BY l_major.id,l_go_batch_pass.id_batch');
        $pass_tr2 =  DB::select('SELECT l_major.id as id_t,l_go_batch_pass.id_batch as id, COUNT(*) as val FROM `l_go_batch_pass` INNER JOIN l_wish ON l_go_batch_pass.id_wish = l_wish.id INNER JOIN l_method_major ON l_wish.id_major = l_method_major.id INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_wish.id_method = 2 AND l_major.id = '.(int)$id.' AND l_go_batch_pass.id_batch_ts = '.(int)$id_batch_ts.' GROUP BY l_major.id,l_go_batch_pass.id_batch');
        $pass_tr3 =  DB::select('SELECT l_major.id as id_t,l_go_batch_pass.id_batch as id, COUNT(*) as val FROM `l_go_batch_pass` INNER JOIN l_wish ON l_go_batch_pass.id_wish = l_wish.id INNER JOIN l_method_major ON l_wish.id_major = l_method_major.id INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_wish.id_method = 3 AND l_major.id = '.(int)$id.' AND l_go_batch_pass.id_batch_ts = '.(int)$id_batch_ts.' GROUP BY l_major.id,l_go_batch_pass.id_batch');


        $pass_nhom1 =  DB::select('SELECT l_major.id as id_t,l_go_batch_pass.id_batch as id, COUNT(*) as val FROM `l_go_batch_pass` INNER JOIN l_wish ON l_go_batch_pass.id_wish = l_wish.id INNER JOIN l_method_major ON l_wish.id_major = l_method_major.id INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_wish.id_method = 1 AND l_major.id = '.(int)$id.' AND l_go_batch_pass.id_batch_ts = '.(int)$id_batch_ts.' AND pass_nhom = 1 GROUP BY l_major.id,l_go_batch_pass.id_batch');
        $pass_nhom2 =  DB::select('SELECT l_major.id as id_t,l_go_batch_pass.id_batch as id, COUNT(*) as val FROM `l_go_batch_pass` INNER JOIN l_wish ON l_go_batch_pass.id_wish = l_wish.id INNER JOIN l_method_major ON l_wish.id_major = l_method_major.id INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_wish.id_method = 2 AND l_major.id = '.(int)$id.' AND l_go_batch_pass.id_batch_ts = '.(int)$id_batch_ts.' AND pass_nhom = 1 GROUP BY l_major.id,l_go_batch_pass.id_batch');
        $pass_nhom3 =  DB::select('SELECT l_major.id as id_t,l_go_batch_pass.id_batch as id, COUNT(*) as val FROM `l_go_batch_pass` INNER JOIN l_wish ON l_go_batch_pass.id_wish = l_wish.id INNER JOIN l_method_major ON l_wish.id_major = l_method_major.id INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_wish.id_method = 3 AND l_major.id = '.(int)$id.' AND l_go_batch_pass.id_batch_ts = '.(int)$id_batch_ts.' AND pass_nhom = 1 GROUP BY l_major.id,l_go_batch_pass.id_batch');

        $pass_bo1 =  DB::select('SELECT l_major.id as id_t,l_go_batch_pass.id_batch as id, COUNT(*) as val FROM `l_go_batch_pass` INNER JOIN l_wish ON l_go_batch_pass.id_wish = l_wish.id INNER JOIN l_method_major ON l_wish.id_major = l_method_major.id INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_wish.id_method = 1 AND l_major.id = '.(int)$id.' AND l_go_batch_pass.id_batch_ts = '.(int)$id_batch_ts.' AND pass_bo = 1 GROUP BY l_major.id,l_go_batch_pass.id_batch');
        $pass_bo2 =  DB::select('SELECT l_major.id as id_t,l_go_batch_pass.id_batch as id, COUNT(*) as val FROM `l_go_batch_pass` INNER JOIN l_wish ON l_go_batch_pass.id_wish = l_wish.id INNER JOIN l_method_major ON l_wish.id_major = l_method_major.id INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_wish.id_method = 2 AND l_major.id = '.(int)$id.' AND l_go_batch_pass.id_batch_ts = '.(int)$id_batch_ts.' AND pass_bo = 1 GROUP BY l_major.id,l_go_batch_pass.id_batch');
        $pass_bo3 =  DB::select('SELECT l_major.id as id_t,l_go_batch_pass.id_batch as id, COUNT(*) as val FROM `l_go_batch_pass` INNER JOIN l_wish ON l_go_batch_pass.id_wish = l_wish.id INNER JOIN l_method_major ON l_wish.id_major = l_method_major.id INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_wish.id_method = 3 AND l_major.id = '.(int)$id.' AND l_go_batch_pass.id_batch_ts = '.(int)$id_batch_ts.' AND pass_bo = 1 GROUP BY l_major.id,l_go_batch_pass.id_batch');

        if(count($batch)>0){
            foreach ($batch as $value) {
                $data[] = array(
                    'id' =>$value ->id,
                    'id_batch' => $value ->id_batch,
                    'pass_tr1' =>$this ->join($value ->id,$pass_tr1),
                    'pass_tr2' =>$this ->join($value ->id,$pass_tr2),
                    'pass_tr3' =>$this ->join($value ->id,$pass_tr3),

                    'pass_nhom1' =>$this ->join($value ->id,$pass_nhom1),
                    'pass_nhom2' =>$this ->join($value ->id,$pass_nhom2),
                    'pass_nhom3' =>$this ->join($value ->id,$pass_nhom3),

                    'pass_bo1' =>$this ->join($value ->id,$pass_bo1),
                    'pass_bo2' =>$this ->join($value ->id,$pass_bo2),
                    'pass_bo3' =>$this ->join($value ->id,$pass_bo3),
                );
            }
            return $data;
        }else{
            return 2;
        }


        // $id_batch_ts = $request -> input('go_virtual_batch_ip_list_bo_id_batch_ts');
        // $id_batch = $request -> input('go_virtual_batch_ip_list_bo_id_batch');
        // SELECT l_major.id ,COUNT(*) FROM `l_go_batch_pass` INNER JOIN l_wish ON l_wish.id = l_go_batch_pass.id_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_major.id = l_method_major.id_major GROUP BY l_major.id

    }

    public function go_virtual_batch_list_bo_block(){
        $check =   DB::table('l_year_active')
        ->get();
        if(count($check) >0){
            if($check[0]->block == 0){
                DB::table('l_year_active')
                ->update(
                    ['block' => 1]
                );
                return 1;
            }
            if($check[0]->block == 1){
                return 2;
            }
        }else{
            return 3;
        }
    }


    public function go_virtual_batch_list_bo_internet(){
        $check =   DB::table('l_year_active')
        ->get();
        if(count($check) >0){
            if($check[0]->search == 0){
                DB::table('l_year_active')
                ->update(
                    ['search' => 1]
                );
                return 1;
            }
            if($check[0]->search == 1){
                return 2;
            }
        }else{
            return 3;
        }
    }

    public function go_virtual_batch_list_bo_new_dowload($id){
        $check =   DB::table('l_year_active')
        ->get();
        if(count($check) >0){
            if($check[0]->block == 1){




                return 1;
            }
            if($check[0]->block == 0){
                return 2;
            }
        }else{
            return 3;
        }
    }
}






















