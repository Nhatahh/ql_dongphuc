<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Role;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Exists;
use Nette\Utils\Strings;

class PolicyController extends Controller
{
    public function index(){
        return view('admin.policy.index',[
            'title' => "CTUT|Quản lý người dùng",
        ]);
    }

    public function list_policy(){
        $policys = DB::select("SELECT l_policy_users.*, CONCAT(l_policy_users.name_policy_user,'xxx',l_policy_users.id) as name_policy FROM `l_policy_users`");

        $policys_file = DB::select("SELECT l_policy_users_file.id_policy as id, l_policy_users_list.name_list as name_list FROM l_policy_users_file INNER JOIN l_policy_users_list ON l_policy_users_list.id = l_policy_users_file.id_file");

        foreach ($policys as $key => $value) {
            $list = "";
            foreach ($policys_file as $key => $file) {
                if($file ->id == $value ->id){
                    $list .= $file->name_list.", ";
                }
            }
            $value->name_list = rtrim($list, ", ");
        }

        $json_data['data'] = $policys;
        $data = json_encode($json_data);
        echo  $data;
    }


    public function file_policy($id){
        $file = DB::select("SELECT l_policy_users_list.id as id, l_policy_users_list.name_list, CONCAT(l_policy_users_list.id,'xxx',if(PO.id_file is null, 0,1)) as active FROM l_policy_users_list LEFT JOIN (SELECT * FROM l_policy_users_file WHERE id_policy = ".$id.") AS PO ON PO.id = l_policy_users_list.id");
        $json_data['data'] = $file;
        $data = json_encode($json_data);
        echo  $data;
    }


    public function file_policy_attr(){
        $files = DB::select("SELECT l_policy_users_list.*, CONCAT(name_list,'xxx',id) as name_list FROM `l_policy_users_list`");
        $json_data['data'] = $files;
        $data = json_encode($json_data);
        echo  $data;
    }

    public function load_file_policy($id){
        $sliders = DB::table('l_image_hocba')
        ->where('id_user',10603)
        ->orderBy('type_img','asc')
        ->get();
        $html = '';
        foreach ($sliders as  $slider) {
            $html .= '<div  class="swiper-slide">';

                $html .= '<i onclick = "del_img_slide('.$slider->id.')"  class="fa-solid fa-trash icon_slide1"></i>';
                $html .= '<i onclick = "update_img_slide('.$slider->id.')" class="fa-solid fa-circle-up icon_slide"></i>';
                $html .= '<i onclick = "update_img_seen('.$slider->id.')" class="fa-solid fa-eye icon_slide2"></i>';
                $html .= '<div class="swiper-zoom-container">';
                    $html .= '<img class = "img_slide" src="'.$slider->link_img.'">';
                $html .= '</div>';
            $html .= '</div>';
        }
        echo $html;
    }
}


