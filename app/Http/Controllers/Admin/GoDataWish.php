<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportGoWish;

use App\Exports\GoWish;


use Exception;

use function PHPSTORM_META\type;

class GoDataWish extends Controller

{
    public function index(){
        return view('admin.go_wish.index',
        [
            'title' => "CTUT|Hệ thống đăng ký xét tuyển",
        ]);
    }

    //Check đăng ký
    public function import_go_wish(Request $request){
        $year = DB::table('l_year_active')
        ->get();
        if($year[0]->open_go_bo == 1){
            DB::beginTransaction();
            try{
                Excel::import(new ImportGoWish, $request->file('import_go_wish'));
                $year = DB::table('l_year_active')
                ->join('l_years','l_years.id','l_year_active.id_year')
                ->get();
                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                DB::table('l_history')
                ->insert([
                    'id_student'    =>  0,
                    'id_user'       =>  Auth::user()->id,
                    'name_history'  =>  'Import Nguyện vọng từ Bộ',
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

    public function load_go_wish(){
        $year = DB::table('l_year_active')
        ->get();

        $infor = DB::select("SELECT *, l_wish.number as number,if(l_wish.tts = 1,'x','') as tts1, USER.id as id_user,l_group.id_group as id_group FROM l_wish INNER JOIN (SELECT l_method.id_method, l_major.id_major as id_major, l_major.name_major,l_method_major.id as id FROM l_method_major INNER JOIN l_major ON l_major.id = l_method_major.id_major INNER JOIN l_method ON l_method.id = l_method_major.id_method) as MAJOR ON MAJOR.id = l_wish.id_major INNER JOIN (SELECT l_users.id as id, l_users.id_card_users,l_info_users.name_user FROM l_users LEFT JOIN l_info_users ON l_info_users.id_user = l_users.id WHERE l_users.id_batch = ".$year[0]->id_batch.") AS USER ON USER.id = l_wish.id_user LEFT JOIN l_group ON l_wish.id_group = l_group.id WHERE l_wish.id_batch = ".$year[0]->id_batch." ORDER BY  l_wish.number_bo ASC, l_wish.number ASC");
        $json_data['data'] = $infor;
        $data = json_encode($json_data);
        echo  $data;
    }


    public function go_wish_tts(){
        $year = DB::table('l_year_active')
        ->get();
        if($year[0]->open_go_bo == 1){
            $tts = DB::table('l_go_check')
            ->select('id_user','id_major')
            ->join('l_wish','l_wish.id','l_go_check.id_wish')
            ->get();
            if(count($tts)> 0){
                DB::table('l_wish')
                ->where('id_batch',$year[0] ->id_batch)
                ->update([
                    'tts' => 0,
                ]);
                $wishs = DB::table('l_wish')
                ->where('id_batch',$year[0] ->id_batch)
                ->get();
                foreach ($wishs as $key => $wish) {
                    foreach ($tts as $value) {
                        if($wish ->id_major == $value ->id_major && $wish ->id_user == $value ->id_user){
                            $wish_s[]  = $wish->id;
                        }else{
                            continue;
                        }
                    }
                }
                DB::table('l_wish')
                ->whereIn('id',$wish_s)
                ->update(
                    ['tts' => 1]
                );

                $wishs = DB::table('l_wish')
                ->where('id_batch',$year[0] ->id_batch)
                ->get();
            }
        }else{
            return 2;
        }
    }

    function policy($id_user,$group_mark,$id_method){
        $year = DB::table('l_year_active')
        ->get();

        $graduation_year_user = DB::table('l_info_users')
        ->select('graduation_year_user','mark_priority',DB::raw('if(l_policy_users.mark_policy_user is null,0,l_policy_users.mark_policy_user) as mark_policy_user'))
        ->join('l_users','l_users.id','l_info_users.id_user')
        ->join('l_priority_area','l_priority_area.id','l_info_users.id_priority_area_user')
        ->leftJoin('l_policy_users_reg','l_policy_users_reg.id_user','l_info_users.id_user')
        ->leftJoin('l_policy_users','l_policy_users.id','l_policy_users_reg.id_policy_users')
        ->where('l_info_users.id_user',$id_user)
        ->get();

        if($graduation_year_user){
            $po = $graduation_year_user[0] ->mark_policy_user;

            $po_area = $graduation_year_user[0] ->mark_priority;

            if($graduation_year_user[0] ->graduation_year_user >= 2022){
                $area = $po_area;
                }else{
                    $area = 0;
                }
            }else{
                $area = 0;
            }
            $po_basic = (float)$area + (float)$po;

            switch ($id_method) {
            case '1':
                if($group_mark >= 22.5){
                    $po_basic_s = ((30-$group_mark)/7.5)*(float)$po_basic;
                }else{
                    $po_basic_s = $po_basic;
                }
                $mark_policy = $po_basic_s;
                break;
            case '2':
                if($group_mark >= 22.5){
                    $po_basic_s = ((30-$group_mark)/7.5)*(float)$po_basic;
                }else{
                    $po_basic_s = $po_basic;
                }
                $mark_policy = $po_basic_s;
                break;
            case '3':
                $mark_policy = $po_basic;
                break;
            default:
                # code...
                break;
            }
        return $mark_policy;
    }


    function mark_group($id_group,$id_method,$id_user){
        switch ($id_method) {
            case '1':
                $mark1 = DB::select('SELECT ROUND(SUM(MARK.mark),3) as group_mark FROM (SELECT SUM(l_result.mark_result) as mark,l_result.id_class_result FROM l_result WHERE l_result.id_student_result = '.(int)$id_user.' AND l_result.id_semester_result = "CN" AND l_result.id_class_result = "12"  AND l_result.id_subject IN (SELECT l_group_subject.id_subject FROM l_group_subject WHERE l_group_subject.id_group = '.(int)$id_group.') GROUP BY l_result.id_class_result) AS MARK');
                $mark2 = DB::select('SELECT ROUND(SUM(MARK.mark),3) as group_mark FROM (SELECT SUM(l_result.mark_result)/3 as mark,l_result.id_class_result FROM l_result WHERE l_result.id_student_result = '.(int)$id_user.' AND ((l_result.id_semester_result = "CN" AND (l_result.id_class_result = "10" OR l_result.id_class_result = "11")) OR (l_result.id_semester_result = "1" AND l_result.id_class_result = "12")) AND l_result.id_subject IN (SELECT l_group_subject.id_subject FROM l_group_subject WHERE l_group_subject.id_group = '.(int)$id_group.') GROUP BY l_result.id_class_result) AS MARK');
                if(count($mark1) > 0){
                    $mark_s1 = $mark1[0] ->group_mark;
                }else{
                    $mark_s1 = 0;
                }
                if(count($mark2) > 0){
                    $mark_s2 = $mark2[0] ->group_mark;
                }else{
                    $mark_s2 = 0;
                }
                if($mark_s1 >= $mark_s2){
                    $mark = $mark_s1;
                }else{
                    $mark = $mark_s2;
                }
                $group = DB::select("SELECT l_group.id,l_group.id_group, l_group.name_group, CONCAT(l_group.id_group,': ',l_group.name_group) as note_group FROM l_group WHERE l_group.id = ".(int)$id_group);
                $result = array(
                    'id' => $group[0] ->id,
                    'id_group' => $group[0] ->id_group,
                    'name_group' => $group[0] ->name_group,
                    'note_group' => $group[0] ->note_group,
                    'group_mark' => $mark,
                );
                return $result;
                break;
            case '2':
                $mark = DB::select('SELECT ROUND(SUM(MARK.mark),3) as group_mark FROM (SELECT SUM(l_result.mark_result) as mark,l_result.id_class_result FROM l_result WHERE l_result.id_student_result = '.(int)$id_user.' AND l_result.id_semester_result = "PT" AND l_result.id_subject IN (SELECT l_group_subject.id_subject FROM l_group_subject WHERE l_group_subject.id_group = '.(int)$id_group.') GROUP BY l_result.id_class_result) AS MARK');
                $group = DB::select("SELECT l_group.id,l_group.id_group, l_group.name_group, CONCAT(l_group.id_group,': ',l_group.name_group) as note_group FROM l_group WHERE l_group.id = ".(int)$id_group);
                if(count($mark) > 0){
                    $mark_s = $mark[0] ->group_mark;
                }else{
                    $mark_s = 0;
                }
                $result = array(
                    'id' => $group[0] ->id,
                    'id_group' => $group[0] ->id_group,
                    'name_group' => $group[0] ->name_group,
                    'note_group' => $group[0] ->note_group,
                    'group_mark' => $mark_s,
                );
                return $result;
                break;
            case '3':
                $mark = DB::select('SELECT l_result.mark_result as group_mark,l_result.id_class_result FROM l_result WHERE l_result.id_student_result = '.(int)$id_user.' AND l_result.id_semester_result = "NL"');
                $group = DB::select("SELECT l_group.id,l_group.id_group, l_group.name_group, CONCAT(l_group.id_group,': ',l_group.name_group) as note_group FROM l_group WHERE l_group.id = ".(int)$id_group);
                if(count($mark) > 0){
                    $mark_s = $mark[0] ->group_mark;
                }else{
                    $mark_s = 0;
                }
                $result = array(
                    'id' => $group[0] ->id,
                    'id_group' => $group[0] ->id_group,
                    'name_group' => $group[0] ->name_group,
                    'note_group' => $group[0] ->note_group,
                    'group_mark' => $mark_s
                );
                return $result;
                break;

            default:
                # code...
                break;
        }
    }

    function take_decimal_number($num,$n){
        $base = 10**$n;
        $result = round($num * $base) / $base ;
        return $result;
    }

    function total_mark($id_major,$id_method,$id_user){
        switch ($id_method) {
            case '1':
                $groups = DB::select('SELECT id_gruop FROM l_major_group WHERE id_major = '.$id_major);
                $summark = 0;
                foreach ($groups as $key => $group) {
                    $total_mark = $this ->mark_group($group ->id_gruop,$id_method,$id_user);
                    $policy_mark = $this ->policy($id_user,$total_mark['group_mark'],$id_method);
                    $mark = (float)$total_mark['group_mark'] + (float)$policy_mark;
                    if((float)$mark >= (float)$summark){
                        $summark = $mark;
                        $id = $total_mark['id'];
                        $group_mark = $this ->take_decimal_number($total_mark['group_mark'],3);
                        $name_group = $total_mark['name_group'];
                        $note_group = $total_mark['note_group'];
                        $id_group = $total_mark['id_group'];
                        $policy = $this ->take_decimal_number($policy_mark,3);
                        $mark1 = $this ->take_decimal_number($summark,2);
                    }
                }
                $result = array(
                    'id' => $id,
                    'id_group' => $id_group,
                    'name_group' => $name_group,
                    'note_group' => $note_group,
                    'group_mark' => $group_mark,
                    'priority_mark' => $policy,
                    'mark' => $mark1,
                );
                return $result;
                break;
            case '2':
                $groups = DB::select('SELECT id_gruop FROM l_major_group WHERE id_major = '.$id_major);
                $summark = 0;
                foreach ($groups as $key => $group) {
                    $total_mark = $this ->mark_group($group ->id_gruop,$id_method,$id_user);
                    $policy_mark = $this ->policy($id_user,$total_mark['group_mark'],$id_method);
                    $mark = (float)$total_mark['group_mark'] + (float)$policy_mark;
                    if((float)$mark >= (float)$summark){
                        $summark = $mark;
                        $id = $total_mark['id'];
                        $group_mark = $this ->take_decimal_number($total_mark['group_mark'],3);
                        $name_group = $total_mark['name_group'];
                        $note_group = $total_mark['note_group'];
                        $id_group = $total_mark['id_group'];
                        $policy = $this ->take_decimal_number($policy_mark,3);
                        $mark1 = $this ->take_decimal_number($summark,2);
                    }
                }
                $result = array(
                    'id' => $id,
                    'id_group' => $id_group,
                    'name_group' => $name_group,
                    'note_group' => $note_group,
                    'group_mark' => $group_mark,
                    'priority_mark' => $policy,
                    'mark' => $mark1,
                );
                return $result;
                break;
            case '3':
                $groups = DB::select('SELECT id_gruop FROM l_major_group WHERE id_major = '.$id_major);
                $summark = 0;
                foreach ($groups as $key => $group) {
                    $total_mark = $this ->mark_group($group ->id_gruop,$id_method,$id_user);
                    $policy_mark = $this ->policy($id_user,$total_mark['group_mark'],$id_method);
                    $mark = (float)$total_mark['group_mark'] + (float)$policy_mark;
                    if((float)$mark >= (float)$summark){
                        $summark = $mark;
                        $id = $total_mark['id'];
                        $group_mark = $this ->take_decimal_number($total_mark['group_mark'],3);
                        $name_group = $total_mark['name_group'];
                        $note_group = $total_mark['note_group'];
                        $id_group = $total_mark['id_group'];
                        $policy = $this ->take_decimal_number($policy_mark,3);
                        $mark1 = $this ->take_decimal_number($summark,2);
                    }
                }
                $result = array(
                    'id' => $id,
                    'id_group' => $id_group,
                    'name_group' => $name_group,
                    'note_group' => $note_group,
                    'group_mark' => $group_mark,
                    'priority_mark' => $policy,
                    'mark' => $mark1,
                );
                return $result;
                break;

            default:
                # code...
                break;
        }
    }

    public function cal_go_wish(Request $request){
        $start = $request ->input('start');
        $end = $request ->input('end');
        $year = DB::table('l_year_active')
        ->get();
        if($year[0]->open_go_bo == 1){
            $wishs = DB::table('l_wish')
            ->where('id_batch',$year[0]->id_batch)
            ->where('id_user','>=',$start)
            ->where('id_user','<=',$end)
            // ->where('id_method',2)
            ->get();
            if($wishs){
                DB::beginTransaction();
                try{
                    foreach ($wishs as $key => $wish) {
                        $group = $this ->total_mark($wish ->id_major,$wish ->id_method,$wish ->id_user);
                        DB::table('l_wish')
                        ->where('id_major',$wish ->id_major)
                        ->where('id_user',$wish ->id_user)
                        ->where('id_method',$wish ->id_method)
                        ->where('id_batch', $year[0]->id_batch)
                        ->update([
                            'id_group' => $group['id'],
                            'group_mark' => $group['group_mark'],
                            'priority_mark' => $group['priority_mark'],
                            'mark' => $group['mark'],
                        ]);
                    }
                    DB::commit();
                    return 1;
                }catch(Exception $e){
                    DB::rollBack();
                    return 0;
                }
            }else{
                return 2;
            }
        }else{
            return 3;
        }
    }


    public function number_go_wish(Request $request){
        $start = $request ->input('start');
        $end = $request ->input('end');
        $year = DB::table('l_year_active')
        ->get();
        if($year[0]->open_go_bo == 1){
            $wishs = DB::table('l_wish')
            ->where('id_batch',$year[0]->id_batch)
            ->where('id_user','>=',$start)
            ->where('id_user','<=',$end)
            // ->where('id_method',1)
            ->get();
            if($wishs){
                DB::beginTransaction();
                try{
                    foreach ($wishs as $key => $wish) {
                        $numbers = DB::select('SELECT l_wish.id as id FROM `l_wish` INNER JOIN l_method_number ON l_method_number.id_method = l_wish.id_method WHERE l_wish.id_user = '.(int)$wish->id_user.' AND id_batch = 2 ORDER BY number_bo ASC ,l_method_number.number ASC');
                        $i=1;
                        foreach ($numbers as $key => $number) {
                            DB::table('l_wish')
                            ->where('id',$number ->id)
                            ->update([
                                'number' => $i,
                            ]);
                            $i++;
                        }
                        $i = 1;
                    }
                    DB::commit();
                    return 1;
                }catch(Exception $e){
                    DB::rollBack();
                    return 0;
                }
            }else{
                return 2;
            }
        }else{
            return 3;
        }
    }


    public function download_go_wish(){
        $year = DB::table('l_year_active')
        ->get();
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DanhSachNguyenVong_'.date("d-m-Y H:i:s").'.xlsx';
        return Excel::download(new GoWish(1,$year[0] ->id_year),$title);
    }



}
