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

class ResultnlController extends Controller

{
    public function index(){
        return view('user.main.result_nl',
        [
            'title' => "CTUT|Hệ thống đăng ký xét tuyển",
        ]);
    }
//Check đã tải img
    public  function check_img(){
        $heck = DB::table('l_image_hocba')
        ->where('type_img',2)
        ->get();
        if(count($heck) == 4){
            return 1;
        }else{
            return 0;
        }
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
        ->where('id_type_subject',2)
        ->get();

        $classnl = $this ->join($subjects,"NL","NL");
        $htmlnl = "";
        foreach ($classnl as $value) {
            $htmlnl .= '<div class="col-md-12 col-12">
                <div class="form-group row" style="margin-bottom: 3px">
                    <label for="" class="col-sm-5 col-form-label" style="padding-bottom: 0;font-weight:normal;padding-left: 10px;padding-right: 0px;">Điểm thi '.$value->name_subject.':</label>
                    <div class="col-sm-7" style="padding-left: 0px;padding-right: 0px;">
                        <input type="text" class="form-control result" id = "mark_nl"  subject = "'.$value->name_subject.'" id_subject="'.$value->id_subject.'" id_class_result = "NL" id_semester_result = "NL" style="height:30px" value="'.$value->mark_result.'">
                    </div>
                </div>
            </div>';
        }

        $image = DB::table('l_image_hocba')
        ->where('id_user',Auth::guard('user')->user()->id)
        ->where('type_img',5)
        ->get();

        if(count($image) == 1){
            $id_check = $image[0]->id_check."x".$classnl[0]->mark_result;
            $id_check1 = $image[0]->id_check;
            $data = 1;
        }else{
            $id_check = 0;
            $id_check1 = 0;
            $data = 0;
        }

        $result = array(
            'classnl' => $htmlnl,
            'id_check' => $id_check,
            'id_check1' => $id_check1,
            'data' => $data,
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
    // public function slider_nl(Request $request){
    //     $prefixfileName = Auth::guard('user')->user()->id.'.png';
    //     $fileName =$this ->rand_string(30)."_".$prefixfileName;
    //     $path = '/images/hocba'.'/'.Auth::guard('user')->user()->id.'/result_5_1_'.$fileName;
    //     $data =  $request->input('img');
    //     list($type, $data) = explode(';', $data);
    //     list(, $data)      = explode(',', $data);
    //     $data = base64_decode($data);
    //     $storage = Storage::disk('local');
    //     $storage->put('/hocba'.'/'.Auth::guard('user')->user()->id.'/result_5_1_'.$fileName, $data, 'public');

    //     $ins = DB::table('l_image_hocba')
    //     ->updateOrInsert(
    //         [
    //             'id_user'   => Auth::guard('user')->user()->id,
    //             'type_img'  => 5,
    //             'id_img'    => 1,

    //         ],
    //         [
    //         'link_img'     => $path,
    //         'note_type'    => "Kết quả thi năng lực",
    //         'block_img'    => 0,
    //         'number_img'   =>5,
    //         ]
    //     );
    //     $result = array(
    //         'ins' => $ins,
    //         'src' =>  $path,
    //     );
    //     return $result;
    // }




    //Load sider học bạ
    function loadImg_nl(){
        $sliders = DB::table('l_image_hocba')
        ->where('type_img',5)
        ->where('id_user',Auth::guard('user')->user()->id)
        ->orderBy('id_img','asc')
        ->get();
        if(count($sliders) >0){
            return  $sliders[0]->link_img;
        }else{
            return  "";
        }
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


    public function addResult_nl(Request $request){
        $check_reg = $this->check_reg();
        if($check_reg == 1){
            return 'check_reg_false';
        }else{
            DB::beginTransaction();
            try
            {
                // Thêm điểm
                DB::table('l_result')
                ->updateOrInsert(
                [
                    'id_subject'            => $request->input('id_subject'),
                    'id_class_result'       => "NL",
                    'id_semester_result'    => "NL",
                    'id_student_result'     =>Auth::guard('user')->user()->id
                ],
                [
                    'mark_result'      => (float)$request->input('mark'),
                ]);

                if($request->input('img') != 1){
                    $del_img = DB::table('l_image_hocba')
                    ->where('type_img',5)
                    ->where('id_user',Auth::guard('user')->user()->id)
                    ->orderBy('id_img','asc')
                    ->get();
                    if(count($del_img) == 1){
                        if(File::exists(ltrim($del_img[0] ->link_img,"/"))){
                            unlink(ltrim($del_img[0] ->link_img,"/"));
                        }
                    }
                    $prefixfileName = Auth::guard('user')->user()->id.'.png';
                    $fileName =$this ->rand_string(30)."_".$prefixfileName;
                    $path = '/images/hocba'.'/'.Auth::guard('user')->user()->id.'/result_5_1_'.$fileName;
                    $data =  $request->input('img');
                    list($type, $data) = explode(';', $data);
                    list(, $data)      = explode(',', $data);
                    $data = base64_decode($data);
                    $storage = Storage::disk('local');
                    $storage->put('/hocba'.'/'.Auth::guard('user')->user()->id.'/result_5_1_'.$fileName, $data, 'public');

                    DB::table('l_image_hocba')
                    ->updateOrInsert(
                        [
                            'id_user'   => Auth::guard('user')->user()->id,
                            'type_img'  => 5,
                            'id_img'    => 1,
                        ],
                        [
                        'link_img'     => $path,
                        'note_type'    => "Kết quả thi năng lực",
                        'block_img'    => 0,
                        'number_img'   =>5,
                        'id_check'      => $request->input('id_check'),
                        ]
                    );

                        // unlink('images/hocba/4/result_5_1_ES0wNP839jFzMnzl5w4ujv9uC2kcFx_4.png');

                }
                DB::commit();
                echo 1;
            }catch(Exception $e){
                DB::rollBack();
                echo 0;
            }
        }
    }




}
