<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
<<<<<<< Updated upstream
    //
=======
    public function profile()
    {
        $user = DB::table('users')->where('id', 1)->first();
        return view('user.profile', compact('user'));
    }


    public function formSignIn()
    {
        return view('user.form.sign_in');
    }
>>>>>>> Stashed changes
}
