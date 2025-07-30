<?php

namespace App\Http\Controllers\User\Main;

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

use function PHPUnit\Framework\countOf;
use \App\Http\Controllers\User\Main\RegisterWishController;
use Exception;

class ResulthbController extends Controller

{
    public function index(){
        return view('user.main.result_hb',
        [
            'title' => "CTUT|Hệ thống đăng ký xét tuyển",
        ]);
    }
//Check đã tải img
    // public  function check_img(){
    //     $heck = DB::table('l_image_hocba')
    //     ->where('type_img',2)

    //     ->where('type_img',2)
    //     ->get();
    //     if(count($heck) == 4){
    //         return 1;
    //     }else{
    //         return 0;
    //     }
    // }


    function  join($subjects,$class,$semester){
        $results = DB::table('l_result')
        ->select('id_subject','mark_result')
        ->where('id_student_result',Auth::guard('user')->user()->id)
        ->where('id_class_result',$class)
        ->where('id_semester_result',$semester)
        ->get();
        $i=0;
        foreach ($subjects as  $subject) {
            foreach ($results as  $result) {
                if($subject->id_subject == $result->id_subject){
                    $tam = $result->mark_result;
                    $i++;
                }
            }
            if($i == 0){
                $subject->mark_result = 0;
            }else{
                $subject->mark_result = $tam;
            }
            $i=0;
        }
        return $subjects;
    }


    public function loadSubjects(){
        $subjects = DB::table('l_batch_subject')
        ->select('name_subject','l_subject.id as id_subject')
        ->join('l_subject','l_batch_subject.id_subject','l_subject.id')
        ->where('id_type_subject',1)
        ->get();

        $class10_1 = $this ->join($subjects,10,1);
        $html10_1 = "";
        foreach ($class10_1 as $value) {
            $html10_1 .= '<div class="col-md-2 col-6">
                <div class="form-group row" style="margin-bottom: 3px">
                    <label for="" class="col-sm-6 col-form-label" style="padding-bottom: 0;font-weight:normal;padding-left: 10px;padding-right: 0px;">'.$value->name_subject.':</label>
                    <div class="col-sm-6" style="padding-left: 0px;padding-right: 0px;">
                        <input type="text" class="form-control result"  subject = "'.$value->name_subject.'" id_subject="'.$value->id_subject.'" id_class_result = "10" id_semester_result = "1" style="height:30px" value="'.$value->mark_result.'">
                    </div>
                </div>
            </div>';
        }

        $class10_2 = $this ->join($subjects,10,2);
        $html10_2 ="";
        foreach ($class10_2  as $value) {
            $html10_2 .= '<div class="col-md-2 col-6">
                <div class="form-group row" style="margin-bottom: 3px">
                    <label for="" class="col-sm-6 col-form-label" style="padding-bottom: 0;font-weight:normal;padding-left: 10px;padding-right: 0px;">'.$value->name_subject.':</label>
                    <div class="col-sm-6" style="padding-left: 0px;padding-right: 0px;">
                        <input type="text" class="form-control result"  subject = "'.$value->name_subject.'" id_subject="'.$value->id_subject.'" id_class_result = "10" id_semester_result = "2" style="height:30px" value="'.$value->mark_result.'">
                    </div>
                </div>
            </div>';
        }

        $class10_cn = $this ->join($subjects,10,'CN');
        $html10_cn="";
        foreach ($class10_cn as $value) {
            $html10_cn .= '<div class="col-md-2 col-6">
                <div class="form-group row" style="margin-bottom: 3px">
                    <label for="" class="col-sm-6 col-form-label" style="padding-bottom: 0;font-weight:normal;padding-left: 10px;padding-right: 0px;">'.$value->name_subject.':</label>
                    <div class="col-sm-6" style="padding-left: 0px;padding-right: 0px;">
                        <input type="text" class="form-control result"  subject = "'.$value->name_subject.'" id_subject="'.$value->id_subject.'" id_class_result = "10" id_semester_result = "CN" style="height:30px" value="'.$value->mark_result.'">
                    </div>
                </div>
            </div>';
        }


        $class11_1= $this ->join($subjects,11,1);
        $html11_1 = "";
        foreach ( $class11_1 as $value) {
            $html11_1 .= '<div class="col-md-2 col-6">
                <div class="form-group row" style="margin-bottom: 3px">
                    <label for="" class="col-sm-6 col-form-label" style="padding-bottom: 0;font-weight:normal;padding-left: 10px;padding-right: 0px;">'.$value->name_subject.':</label>
                    <div class="col-sm-6" style="padding-left: 0px;padding-right: 0px;">
                        <input type="text" class="form-control result"  subject = "'.$value->name_subject.'" id_subject="'.$value->id_subject.'" id_class_result = "11" id_semester_result = "1" style="height:30px" value="'.$value->mark_result.'">
                    </div>
                </div>
            </div>';
        }

        $class11_2 =$this ->join($subjects,11,2);
        $html11_2 ="";
        foreach ( $class11_2 as $value) {
            $html11_2 .= '<div class="col-md-2 col-6">
                <div class="form-group row" style="margin-bottom: 3px">
                    <label for="" class="col-sm-6 col-form-label" style="padding-bottom: 0;font-weight:normal;padding-left: 10px;padding-right: 0px;">'.$value->name_subject.':</label>
                    <div class="col-sm-6" style="padding-left: 0px;padding-right: 0px;">
                        <input type="text" class="form-control result"  subject = "'.$value->name_subject.'" id_subject="'.$value->id_subject.'" id_class_result = "11" id_semester_result = "2" style="height:30px" value="'.$value->mark_result.'">
                    </div>
                </div>
            </div>';
        }

        $class11_cn =  $this ->join($subjects,11,'CN');
        $html11_cn="";
        foreach ($class11_cn as $value) {
            $html11_cn .= '<div class="col-md-2 col-6">
                <div class="form-group row" style="margin-bottom: 3px">
                    <label for="" class="col-sm-6 col-form-label" style="padding-bottom: 0;font-weight:normal;padding-left: 10px;padding-right: 0px;">'.$value->name_subject.':</label>
                    <div class="col-sm-6" style="padding-left: 0px;padding-right: 0px;">
                        <input type="text" class="form-control result"  subject = "'.$value->name_subject.'" id_subject="'.$value->id_subject.'" id_class_result = "11" id_semester_result = "CN" style="height:30px" value="'.$value->mark_result.'">
                    </div>
                </div>
            </div>';
        }

        $class12_1 = $this ->join($subjects,12,1);
        $html12_1 = "";
        foreach ($class12_1  as $value) {
            $html12_1 .= '<div class="col-md-2 col-6">
                <div class="form-group row" style="margin-bottom: 3px">
                    <label for="" class="col-sm-6 col-form-label" style="padding-bottom: 0;font-weight:normal;padding-left: 10px;padding-right: 0px;">'.$value->name_subject.':</label>
                    <div class="col-sm-6" style="padding-left: 0px;padding-right: 0px;">
                        <input type="text" class="form-control result"  subject = "'.$value->name_subject.'" id_subject="'.$value->id_subject.'" id_class_result = "12" id_semester_result = "1" style="height:30px" value="'.$value->mark_result.'">
                    </div>
                </div>
            </div>';
        }
        $class12_2 = $this ->join($subjects,12,2);
        $html12_2 ="";
        foreach ($class12_2  as $value) {
            $html12_2 .= '<div class="col-md-2 col-6">
                <div class="form-group row" style="margin-bottom: 3px">
                    <label for="" class="col-sm-6 col-form-label" style="padding-bottom: 0;font-weight:normal;padding-left: 10px;padding-right: 0px;">'.$value->name_subject.':</label>
                    <div class="col-sm-6" style="padding-left: 0px;padding-right: 0px;">
                        <input type="text" class="form-control result"  subject = "'.$value->name_subject.'" id_subject="'.$value->id_subject.'" id_class_result = "12" id_semester_result = "2" style="height:30px" value="'.$value->mark_result.'">
                    </div>
                </div>
            </div>';
        }

        $class12_cn = $this ->join($subjects,12,'CN');
        $html12_cn="";
        foreach ($class12_cn as $value) {
            $html12_cn .= '<div class="col-md-2 col-6">
                <div class="form-group row" style="margin-bottom: 3px">
                    <label for="" class="col-sm-6 col-form-label" style="padding-bottom: 0;font-weight:normal;padding-left: 10px;padding-right: 0px;">'.$value->name_subject.':</label>
                    <div class="col-sm-6" style="padding-left: 0px;padding-right: 0px;">
                        <input type="text" class="form-control result"  subject = "'.$value->name_subject.'" id_subject="'.$value->id_subject.'" id_class_result = "12" id_semester_result = "CN" style="height:30px" value="'.$value->mark_result.'">
                    </div>
                </div>
            </div>';
        }

        $img_hocba = DB::table('l_image_hocba')
        ->where('type_img',2)
        ->where('id_user',Auth::guard('user')->user()->id)
        ->get();

        if(count($img_hocba) >0){
            $img_hocba = $img_hocba;
        }else{
            $img_hocba = 0;
        }
        $result = array(
            'class10_1' => $html10_1,
            'class10_2' => $html10_2,
            'class10_cn' => $html10_cn,
            'class11_1' => $html11_1,
            'class11_2' => $html11_2,
            'class11_cn' => $html11_cn,
            'class12_1' => $html12_1,
            'class12_2' => $html12_2,
            'class12_cn' => $html12_cn,
            'id_check_info' => $img_hocba,
        );
        return $result;
    }
    //Tạo chuỗi để lưu
    function rand_string( $length ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str ='';
        $size = strlen( $chars );

        for( $i = 0; $i < $length ; $i++ ) {
            $str .= $chars[rand( 0, $size - 1)];
        }
        return $str;
    }


    //Lưu ẢNh học bạ
    public function slider_hb(Request $request){
        $check = DB::table('l_image_hocba')
        ->where('id_user', Auth::guard('user')->user()->id)
        ->where('type_img',$request->input('type'))
        ->get();
        if(count($check) ==  5){
            return -1;
        }else{
            DB::beginTransaction();
            try{
                $del_img = DB::table('l_image_hocba')
                    ->where('type_img',2)
                    ->where('id_user',Auth::guard('user')->user()->id)
                    ->where('id_img', $request->input('id'))
                    ->orderBy('id_img','asc')
                    ->get();
                    if(count($del_img) == 1){
                        if(File::exists(ltrim($del_img[0] ->link_img,"/"))){
                            unlink(ltrim($del_img[0] ->link_img,"/"));
                        }
                    }
                $prefixfileName = Auth::guard('user')->user()->id.'.png';
                $fileName =$this ->rand_string(30)."_".$prefixfileName;
                $path = '/images/hocba'.'/'.Auth::guard('user')->user()->id.'/result_'.$request->input('type').'_'.$request->input('id').'_'.$fileName;
                $data =  $request->input('img');
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);
                $storage = Storage::disk('local');
                $storage->put('/hocba'.'/'.Auth::guard('user')->user()->id.'/result_'.$request->input('type').'_'.$request->input('id').'_'.$fileName, $data, 'public');
                $ins = DB::table('l_image_hocba')
                ->updateOrInsert(
                    [
                        'id_user'   => Auth::guard('user')->user()->id,
                        'type_img'  =>$request->input('type'),
                        'id_img'    =>$request->input('id'),

                    ],
                    [
                    'link_img'     => $path,
                    'note_type'    => "Ảnh học bạ",
                    'block_img'    => 0,
                    'number_img'   =>4,
                    'id_check'      => $request->input('id_check')
                    ]
                );
                DB::commit();
                echo 1;
            }catch(Exception $e){
                DB::rollBack();
                echo 0;
            }
        }
    }

    //Load sider học bạ
    function loadslider_hb(){
        $sliders = DB::table('l_image_hocba')
        // ->where('type_img',2)
        ->where('id_user',Auth::guard('user')->user()->id)
        ->orderBy('id_img','asc')
        ->get();
        $html = '<ul class = "slider_hb" id ="slider_hb">';
        foreach ($sliders as  $slider) {
            if($slider->type_img == 2){
                if($slider->id_img == 9){
                    $title = "Thông tin học sinh";
                }else{
                    $title ='Học bạ lớp '.$slider->id_img;
                }
            }else{
                $title = $slider->note_type;
            }
            $html .= '<li><img class = "" src="'.$slider->link_img.'" title="'.$title.'"></li>';
        }
        $html .= '</ul>';
        $result = array(
            'html' => $html,
            'fail' => 0
        );
        return  $result;
    }

    public function check_reg(){
        $chec_reg =  DB::table('l_block_wish')
        ->where('id_user',Auth::guard('user')->user()->id)
        ->get();
        if(count($chec_reg) == 1){
            if($chec_reg[0] ->id_block == 1 ){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }

    public function addResult(Request $request){

        if($this ->check_reg() == 1){
            return 'check_reg_false';
        }else{
            $check_false = DB::table('l_image_hocba')
            ->where('type_img',2)
            ->where('id_user',Auth::guard('user')->user()->id)
            ->get();
            if(count($check_false) == 4){
                $data = $request->input('data');
                DB::beginTransaction();
                try {
                    $dem = 0;
                    foreach ($data  as $key => $value) {
                        $ins = DB::table('l_result')
                        ->updateOrInsert(
                        [
                            'id_subject'            => $value[0],
                            'id_class_result'       => $value[1],
                            'id_semester_result'    => $value[2],
                            'id_student_result'     =>Auth::guard('user')->user()->id
                        ],
                        [
                            'mark_result'      => (float)$value[3],
                        ]);
                        $dem = $dem + $ins;
                    }
                    DB::commit();
                    return $dem;
                }catch( Exception $e){
                    DB::rollBack();
                    return -1;
                }
            }else{
                if(count($check_false) < 4){
                    return 'check_false';
                }else{
                    return 'check_false_error';
                }
            }
        }
    }
}
