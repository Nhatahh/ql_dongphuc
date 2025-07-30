<?php

namespace App\Http\Controllers\User_24;

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
use Carbon\Carbon;
use PhpParser\Node\Expr\FuncCall;
use \App\Http\Controllers\User\Main\InfoUserController;
use \App\Http\Controllers\User\Main\RegisterWishController;
use Exception;

use function PHPUnit\Framework\countOf;

class Lichsuthaotac24Controller extends Controller

{
    public function lichsuthaotac(){
        $id_taikhoan = Auth::guard('loginbygoogles')->id();
        $img_slider = DB::select("SELECT 24_image_chuan.id, 24_image_chuan.funtion_id,24_image_chuan.ghichu,24_image_chuan.loaianh,if(image.path_img is null,'/img/test.png',image.path_img) as path_img,if(image.id is null,0,image.id) as test  FROM `24_image_chuan` LEFT JOIN (SELECT * FROM 24_image WHERE id_taikhoan = ".$id_taikhoan." AND loaianh > 1) AS image ON 24_image_chuan.id = image.id_image_chuan ORDER BY thutu ASC");
        $avatar=DB::table('24_image')
            ->select('path_img')
            ->where('id_taikhoan',$id_taikhoan)
            ->where('loaianh',1)
            ->get();
        $name_user=DB::table('24_thongtincanhan')
            ->select('hoten')
            ->where('id_taikhoan',$id_taikhoan)
            ->first();
        $history = DB::table('24_lichsu')
            ->selectRaw('24_lichsu.noidung, DATE_FORMAT(24_lichsu.create_at, "%d/%m/%Y %H:%i") as create_at, 24_nhansu.ten as ten_nhansu, 24_lichsu.id_nhansu as id_nhansu')
            ->where('id_taikhoan', $id_taikhoan)
            ->where('hienthi', 1)
            ->orderBy('24_lichsu.create_at', 'DESC')
            ->leftJoin('24_nhansu', '24_nhansu.id', '24_lichsu.id_nhansu')
            ->get();
        if( count($avatar) <= 0 ){
        $avatar_tmp ='img/student_icon.jpg';
        }
        elseif($avatar[0]->path_img == null){
            $avatar_tmp ='img/student_icon.jpg';
        }else{
            $avatar_tmp =$avatar[0]->path_img;
        }

        if( $img_slider){
            return view('user_24.lichsuthaotac',
            [
                'img_slider_right' =>  $img_slider,
                'avatar' =>  $avatar_tmp,
                'name_user' =>  $name_user,
                'history' =>  $history,
                'img_slider' =>  $img_slider,
            ]);
        }else{
            return view('user_24.lichsuthaotac',
            [
                'img_slider_right' =>  $img_slider,
                'avatar' => $avatar_tmp ,
                'name_user' =>  $name_user,
                'history' =>  $history,
                'img_slider' =>  $img_slider,
            ]);
        }
    }

}
