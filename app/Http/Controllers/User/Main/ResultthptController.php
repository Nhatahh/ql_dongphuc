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

class ResultthptController extends Controller

{
    public function index(){
        return view('user.main.result_thpt',
        [
            'title' => "CTUT|Hệ thống đăng ký xét tuyển",
        ]);
    }

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
        ->where('id_type_subject',3)
        ->get();

        $class_thpt = $this ->join($subjects,"TN","PT");
        $subjects_thpt = "";
        foreach ($class_thpt as $value) {
            $subjects_thpt .= '<div class="col-md-2 col-6">
                <div class="form-group row" style="margin-bottom: 3px">
                    <label for="" class="col-sm-6 col-form-label" style="padding-bottom: 0;font-weight:normal;padding-left: 10px;padding-right: 0px;">'.$value->name_subject.':</label>
                    <div class="col-sm-6" style="padding-left: 0px;padding-right: 0px;">
                        <input type="text" class="form-control result_thpt"  subject = "'.$value->name_subject.'" id_subject="'.$value->id_subject.'" id_class_result = "TN" id_semester_result = "PT" style="height:30px" value="'.$value->mark_result.'">
                    </div>
                </div>
            </div>';
        }


        $img_hocba = DB::table('l_image_hocba')
        ->where('type_img',7)
        ->where('id_user',Auth::guard('user')->user()->id)
        ->get();

        if(count($img_hocba) >0){
            $img_hocba = $img_hocba;
        }else{
            $img_hocba = 0;
        }
        $result = array(
            'subjects_thpt' => $subjects_thpt,
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
    public function save_img_result_thpt(Request $request){
        // $check = DB::table('l_image_hocba')
        // ->where('id_user', Auth::guard('user')->user()->id)
        // ->where('type_img',3)
        // ->get();
        // if(count($check) ==  1){
        //     return -1;
        // }else{
            DB::beginTransaction();
            try{
                $del_img = DB::table('l_image_hocba')
                    ->where('type_img',7)
                    ->where('id_user',Auth::guard('user')->user()->id)
                    ->get();
                    if(count($del_img) == 1){
                        if(File::exists(ltrim($del_img[0] ->link_img,"/"))){
                            unlink(ltrim($del_img[0] ->link_img,"/"));
                        }
                    }
                $prefixfileName = Auth::guard('user')->user()->id.'.png';
                $fileName =$this ->rand_string(30)."_".$prefixfileName;
                $path = '/images/hocba'.'/'.Auth::guard('user')->user()->id.'/result_7_1_'.$fileName;
                $data =  $request->input('img');
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);
                $storage = Storage::disk('local');
                $storage->put('/hocba'.'/'.Auth::guard('user')->user()->id.'/result_7_1_'.$fileName, $data, 'public');
                $ins = DB::table('l_image_hocba')
                ->updateOrInsert(
                    [
                        'id_user'   => Auth::guard('user')->user()->id,
                        'type_img'  => 7,
                        'id_img'    => 1

                    ],
                    [
                    'link_img'     => $path,
                    'note_type'    => "GCN kết quả thi",
                    'block_img'    => 0,
                    'number_img'   => 11,
                    'id_check'      => $request->input('id_check')
                    ]
                );
                DB::commit();
                echo 1;
            }catch(Exception $e){
                DB::rollBack();
                echo 0;
            }
        // }
    }

    //Load sider học bạ
    function loadslider_thpt(){
        $sliders = DB::table('l_image_hocba')
        ->where('type_img',7)
        ->where('id_user',Auth::guard('user')->user()->id)
        ->orderBy('id_img','asc')
        ->get();
        $html = '<ul class = "slider_thpt" id ="slider_thpt">';
        foreach ($sliders as  $slider) {
            $html .= '<li><img class = "" src="'.$slider->link_img.'" title="GCN Tốt nghiệp THPT"></li>';
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

    public function addResult_thpt(Request $request){
        if($this ->check_reg() == 1){
            return 'check_reg_false';
        }else{
            $check_false = DB::table('l_image_hocba')
            ->where('type_img',7)
            ->where('id_user',Auth::guard('user')->user()->id)
            ->get();
            if(count($check_false) == 1){
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
