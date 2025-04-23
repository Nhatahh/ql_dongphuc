<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;  
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        $user_id = 'U01';
        $user = DB::table('users')->where('user_id', $user_id)->first();
        return view('user.profile', compact('user'));
    }


}
