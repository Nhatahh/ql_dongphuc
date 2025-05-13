<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;  
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        $user_id = '1';
        $user = DB::table('giohang as gh')
        ->join('sanpham', 'sanpham.sp_id', '=', 'gh.sp_id')
        ->join('users', 'users.user_id', '=', 'gh.user_id')
        ->join('kho', 'sanpham.kho_id', '=', 'kho.kho_id')
        ->join('mau', 'gh.mau_id', '=', 'mau.mau_id')
        ->join('size', 'gh.size_id', '=', 'size.size_id')
        ->where('gh.user_id', $user_id)
        ->select(
            'gh.*',
            'sanpham.tensp',
            'sanpham.sp_id as sp_id',
            'sanpham.gia',
            'sanpham.image_url as image_url',
            'users.avt_url as avt_url',
            'users.hoten as hoten',
            'users.diachi as diachi',
            'users.sdt as sdt',
            'users.email as email',
            'users.mssv as mssv',
            'mau.ten as tenmau',
            'size.ten as tensize',
            'kho.kho_id as kho_id',
        )
        ->get();
        return view('user.profile', compact('user'));
    }


    public function formSignIn()
    {
        return view('user.form.sign_in');
    }


}
