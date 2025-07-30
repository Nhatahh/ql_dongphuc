<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Nette\Utils\Strings;

class NavarController extends Controller
{

    // public function create(){
    //     return view('admin.users.users',[
    //         'title' => "CTUT|Quản lý người dùng",
    //     ]);
    // }

    public function loadUser(){
        return Auth::user();
    }
}

