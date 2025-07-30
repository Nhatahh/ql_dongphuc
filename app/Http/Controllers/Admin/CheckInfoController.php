<?php

namespace App\Http\Controllers\Admin;
use App\Http\Requests\Menu\CreateFormRequest;

use App\Models\Menu;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\JsonDecoder;

class CheckInfoController extends Controller
{

    public function create(){
        return view('admin.checkinfo.checkinfo');
    }



    // public function loadComboxMenu(){
    //     $menus = DB::table('l_menus')->where('parent_id',0)->get();
    //     return  $menus;
    // }




    public function testdiem(){
        $class_1011 = DB::table('l_result')

        ->where('id_student_result',1)
        ->where('id_subject',1)
        ->whereIn('id_class_result',[10,11])
        ->whereIn('id_semester_result',[1,2])
        ->sum('mark_result');

        $class_12 = DB::table('l_result')

        ->where('id_student_result',1)
        ->where('id_subject',1)
        ->whereIn('id_class_result',[12])
        ->whereIn('id_semester_result',[1])
        ->sum('mark_result');


        // ->get();


        $subject_1 = $this->take_decimal_number(($class_1011 + $class_12)/3,2);

        $json_data['data'] =  $subject_1;
        $data = json_encode($json_data);
        echo  $data;
    }

    function take_decimal_number($num,$n){
        $base = 10**$n;
        $result = round($num * $base) / $base ;
        return $result;
    }

    // public function loadGroups(){
    //     $groups = DB::table('l_group')->orderBy('num_group', 'asc')->get();
    //     $group_subjects = DB::table('l_group_subject')
    //     ->join('l_subject','l_group_subject.id_subject','=','l_subject.id')
    //     ->orderBy('id_group', 'asc')->get();

    //     foreach ($groups as $group ){
    //         $subject = ''; $i=0;
    //         foreach ($group_subjects as $group_subject){
    //             if($group ->id == $group_subject ->id_group ){
    //                 if($i==0){
    //                     $subject .= $group_subject ->name_subject;
    //                 }else{
    //                     $subject .= ', '.$group_subject ->name_subject;
    //                 }
    //                 $group ->subjects_group = $subject;
    //                 $i++;
    //             }
    //         }
    //         $subject = '';
    //         if($i==0){
    //             $group ->subjects_group = 0;
    //         }
    //         $i=0;
    //     }
    //     $json_data['data'] = $groups;
    //     $data = json_encode($json_data);
    //     echo  $data;
    //     // echo   $group_subjects;
    // }

}
