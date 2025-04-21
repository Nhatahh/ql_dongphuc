<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;  
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        $user = DB::table('users')->where('id', 1)->first();
        return view('user.profile', compact('user'));
    }


}
