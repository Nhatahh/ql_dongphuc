<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function banhang() {
        return view('admin.banhang');
    }
     public function taikhoan() {
        return view('admin.taikhoan');
    }
     public function donhang() {
        return view('admin.donhang');
    }
     public function danhmuc() {
        return view('admin.danhmuc');
    }
     public function sanpham() {
        return view('admin.sanpham');
    }
     public function thongke() {
        return view('admin.thongke');
    }
}
