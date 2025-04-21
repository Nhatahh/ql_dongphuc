<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UniformController extends Controller
{
    public function store() {
        return view('user.uniforms.store');
    }

    public function show_detail() {
        $chitietSanpham = DB::table('sanpham')
        ->join ('kho','kho.sp_id','=','sanpham.sp_id')
        ->join ('danhmuc','danhmuc.dm_id','=','sanpham.sp_id')
        ->join ('danhgia','danhgia.sp_id','=','sanpham.sp_id')
        ->join ('users','users.user_id','=','danhgia.user_id')
        ->where('sanpham.id', 1)
        ->first();
        return view('user.uniforms.show_detail',compact('chitietSanpham'));
    }

}
