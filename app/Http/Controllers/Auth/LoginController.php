<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('user.form.sign_in'); 
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $login_type = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where($login_type, $request->login)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            // Lưu user_id vào session
            session(['user_id' => $user->user_id]);

            return redirect()->route('/');
        }

        return back()->withErrors([
            'login' => 'Tài khoản hoặc mật khẩu không đúng.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Hủy session, token, cookie nếu cần
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login'); // hoặc trang bạn muốn sau logout
    }
}

