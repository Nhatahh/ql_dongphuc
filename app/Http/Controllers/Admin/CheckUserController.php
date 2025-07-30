<?php

namespace App\Http\Controllers\Admin;
use PDF;
use Carbon\Carbon;
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

use \App\Http\Controllers\User\Main\RegisterWishController;
use Exception;
use LDAP\Result;
use PHPUnit\Framework\Constraint\Count;
use Psy\Command\WhereamiCommand;

use function PHPUnit\Framework\countOf;

class CheckUserController extends Controller

{
    public function index(){
        return view('admin.checkuser.index',
        [
            'title' => "CTUT|Hệ thống đăng ký xét tuyển",
        ]);
    }



    function check_year(){
        $check_year = DB::table('l_year_active')
        ->get();
        if(count($check_year) > 0 ){
            if(count($check_year) == 1){
                $result = array(
                    'sus' => 1,
                    'id_year' => $check_year[0]->id_year,
                );
            }else{
                $result = array(
                    'sus' => 0,
                    'id_year' => 0,
                );
            }
        }else{
            $result = array(
                'sus' => 0,
                'id_year' => 0,
            );
        }
        return $result;
    }

    public function  change_check(Request $request){
        $number = DB::table('l_wish')
        ->where('id_user',$request ->input('id_user'))
        ->where('id_major',$request ->input('id_major'))
        ->get();

        $check = DB::table('l_wish')
        ->join('l_go_batch_pass','l_wish.id','l_go_batch_pass.id_wish')
        ->where('l_wish.id_user',$request ->input('id_user'))
        ->get();

        // $check_block = DB::table('l_check_assuser')
        // ->where('l_check_assuser.id_student',$request ->input('id_user'))
        // ->get();

        // if(count($check_block) >0){
        //     if($check_block[0]->check_user == 3){
        if($this->check_user_edit() == 0){
            return 6;
        }else{
            if(count($check)>0){
                echo 3;
            }else{
                if(count($number) >0){
                    if($number[0]->number == 1 && $number[0]->id_major == $request ->input('id_major') ){
                        DB::beginTransaction();
                        try{
                            DB::table('l_go_batch_pass')
                            ->insert(
                                [
                                    'id_wish' => $number[0]->id,
                                    'id_batch_ts' => 2,
                                    'id_batch' => 18,
                                    'pass_bo' => 1,
                                    'note' => 'bs'
                                ]
                            );

                            $major = DB::table('l_method_major')
                            ->select('l_major.name_major as name_major')
                            ->join('l_major','l_method_major.id_major','l_major.id')
                            ->where('l_method_major.id',$request ->input('id_major'))
                            ->get();

                            $user_agent = $_SERVER['HTTP_USER_AGENT'];
                            DB::table('l_history')
                            ->insert([
                                'id_student'    =>  $request ->input('id_user'),
                                'id_user'       =>  Auth::user()->id,
                                'name_history'  =>  "Chuyển ngành/Cập nhật ngành TT",
                                'content'       =>  "Cập nhật Ngành: ".$major[0]->name_major,
                                'ip'            => request()->ip(),
                                'info_client'    => $user_agent
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
                }else{
                    echo 2;
                }
            }
        }

            // }else{
            //     echo 5;
        //     // }
        // }else{
        //     echo 4;
        // }

    }

    function check_pass($id){
        $check = DB::table('l_check_assuser')
        ->where('id_student',$id)
        ->get();
        if(count($check) == 1){
            if($check[0]->pass == 1){
                $check1 = 1;
            }else{
                $check1 = 0;
            }
        }else{
            $check1 = 0;
        }
        return $check1;
    }

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


    //Load Search
    public function load_search(){
        //Year
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

        //Tỉnh
        $province0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Tỉnh THPT",
                'selected' => true
            ]
        );
        $provinces = DB::table('l_province')
        ->select('id','name_province as text')
        ->get();
        $provinces[] = $province0;


        $school0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Trường THPT",
                'selected' => true
            ]
        );

        // $schools = DB::table('l_school')
        // ->select('l_school.id as id','name_school as text')
        // ->get();
        $schools[] = $school0;

        $result = array(
            'year' => $years,
            'batch' => $batchs,
            'province' => $provinces,
            'school' => $schools,

        );
        return $result;
    }

    //Change Year
    public function changeyear($id){
        $batch0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Đợt tuyển sinh",
                'selected' => true
            ]
        );
        $batchs = DB::table('l_year_batch')
        ->select('l_batch.id as id','name_batch as text')
        ->join('l_batch','l_year_batch.id_batch','l_batch.id')
        ->where('id_year',$id)
        ->get();
        $batchs[] = $batch0;
        echo  $batchs;
    }

    //Change School
    public function changeprovince($id){
        $school0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Trường THPT",
                'selected' => true
            ]
        );
        $schools = DB::table('l_school')
        ->select('l_school.id as id','name_school as text')
        ->where('id_province',$id)
        ->get();
        $schools[] = $school0;
        echo $schools;
    }

    public function load_list_reg(Request $request){
        $year = $request ->input('data')[0];
        $active = $request ->input('data')[2];
        $batch = $request ->input('data')[1];
        // $province = $request ->input('data')[3];
        // $school = $request ->input('data')[4];
        $id_card = $request ->input('data')[3];
        $phone = $request ->input('data')[4];
        $id = $request ->input('data')[5];
        if($batch == 0){
            $batch = 'l_batch.id is not null';
        }else{
            $batch = 'l_batch.id = '.$batch;
        }

        if( $id_card == ''){
            $id_card  = 'id_card_users is not null';
        }else{
            $id_card = 'id_card_users = '.$id_card;
        }

        if( $phone == ''){
            $phone  = 'phone_users is not null';
        }else{
            $phone = 'phone_users = '.$phone;
        }

        if( $id == ''){
            $id  = 'l_users.id is not null';
        }else{
            $id = 'l_users.id= '.$id;
        }

        $check = DB::table('l_roles')
        ->where('iduser',Auth::user()->id)
        ->where('idmenu',16)
        // ->where('idmenu',13)
        ->get();
        if(count($check) == 1){
            $user = 'l_check_assuser.id_student is not null';
        }else{
            $user = "l_check_assuser.id_user = ". Auth::user()->id;
        }
        switch ($active) {
            case 1:


                break;
            case 2:
                # code...
                break;
            case 3:
                // $batch = DB::table('l_year_batch')
                // ->where('active_year_batch',1)
                // ->get();
                // $sql ="SELECT if(l_check_block.id_user >0,l_check_block.pass,0) as active_block,l_users.id as id, l_info_users.name_user, DATE_FORMAT(l_info_users.birth_user, '%d/%m/%Y') as birth_user,l_users.phone_users as phone_users, l_users.email_users as email_users,l_users.id_card_users as id_card_users,l_batch.name_batch as name_batch FROM l_users INNER JOIN l_info_users ON l_users.id = l_info_users.id_user INNER JOIN l_batch ON l_batch.id = l_users.id_batch  INNER JOIN l_check_assuser ON l_check_assuser.id_student = l_info_users.id_user LEFT JOIN l_check_block ON l_check_block.id_student = l_users.id WHERE l_users.id_year = ".$year." AND ".$batch." AND ".$id_card." AND ".$phone." AND ".$id. " AND l_check_assuser.id_user = ". Auth::user()->id." ORDER BY l_users.id ASC";

                $sql ="SELECT if(l_check_assuser.pass >0,l_check_assuser.pass,0) as pass,l_check_assuser.id_student as id, l_info_users.name_user as name_user,l_users.phone_users as phone_users,l_users.id_card_users as id_card_users, l_users.email_users as email_users, l_batch.name_batch as name_batch, CONCAT(l_check_assuser.check_user,'-',l_check_assuser.id_student) as check_user FROM l_check_assuser INNER JOIN l_info_users ON l_info_users.id_user = l_check_assuser.id_student INNER JOIN l_users  ON l_users.id = l_check_assuser.id_student INNER JOIN l_batch ON l_batch.id = l_users.id_batch WHERE l_users.id_year = ".$year." AND ".$batch." AND ".$id_card." AND ".$phone." AND ".$id. " AND ".$user." ORDER BY l_check_assuser.create_at ASC";
                // $sql ='SELECT *,l_batch_user.id_user as id FROM `l_batch_user` INNER JOIN l_users ON l_users.id = l_batch_user.id_user INNER JOIN l_info_users ON l_info_users.id_user = l_batch_user.id_user INNER JOIN l_batch ON l_batch.id = l_batch_user.id_batch INNER JOIN l_year_batch ON l_year_batch.id_batch = l_batch_user.id_batch INNER JOIN l_years ON l_years.id = l_year_batch.id_year =  '.$year.' AND '.$batch.' AND '.$id_card.' AND '.$phone.' AND '.$id. ' ORDER BY l_batch_user.id_user ASC';

                break;
            default:
                # code...
                break;
        };
        $infor = DB::select($sql);
        $json_data['data'] = $infor;
        $data = json_encode($json_data);
        echo  $data;
    }

    public function search($id){
        $infor = DB::table('l_info_users')
        ->join('l_users','l_users.id','l_info_users.id_user')
        ->where('id_user',$id)
        ->get();
        if(count($infor) == 0){
            $active_info = 0;
        }else{
            $active_info = 1;
        }

        $img = DB::table('l_image_hocba')
        ->where('id_user',$id)
        ->where('id_img',10)
        ->get();

        if(count($img) == 0){
            $img = "#";
        }else{
            $img = $img[0]->link_img;
        }

        $result = array(
            'info' => $infor,
            'active_info' => $active_info,
            'img' => $img,
        );
        return $result;
    }

    //Load Trường THPT
    public function load_list_school($id){
        $data = DB::table('l_area')
            ->join('l_school','l_school.id','l_area.id_school_area')
            ->join('l_priority_area','l_school.priority_area_school','l_priority_area.id')
            ->join('l_province','l_province.id','l_school.id_province')
            ->where('l_area.id_user_area',$id)
            ->select('l_area.id as id','id_province_area','id_school_area','time_area','l_area.id_class_area as class','id_priority_area','id_school_check')
            ->orderBy('l_area.id_class_area')
            ->get();

            if(count($data) >0){
                foreach ($data as $value) {
                    $class = $value->class;
                    $time_area = $value->time_area;
                    $id_priority_area = $value->id_priority_area;
                    $provinces = DB::table('l_province')
                    ->orderBy('id', 'asc')
                    ->get();
                    foreach ($provinces as $province ){
                        if( $province ->id == $value ->id_province_area){
                            $province ->selected = 'selected';
                        }else{
                            $province ->selected = "";
                        }
                    }

                    $schools = DB::table('l_school')
                    ->where('id_province',$value ->id_province_area)
                    ->orderBy('id', 'asc')
                    ->get();

                    foreach ($schools as $school ){
                        if( $school ->id == $value ->id_school_area){
                            $school ->selected = "selected";
                        }else{
                            $school ->selected = "";
                        }
                    }

                    $row = array(
                        'class' => $class,
                        'provinces' => $provinces,
                        'school' => $schools,
                        'time_area' => $time_area,
                        'id_priority_area' => $id_priority_area,
                        'id_province_area' => $value ->id_province_area,
                        'id_data' => $value ->id,
                        'id_school_check' => $value ->id_school_check,
                        'fail' => 0,
                    );
                    $result[] = $row;
                    unset($row);
                }
            }else{
                $row = array(
                    'fail' => 1,
                );
                $result[] = $row;
            }

            return $result;
        // $json_data['data'] = $data;
        // $data = json_encode($json_data);
        // echo  $data;

    }

    //Change Tỉnh ->>> Trường
    public function change_province_school($id){
        $province0 = new Collection(
            [
                'id' => 0,
                'name_school' => 'Chọn Trường THPT',
                'selected' => 'selected'
            ]
        );
        $provinces = DB::table('l_school')
        ->select('id','name_school')
        ->where('id_province',$id)
        ->orderBy('id', 'asc')
        ->get();
        foreach ($provinces as $province ){
            $province ->selected = '';
        }
        $provinces[] = $province0;
        return $provinces;

    }

    //Change Trường ---> Khu vực
    public function change_school_area($id){
        $area = DB::table('l_school')
        ->select('id_priority_area')
        ->join('l_priority_area','l_school.priority_area_school','l_priority_area.id')
        ->where('l_school.id',$id)
        ->get();
        return $area;

    }

    //Load Tỉnh
    public function load_province(){
        $province0 = new Collection(
            [
                'id' => 0,
                'name_province' => 'Chọn Tỉnh/TP',
                'selected' => 'selected'
            ]
        );
        $provinces = DB::table('l_province')
        ->select('id','name_province')
        ->orderBy('id', 'asc')
        ->get();
        foreach ($provinces as $province ){
            $province ->selected = '';
        }
        $provinces[] = $province0;
        return $provinces;
    }

    public function save_list_school(Request $request){

        $data = $request->input('data');
        if($this ->check_block($data[0][4]) == 1){
           return 3;
        }else{
            DB::beginTransaction();
            try{
                DB::table('l_area')
                ->where('id_user_area',$data[0][4])
                ->delete();
                for ($i = 0; $i < count($data); $i++){
                    DB::table('l_area')
                    ->insert([
                        'id_class_area'     => $data[$i][0],
                        'id_province_area'  => $data[$i][1],
                        'id_school_area'    => $data[$i][2],
                        'time_area'         => $data[$i][3],
                        'id_user_area'      => $data[$i][4],
                        'id_school_check'   => $data[$i][0]."_".$data[$i][1]."_".$data[$i][2]."_".$data[$i][3]."_".$data[$i][4]
                        ]);

                    $province = DB::table('l_province')
                    ->where('id',$data[$i][1])
                    ->get();
                    $schools = DB::table('l_school')
                    ->where('id',$data[$i][2])
                    ->get();

                    $user_agent = $_SERVER['HTTP_USER_AGENT'];
                    DB::table('l_history')
                    ->insert([
                        'id_student'    =>  $data[$i][4],
                        'id_user'       =>  Auth::user()->id,
                        'name_history'  =>  "Kiểm tra hồ sơ",
                        'content'       =>  "Cập nhật: Lớp ".$data[$i][0].", Tỉnh ".$province[0] ->name_province.", Trường ".$schools[0] ->name_school.", Thời gian ".$data[$i][3],
                        'ip'            => request()->ip(),
                        'info_client'   => $user_agent
                    ]);

                }
                // $mark = DB::select('SELECT max(time_area) as time_area FROM (SELECT sum(l_area.time_area) as time_area,l_school.priority_area_school as priority_area_school FROM `l_area` INNER JOIN l_school ON l_area.id_school_area = l_school.id INNER JOIN l_priority_area ON l_priority_area.id = l_school.priority_area_school WHERE l_area.id_user_area = '.$data[0][4].' GROUP BY l_school.priority_area_school ORDER BY l_priority_area.num_priority_area ASC) AS A');
                // $area = DB::select('SELECT sum(l_area.time_area) as time_area,l_school.priority_area_school as priority_area_school FROM `l_area` INNER JOIN l_school ON l_area.id_school_area = l_school.id INNER JOIN l_priority_area ON l_priority_area.id = l_school.priority_area_school WHERE l_area.id_user_area = '.$data[0][4].' GROUP BY l_school.priority_area_school ORDER BY l_priority_area.num_priority_area ASC');
                // foreach ($area as $key => $value) {
                //     if($mark[0]->time_area == $value ->time_area){
                //         DB::table('l_info_users')
                //         ->where('id_user',$data[0][4])
                //         ->update([
                //             'id_priority_area_user' =>$value ->priority_area_school,
                //         ]);
                //         $area = DB::table('l_priority_area')
                //         ->where('id',$value ->priority_area_school)
                //         ->get();

                //         DB::table('l_history')
                //         ->insert([
                //             'id_student'    =>  $data[0][4],
                //             'id_user'       =>  Auth::user()->id,
                //             'name_history'  =>  "Kiểm tra hồ sơ",
                //             'content'       =>  "Cập nhật KVUT: ".$area[0] ->id_priority_area,
                //             'ip'            => request()->ip(),
                //             'info_client'    => $user_agent
                //         ]);
                //         break;
                //     }
                // }

                // $wishs = DB::table('l_wish')
                // ->where('id_user',$data[0][4])
                // ->get();
                // foreach ($wishs as $key => $wish) {
                //     $id_user = $wish->id_user;
                //     $id_method = $wish->id_method;
                //     $id_group = $wish->id_group;
                //     $group_mark =  $this ->take_decimal_number($this ->group_mark($id_method,$id_group,$id_user),3);
                //     $priotity_mark = $this ->take_decimal_number($this ->priotity_mark($id_user,$this ->group_mark($id_method,$id_group,$id_user)),3);
                //     $total_mark =  $this ->take_decimal_number($group_mark + $priotity_mark,2);
                //     DB::table('l_wish')
                //     ->where('id',$wish->id)
                //     ->update([
                //         'group_mark' => $group_mark,
                //         'priority_mark' => $priotity_mark,
                //         'mark' => $total_mark,
                //     ]);
                // }

                DB::commit();
                return 'true';
            } catch (Exception $e) {
                DB::rollback();
                return 'ins_false';
            }
        }
    }

    //Load sider học bạ
    function loadslider_info_check($id){
        $sliders = DB::table('l_image_hocba')
        ->whereIn('type_img',[0,1,4])
        ->where('id_user',$id)
        ->orderBy('id_img','asc')
        ->get();
        $html = '<ul class = "slider_info_check" id ="slider_info_check">';
        foreach ($sliders as  $slider) {
            switch ($slider->type_img) {
                case 0:
                    $title = "Chứng minh nhân dân";
                    break;
                case 1:
                    $title = "Đối tượng ưu tiên";
                    break;
                case 4:
                    $title = "Bằng Tốt nghiệp THPT";
                    break;
                default:
                    # code...
                    break;
            }
            $html .= '<li><img src="'.$slider->link_img.'" title="'.$title.'"></li>';
        }
        $html .= '</ul>';
        $result = array(
            'html' => $html,
            'fail' => 0
        );
        return $result;
    }

    //Load khu vực ưu tiên sau khi lưu Trường THPT
    public function load_area_check($id){
        try{
            $area = DB::table('l_info_users')
            ->join('l_priority_area','l_priority_area.id','l_info_users.id_priority_area_user')
            ->where('id_user',$id)
            ->get();
            return $area[0]->name_priority_area;
        }catch (Exception $e){
            return "Không tìm thấy khu vực";
        }
    }

                            //ĐỐI TƯỢNG ƯU TIÊN

    //Load đối tượng ưu tiên
    public function load_policy_check($id){
        $policy0 = new Collection(
            [
                'id' => 0,
                'text' => 'Chọn Đối tượng ưu tiên',
                'selected' => true
            ]
        );

        $policy1 = new Collection(
            [
                'id' => 0,
                'text' => 'Chọn Đối tượng ưu tiên',
                'selected' => false
            ]
        );

        $policy_user = DB::table('l_policy_users_reg')
        ->select('name_policy_user','note_policy_user','id_policy_users')
        ->join('l_policy_users','l_policy_users.id','l_policy_users_reg.id_policy_users')
        ->where('id_user',$id)
        ->get();

        if(count($policy_user) >0 ){
            $note_policy = $policy_user[0] ->note_policy_user;
        }else{
            $note_policy = "";
        }

        $policys = DB::table("l_policy_users")
            ->select('id','name_policy_user as text')
            ->get();
        if(count($policy_user) >0){
            foreach ($policys as $policy ){
                if($policy ->id == $policy_user[0]->id_policy_users){
                    $policy ->selected = true;
                }else{
                    $policy ->selected = false;
                }
            }
            $policys[] = $policy1;
        }else{
            foreach ($policys as $policy ){
                $policy ->selected = false;
            }
            $policys[] = $policy0;
        }

        $file_policy = DB::table('l_policy_users_reg')
            ->select('name_list','l_policy_users_list.id as id_file')
            ->join('l_policy_users_list','l_policy_users_list.id_policy_users','l_policy_users_reg.id_policy_users')
            ->where('id_user',$id)
            ->get();

        $html = "";
        if(count($file_policy) >0){
            foreach ($file_policy as $key => $value) {
                $get_img = DB::table("l_image_hocba")
                ->where('type_img',1)
                ->where('id_user',$id)
                ->where('id_img',$value ->id_file)
                ->get();
                if(count($get_img) == 1){
                    $id_data = $get_img[0] ->id_check;
                    $color = "#007bff";
                }else{
                    $color = "red";
                    $id_data = 0;
                }
                $html .= '<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-paperclip img_check img_check'.$value ->id_file.'" id_check = '.$id_data.' id_check_1 = '.$id_data.' onclick = file_policy_check('.$value ->id_file.') id-data = '.$value ->id_file.' style = "color: '.$color.'" aria-hidden="true"></i>&nbsp;&nbsp;'.$value ->name_list."</div>";
                // $img_link[] = $value->link_img;
            }
        }else{
            $html = "";
        }

        $result = array(
            'policy' => $policys,
            'note_policy' => $note_policy,
            'list_policy' => $html,
        );

        return $result;

    }

    //Change Đối tượng ưu tiên
    public function change_policy_check(Request $request){
        try{
            $policy_user = DB::table('l_policy_users')
            ->select('note_policy_user')
            ->where('id',$request ->input('id'))
            ->get();
            $file_policy = DB::table('l_policy_users')
            ->select('name_list','l_policy_users_list.id as id_file')
            ->join('l_policy_users_list','l_policy_users_list.id_policy_users','l_policy_users.id')
            ->where('l_policy_users.id',$request ->input('id'))
            ->get();
            $html = "";
            foreach ($file_policy as $key => $value) {
                $get_img = DB::table("l_image_hocba")
                ->where('type_img',1)
                ->where('id_user',$request ->input('id_user'))
                ->where('id_img',$value ->id_file)
                ->get();
                if(count($get_img) == 1){
                    $id_data = $get_img[0] ->id_check;
                    $color = "#007bff";
                }else{
                    $color = "red";
                    $id_data = 0;
                }
                $html .= '<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-paperclip img_check img_check'.$value ->id_file.'" id_check = '.$id_data.' id_check_1 = '.$id_data.' onclick = file_policy_check('.$value ->id_file.') id-data = '.$value ->id_file.' style = "color: '.$color.'" aria-hidden="true"></i>&nbsp;&nbsp;'.$value ->name_list."</div>";
                // $img_link[] = $value->link_img;
            }
            $result = array(
                'file_policy' => $html,
                'note_policy' => $policy_user[0] ->note_policy_user,
                'fail' => 0,
            );
            return $result;
        }catch(Exception $e){
            $result = array(
                'file_policy' => '',
                'note_policy' => '',
                'fail' => 1,
            );
            return $result;
        }
    }

    //Random đường dẫn
    function rand_string( $length ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str ='';
        $size = strlen( $chars );

        for( $i = 0; $i < $length ; $i++ ) {
            $str .= $chars[rand( 0, $size - 1)];
        }
        return $str;
    }

    //Save đối tượng ưu tiên
    public function save_policy_check(Request $request){
        if($this ->check_block($request->input('id_user'))){
            return 3;
        }else{
            if( $request ->input('id') == 0){
                DB::beginTransaction();
                try{
                    DB::table('l_image_hocba')
                    ->where('id_user', $request ->input('id_user'))
                    ->where('type_img', 1)
                    ->delete();
                    DB::table('l_policy_users_reg')
                    ->where('id_user', $request ->input('id_user'))
                    ->delete();

                    $user_agent = $_SERVER['HTTP_USER_AGENT'];
                    DB::table('l_history')
                    ->insert([
                        'id_student'    => $request ->input('id_user'),
                        'id_user'       => Auth::user()->id,
                        'name_history'  => "Kiểm tra hồ sơ",
                        'content'       => "Cập nhật đối tượng ưu tiên: Không ưu tiên",
                        'ip'            => request()->ip(),
                        'info_client'    => $user_agent

                    ]);

                    // $wishs = DB::table('l_wish')
                    // ->where('id_user',$request->input('id_user'))
                    // ->get();
                    // foreach ($wishs as $key => $wish) {
                    //     $id_user = $wish->id_user;
                    //     $id_method = $wish->id_method;
                    //     $id_group = $wish->id_group;
                    //     $group_mark =  $this ->take_decimal_number($this ->group_mark($id_method,$id_group,$id_user),3);
                    //     $priotity_mark = $this ->take_decimal_number($this ->priotity_mark($id_user,$this ->group_mark($id_method,$id_group,$id_user)),3);
                    //     $total_mark =  $this ->take_decimal_number($group_mark + $priotity_mark,2);
                    //     DB::table('l_wish')
                    //     ->where('id',$wish->id)
                    //     ->update([
                    //         'group_mark' => $group_mark,
                    //         'priority_mark' => $priotity_mark,
                    //         'mark' => $total_mark,
                    //     ]);
                    // }

                    DB::commit();
                    return true;
                }catch(Exception $e){
                    DB::rollback();
                    return false;
                }
            }else{
                DB::beginTransaction();
                try{
                    DB::table('l_policy_users_reg')
                    ->updateOrInsert(
                    [
                        'id_user' => $request->input('id_user')
                    ],
                    [
                        'id_policy_users' => $request ->input('id')
                    ]);

                    DB::table('l_image_hocba')
                    ->where('id_user', $request ->input('id_user'))
                    ->where('type_img', 1)
                    ->delete();

                    $data = $request->input('data');
                    foreach ($data as $value) {
                        $prefixfileName = $request ->input('id_user').'.png';
                        $fileName =$this ->rand_string(30)."_".$prefixfileName;
                        $path = '/images/hocba'.'/'.$request ->input('id_user').'/policy_1_'.$value[1].'_'.$fileName;
                        $data = $value[0];
                        list($type, $data) = explode(';', $data);
                        list(, $data)      = explode(',', $data);
                        $data = base64_decode($data);
                        $storage = Storage::disk('local');
                        $storage->put('/hocba'.'/'.$request ->input('id_user').'/policy_1_'.$value[1].'_'.$fileName, $data, 'public');
                        DB::table('l_image_hocba')
                        ->updateOrInsert(
                            [
                                'id_user'   =>$request ->input('id_user'),
                                'type_img'  =>1,
                                'id_img'    =>$value[1],
                            ],
                            [
                                'link_img'     => $path,
                                'note_type'    => "Đối tượng ưu tiên",
                                'block_img'    => 0,
                                'number_img'   => 3,
                                'id_check'     => $value[2],
                            ]
                        );
                    }

                    $policy_his = DB::table('l_policy_users')
                    ->where('id',$request ->input('id'))
                    ->get();
                    $user_agent = $_SERVER['HTTP_USER_AGENT'];
                    DB::table('l_history')
                    ->insert([
                        'id_student'    => $request ->input('id_user'),
                        'id_user'       => Auth::user()->id,
                        'name_history'  => "Kiểm tra hồ sơ",
                        'content'       => "Cập nhật đối tượng ưu tiên: ".$policy_his[0] ->name_policy_user,
                        'ip'            => request()->ip(),
                        'info_client'    => $user_agent
                    ]);

                    // $wishs = DB::table('l_wish')
                    // ->where('id_user',$request->input('id_user'))
                    // ->get();
                    // foreach ($wishs as $key => $wish) {
                    //     $id_user = $wish->id_user;
                    //     $id_method = $wish->id_method;
                    //     $id_group = $wish->id_group;
                    //     $group_mark =  $this ->take_decimal_number($this ->group_mark($id_method,$id_group,$id_user),3);
                    //     $priotity_mark = $this ->take_decimal_number($this ->priotity_mark($id_user,$this ->group_mark($id_method,$id_group,$id_user)),3);
                    //     $total_mark =  $this ->take_decimal_number($group_mark + $priotity_mark,2);
                    //     DB::table('l_wish')
                    //     ->where('id',$wish->id)
                    //     ->update([
                    //         'group_mark' => $group_mark,
                    //         'priority_mark' => $priotity_mark,
                    //         'mark' => $total_mark,
                    //     ]);
                    // }
                    DB::commit();
                    return true;
                }catch(Exception $e){
                    DB::rollBack();
                    return 'fail';
                }
            }
        }
    }


                            //THÔNG TIN CÁ NHÂN
    //Load Thông tin cá nhân
    public function load_list_info($id){
        $info = DB::table('l_info_users')
        ->join('l_users','l_users.id','l_info_users.id_user')
        // ->join('l_priority_area','l_priority_area.id','l_info_users.id_priority_area_user')
        ->where('id_user',$id)
        ->get();

        $birth_provine = new Collection(
            [
                'id' => 0,
                'text' => 'Chọn Tỉnh/Thành phố',
                'selected' => true
            ]
        );

        $nation0 = new Collection(
            [
                'id' => 0,
                'text' => 'Chọn Dân tộc',
                'selected' => true
            ]
        );

        $province0 = new Collection(
            [
                'id' => 0,
                'text' => 'Chọn Tỉnh/Thành phố Thường trú',
                'selected' => true
            ]
        );

        $province20 = new Collection(
            [
                'id' => 0,
                'text' => 'Chọn Huyện/Quận Thường trú',
                'selected' => true
            ]
        );

        $province30 = new Collection(
            [
                'id' => 0,
                'text' => 'Chọn Xã/Phường Thường trú',
                'selected' => true
            ]
        );


        $user = DB::table('l_info_users')
        ->where('id_user',$id)
        ->get();

        $provinces_birth = DB::table('l_province')
        ->select('id','name_province as text')
        ->orderBy('id', 'asc')
        ->get();

        $nations = DB::table('l_nation')
        ->select('id','name_nation as text')
        ->orderBy('id', 'asc')
        ->get();

        $provinces = DB::table('l_province')
        ->select('id','name_province as text')
        ->orderBy('id', 'asc')
        ->get();

        $provinces2 = DB::table('l_province2')
        ->select('id','name_province2 as text')
        ->where('id_province',$user[0] ->id_khttprovince_user)
        ->orderBy('id', 'asc')
        ->get();

        $provinces3 = DB::table('l_province3')
        ->select('id','name_province3 as text')
        ->where('id_province2',$user[0] ->id_khttprovince2_user)
        ->orderBy('id', 'asc')
        ->get();

        if(count($user) == 1){
            foreach ($provinces_birth as $province ){
                if( $province ->id == $user[0] ->id_place_user){
                    $province ->selected = true;
                }else{
                    $province ->selected = false;
                }
            }

            foreach ($nations as $nation ){
                if( $nation ->id == $user[0] ->id_nation_user){
                    $nation ->selected = true;
                }else{
                    $nation ->selected = false;
                }
            }

            foreach ($provinces as $province ){
                if( $province ->id == $user[0] ->id_khttprovince_user){
                    $province ->selected = true;
                }else{
                    $province ->selected = false;
                }
            }

            foreach ($provinces2 as $province ){
                if( $province ->id == $user[0] ->id_khttprovince2_user){
                    $province ->selected = true;
                }else{
                    $province ->selected = false;
                }
            }

            foreach ($provinces3 as $province ){
                if( $province ->id == $user[0] ->id_khttprovince3_user){
                    $province ->selected = true;
                }else{
                    $province ->selected = false;
                }
            }

        }else{
            foreach ($provinces_birth as $province ){
                $province ->selected = false;
            }
            $provinces_birth[] = $birth_provine;

            foreach ($nations as $nation ){
                $nation ->selected = false;
            }
            $nations[] = $nation0;

            foreach ($provinces as $province ){
                $province ->selected = false;
            }
            $provinces[] = $province0;

            foreach ($provinces2 as $province ){
                $province ->selected = false;
            }
            $provinces2[] = $province20;

            foreach ($provinces3 as $province ){
                $province ->selected = false;
            }
            $provinces3[] = $province30;

        }

        $result = array(
            'info' => $info,
            'birth_provine' => $provinces_birth,
            'nation' => $nations,
            'province' => $provinces,
            'province2' => $provinces2,
            'province3' => $provinces3,
            // 'policy' => $policys,
            // 'note_policy' => $policy_user,
            // // 'file_policy' => $html,
            // // 'check_policy' => $check_policy
        );
        return $result;
    }
    //Change HỘ khẩu thường trú TỈnh
    public function change_hktt_province_check($id){
        $doituong = new Collection(
            [
                'id' => 0,
                'text' => 'Chọn Quận/Huyện',
                'selected' => true
            ]
        );
        $provinces = DB::table('l_province2')
        ->select('id','name_province2 as text')
        ->where('id_province',$id)
        ->orderBy('id', 'asc')
        ->get();
        $provinces[] = $doituong;
        return  $provinces;
    }

    public function change_hktt_province2_check($id){
        $doituong = new Collection(
            [
                'id' => 0,
                'text' => 'Chọn Phường/Xã',
                'selected' => true
            ]
        );
        $provinces = DB::table('l_province3')
        ->select('id','name_province3 as text')
        ->where('id_province2',$id)
        ->orderBy('id', 'asc')
        ->get();
        $provinces[] = $doituong;
        return  $provinces;
    }

    public function add_info_check(Request $request){
        if($this ->check_block($request->input('id_user'))){
            return 3;
        }else{
            DB::beginTransaction();
            try{
                DB::table('l_info_users')
                ->where('id_user',$request->input('id_user'))
                ->update([
                    'name_user'                 => $request->input('name_user'),
                    'birth_user'                => $request->input('birth_user'),
                    'id_place_user'             => $request->input('id_place_user'),
                    'id_nation_user'            => $request->input('id_nation_user'),
                    'emailsc_user'              => $request->input('emailsc_user'),
                    'phonesc_user'              => $request->input('phonesc_user'),
                    'sex_user'                  => $request->input('sex_user'),
                    'address_user'              => $request->input('address_user'),
                    'id_khttprovince_user'      => $request->input('id_khttprovince_user'),
                    'id_khttprovince2_user'     => $request->input('id_khttprovince2_user'),
                    'id_khttprovince3_user'     => $request->input('id_khttprovince3_user'),
                    'graduation_year_user'      => $request->input('graduation_year_user'),
                ]);

                $info = DB::table('l_info_users')->where('id_user',$request->input('id_user'))->get();
                $id_place_user = DB::table('l_province') ->where('id',$info[0]->id_place_user)->select('name_province')->get()[0]->name_province;
                $id_nation_user = DB::table('l_nation') ->where('id',$info[0]->id_nation_user)->select('name_nation')->get()[0]->name_nation;
                $id_khttprovince_user = DB::table('l_province') ->where('id',$info[0]->id_khttprovince_user)->select('name_province')->get()[0]->name_province;
                $id_khttprovince2_user = DB::table('l_province2') ->where('id',$info[0]->id_khttprovince2_user)->select('name_province2')->get()[0]->name_province2;
                $id_khttprovince3_user = DB::table('l_province3') ->where('id',$info[0]->id_khttprovince3_user)->select('name_province3')->get()[0]->name_province3;
                $request->input('sex_user') == 1 ? $sex_user = "Nữ" : $sex_user = "Nam";
                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                DB::table('l_history')
                ->insert([
                    'id_student'    => $request ->input('id_user'),
                    'id_user'       => Auth::user()->id,
                    'name_history'  => "Kiểm tra hồ sơ",
                    'content'       => "Cập nhật Tên: ".$info[0]->name_user.", Ngày sinh:  ".$info[0]->birth_user.", Nơi sinh: ".$id_place_user.", Giới tính: ".$sex_user.", Dân tộc: ".$id_nation_user.", Email phụ: ".$info[0]->emailsc_user.", SĐT phụ: ".$info[0]->phonesc_user.", Năm TN: ".$info[0]->graduation_year_user.", HKTT Tỉnh: ".$id_khttprovince_user.", HKTT Huyện: ".$id_khttprovince2_user.", HKTT Xã: ".$id_khttprovince3_user,
                    'ip'            => request()->ip(),
                    'info_client'    => $user_agent
                ]);

                // $wishs = DB::table('l_wish')
                // ->where('id_user',$request->input('id_user'))
                // ->get();
                // foreach ($wishs as $key => $wish) {
                //     $id_user = $wish->id_user;
                //     $id_method = $wish->id_method;
                //     $id_group = $wish->id_group;
                //     $group_mark =  $this ->take_decimal_number($this ->group_mark($id_method,$id_group,$id_user),3);
                //     $priotity_mark = $this ->take_decimal_number($this ->priotity_mark($id_user,$this ->group_mark($id_method,$id_group,$id_user)),3);
                //     $total_mark =  $this ->take_decimal_number($group_mark + $priotity_mark,2);
                //     DB::table('l_wish')
                //     ->where('id',$wish->id)
                //     ->update([
                //         'group_mark' => $group_mark,
                //         'priority_mark' => $priotity_mark,
                //         'mark' => $total_mark,
                //     ]);
                // }
                DB::commit();
                return 1;
            }catch(Exception $e){
                DB::rollBack();
                return 0;
            }
        }
    }


                         //ĐIỂM

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

    // Load phương thức
    public function method_mark_check(){
        $method0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn phương thức tuyển sinh",
                'selected' => true
            ]
        );
        $check_batch = DB::table('l_year_batch')
        ->join('l_batch','l_batch.id','l_year_batch.id_batch')
        ->where('active_year_batch',1)
        ->select('l_year_batch.id_batch as id','l_batch.name_batch as text')
        ->get();
        if(count($check_batch) == 1){
            $method = DB::table('l_batch_method')
            ->join('l_method','l_method.id','l_batch_method.id_method')
            ->where('active_batch_method',1)
            ->select('l_batch_method.id_method as id','l_method.name_method as text')
            ->get();
            $method[] = $method0;
            $result = array(
                'method' => $method,
                'fail' => 0,
            );
        }else{
            if(count($check_batch) == 0){
                $method =  new Collection(
                    [
                        'id' => 0,
                        'text' =>"Không có đợt tuyển sinh đang mở",
                        'selected' => true
                    ]
                );
                $result = array(
                    'method' => $method,
                    'fail' => 1,
                );
            }else{
                $method =  new Collection(
                    [
                        'id' => 0,
                        'text' =>"Lỗi cài đặt hệ thống",
                        'selected' => true
                    ]
                );
                $result = array(
                    'method' => $method,
                    'fail' => 2,
                );
            }
        }
        return $result;
    }

    //Load điểm theo phương thức
    public function load_mark_check($id){
        $active_year = DB::table('l_year_active')
        ->get();
        if(count($active_year) == 1){
        switch ($active_year[0] ->id_year) {
            case '1':
                $mark10hk1= DB::table('l_result')
                ->where('id_semester_result',1)
                ->where('id_class_result',10)
                ->where('id_student_result',$id)
                ->where('year_result',$active_year[0] ->id_year)
                ->get();

                $mark10hk2= DB::table('l_result')
                ->where('id_semester_result',2)
                ->where('id_class_result',10)
                ->where('year_result',$active_year[0] ->id_year)
                ->where('id_student_result',$id)->get();

                $mark10hkcn= DB::table('l_result')
                ->where('id_semester_result',"CN")
                ->where('id_class_result',10)
                ->where('year_result',$active_year[0] ->id_year)
                ->where('id_student_result',$id)->get();

                $mark11hk1= DB::table('l_result')
                ->where('id_semester_result',1)
                ->where('id_class_result',11)
                ->where('year_result',$active_year[0] ->id_year)
                ->where('id_student_result',$id)->get();

                $mark11hk2= DB::table('l_result')
                ->where('id_semester_result',2)
                ->where('id_class_result',11)
                ->where('year_result',$active_year[0] ->id_year)
                ->where('id_student_result',$id)->get();

                $mark11hkcn= DB::table('l_result')
                ->where('id_semester_result',"CN")
                ->where('id_class_result',11)
                ->where('year_result',$active_year[0] ->id_year)
                ->where('id_student_result',$id)->get();

                $mark12hk1= DB::table('l_result')
                ->where('id_semester_result',1)
                ->where('id_class_result',12)
                ->where('year_result',$active_year[0] ->id_year)
                ->where('id_student_result',$id)->get();

                $mark12hk2= DB::table('l_result')
                ->where('id_semester_result',2)
                ->where('id_class_result',12)
                ->where('year_result',$active_year[0] ->id_year)
                ->where('id_student_result',$id)->get();

                $mark12hkcn= DB::table('l_result')
                ->where('id_semester_result',"CN")
                ->where('id_class_result',12)
                ->where('year_result',$active_year[0] ->id_year)
                ->where('id_student_result',$id)->get();

                $subject = DB::table("l_year_subject")
                ->join('l_subject','l_subject.id','l_year_subject.id_subject')
                ->where('l_subject.id_type_subject',1)
                ->get();

                if(count($mark10hk1) == count($subject) && count($mark10hk2) == count($subject) && count($mark10hkcn) == count($subject) && count($mark11hk1) == count($subject) && count($mark11hk2) == count($subject) && count($mark11hkcn) == count($subject) && count($mark12hk1) == count($subject) && count($mark12hk2) == count($subject) && count($mark12hkcn) == count($subject)){
                    $active_hb = 1;
                }else{
                    $active_hb = 0;
                }

                $mark_nl= DB::table('l_result')
                ->where('id_semester_result',"NL")
                ->where('id_class_result','NL')
                ->where('year_result',$active_year[0] ->id_year)
                ->where('id_student_result',$id)->get();

                $mark_thpt= DB::table('l_result')
                ->where('id_semester_result',"PT")
                ->where('id_class_result','TN')
                ->where('year_result',$active_year[0] ->id_year)
                ->where('id_student_result',$id)->get();

                $subject_thpt = DB::table("l_year_subject")
                ->join('l_subject','l_subject.id','l_year_subject.id_subject')
                ->where('l_subject.id_type_subject',3)
                ->get();

                if(count($mark_thpt) == count($subject_thpt)){
                    $active_thpt = 1;
                }else{
                    $active_thpt = 0;
                }


                if(count($mark_nl)==1){
                    $active_nl = 1;
                }else{
                    $active_nl = 0;
                }

                $result = array(
                    'subject' => $subject,
                    'mark_10hk1' => $mark10hk1,
                    'mark_10hk2' => $mark10hk2,
                    'mark_10hkcn' => $mark10hkcn,
                    'mark_11hk1' => $mark11hk1,
                    'mark_11hk2' => $mark11hk2,
                    'mark_11hkcn' => $mark11hkcn,
                    'mark_12hk1' => $mark12hk1,
                    'mark_12hk2' => $mark12hk2,
                    'mark_12hkcn' => $mark12hkcn,
                    'active_hb' => $active_hb,
                    'subject_nl' => "Điểm thi:",
                    'mark_nl' => $mark_nl,
                    'active_nl' => $active_nl,
                    'subject_thpt' => $subject_thpt,
                    'mark_thpt' => $mark_thpt,
                    'active_thpt' => $active_thpt,
                );
                return $result;
            break;
        default:
            # code...
            break;

            }
        }
    }

    //Load Slider minh chứng điểm
    function loadslider_mark_check(Request $request){
        $sliders = DB::table('l_image_hocba')
        // ->whereIn('type_img',[0,1,4])
        ->where('id_user',$request ->input('data'))
        ->orderBy('type_img','asc')
        ->get();
        $html = '';
        foreach ($sliders as  $slider) {
            $html .= '<div class="swiper-slide" style = "height:100%">';
            $html .= '<div class="swiper-zoom-container" style = "height:100%"><img style="height:100%;width:auto" src="'.$slider->link_img.'" title="'.$slider->note_type.'"></div>';
            $html .= '</div>';
        }
        echo $html;
    }

    //Kiểm tra người sửa thông tin
    function check_user_edit(){
        $check = DB::table('l_check_assuser_admin')
        ->where('id_admin',Auth::user()->id)
        ->get();
        if(count($check) > 0){
            if(count($check) == 1){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }
    //Edit Điểm
    function edit_mark_check(Request $request){
        DB::beginTransaction();
        if($this ->check_user_edit() == 1){
            if($this ->check_block($request->input('id_student')) == 1){
                return 3;
            }else{
                try
                {
                    DB::table('l_result')
                    ->where('id',$request->input('id'))
                    ->update(['mark_result' => $request->input('mark')]);
                    $subject = DB::select('SELECT name_subject FROM (SELECT * FROM l_result WHERE id = '.$request->input('id').') AS A INNER JOIN l_subject ON l_subject.id = A.id_subject');
                    $user_agent = $_SERVER['HTTP_USER_AGENT'];
                    DB::table('l_history')
                    ->insert([
                        'id_student'    =>  $request->input('id_student'),
                        'id_user'       =>  Auth::user()->id,
                        'name_history'  =>  "Kiểm tra hồ sơ",
                        'content'       =>  "Cập nhật: Điểm môn ".$subject[0] ->name_subject.": ".$request->input('mark'),
                        'ip'            => request()->ip(),
                        'info_client'   => $user_agent
                    ]);
                    DB::commit();
                    echo 1;
                }catch(Exception $e){
                    DB::rollBack();
                    echo 0;
                }
            }
        }else{
            return 4;
        }
    }



                    //NGUYỆN VỌNG
    //Load nguyện vọng
    public function load_wish_check($id){

        // SELECT if(l_wish.tts = 1,"x","") as tts, if(l_go_batch_pass.id_wish is null, "Trượt", "Đỗ") as tt, l_wish.id_method as id_method_id,priority_mark,group_mark,l_wish.id_batch as id_batch,l_wish.id_user,l_wish.mark,l_wish.number, l_wish.id as id, l_wish.id_method as method, l_wish.id_major as id_major, l_major.name_major,l_method.id_method as id_method,l_method_major.min_mark, l_wish.id_group as id_group  FROM `l_wish` INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_method_major.id_major = l_major.id INNER JOIN l_batch_method ON l_batch_method.id = l_wish.id_method INNER JOIN l_method ON l_batch_method.id_method = l_method.id INNER JOIN l_group ON l_group.id = l_wish.id_group LEFT JOIN l_go_batch_pass ON l_wish.id = l_go_batch_pass.id_wish WHERE id_user = 10603 ORDER BY l_wish.number ASC
        $info = DB::select('SELECT if(l_wish.tts = 1,"x","") as tts, if(TT.id_wish is null, "Trượt", "Đỗ") as tt, l_wish.id_method as id_method_id,priority_mark,group_mark,l_wish.id_batch as id_batch,l_wish.id_user,l_wish.mark,l_wish.number, l_wish.id as id, l_wish.id_method as method, l_wish.id_major as id_major, l_major.name_major,l_method.id_method as id_method,l_method_major.min_mark, l_wish.id_group as id_group  FROM `l_wish` INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_method_major.id_major = l_major.id INNER JOIN l_batch_method ON l_batch_method.id = l_wish.id_method INNER JOIN l_method ON l_batch_method.id_method = l_method.id INNER JOIN l_group ON l_group.id = l_wish.id_group  LEFT JOIN (SELECT * FROM l_go_batch_pass WHERE l_go_batch_pass.id_batch = 18 ) AS TT ON l_wish.id = TT.id_wish WHERE l_wish.id_user = '.$id.' ORDER BY l_wish.number ASC');
        foreach ($info as $value) {
            $methods = DB::table('l_batch_method')
            ->select('l_batch_method.id as id','l_method.id_method as text')
            // ->where('id_batch',$value->id_batch)
            ->join('l_method','l_method.id','l_batch_method.id_method')
            ->get();
            foreach ($methods as $key => $method) {
                if($method->id == $value->method){
                    $method ->selected = 'selected';
                }else{
                    $method ->selected = '';
                }
            }
            $value->sl_method = $methods;


            $majors = DB::table('l_method_major')
            ->select('l_method_major.id as id','l_major.name_major as text')
            ->where('l_method_major.id_method',$value->method)
            ->join('l_major','l_major.id','l_method_major.id_major')
            ->get();

            $major0 = array(
                'id' => 0,
                'text' => "Chọn nguyện vọng",
                'selected' => ""
            );
            foreach ($majors as $key => $major) {
                if($major->id == $value->id_major){
                    $major ->selected = 'selected';
                }else{
                    $major ->selected = '';
                }
            }
            $majors[] = $major0;
            $value->sl_major = $majors;

            $groups = DB::table('l_major_group')
            ->select('l_major_group.id_gruop as id',DB::raw("CONCAT(l_group.id_group,'-',l_group.name_group) as text"))
            ->join('l_group','l_group.id','l_major_group.id_gruop')
            ->where('l_major_group.id_major',$value->id_major)
            ->get();
            $group0 = array(
                'id' => 0,
                'text' => "Chọn tổ hợp",
                'selected' => ""
            );
            foreach ($groups as $key => $group) {
                if($group->id == $value->id_group){
                    $group ->selected = 'selected';
                }else{
                    $group ->selected = '';
                }
            }
            $groups[] = $group0;
            $value->sl_group = $groups;

        }

        $block = DB::table('l_check_assuser')
        ->where('id_student',$id)
        ->get();


        if($this ->check_block($id) == 1){
            $check_block = 1;
            $user_block = $block[0]->id_user;
        }else{
            $check_block = 0;
            $user_block = 0;
        }


        // if($this ->check_block($id) == 1){
        //     if($block[0] ->pass == 1){
        //         $check_block = 1;
        //         $user_block = $block[0]->id_user;
        //     }else{
        //         $check_block = 0;
        //         $user_block = 0;
        //     }
        // }else{
        //     $check_block = 0;
        //     $user_block = 0;
        // }


        if(count($info) > 0){
            $fail = 0;
        }else{
            $info = "Không có nguyện vọng";
            $fail = 1;
        }

        $result = array(
            'info' => $info,
            'fail' => $fail,
            'check_block' => $this ->check_block($id),
            'user_block' => $user_block,
        );
        return $result;
    }


    public function change_method_wish_check($id){
        $majors = DB::table('l_method_major')
            ->select('l_method_major.id as id','l_major.name_major as text')
            ->where('l_method_major.id_method',$id)
            ->join('l_major','l_major.id','l_method_major.id_major')
            ->get();
        $major0 = array(
                'id' => 0,
                'text' => "Chọn nguyện vọng",
                'selected' => "selected"
            );
        $majors[] = $major0;

        $group = array(
            'id' => 0,
            'text' => "Chọn tổ hợp",
        );

        $result = array(
            'majors' => $majors,
            'groups' => $group,
        );

        return $result;
    }

    public function change_major_wish_check($id){
        $group0 = array(
            'id' => 0,
            'text' => "Chọn tổ hợp",
            'selected' => ""
        );

        $groups = DB::table('l_major_group')
            ->select('l_major_group.id_gruop as id',DB::raw("CONCAT(l_group.id_group,'-',l_group.name_group) as text"))
            ->join('l_group','l_group.id','l_major_group.id_gruop')
            ->where('l_major_group.id_major',$id)
            ->get();

        if(count($groups) > 0)  {
            $groups[] = $group0;
        }else{
            $groups =  $group0;
        }

        $min_mark = DB::table('l_method_major')
            ->select('min_mark')
            ->where('l_method_major.id',$id)
            ->get();

        $result = array(
            'groups' => $groups,
            'min_mark' => $min_mark[0] ->min_mark,
        );
        return $result;
    }

    //làm tròn
    function take_decimal_number($num,$n){
        $base = 10**$n;
        $result = round($num * $base) / $base ;
        return $result;
    }

    //Tính điểm tổ hợp
    // function group_mark($id_method,$id_group,$id_user){
    //     switch ($id_method) {
    //         case '1':
    //             $group_subject = DB::table('l_group_subject')
    //             ->where('l_group_subject.id_group',$id_group)
    //             ->get();
    //             $mark = 0;
    //             foreach ($group_subject as $key => $subject) {
    //                 $results = DB::table('l_result')
    //                 ->where([
    //                 ['id_subject','=',  $subject->id_subject],
    //                 ['id_student_result',$id_user],
    //                 ['id_semester_result', '=', 1],
    //                 ['id_class_result', '=', 10]
    //                 ])
    //                 ->orWhere([
    //                 ['id_subject','=',  $subject->id_subject],
    //                 ['id_student_result',$id_user],
    //                 ['id_semester_result', '=', 1],
    //                 ['id_class_result', '<=>', 11]
    //                 ])
    //                 ->orWhere([
    //                 ['id_subject','=',  $subject->id_subject],
    //                 ['id_student_result',$id_user],

    //                 ['id_semester_result', '=', 1],
    //                 ['id_class_result', '<=>', 12]
    //                 ])
    //                 ->orWhere([
    //                 ['id_subject','=',  $subject->id_subject],
    //                 ['id_student_result',$id_user],

    //                 ['id_semester_result', '=', 2],
    //                 ['id_class_result', '<=>', 10]
    //                 ])
    //                 ->orWhere([
    //                 ['id_subject','=',   $subject->id_subject],
    //                 ['id_student_result',$id_user],
    //                 ['id_semester_result', '=', 2],
    //                 ['id_class_result', '<=>', 11]
    //                 ])
    //                 ->sum('mark_result');
    //                 $mark = $mark + $results;
    //                 }
    //                 $mark_group =$mark/5;
    //             return $mark_group;
    //             break;
    //         case '2':
    //             $group_subject = DB::table('l_group_subject')
    //             ->where('l_group_subject.id_group',$id_group)
    //             ->get();
    //             $mark = 0;
    //             foreach ($group_subject as $key => $subject) {
    //                 $results = DB::table('l_result')
    //                 ->where([
    //                 ['id_subject','=',  $subject->id_subject],
    //                 ['id_student_result',$id_user],
    //                 ['id_semester_result', '=', 'CN'],
    //                 ['id_class_result', '=', 12]
    //                 ])
    //                 ->sum('mark_result');
    //                 $mark = $mark + $results;
    //             }
    //             $mark_group =$mark;
    //             return $mark_group;
    //             break;
    //         case '3':
    //             $results = DB::table('l_result')
    //             ->where('id_student_result',$id_user)
    //             ->where('id_semester_result','NL')
    //             ->get();
    //             return $results[0]->mark_result;
    //             break;
    //         default:
    //             # code...
    //             break;
    //     }
    // }

    //Tính điêm ưu tiên
    // function priotity_mark($id_user,$mark_group){
    //     $area_user = DB::table('l_info_users')
    //     ->select('l_info_users.graduation_year_user as year','id_user','mark_priority','l_priority_area.id_priority_area','l_priority_area.name_priority_area','l_priority_area.id as id')
    //     ->join('l_priority_area','l_priority_area.id','l_info_users.id_priority_area_user')
    //     ->where('l_info_users.id_user',$id_user)
    //     ->get();
    //     $policy_user = DB::select('SELECT id_user,id_policy_users,l_policy_users.name_policy_user,l_policy_users.mark_policy_user as mark_policy_user FROM `l_policy_users_reg` INNER JOIN l_policy_users ON l_policy_users.id = l_policy_users_reg.id_policy_users WHERE id_user = '.$id_user);


    //     if($policy_user){
    //         $mark_policy_user = $policy_user[0]->mark_policy_user;
    //     }else{
    //     $mark_policy_user = 0;
    //     }
    //     $mark = $area_user[0]->mark_priority + $mark_policy_user;

    //     if($area_user[0] ->year >= 2022){
    //         if($mark_group < 22.5 || $mark_group >30){
    //             $priotity_mark = $mark;
    //         }else{
    //             $priotity_mark = ((30 - $mark_group)/7.5)*$mark;
    //         }
    //     }else{
    //         $priotity_mark = 0;
    //     }
    //     return $priotity_mark;
    // }


    public function change_group_wish_check(Request $request){
        $id_user = $request->input('id_user');
        $id_method = $request->input('id_method');
        $id_group = $request->input('value');
        $group_mark =  $this ->take_decimal_number($this ->group_mark($id_method,$id_group,$id_user),3);
        $priotity_mark = $this ->take_decimal_number($this ->priotity_mark($id_user,$this ->group_mark($id_method,$id_group,$id_user)),3);
        $total_mark =  $this ->take_decimal_number($group_mark + $priotity_mark,2);
        $result = array(
                'group_mark' =>$group_mark,
                'priotity_mark'  => $priotity_mark,
                'total_mark'  => $total_mark,
        );
        return  $result;
    }


    public function save_wish_check(Request $request){
        $datas = $request->input('data');
        DB::beginTransaction();
        try{
            foreach ($datas as $key => $data) {
                $wish = DB::table('l_wish')
                ->where('id_user',$data[0])
                ->get();
                $check =  $wish[0]->id.'x'.$wish[0]->number.'x'.$wish[0]->id_method.'x'.$wish[0]->id_major.'x'.$wish[0]->id_group.'x'.$wish[0]->group_mark.'x'.$wish[0]->priority_mark.'x'.$wish[0]->mark;
                if($check != $data[9] ){
                    DB::table('l_wish')
                    ->where('id',$data[1])
                    ->update([
                        'number' => $data[2],
                        'id_method' => $data[3],
                        'id_major' => $data[4],
                        'id_group' => $data[5],
                        'group_mark' => $data[6],
                        'priority_mark' => $data[7],
                        'mark' => $data[8],
                        ]
                    );

                    $method = DB::table('l_method')
                    ->where('id', $data[3])
                    ->get();

                    $major = DB::table('l_method_major')
                    ->join('l_major','l_method_major.id_major','l_major.id')
                    ->where('l_method_major.id', $data[4])
                    ->get();

                    $group = DB::table('l_group')
                    ->where('id', $data[5])
                    ->get();

                    $user_agent = $_SERVER['HTTP_USER_AGENT'];
                    DB::table('l_history')
                    ->insert([
                        'id_student'    =>  $data[0],
                        'id_user'       =>  Auth::user()->id,
                        'name_history'  =>  "Kiểm tra hồ sơ",
                        'content'       =>  "Cập nhật: Thứ tự nguyện vọng: ".$data[2].", PT: ".$method[0]->name_method.", NV: ".$major[0] ->name_major.", TH: ".$group[0] ->id_group.", Điểm TH: ".$data[6].", Điểm UT: ".$data[7].", Điểm XT: ".$data[8],
                        'ip'            => request()->ip(),
                        'info_client'   => $user_agent
                    ]);
                }
            }
            DB::commit();
            echo 1;
        }catch ( Exception $e ){
            DB::rollBack();
            echo 0;
        }
    }

    function check_online($id){
        $check = DB::select('SELECT l_wish.id_user FROM l_go_batch_pass INNER JOIN l_wish ON l_wish.id = l_go_batch_pass.id_wish WHERE l_go_batch_pass.id_batch IN (SELECT l_year_active.id_batch_locao FROM l_year_active) AND pass_bo = 1 AND l_go_batch_pass.check_end = 1 AND l_wish.id_user = '.$id);
        if(count($check)>0){
            return 1;
        }else{
            return 0;
        }
    }
    //Khóa hồ sơ
    public function block_wish_check($id,$active){
        if($this->check_online($id) == 0){
            return 5;
        }else{
            $check_file = DB::select('SELECT l_file_list_student.id FROM `l_file_list_student` WHERE id_user = '.$id.' AND active = 1');
            if(count($check_file) >0){
                if($this ->check_pass($id) == 1){
                    $fail = 3;
                }else{
                    date_default_timezone_set("Asia/Ho_Chi_Minh");
                    if($active == 0){
                        DB::beginTransaction();
                        try{
                            DB::table('l_check_assuser')
                            ->where('id_student',$id)
                            ->update([
                                'check_user' =>3,
                                'check_at' => date("Y-m-d H:i:s")
                            ]);

                            $user_agent = $_SERVER['HTTP_USER_AGENT'];
                            DB::table('l_history')
                            ->insert([
                                'id_student'    =>  $id,
                                'id_user'       =>  Auth::user()->id,
                                'name_history'  =>  "Kiểm tra hồ sơ",
                                'content'       =>  "Cập nhật trạng thái hồ sơ: Khóa",
                                'ip'            => request()->ip(),
                                'info_client'   => $user_agent
                            ]);
                            DB::commit();
                            $fail = 0;
                        }catch(Exception $e){
                            $fail = 2;
                        }
                    }else{
                        DB::beginTransaction();
                        try{
                            DB::table('l_check_assuser')
                            ->where('id_student',$id)
                            ->update([
                                'check_user' =>1,
                                'check_at' => date("Y-m-d H:i:s")
                            ]);
                            $user_agent = $_SERVER['HTTP_USER_AGENT'];
                            DB::table('l_history')
                            ->insert([
                                'id_student'    =>  $id,
                                'id_user'       =>  Auth::user()->id,
                                'name_history'  =>  "Kiểm tra hồ sơ",
                                'content'       =>  "Cập nhật trạng thái hồ sơ: Mở khóa",
                                'ip'            => request()->ip(),
                                'info_client'   => $user_agent
                            ]);
                            DB::commit();
                            $fail = 1;
                        }catch(Exception $e){
                            $fail = 2;
                        }
                    }

                }
                return $fail;
            }else{
                return 4;
            }
        }
    }

    public function load_list_history($id){
        $his = DB::table('l_history')
        ->where('id_student',$id)
        ->leftJoin('users','l_history.id_user','users.id')
        ->orderBy('l_history.update_at', 'desc')
        ->get();
        $i = 1;
        foreach ($his as $key => $value) {
            $value ->stt = $i;
            $i++;
        }
        $json_data['data'] = $his;
        $data = json_encode($json_data);
        echo  $data;
    }


    public function faceback_check_user(Request $request){
        $id_student = $request ->input('id_student');
        $content = $request ->input('content');
        if($this ->check_block($id_student) == 1){
            return 3;
        }else{
            date_default_timezone_set("Asia/Ho_Chi_Minh");
            DB::beginTransaction();
            try{
                DB::table('l_check_assuser')
                ->where('id_student',$id_student)
                ->update([
                    'check_user' => 2,
                    'check_at' => date("Y-m-d H:i:s")
                ]);

                DB::table('l_block_wish')
                ->where('id_user',$id_student)
                ->update(
                    [
                    'id_block' => 0,
                    ]
                );

                $email = DB::table('l_users')
                ->where('id',$id_student)
                ->get();

                $name_student = DB::table('l_info_users')
                ->where('id_user',$id_student)
                ->get();

                $name_student1 = $name_student[0]->name_user;

                $maiable = new Check_user($name_student1,$content);
                Mail::to('ngphantu2004@gmail.com')->send($maiable);

                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                DB::table('l_history')
                ->insert([
                    'id_student'    =>  $id_student,
                    'id_user'       =>  Auth::user()->id,
                    'name_history'  =>  "Kiểm tra hồ sơ",
                    'content'       =>  "Gửi mail: ".$content,
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
    }


    public function calculator_check(Request $request){


        $id_student = $request ->input('id_student');
        $wishs = DB::table('l_wish')
        ->where('id_user',$id_student)
        ->get();
        if($this ->check_user_edit() == 0){
            return 4; //Check user được edit
        }else{
            if($this ->check_block($id_student) == 1){
                echo 2;
            }else{
                if(count($wishs) >0){
                    DB::beginTransaction();
                    try{
                        $wishs = DB::table('l_wish')
                        ->where('id_user',$request->input('id_student'))
                        ->get();
                        foreach ($wishs as $key => $wish) {
                            $id_user = $wish->id_user;
                            $id_method = $wish->id_method;
                            $id_major = $wish->id_major;
                            $group_mark_arr = $this ->total_mark($id_major,$id_method,$id_user)['group_mark'];
                            $group_mark =  $this ->take_decimal_number($group_mark_arr,3);
                            $priotity_mark_arr = $this ->total_mark($id_major,$id_method,$id_user)['priority_mark'];
                            $priotity_mark = $this ->take_decimal_number($priotity_mark_arr,3);
                            $total_mark_arr = $this ->total_mark($id_major,$id_method,$id_user)['mark'];
                            $total_mark = $this ->take_decimal_number($total_mark_arr,3);
                            $id_group = $this ->total_mark($id_major,$id_method,$id_user)['id'];
                            DB::table('l_wish')
                            ->where('id',$wish->id)
                            ->update([
                                'group_mark' => $group_mark,
                                'priority_mark' => $priotity_mark,
                                'mark' => $total_mark,
                                'id_group' => $id_group,
                            ]);
                        }

                        $name_student = DB::table('l_info_users')
                        ->where('id_user',$id_student)
                        ->get();

                        $name_student1 = $name_student[0]->name_user;

                        $user_agent = $_SERVER['HTTP_USER_AGENT'];
                        DB::table('l_history')
                        ->insert([
                            'id_student'    =>  $id_student,
                            'id_user'       =>  Auth::user()->id,
                            'name_history'  =>  "Tính lại điểm",
                            'content'       =>  "ID: ".$id_user." Thí sinh: ".$name_student1,
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
        }


    }

    public function check_user_load_list_file($id){
        // return $this ->check_year()['sus'];
        if($this ->check_year()['sus'] == 1){
            $list = DB::select('select if(USER.active is null OR USER.active = 0,0,1) as checked, `l_file_list`.`name_file` as `name_file`, `l_file_list`.`id` as `id`,`USER`.`active` as `active` from `l_file_list` left join (SELECT * FROM `l_file_list_student` WHERE  `l_file_list_student`.`id_user` = '.$id.') AS USER on `USER`.`id_file` = `l_file_list`.`id` WHERE id_year IN (SELECT id_year FROM l_year_active)  order by `stt` asc');
            return $list;
        }else{
            return 0;
        }
    }

    public function check_user_load_list_file_maphieu($id){
       $maphieu = DB::table('l_info_users')
       ->where('id_user',$id)
       ->get();
       $trungtuyen = DB::table('l_wish')
       ->join('l_go_batch_pass','l_go_batch_pass.id_wish','l_wish.id')
       ->where('l_wish.id_user',$id)
       ->where('l_go_batch_pass.id_batch',18)
       ->get();
       if(count($trungtuyen)>0){
            if($trungtuyen[0]->pass_bo == 1){
                $tt = "Trúng tuyển";
            }else{
                $tt = "Không đạt";
            }
            if($trungtuyen[0]->check_end == 1){
                $xn  = "Đã xác nhận";
            }else{
                $xn = "Chưa xác nhận";
            }
       }else{
            $tt = "Không có đăng ký trong đợt này";
            $xn = "";
       }

       $rasoat = DB::table('l_file_phieu')
       ->where('l_file_phieu.id_user',$id)
       ->get();

        if(count($rasoat) > 0){
                $rs = $rasoat[0]->maphieu;
        }else{
                $rs = "";
        }

        $xnnh = DB::table('l_go_xanhannhaphoc')
        ->where('l_go_xanhannhaphoc.id_user',$id)
        ->get();

        if(count($xnnh) > 0){
            $nhaphoc = "Đã xác nhận (".$xnnh[0]->update_at.")";
        }else{
            $nhaphoc = "";
        }

        $hssv = DB::table('l_file_list_student_hssv')
        ->where('id_user',$id)
        ->where('active',1)
        ->get();

        if(count($hssv) > 0){
            $hssv = "Đã thu";
        }else{
            $hssv = "";
        }

       $result = array(
            'maphieu' => $maphieu[0]->maphieu,
            'tt' => $tt,
            'xn' => $xn,
            'rs' => $rs,
            'nhaphoc' => $nhaphoc,
            'hssv' => $hssv,

       );



        return $result;


    }


    public function check_user_save_list_file(Request $request){
        $datas = $request ->input('data');
        if($this->check_block($datas[0][0]) == 0){
            if($this ->check_year()['sus'] == 1){
                $update = DB::table('l_file_list_student')
                ->where('id_user',$datas[0][0])
                ->get();
                if(count($update) > 0){
                    DB::beginTransaction();
                    try{
                        foreach ($datas as $key => $data) {
                            DB::table('l_file_list_student')
                                ->updateOrInsert(
                                [
                                    'id_user' => $data[0],
                                    'id_file' => $data[1],
                                ],
                                [
                                    'active' => $data[2],
                                    'id_admin_update' => Auth::user()->id,
                                ],
                            );

                            if($data[3] == 1){
                                if($data[2] == 1){
                                    $trangthai = "Thêm hồ sơ";
                                }else{
                                    $trangthai = "Xóa hồ sơ";
                                }
                                $name_file = DB::table('l_file_list')
                                ->where('id', $data[1])
                                ->get();

                                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                                DB::table('l_history')
                                ->insert([
                                    'id_student'    =>  $data[0],
                                    'id_user'       =>  Auth::user()->id,
                                    'name_history'  =>  "Thu hồ sơ tuyển sinh",
                                    'content'       =>  $trangthai.': '.$name_file[0]->name_file,
                                    'ip'            => request()->ip(),
                                    'info_client'   => $user_agent
                                ]);
                            }else{
                                continue;
                            }
                        }
                        DB::commit();
                        return 1;
                    }catch(Exception $e){
                        DB::rollBack();
                        return 0;
                    }
                }else{
                    DB::beginTransaction();
                    try{
                        foreach ($datas as $key => $data) {
                            DB::table('l_file_list_student')
                                ->updateOrInsert(
                                [
                                    'id_user' => $data[0],
                                    'id_file' => $data[1],
                                ],
                                [
                                    'active' => $data[2],
                                    'id_admin' => Auth::user()->id,
                                ],
                            );

                            if($data[3] == 1){
                                if($data[2] == 1){
                                    $trangthai = "Thêm hồ sơ";
                                }else{
                                    $trangthai = "Xóa hồ sơ";
                                }
                                $name_file = DB::table('l_file_list')
                                ->where('id', $data[1])
                                ->get();

                                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                                DB::table('l_history')
                                ->insert([
                                    'id_student'    =>  $data[0],
                                    'id_user'       =>  Auth::user()->id,
                                    'name_history'  =>  "Thu hồ sơ tuyển sinh",
                                    'content'       =>  $trangthai.': '.$name_file[0]->name_file,
                                    'ip'            => request()->ip(),
                                    'info_client'   => $user_agent
                                ]);
                            }else{
                                continue;
                            }
                        }
                        DB::commit();
                        return 1;
                    }catch(Exception $e){
                        DB::rollBack();
                        return 0;
                    }

                }
            }else{
                return 2;
            }
        }else{
            return 3;
        }
    }


    public function check_user_his_list_file($id){
        $his = DB::select("SELECT users.name, l_history.content,l_history.creat_at FROM `l_history` INNER JOIN users ON users.id = l_history.id_user WHERE l_history.id_student = ".$id." AND l_history.name_history = 'Thu hồ sơ tuyển sinh' ORDER BY l_history.update_at DESC");
        $i = 1;
        foreach ($his as $key => $value) {
            $value ->stt = $i;
            $i++;
        }
        $json_data['data'] = $his;
        $data = json_encode($json_data);
        echo  $data;
    }

    function check_chekend($id_student){
        $check = DB::select('SELECT check_user FROM l_check_assuser WHERE l_check_assuser.id_student = '.$id_student.' AND check_user = 3');
        if(count($check) >0){
            return 1; //Đã xacsd nhận tại Trường
        }else{
            return 0;
        }
    }

    public function check_user_phieu_list_file($id){
        if($this->check_chekend($id) == 1){
            $infor = DB::select("SELECT  if(l_info_users.sex_user = 1,'Nữ','Nam') as sex_user, l_info_users.id_user, l_info_users.name_user, DATE_FORMAT(l_info_users.birth_user,'%d/%m/%Y') as birth_user,  l_info_users.graduation_year_user, l_users.id_card_users, l_users.phone_users ,name_priority_area, if(l_policy_users.name_policy_user is null, '', l_policy_users.name_policy_user) as name_policy_user FROM l_info_users INNER JOIN l_users ON l_users.id = l_info_users.id_user INNER JOIN l_priority_area ON l_priority_area.id = l_info_users.id_priority_area_user LEFT JOIN l_policy_users_reg ON l_policy_users_reg.id_user = l_info_users.id_user LEFT JOIN l_policy_users ON l_policy_users.id = l_policy_users_reg.id_policy_users WHERE l_users.id = ".$id);
            $active_year = DB::table('l_year_active')
            ->join('l_years','l_year_active.id_year','l_years.id')
            ->get();

            if(count($active_year) == 1){
                    $subject_thpt = DB::table("l_year_subject")
                    ->select('l_subject.id as id', 'l_subject.name_subject as name_subject')
                    ->join('l_subject','l_subject.id','l_year_subject.id_subject')
                    ->where('l_subject.id_type_subject',3)
                    ->get();

                    $subject_hb = DB::table("l_year_subject")
                    ->select('l_subject.id as id', 'l_subject.name_subject as name_subject')
                    ->join('l_subject','l_subject.id','l_year_subject.id_subject')
                    ->where('l_subject.id_type_subject',1)
                    ->get();

                    $mark10 = DB::table('l_result')
                    ->select('l_result.id_subject as id', 'l_result.mark_result as mark')
                    ->where('id_semester_result',"CN")
                    ->where('id_class_result',10)
                    ->where('year_result',$active_year[0] ->id_year)
                    ->where('id_student_result',$id)->get();
                    $mark11 = DB::table('l_result')
                    ->select('l_result.id_subject as id', 'l_result.mark_result as mark')
                    ->where('id_semester_result',"CN")
                    ->where('id_class_result',11)
                    ->where('year_result',$active_year[0] ->id_year)
                    ->where('id_student_result',$id)->get();
                    $mark12 = DB::table('l_result')
                    ->select('l_result.id_subject as id', 'l_result.mark_result as mark')
                    ->where('id_semester_result',"CN")
                    ->where('id_class_result',12)
                    ->where('year_result',$active_year[0] ->id_year)
                    ->where('id_student_result',$id)->get();


                    $mark_12hk1 = DB::table('l_result')
                    ->select('l_result.id_subject as id', 'l_result.mark_result as mark')
                    ->where('id_semester_result','1')
                    ->where('id_class_result',12)
                    ->where('year_result',$active_year[0] ->id_year)
                    ->where('id_student_result',$id)->get();


                    $mark_thpt = DB::table('l_result')
                    ->select('l_result.id_subject as id', 'l_result.mark_result as mark')
                    ->where('id_semester_result','PT')
                    ->where('id_class_result',"TN")
                    ->where('year_result',$active_year[0] ->id_year)
                    ->where('id_student_result',$id)->get();

                    if(count($subject_hb) == count($mark10) && count($subject_hb) == count($mark11) && count($subject_hb) == count($mark12) && count($subject_hb) == count($mark_12hk1)){
                        $active_hb = 1;
                    }else{
                        $active_hb = 0;
                    }

                    if(count($subject_thpt) == count($mark_thpt) ){
                        $active_thpt = 1;
                    }else{
                        $active_thpt = 0;
                    }

                    $mar_nl = DB::table('l_result')
                    ->select('l_result.id_subject as id', 'l_result.mark_result as mark')
                    ->where('id_semester_result','NL')
                    ->where('id_class_result',"NL")
                    ->where('year_result',$active_year[0] ->id_year)
                    ->where('id_student_result',$id)->get();

                    if(count($mar_nl) >0){
                        $mark_nl = $mar_nl[0]->mark;
                    }else{
                        $mark_nl = 0;
                    }

                    $wish = DB::select("SELECT TT.pass_bo, if(TT.check_end = 1,'Đã xác nhận','Xác nhận') as check_end ,TT.id as id_search, if(TT.id_wish is null,0,1) as id_check, if(TT.pass_bo = 0  or TT.pass_bo is null, 'Trượt', 'Đỗ') as tt, INFO.* FROM (SELECT l_policy_users.name_policy_user, l_priority_area.id_priority_area, l_group.id_group as name_group, if(l_wish.tts = 1,'x','') as tts, l_wish.id_method as id_method_id ,priority_mark,group_mark,l_wish.id_batch as id_batch,l_wish.id_user,l_wish.mark,l_wish.number_bo, l_wish.id as id, l_wish.id_method as method, l_wish.id_major as id_major, l_major.name_major,l_method.id_method as id_method,l_method_major.min_mark, l_wish.id_group as id_group  FROM `l_wish` INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_method_major.id_major = l_major.id INNER JOIN l_batch_method ON l_batch_method.id = l_wish.id_method INNER JOIN l_method ON l_batch_method.id_method = l_method.id INNER JOIN l_group ON l_group.id = l_wish.id_group INNER JOIN l_info_users ON l_info_users.id_user = l_wish.id_user INNER JOIN l_priority_area ON l_priority_area.id = l_info_users.id_priority_area_user LEFT JOIN l_policy_users_reg ON l_policy_users_reg.id_user = l_wish.id_user LEFT JOIN l_policy_users ON l_policy_users.id = l_policy_users_reg.id_policy_users WHERE l_wish.id_user = ".$id.") AS INFO LEFT JOIN (SELECT * FROM l_go_batch_pass WHERE id_batch = 18) AS TT ON INFO.id = TT.id_wish");

                    $list = DB::select('select if(USER.active is null OR USER.active = 0,0,1) as checked, `l_file_list`.`name_file` as `name_file`, `l_file_list`.`id` as `id`,`USER`.`active` as `active` from `l_file_list` left join (SELECT * FROM `l_file_list_student` WHERE  `l_file_list_student`.`id_user` = '.$id.') AS USER on `USER`.`id_file` = `l_file_list`.`id` WHERE id_year IN (SELECT id_year FROM l_year_active)  order by `stt` asc');

                    $admin = DB::table('users')
                    ->where('id', Auth::user()->id)
                    ->get();

                    $total = DB::table('l_file_phieu')
                    ->orderBy('id',"DESC")
                    ->get();

                    if(count($total)>0){
                        $count = count($total);
                        $stt = 1+$count;
                    }else{
                        $count = 0;
                        $stt = 1;
                    }

                    $phandu =$count%150;
                    $phannguyen = ($count - $phandu)/150;
                    $box = $phannguyen + 1;
                    if($box <10){
                        $boxs = "0".$box;
                    }else{
                        $boxs = $box;
                    }


                    if($stt <10){
                        $stts = "000".$stt;
                    }else{
                        if($stt >=10 && $stt <=100 ){
                            $stts = "00".$stt;
                        }else{
                            if($stt >=10 && $stt <=100 ){
                                $stts = "0".$stt;
                            }else{
                                $stts = $stt;
                            }
                        }
                    }

                    $maphieu = $active_year[0] ->course.".H".$boxs.".".$stts;

                    $check = DB::table('l_file_phieu')
                    ->where('id_user', $id)
                    ->get();

                    if(count($check)>0){
                        DB::table('l_file_phieu')
                        ->where('id_user', $id)
                        ->update([
                            'id_admin' => Auth::user()->id,
                        ]);
                    }else{
                        DB::table('l_file_phieu')
                        ->insert([
                            'id_user' => $id,
                            'id_admin' => Auth::user()->id,
                            'box' =>  $box,
                            'id_year' => $active_year[0] ->id_year,
                            'maphieu' => $maphieu,
                        ]);

                    }

                    $user_agent = $_SERVER['HTTP_USER_AGENT'];
                    DB::table('l_history')
                    ->insert([
                        'id_student'    =>  $id,
                        'id_user'       =>  Auth::user()->id,
                        'name_history'  =>  "Thu hồ sơ tuyển sinh",
                        'content'       =>  "In phiếu: ".$maphieu.", Thí sinh: ".$infor[0]->name_user,
                        'ip'            => request()->ip(),
                        'info_client'   => $user_agent
                    ]);

                    $check1 = DB::table('l_file_phieu')
                    ->where('id_user', $id)
                    ->get()[0]->maphieu;
            }


            $data = [
                'active_hb' => $active_hb,
                'active_thpt' => $active_thpt,
                'id_user' =>$infor[0]->id_user,
                'name_user' =>$infor[0]->name_user,
                'birth_user' =>$infor[0]->birth_user,
                'graduation_year_user' =>$infor[0]->graduation_year_user,
                'id_card_users' =>$infor[0]->id_card_users,
                'name_priority_area' =>$infor[0]->name_priority_area,
                'phone_users' =>$infor[0]->phone_users,
                'name_policy_user' =>$infor[0]->name_policy_user,
                'sex_user' =>$infor[0]->sex_user,
                'sub_hb' =>$subject_hb,
                'mark_10' => $mark10,
                'mark_11' => $mark11,
                'mark_12' => $mark12,
                'mark_12hk1' => $mark_12hk1,
                'sub_thpt' =>$subject_thpt,
                'mark_thpt' => $mark_thpt,
                'mark_nl' => $mark_nl,
                'wish' =>  $wish,
                'file' => $list,
                'day' =>  Carbon::today()->day,
                'month' =>  Carbon::today()->month,
                'year' =>  Carbon::today()->year,
                'admin' => $admin[0]->name,
                'maphieu' => $check1,
                'check_block' => 1
            ];

            // return view('pdf.check_user_phieu_list_file',
            // [
            //     'data' => $data
            // ]);
            // return $data;

        }else{
            $data = [
                'check_block' => 0
            ];
        }
        $pdf = PDF::loadView('pdf.check_user_phieu_list_file',$data);
        return $pdf->stream('PhieuThuHoSoTuyenSinh.pdf');
    }


}//End Class
