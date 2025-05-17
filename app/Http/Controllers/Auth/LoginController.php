<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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
        $validator = Validator::make( $request->all(),
            [
            'login' => [
                'required',
                'string',
                'regex:/^([a-zA-Z0-9_]+|[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})$/'
            ],
            'password' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9_]+$/'
            ],
        ], [
            'login.required' => 'Vui lòng nhập tên đăng nhập.',
            'login.regex' => 'Tên đăng nhập phải là email hợp lệ hoặc chỉ gồm chữ cái, số, gạch dưới.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.regex' => 'Mật khẩu không được chứa ký tự đặc biệt.',
        ]);

        // Trả lỗi về view nếu không hợp lệ
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        $login_type = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where($login_type, $request->login)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->route('/');
        }

        return back()->withErrors([
            'login' => 'Tài khoản hoặc mật khẩu không đúng.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

