<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('user.form.register');
    }

    public function register(Request $request)
    {
        // Validate dữ liệu
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users,username',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'mssv' => 'required|string|unique:users,mssv',
            'sdt' => 'nullable|string|max:15',
            'hoten' => 'nullable|string|max:100',
            'diachi' => 'nullable|string|max:255',
            'avt_url' => 'nullable|string|max:255',
        ], [
            'username.required' => 'Vui lòng nhập tên tài khoản.',
            'username.unique' => 'Tên tài khoản đã tồn tại.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.confirmed' => 'Mật khẩu nhập lại không khớp.',
            'mssv.required' => 'Vui lòng nhập MSSV.',
            'mssv.unique' => 'MSSV đã tồn tại.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Xử lý lưu ảnh nếu có
        $avatarPath = 'images/avt/default.jpg';
        if ($request->hasFile('avt_file')) {
            $file = $request->file('avt_file');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/avt'), $filename);
            $avatarPath = $filename;
        }

        $maxUser_id = DB::table('users')->max('user_id');
        $newUser_id = $maxUser_id + 1;

        // Lưu vào DB
        User::create([
            'user_id' => $newUser_id,
            'username' => $request->username,
            'password' => Hash::make($request->password), // bcrypt
            'mssv'     => $request->mssv,
            'email'    => $request->email,
            'sdt'      => $request->sdt,
            'hoten'    => $request->hoten,
            'diachi'   => $request->diachi,
            'avt_url'  => $avatarPath,
        ]);

        return redirect()->route('login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }
}
