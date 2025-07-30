<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class MainUserController extends Controller

{
    public function index(){
        return view('user.main',
        [
            'title' => "CTUT|Hệ thống đăng ký xét tuyển",
        ]);
    }


    function datasidebar($menus,$parent_id = 0,$level=0,&$html){
        foreach($menus as $key => $menu){
            if($menu->parent_id === $parent_id ){
                $menu ->level = $level;
                if( $menu ->level == 0){
                    $html .= '<li class = "nav-item">';
                        $html .= '<a class="nav-link">';
                            $html .= '<i class="nav-icon fas fa-edit"></i>';
                            $html .=  '<p>'.$menu ->name;
                                $html .= '<i class="fas fa-angle-left right"></i>';
                            $html .= '</p>';
                        $html .='</a>';
                }else{
                    $html .= "<ul class='nav nav-treeview'>";
                    $html .= '<li class="nav-item">';
                        $html .= "<a  onclick = 'loadpage(".$menu ->id.")' class='nav-link'>";
                            $html .=  '<i class="fa fa-check nav-icon"></i>';
                            $html .= '<p>'.$menu ->name.'</p>';
                        $html .= '</a>';
                    $html .= '</li>';
                }
                unset($menus[$key]);
                self::datasidebar($menus,$menu->id,$level + 1,$html);
                $html .= '</li>';
                $html .= "</ul>";
            }
        }
    }

    public function sidebar(){
        $menus = DB::table('l_users_menus')->orderBy('number', 'asc')
        ->where('active', 1)
        ->get();
        $this->datasidebar($menus,0,0,$result);
        echo $result;
    }

    public function logout(){
        Auth::guard('user')->logout();
    }

    public function changepass(){
        return view('user.login.changepass');
    }

    public function updatepassword(Request $request){
        $validator = Validator::make($request->all(),
        [
            'user_passwordreset_old'        =>'required|alpha_dash|min:8',
            'user_passwordreset'            =>'required|alpha_dash|min:8|different:user_passwordreset_old',
            'user_passwordreset_confirm'    =>'required|alpha_dash|min:8|same:user_passwordreset',
        ],
        [
            'user_passwordreset_old.required'       => 'Vui lòng điền mật khẩu cũ',
            'user_passwordreset_old.alpha_dash'     => 'Mật khẩu chỉ gồm chữ cái và chữ số',
            'user_passwordreset_old.min'            => 'Mật khẩu gồm 8 ký tự trở lên',



            'user_passwordreset.required'       => 'Vui lòng điền mật khẩu mới',
            'user_passwordreset.differents'           => 'Mật khẩu bị trùng với mật khẩu cũ',
            'user_passwordreset.alpha_dash'     => 'Mật khẩu chỉ gồm chữ cái và chữ số',
            'user_passwordreset.min'            => 'Mật khẩu gồm 8 ký tự trở lên',



            'user_passwordreset_confirm.required'   => 'Vui lòng điền mật khẩu mới',
            'user_passwordreset_confirm.same'       => 'Điền mật khẩu trùng với mật khẩu mới',
            'user_passwordreset_confirm.alpha_dash' => 'Mật khẩu chỉ gồm chữ cái và chữ số',
            'user_passwordreset_confirm.min'        => 'Mật khẩu gồm 8 ký tự trở lên',
        ]
    );
        if($validator ->fails()){
            return response()->json($validator ->errors());
        }else{
            $user_passwordreset_old = $request ->input('user_passwordreset_old');
            $user_passwordreset = Hash::make($request ->input('user_passwordreset'));
            $id = $request ->input('id');

            if(Hash::check($user_passwordreset_old, Auth::guard('user')->user()->password)){
                $update = DB::table('l_users')
                ->where([ 'id' =>$id ])
                ->update([
                    'password' => $user_passwordreset,
                    ]);
                if($update == 1){
                    return  $update;
                }else{
                    return  0;
                }
            };
        }
    }


    public function loadpage($id){
        $page = DB::table('l_users_menus')->where('id',$id)->get();
        return $page;
    }

    public function loaduser_Img(){
        $infoUser = DB::table('l_info_users')
        ->where('id_user',Auth::guard('user')->user()->id)
        ->get();
        echo $infoUser;
    }


}



