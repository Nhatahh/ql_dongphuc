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

class Thongtinlienhe24Controller extends Controller

{

    public function thongtinlienhe(){
        $ttnhansu=DB::table('24_nhanvienhotro')
        ->where('trangthai',1)
        ->inRandomOrder()
        ->get();
        $doinguphattrien=DB::table('24_doinguphattrien')->get();

        $id_taikhoan = Auth::guard('loginbygoogles')->id();
        $img_slider = DB::select("SELECT 24_image_chuan.id, 24_image_chuan.funtion_id,24_image_chuan.ghichu,24_image_chuan.loaianh,if(image.path_img is null,'/img/test.png',image.path_img) as path_img,if(image.id is null,0,image.id) as test  FROM `24_image_chuan` LEFT JOIN (SELECT * FROM 24_image WHERE id_taikhoan = ".$id_taikhoan." AND loaianh > 1) AS image ON 24_image_chuan.id = image.id_image_chuan ORDER BY thutu ASC");
        return view('user_24.thongtinlienhe',
        [
            'ttnhansu'=>$ttnhansu,
            'img_slider' =>  $img_slider,
            'doinguphattrien'=>$doinguphattrien,
        ]);
    }

}
