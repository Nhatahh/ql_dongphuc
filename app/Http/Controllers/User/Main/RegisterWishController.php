<?php

namespace App\Http\Controllers\User\Main;

use App\Http\Controllers\Controller;
use Faker\Core\Number;
use Illuminate\Support\Facades\Storage;
use App\Mail\RegWish;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use PhpOption\Option;
use PhpParser\Node\Expr\FuncCall;

use function PHPUnit\Framework\countOf;
use Illuminate\Support\Facades\Mail;
class RegisterWishController extends Controller

{
    public function index(){
        return view('user.main.register_wish',
        [
            'title' => "CTUT|Hệ thống đăng ký xét tuyển",
        ]);
    }

    // function check_expenses($id){
    //     $check = DB::
    // }


    //DEl nguyên vọng

    public function block_user(){
        $block = DB::table('l_users')
        ->where('id',Auth::guard('user')->user()->id)
        ->get();

        if($block[0] ->block == 1){
            return 1;
        }else{
            return 0;
        }

    }




    public function del_wish($id){
        if($this ->check_expenses($id) == 1){
            return 0;
        }else{
            $del = DB::table('l_wish')
            ->where('id',$id)
            ->delete();
            return $del;
        }
    }

    /*Hàm lấy số lượng số chỉ định sau dấu phẩy trong PHP*/
    function take_decimal_number($num,$n){
        //num : số cần xử lý
        //n: số chữ số sau dấu phẩy cần lấy
        $base = 10**$n;
        $result = round($num * $base) / $base ;
        return $result;
    }

    //Load ngưỡng
    function loadmin_mark($id_major){
        $min_mark = DB::table('l_method_major')
        ->where('id',$id_major)
        ->get();
        return $min_mark[0]->min_mark;
    }


    //Kiểm tra ngưỡng đầu vào
    function checkmin_mark($id_major,$mark){
        if($mark >= $this->loadmin_mark($id_major)){
            return true;
        }else{
            return false;
        }
    }

    //Ràng buộc số nguyện vọng
    public function number_wish($id_batch){
        $number =  DB::table('l_batch')
        ->where('id',$id_batch)
        ->where('active_batch',1)
        ->get();
        return $number[0]->number_wish;
    }

    //Công thức tính ưu tiên học bạ (2023)
    function priority_area1($subject_mark){
        $priority = DB::table('l_info_users')
        ->join('l_priority_area','l_info_users.id_priority_area_user','l_priority_area.id')
        ->where('id_user',Auth::guard('user')->user()->id)
        ->get();
        if(count($priority)==1){
            if($priority[0]->graduation_year_user < getdate()['year']-1){
                $mark_priority = 0;
            }else{
                if($subject_mark <22.5){
                    $mark_priority = $priority[0]->mark_priority;
                }else{
                    $mark_priority = ((30 - $subject_mark)/7.5)*$priority[0]->mark_priority;
                }
            }
            $result = array(
                'mark_priority' => $mark_priority,
                'area' => $priority[0]->id_priority_area,
            );
        }else{
            $result = array(
                'mark_priority' => 0,
                'area' => '',
            );
        }
        return $result;
    }

    //Công thức tính ưu tiên đánh giá năng lực (2023)
    function priority_area2(){
        $priority = DB::table('l_info_users')
        ->join('l_priority_area','l_info_users.id_priority_area_user','l_priority_area.id')
        ->where('id_user',Auth::guard('user')->user()->id)
        ->get();
        if(count($priority)==1){
            if($priority[0]->graduation_year_user < getdate()['year']-1){
                $mark_priority = 0;
            }else{
                $mark_priority = $priority[0]->mark_priority;
            }
            $result = array(
                'mark_priority' => $mark_priority,
                'area' => $priority[0]->id_priority_area,
            );
        }else{
            $result = array(
                'mark_priority' => 0,
                'area' => '',
            );
        }
        return $result;
    }

    //Bộ điều khiển khu vực ưu tiên
    public function loadpriority_area($fun,$para){
        switch ($fun) {
            case 1:
                return $this->priority_area1($para);
                break;
            case 2:
            return $this->priority_area2();
                break;
            default:
                # code...
                break;
        }
    }


    //Ưu tiên đối tượng
    public function loadpriority_policy($mark){
        $policy = DB::table('l_policy_users_reg')
        ->join('l_info_users','l_policy_users_reg.id_user','l_info_users.id_user')
        ->join('l_policy_users','l_policy_users.id','l_policy_users_reg.id_policy_users')
        ->where('l_policy_users_reg.id_user',Auth::guard('user')->user()->id)
        ->get();
        if(count($policy)>0){
            if($mark < 22.5){
                $result = array(
                    'mark_priority' => $policy[0]->mark_policy_user,
                    'policy' => $policy[0]->name_policy_user,
                );
            }else{
                $result = array(
                    'mark_priority' => ((30 - $mark)/7.5)*$policy[0]->mark_policy_user,
                    'policy' => $policy[0]->name_policy_user,
                );
            }
        }else{
            $result = array(
                'mark_priority' => 0,
                'policy' => 'Không',
            );
        }

        return $result;
    }


        //Tính điểm từng tổ hợp phương thức 5 học kì 2023
    function mark_group1($id_group){
        $group_subjects = DB::table('l_group_subject')
        ->where('id_group',$id_group)
        ->get();
        $subject_mark = 0;
        foreach( $group_subjects as $group_subject){
            $results = DB::table('l_result')
            ->where([
            ['id_subject','=',  $group_subject->id_subject],
            ['id_student_result',Auth::guard('user')->user()->id],
            ['id_semester_result', '=', 1],
            ['id_class_result', '=', 10]
            ])
            ->orWhere([
            ['id_subject','=',  $group_subject->id_subject],
            ['id_student_result',Auth::guard('user')->user()->id],
            ['id_semester_result', '=', 1],
            ['id_class_result', '<=>', 11]
            ])
            ->orWhere([
            ['id_subject','=',  $group_subject->id_subject],
            ['id_student_result',Auth::guard('user')->user()->id],

            ['id_semester_result', '=', 1],
            ['id_class_result', '<=>', 12]
            ])
            ->orWhere([
            ['id_subject','=',  $group_subject->id_subject],
            ['id_student_result',Auth::guard('user')->user()->id],

            ['id_semester_result', '=', 2],
            ['id_class_result', '<=>', 10]
            ])
            ->orWhere([
            ['id_subject','=',  $group_subject->id_subject],
            ['id_student_result',Auth::guard('user')->user()->id],
            ['id_semester_result', '=', 2],
            ['id_class_result', '<=>', 11]
            ])
            ->sum('mark_result');
            $subject_mark = $subject_mark + $results/5;
        }
        return $subject_mark;
    }

    //Tính điểm từng tổ hợp phương thức cả năm 12 2023
    function mark_group2($id_group){
        $group_subjects = DB::table('l_group_subject')
        ->where('id_group',$id_group)
        ->get();
        $i = 0;
        $subject_mark = 0;
        foreach( $group_subjects as $group_subject){
            $result = DB::table('l_result')
            ->where([
            ['id_subject','=',  $group_subject->id_subject],
            ['id_student_result',Auth::guard('user')->user()->id],
            ['id_semester_result', '=', 'PT'],
            ['id_class_result', '=', 'TN'],
            ['mark_result', '>', 0]
            ])
            ->get();
            if(count($result) == 1){
                $i++;
            }
        }

        if($i==3){
            foreach( $group_subjects as $group_subject){
                $results = DB::table('l_result')
                ->where([
                ['id_subject','=',  $group_subject->id_subject],
                ['id_student_result',Auth::guard('user')->user()->id],
                ['id_semester_result', '=', 'PT'],
                ['id_class_result', '=', 'TN'],
                ['mark_result', '>', 0]
                ])
                ->sum('mark_result');
                $i++;
                $subject_mark = $subject_mark + $results;
            }
            return  $subject_mark;
        }else{
            return  0;
        }
    }

    //Tính điểm phương thức DGNL 2023
    function mark_group3($id_group){
        $subject_mark = DB::table('l_group_subject')
        ->join('l_subject','l_group_subject.id_subject','l_subject.id')
        ->join('l_result','l_result.id_subject','l_subject.id')
        ->where('id_group',$id_group)
        ->where('id_student_result',Auth::guard('user')->user()->id)
        ->sum('mark_result');
        return $subject_mark;
    }


    //Bộ điều khiển phương thức xet tuyển
    function mark_group($method,$id_group){
        switch ($method) {
            case 1:
                return $this->mark_group1($id_group);
                break;
            case 2:
                return $this->mark_group2($id_group);
                break;
            case 3:
                return $this->mark_group3($id_group);
                break;
            default:
                // chuỗi câu lệnh
                break;
        }
    }

    public function priority(){
        $html = '<div class="card-header" style="text-align: center;padding: 0;margin-left: 10px;font-weight: bold;">Khu vực, đối tượng ưu tiên</div>
        <div class="card-body" style="padding-top: 5px;margin-bottom: 7px">
            <div class="row">
                <div class="col-12 col-md-12">
                    <span >Khu vực ưu tiên:&nbsp;</span><strong style="color: red">'.$this->loadpriority_area(1,0)['area'].'</strong></span>
                </div>
                <div class="col-12 col-md-12">
                    <span >Đối tượng ưu tiên:&nbsp;</span><strong style="color: red">'.$this->loadpriority_policy(1)['policy'].'</span>
                </div>
            </div>
        </div>';
        return $html;
    }


   //Load gợi ý Phương thức học bạ 2023
    function loadsuggest_group_method1(){
        $groups = DB::table('l_major_group')
        ->select('l_group.id as id','l_group.id_group as name')
        ->join('l_method_major','l_major_group.id_major','l_method_major.id')
        ->join('l_batch_method','l_batch_method.id','l_batch_method.id_method')
        ->join('l_group','l_group.id','l_major_group.id_gruop')
        ->where([
            ['id_batch',1],
            ['l_method_major.id_method',1],
            ])
        ->orWhere([
            ['id_batch',1],
            ['l_method_major.id_method',2],
            ])
        ->groupBy('l_group.id')
        ->get();
        $result_groups = [];
        foreach($groups as $group){
            $subject_mark = $this->mark_group(1,$group->id);
            $result_groups[] = array(
                'name' => $group ->name,
                'id' => $group ->id,
                'mark' => $this->take_decimal_number($this->loadpriority_area(1,$subject_mark)['mark_priority'] + $subject_mark + $this->loadpriority_policy($subject_mark)['mark_priority'],3),
                'mark_priority_area' => $this ->take_decimal_number($this->loadpriority_area(1,$subject_mark)['mark_priority']+ $this->loadpriority_policy($subject_mark)['mark_priority'],3)
            );
        }
        if(count($result_groups) == 0){
        return $html = "";
        }else{
            $html = '<div class="card-header" style="text-align: center;padding: 0;margin-left: 10px;font-weight: bold;">Tham khảo phương thức HB1</div>
                <div class="card-body" style="padding-top: 5px;margin-bottom: 7px">
                    <div class="row">';
                        $html .= '<div class = "col-12 col-md-12"><span>Tổng điểm ưu tiên:</span></div> ';
                        for($i = 0;$i<count($result_groups);$i++){
                            $html .= '<div class="col-3" style="margin-bottom: -10px;">
                                <div class="input-group mb-3" style = "margin-bottom: 0">
                                    <div class="input-group-prepend">
                                        <span>'.$result_groups[$i]['name'].':&nbsp;&nbsp;&nbsp</span>
                                    </div>
                                    <span>'.$result_groups[$i]['mark_priority_area'].'</i></span>
                                </div>
                            </div>';
                        }
                        $html .= '<div class = "col-12 col-md-12"><span>Điểm xét tuyển:</span></div> ';
                        for($i = 0;$i<count($result_groups);$i++){
                            $html .= '<div class="col-3" style="margin-bottom: -10px;">
                                <div class="input-group mb-3" style = "margin-bottom: 0">
                                    <div class="input-group-prepend">
                                        <span>'.$result_groups[$i]['name'].':&nbsp;&nbsp;&nbsp</span>
                                    </div>
                                    <span>'.$result_groups[$i]['mark'].'</i></span>
                                </div>
                            </div>';
                        }
                        $html .= '</div>
                </div>';
            return $html;
        }
    }

    function loadsuggest_group_method2(){
        $groups = DB::table('l_major_group')
        ->select('l_group.id as id','l_group.id_group as name')
        ->join('l_method_major','l_major_group.id_major','l_method_major.id')
        ->join('l_batch_method','l_batch_method.id','l_batch_method.id_method')
        ->join('l_group','l_group.id','l_major_group.id_gruop')
        ->where([
            ['id_batch',1],
            ['l_method_major.id_method',1],
            ])
        ->orWhere([
            ['id_batch',1],
            ['l_method_major.id_method',2],
            ])
        ->groupBy('l_group.id')
        ->get();
        $result_groups = [];
        foreach($groups as $group){
            $subject_mark = $this->mark_group(2,$group->id);
            $result_groups[] = array(
                'name' => $group ->name,
                'id' => $group ->id,
                'mark' => $this->take_decimal_number($this->loadpriority_area(1,$subject_mark)['mark_priority'] + $subject_mark + $this->loadpriority_policy($subject_mark)['mark_priority'],3),
                'mark_priority_area' => $this ->take_decimal_number($this->loadpriority_area(1,$subject_mark)['mark_priority']+ $this->loadpriority_policy($subject_mark)['mark_priority'],3)
            );
        }
        if(count($result_groups) == 0){
        return $html = "";
        }else{
            $html = '<div class="card-header" style="text-align: center;padding: 0;margin-left: 10px;font-weight: bold;">Tham khảo phương thức HB2</div>
                <div class="card-body" style="padding-top: 5px;margin-bottom: 7px">
                    <div class="row">';
                        $html .= '<div class = "col-12 col-md-12"><span>Tổng điểm ưu tiên:</span></div> ';
                        for($i = 0;$i<count($result_groups);$i++){
                            $html .= '<div class="col-3" style="margin-bottom: -10px;">
                                <div class="input-group mb-3" style = "margin-bottom: 0">
                                    <div class="input-group-prepend">
                                        <span>'.$result_groups[$i]['name'].':&nbsp;&nbsp;&nbsp</span>
                                    </div>
                                    <span>'.$result_groups[$i]['mark_priority_area'].'</i></span>
                                </div>
                            </div>';
                        }
                        $html .= '<div class = "col-12 col-md-12"><span>Điểm xét tuyển:</span></div> ';
                        for($i = 0;$i<count($result_groups);$i++){
                            $html .= '<div class="col-3" style="margin-bottom: -10px;">
                                <div class="input-group mb-3" style = "margin-bottom: 0">
                                    <div class="input-group-prepend">
                                        <span>'.$result_groups[$i]['name'].':&nbsp;&nbsp;&nbsp</span>
                                    </div>
                                    <span>'.$result_groups[$i]['mark'].'</i></span>
                                </div>
                            </div>';
                        }
                        $html .= '</div>
                </div>';

            return $html;
        }
    }

    //Load gợi ý Phương thức DGNL 2023
    function loadsuggest_group_methodnl(){
        $html = '<div class="card-header" style="text-align: center;padding: 0;margin-left: 10px;font-weight: bold;">Tham khảo phương thức 402</div>
        <div class="card-body" style="padding-top: 5px;margin-bottom: 7px">
            <div class="row">
                <div class = "col-12 col-md-6">
                    <div class="input-group mb-3" style = "margin-bottom: 0">
                        <div class="input-group-prepend">
                            <span>Tổng điểm ưu tiên:&nbsp;&nbsp;&nbsp</span>
                        </div>
                        <span>'.$this->take_decimal_number($this->loadpriority_area(2,0)['mark_priority'] + $this->loadpriority_policy(1)['mark_priority'],3).'</i></span>
                    </div>
                </div>
                <div class = "col-12 col-md-6">
                    <div class="input-group mb-3" style = "margin-bottom: 0">
                        <div class="input-group-prepend">
                            <span>Điểm xét tuyển:&nbsp;&nbsp;&nbsp</span>
                        </div>
                        <span>'.$this->take_decimal_number($this->mark_group(3,13) + $this->loadpriority_area(2,0)['mark_priority'] + $this->loadpriority_policy(1)['mark_priority'],3).'</i></span>
                    </div>
                </div>
            </div>
        </div>
        </div>';
        return $html;
    }
    //LOAD Gợi ý điểmt tổ hợp
    public function loadsuggest_group(){
        $loadsuggest_group = array(
            'methodhb1' => $this ->loadsuggest_group_method1(),
            'methodhb2' => $this ->loadsuggest_group_method2(),
            'methodnl' => $this ->loadsuggest_group_methodnl(),
            'priority' => $this ->priority()
        );
        return $loadsuggest_group;
    }


    //Load nguyện vọng
    public function load_wish(){
        $wishs = DB::table('l_wish')
        ->select('id_method','number','id_major','id_group','id')
        ->where([
            'id_user' => Auth::guard('user')->user()->id,
            'id_batch' => $this ->active_batch()['batch'],
            'id_year' => 2023,
        ])
        ->orderBy('l_wish.number','asc')->get();

        if($this ->check_reg() == 1){
            $check_reg = 1;
        }else{
            $check_reg = 0;
        }

        if(count($wishs) > 0){
            $html = '';
            foreach ($wishs as $wish) {
                // Phương thức
                $methods = DB::table('l_batch_method')
                ->join('l_method','l_method.id','l_batch_method.id_method')
                ->select('l_batch_method.id as id','l_method.name_method as text')
                ->where('id_batch',1)
                ->get();
                foreach ($methods as $method) {
                    if($method->id == $wish->id_method){
                        $method ->selected = true;
                    }else{
                        $method ->selected = false;
                    }
                }

                //Ngành

                $majors = DB::table('l_method_major')
                ->select('l_method_major.id as id','l_major.name_major as text')
                ->join('l_batch_method','l_batch_method.id','l_method_major.id_method')
                ->join('l_major','l_major.id','l_method_major.id_major')
                ->where([
                        ['id_batch',1],
                        ['l_batch_method.id',$wish->id_method],
                    ])
                ->get();
                foreach ($majors as $major) {
                    if($major->id == $wish->id_major){
                        $major ->selected = true;
                    }else{
                        $major ->selected = false;
                    }
                }

                $groups = DB::table('l_major_group')
                ->select('l_group.id as id',DB::raw("CONCAT(l_group.id_group,'-',l_group.name_group) as text"))
                ->join('l_group','l_group.id','l_major_group.id_gruop')
                ->where([
                    ['l_major_group.id_major',$wish->id_major],
                ])
                ->get();

                foreach ( $groups as $group) {
                    if($group->id == $wish->id_group){
                        $group ->selected = true;
                    }else{
                        $group ->selected = false;
                    }
                }
                $mark_group_wish = $this->mark_group($wish->id_method,$wish->id_group);
                if($wish->id_method == 3){
                    $mark_prio = $this-> loadpriority_area(2,0)['mark_priority'] + $this->loadpriority_policy(1)['mark_priority'];
                }else{
                    $mark_prio = $this-> loadpriority_area(1,$mark_group_wish)['mark_priority'] + $this->loadpriority_policy($mark_group_wish)['mark_priority'];
                }
                $mark =  $mark_group_wish + $mark_prio;

                $min_major = DB::table('l_method_major')
                ->select('min_mark')
                ->where('id',$wish->id_major)
                ->get();

                $data = array(
                    'method' => $methods,
                    'major' => $majors,
                    'group' => $groups,
                    'mark' => $this->take_decimal_number($mark,2),
                    'mark_group_wish' => $this->take_decimal_number($mark_group_wish,3),
                    'number' => $wish->number,
                    'mark_prio' => $this->take_decimal_number($mark_prio,2)
                );

                $datas[]=  $data;
                unset($data);

                $html .= '<div id="remove_wish'.$wish->number.'"   id-data ="'.$wish->number.'">
                <div class="row save_wish" id="'.$wish->id.'" id_year ="2023" id_batch = "1" id_major="'.$wish->id_major.'"  id-data ="'.$wish->number.'" >
                <div class="col-md-2 col-sm-4 col-12">
                    <div class="form-group row" style="margin-bottom: 3px">
                        <label for="inputEmail3" class="col-sm-6 col-form-label" style="padding-bottom: 0px;"><i class="fa fa-trash del_wish" onclick="del_wish('.$wish->id.','.$wish->number.')" id-data ="'.$wish->number.'" id_del = "'.$wish->id.'" style="color: red" id="del_wish'.$wish->number.'"></i>&nbsp;&nbspThứ tự:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control  number_wish" id-data ="'.$wish->number.'" id = "number_wish" number = '.$wish->number.' style="height:30px;" value = "'.$wish->number.'">

                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-8 col-12">
                    <div class="form-group row" style="margin-bottom: 3px">
                        <label for="inputEmail3" class="col-sm-3 col-form-label" style="padding-bottom: 0px ">Phương thức:</label>
                        <div class="col-sm-9" >
                            <select  class="select_wish method_wish" id_method="'.$wish->id_method.'" id-data ="'.$wish->number.'" id = "method_wish'.$wish->number.'" style="width: 100%;">

                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-12">
                    <div class="form-group row" style="margin-bottom: 3px">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="padding-bottom: 0px ">Ngành:</label>
                        <div class="col-sm-10">
                            <select class="select_wish major_wish"  id_major="'.$wish->id_major.'"  id-data ="'.$wish->number.'" id = "major_wish'.$wish->number.'"  style="width: 100%;">

                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6 col-12">
                    <div class="form-group row" style="margin-bottom: 3px">
                        <label for="inputEmail3" class="col-sm-6 col-form-label" style="padding-bottom: 0px;" >Ngưỡng:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control min_wish" id = "min_wish'.$wish->number.'" id-data ="'.$wish->number.'" style="height:30px;background-color: inherit;" disabled value = "'.$min_major[0]->min_mark.'">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group row" style="margin-bottom: 3px">
                        <label for="inputEmail3" class="col-sm-3 col-form-label" style="padding-bottom: 0px ">Tổ hợp:</sup></label>
                        <div class="col-sm-9">
                            <select class="select_wish group_wish"  id_group ="'.$wish->id_group.'" id-data ="'.$wish->number.'" id = "group_wish'.$wish->number.'"   style="width: 100%;">

                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6 col-12">
                    <div class="form-group row" style="margin-bottom: 3px">
                        <label for="inputEmail3" class="col-sm-6 col-form-label" style="padding-bottom: 0px;">Điểm tổ hợp:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control mark_group_wish" id = "mark_group_wish'.$wish->number.'" id-data ="'.$wish->number.'" style="height:30px;background-color: inherit;" disabled value = "'.$mark_group_wish.'">
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6 col-12">
                    <div class="form-group row" style="margin-bottom: 3px">
                        <label for="inputEmail3" class="col-sm-6 col-form-label" style="padding-bottom: 0px;" >Điểm ưu tiên:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control area_mark_check" id = "prio_wish'.$wish->number.'" id-data ="'.$wish->number.'" style="height:30px;background-color: inherit;" disabled value = "'.$this->take_decimal_number($mark_prio,3).'">
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6 col-12">
                    <div class="form-group row" style="margin-bottom: 3px">
                        <label for="inputEmail3" class="col-sm-5 col-form-label" style="padding-bottom: 0px" >Tổng điểm:</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control mark_wish" id = "mark_wish'.$wish->number.'" id-data ="'.$wish->number.'" style="height:30px;background-color: inherit;" disabled value = "'.$this ->take_decimal_number($mark,2).'">
                        </div>
                    </div>
                </div>

                </div>
                <div class="card-header" style="padding: 0;margin-left: 10px;margin-bottom: 3px;"></div>
                </div>
                ';



            }
        }else{
            $datas =[];
            $html = '';
        }

        $total = array(
            'datas' => $datas,
            'html'  => $html,
            'check_reg'=> $check_reg,
        );
        return  $total;
    }



    public function active_batch(){
        $batch = DB::table('l_years_open_batch_reg')
        ->get();
        if(count($batch)>0){
            if(count($batch) == 1){
                $active = 0; //Cho đăng ký
                $note = $batch[0]->note;
                $batch_ac =  $batch[0]->id_batch;
                $reg =  $batch[0]->reg;
            }
            if(count($batch) > 1){
                $active = 2; //Setup nhiều đợt
                $note ='Hệ thống đang bảo trì, vui lòng liên hệ 02923.898167';
                $batch_ac =0;
                $reg =  0;
            }
        }else{
            $active = 1; //Khóa tất cả đợt
            $note = 'Hệ thống đang khóa, chưa có đợt xét tuyển tiếp theo';
            $batch_ac = 0;
            $reg = 0;
        }
        $res = array(
            'active' => $active,
            'note' => $note,
            'batch' => $batch_ac,
            'reg' => $reg,
        );
        return $res;
    }
    //Save nguyện vọng

    public function save_wish(Request $request){
        $data = $request->input('data');
        $dem = 0;
        foreach ($data  as $key => $value) {
            $ins = DB::table('l_wish')
            ->updateOrInsert(
            [
                'id'            => $value[0],
                'id_user'       =>Auth::guard('user')->user()->id
            ],
            [
                'id_year'       => $value[1],
                'id_batch'      => $this ->active_batch()['batch'],
                'number'        => $value[3],
                'id_method'     => $value[4],
                'id_major'      => $value[5],
                'id_group'      => $value[6],
                'mark'          => (float)$value[7],
                'priority_mark' => (float)$value[8],
                'group_mark'    => (float)$value[9],
            ]);
            $dem = $dem  + $ins;
        }
        return $dem;
    }


    //Thêm nguyên vọng
    public function add_wish($id){
        if($this->check_reg() == 1){
            return "check_false";
        }else{
            if($id >= $this-> number_wish(1)){
                return 'number_wish_false';
            }else{
                $star_method = new Collection(
                    [
                        'id' => 0,
                        'text' => 'Chọn Phương thức xét tuyển',
                        'selected' => true
                    ]
                );

                    $number = 1000+$id;
                    $html = '';
                    $methods = DB::table('l_batch_method')
                    ->join('l_method','l_method.id','l_batch_method.id_method')
                    ->select('l_batch_method.id as id','l_method.name_method as text')
                    ->where('id_batch',1)
                    ->get();
                    $methods[] = $star_method;

                    $data = array(
                        'method' => $methods,
                        'number' => $number,
                    );
                    $datas[]=  $data;
                    unset($data);

                    $html .= '   <div id="remove_wish'.$number.'"   id-data ="'.$number.'">
                    <div class="row save_wish" id="0" id_year ="2023" id_batch = "1">
                    <div class="col-md-2 col-sm-4 col-12">
                        <div class="form-group row" style="margin-bottom: 3px">
                            <label for="inputEmail3" class="col-sm-6 col-form-label" style="padding-bottom: 0px;"><i class="fa fa-trash " onclick="del_wish(0,'.$number.')" style="color: red" id="del_wish"></i>&nbsp;&nbspThứ tự:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control  number_wish" id = "number_wish" style="height:30px;" value = "">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-8 col-12">
                        <div class="form-group row" style="margin-bottom: 3px">
                            <label for="inputEmail3" class="col-sm-3 col-form-label" style="padding-bottom: 0px ">Phương thức:</label>
                            <div class="col-sm-9" >
                                <select  class="select_wish method_wish" id-data = "'.$number.'" id = "method_wish'.$number.'" style="width: 100%;">

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12 col-12">
                        <div class="form-group row" style="margin-bottom: 3px">
                            <label for="inputEmail3" class="col-sm-2 col-form-label" style="padding-bottom: 0px ">Ngành:</label>
                            <div class="col-sm-10">
                                <select class="select_wish major_wish" id-data = "'.$number.'" id = "major_wish'.$number.'"  style="width: 100%;">

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6 col-12">
                        <div class="form-group row" style="margin-bottom: 3px">
                            <label for="inputEmail3" class="col-sm-6 col-form-label" style="padding-bottom: 0px;" >Ngưỡng:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control min_wish" id-data = "'.$number.'" id = "min_wish'.$number.'"  style="height:30px;background-color: inherit;" disabled value = "">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="form-group row" style="margin-bottom: 3px">
                            <label for="inputEmail3" class="col-sm-3 col-form-label" style="padding-bottom: 0px ">Tổ hợp:</sup></label>
                            <div class="col-sm-9">
                                <select class="select_wish group_wish"  id-data = "'.$number.'" id = "group_wish'.$number.'"  style="width: 100%;">

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6 col-12">
                        <div class="form-group row" style="margin-bottom: 3px">
                            <label for="inputEmail3" class="col-sm-6 col-form-label" style="padding-bottom: 0px;">Điểm tổ hợp:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control mark_group_wish" id = "mark_group_wish'.$number.'" id-data ="'.$number.'" style="height:30px;background-color: inherit;" disabled value = "">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6 col-12">
                        <div class="form-group row" style="margin-bottom: 3px">
                            <label for="inputEmail3" class="col-sm-6 col-form-label" style="padding-bottom: 0px;" >Điểm ưu tiên:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control area_mark_check" id = "prio_wish'.$number.'" id-data ="'.$number.'" style="height:30px;background-color: inherit;" disabled value = "">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6 col-12">
                        <div class="form-group row" style="margin-bottom: 3px">
                            <label for="inputEmail3" class="col-sm-5 col-form-label" style="padding-bottom: 0px" >Tổng điểm: </label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control mark_wish" id-data = "'.$number.'"  id = "mark_wish'.$number.'" style="height:30px;background-color: inherit;" disabled value = "">
                            </div>
                        </div>
                    </div>
                </div> <div class="card-header" style="padding: 0;margin-left: 10px;margin-bottom: 3px;"></div>
                </div>';

                $total = array(
                    'datas' => $datas,
                    'html'  => $html,
                    'number' => $number,

                );
                return  $total;
            }
        }

    }

    //Chage phương thức
    public function change_method(Request $request){
        $star_major= new Collection(
            [
                'id' => 0,
                'text' => 'Chọn Ngành xét tuyển',
                'selected' => true
            ]
        );

        $majors = DB::table('l_method_major')
        ->select('l_method_major.id as id','l_major.name_major as text')
        ->join('l_batch_method','l_batch_method.id','l_method_major.id_method')
        ->join('l_major','l_major.id','l_method_major.id_major')
        ->where([
                ['id_batch',1],
                ['l_batch_method.id',$request->input('id_method')],
            ])
        ->get();

        $majors[]=$star_major;

        $result = array(
            'data' => $majors,
            'dom'=> $request->input('dom'),

        );
        return  $result;
    }

    //Change Ngành
    public function change_major(Request $request){
        $star_group= new Collection(
            [
                'id' => 0,
                'text' => 'Chọn Tổ hợp xét tuyển',
                'selected' => true
            ]
        );

        $groups = DB::table('l_major_group')
        ->select('l_group.id as id',DB::raw("CONCAT(l_group.id_group,'-',l_group.name_group) as text"))
        ->join('l_group','l_group.id','l_major_group.id_gruop')
        ->where([
            ['l_major_group.id_major',$request->input('id_major')],
        ])
        ->get();
        $groups[]=$star_group;
        $result = array(
            'data' => $groups,
            'dom'=> $request->input('dom'),
            'min_mark' => $this->loadmin_mark($request->input('id_major'))
        );
        return  $result;
    }

    //Chage Tổ hợp
    public function change_group(Request $request){
        $mark_group = $this->mark_group($request->input('id_method'),$request->input('id_group'));
        if($request->input('id_method') == 3){
            $result = array(
                'data' => $this->take_decimal_number($mark_group + $this->loadpriority_area(2,0)['mark_priority'] + $this->loadpriority_policy(0)['mark_priority'],2),
                'dom' => $request->input('dom'),
                'mark_group' => $this->take_decimal_number($mark_group,2),
                'mark_prio' => $this->take_decimal_number($this->loadpriority_area(2,0)['mark_priority'] + $this->loadpriority_policy(0)['mark_priority'],3),
            );
        }else{
            $result = array(
                'data' => $this->take_decimal_number($mark_group + $this->loadpriority_area(1,$mark_group)['mark_priority'] + $this->loadpriority_policy($mark_group)['mark_priority'],2),
                'dom' => $request->input('dom'),
                'mark_group' => $this->take_decimal_number($mark_group,2),
                'mark_prio' => $this->take_decimal_number($this->loadpriority_area(1,$mark_group)['mark_priority'] + $this->loadpriority_policy($mark_group)['mark_priority'],3),
            );
        }
        return  $result;
    }

    //Check đăng ký xét tuyển
    public function check_reg(){
        $chec_reg =  DB::table('l_block_wish')
        ->where('id_user',Auth::guard('user')->user()->id)
        // ->where('id_batch',1)
        // ->where('id_block',1)
        ->get();
        if(count($chec_reg) == 1){
            if($chec_reg[0]->id_block == 1){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }

    }

    public function check_reg_first(){
        $chec_reg =  DB::table('l_block_wish')
        ->where('id_user',Auth::guard('user')->user()->id)
        ->get();
        if(count($chec_reg) == 1){
            return 1;
        }else{
            return 0;
        }
    }

    //Check đăng ký xét tuyển
    public function check_expenses($id){
        $chec =  DB::table('l_expenses')
        ->where('id_user',Auth::guard('user')->user()->id)
        ->where('id_wish',$id)
        ->get();
        if(count($chec) > 0){
            return 1;
        }else{
            return 0;
        }
    }

    public function check_khop(Request $request){
        $data = $request->input('data');
        $wishlength = DB::table('l_wish')
        ->where([
            ['id_user','=',Auth::guard('user')->user()->id],
            ['id_year','=', 2023],
            ['id_batch','=',$this ->active_batch()['batch']]
            ])
        ->get();
        $lengt = count($wishlength );
        $dem = 0;
        $dot = 0;
        foreach ($data  as $key => $value) {
            $wish = DB::table('l_wish')
            ->where([
                ['id','=',$value[0]],
                ['id_user','=',Auth::guard('user')->user()->id],
                ['id_year','=', $value[1]],
                ['id_batch','=',$this ->active_batch()['batch']],
                ['number','=',$value[3]],
                ['id_method' ,'=',$value[4]],
                ['id_major' ,'=',$value[5]],
                ['id_group' ,'=',$value[6]],
            ])
            ->get();
            if(count($wish) == 1){
                $dem = $dem + 1;
            }
            $dot = $dot +1;
        }
        // return $dem;
        if($dem == $lengt && $dem == $dot){
            return 1;
        }else{
            return 0;
        }
    }


    // Đăng ký xét tuyển
    public function reg_wish(){
        $check_info = DB::table('l_info_users')
        ->where('id_user',Auth::guard('user')->user()->id)
        ->get();

        if(count($check_info) == 1){
            // DB::beginTransaction();
            // try{
                if($this ->check_reg_first() == 0){
                    DB::table('l_block_wish')
                    ->insert([
                    [
                        'id_user' => Auth::guard('user')->user()->id,
                        'id_block' => 1,
                        'id_batch' => $this ->active_batch()['batch'],
                    ]
                    ]);
                    $reg = 1;
                }else{
                    if($this ->check_reg() == 1){
                       return "check_false";
                    }else{
                        DB::table('l_block_wish')
                        ->where( 'id_user', Auth::guard('user')->user()->id)
                        ->update([
                            'id_block' => 1,
                        ]);
                        $feedback = DB::table('l_check_assuser')
                        ->where('id_student',Auth::guard('user')->user()->id)
                        ->get();
                        if(count($feedback) == 1){
                            DB::table('l_check_assuser')
                            ->where('id_student',Auth::guard('user')->user()->id)
                            ->update([
                                'check_user' => 4,
                                'pass' => 0,
                            ]);
                        }
                    }
                    $reg = 1;
                }

                if($reg == 1){
                    $name_student = DB::table('l_info_users')
                    ->where('id_user',Auth::guard('user')->user()->id)
                    ->get();

                    // $name = DB::table('users')
                    // ->where('id',$value[1])
                    // ->get();

                    $user_agent = $_SERVER['HTTP_USER_AGENT'];
                    DB::table('l_history')
                    ->insert([
                        'id_student'    =>  Auth::guard('user')->user()->id,
                        'id_user'       =>  Auth::guard('user')->user()->id,
                        'name_history'  =>  "Đăng ký xét tuyển ",
                        'content'       =>  $name_student[0]->name_user. ' đăng ký xét tuyển',
                        'ip'            =>  request()->ip(),
                        'info_client'   =>  $user_agent
                    ]);

                    $major = DB::table('l_wish')
                    ->select('name_method','expenses','l_major.id_major as id_major','l_major.name_major as name_major','l_wish.id as id','l_wish.update_at as time','l_wish.number as number' )
                    ->join('l_method_major','l_method_major.id','l_wish.id_major')
                    ->join('l_major','l_method_major.id_major','l_major.id')
                    ->join('l_method','l_method.id','l_method_major.id_method')
                    ->leftJoin('l_expenses','l_expenses.id_wish','l_wish.id')
                    ->where('l_wish.id_user',Auth::guard('user')->user()->id)
                    ->orderBy('l_wish.number','asc')
                    ->get();
                    $email = DB::table('l_users')
                    ->where('id',Auth::guard('user')->user()->id)
                    ->get();
                    $email = $email[0]->email_users;
                    $maiable = new RegWish($major);
                    Mail::to($email)->send($maiable);
                }
            //     DB::commit();
            //     return 1;
            // }catch(Exception $e){
            //     DB::rollBack();
            //     return 0;
            // }
        }else{
            return 'check_false_info';
        }
    }

    public function edit_wish_sc(){
        DB::beginTransaction();
        try{
            if($this ->check_reg()){
                DB::table('l_block_wish')
                ->where('id_user',Auth::guard('user')->user()->id)
                ->update([
                    'id_block' => 0,
                ]);
            }
            $check = DB::table('l_check_assuser')
            ->where('id_student',Auth::guard('user')->user()->id)
            ->get();
            if(count($check) == 1){
                date_default_timezone_set("Asia/Ho_Chi_Minh");
                DB::table('l_check_assuser')
                ->where('id_student',Auth::guard('user')->user()->id)
                ->update([
                    'check_user' => 5,
                    'check_at' => date("Y-m-d H:i:s"),
                    'pass' => 0,
                    'pass_at' => date("Y-m-d H:i:s")
                ]);
            }
            $name_student = DB::table('l_info_users')
            ->where('id_user',Auth::guard('user')->user()->id)
            ->get();
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            DB::table('l_history')
            ->insert([
                'id_student'    =>  Auth::guard('user')->user()->id,
                'id_user'       =>  Auth::guard('user')->user()->id,
                'name_history'  =>  "Yêu cầu chỉnh sửa",
                'content'       =>  $name_student[0]->name_user. ' yêu cầu chỉnh sửa',
                'ip'            =>  request()->ip(),
                'info_client'   =>  $user_agent
            ]);
            DB::commit();
            $fail = 0;
        }catch(Exception $e){
            DB::rollBack();
            $fail = 1;
        }
        echo $fail;
    }




}//Emd control





