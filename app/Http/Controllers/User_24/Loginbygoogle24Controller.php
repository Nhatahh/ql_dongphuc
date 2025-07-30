<?php

namespace App\Http\Controllers\User_24;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use App\Models\Account24;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Google\Client as GoogleClient;

class Loginbygoogle24Controller extends Controller
{

    function login(){
        return view('user_24.login.login',
        [
            'title' => "CTUT|Hệ thống đăng ký xét tuyển",
        ]);
    }


    /**
     * Create a new controller instance.
     *
    //  * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
    //  * @return void
     */
    public function handleGoogleCallback()
    {

        DB::beginTransaction();
        try {
            $user = Socialite::driver('google')->user();
            $finduser = Account24::where('email', $user->email)->first();
            if($finduser ){
                if($finduser->google_id == 0 || $finduser->admin == 1){
                    $post = Account24::where('email', $user->email)->first();
                    // Cập nhật dữ liệu
                    $post->update([
                        'img_gg' => $user->avatar,
                        'google_id' => $user->id,
                    ]);
                    $post->save();
                    Auth::guard('loginbygoogles')->login($finduser);
                    $user_agent = $_SERVER['HTTP_USER_AGENT'];
                    DB::table('24_soluongdangnhap')->insert([
                        'google_id' => $user->id,
                        'email' => $user->email,
                        'thietbi'   => $user_agent,
                        'ip'        => request()->ip()
                    ]);
                    DB::commit();
                    return redirect()->intended('/admin24/main');
                }else{
                    $post = Account24::where('google_id', $user->id)->first();
                    // Cập nhật dữ liệu
                    $post->update([
                        'img_gg' => $user->avatar,
                    ]);
                    $post->save();
                    Auth::guard('loginbygoogles')->login($finduser);
                    // dd(Auth::guard('loginbygoogles')->id());
                    $user_agent = $_SERVER['HTTP_USER_AGENT'];
                    $dangnhap = DB::table('24_soluongdangnhap')->insert([
                        'google_id' => $user->id,
                        'email' => $user->email,
                        'thietbi'   => $user_agent,
                        'ip'        => request()->ip()
                    ]);
                    DB::commit();
                    return redirect()->intended('/thongtincanhan');
                }
            }else{
                $newUserId = DB::table('account24s')->insert([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => Hash::make('1111aaaa'),
                    'img_gg' => $user->avatar,
                ]);
                $finduser = Account24::where('google_id', $user->id)->first();
                Auth::guard('loginbygoogles')->login($finduser);
                // dd(Auth::guard('loginbygoogles')->id());
                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                DB::table('24_soluongdangnhap')->insert([
                    'google_id' => $user->id,
                    'email' => $user->email,
                    'thietbi'   => $user_agent,
                    'ip'        => request()->ip()
                ]);
                DB::commit();
                return redirect()->intended('/thongtincanhan');
            }
            // DB::table('24_soluongdangnhap')

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->intended('/login');
        }
    }


    public function store(Request $requets)
    {
        $validator = Validator::make($requets->all(),
            [
                // 'email_login'     =>'email|required',
                // 'phone_login'     =>'required|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:10|max:10',
                'cmnd_login'      =>'required|regex:/[0-9a-zA-Z]{9,12}/',
                // 'ngaysinh'             => 'required|date|before:today', // Kiểm tra ngày sinh
                // 'password_login' => 'required|alpha_dash|min:8'
            ],
            [
                // 'email_login.email'         =>'Email chưa đúng định dạng',
                // 'email_login.required'      =>'Vui lòng điền email',

                // 'phone_login.required'      =>'Điền số điện thoại',
                // 'phone_login.regex'         =>'Số đầu tiên phải là số 0',
                // 'phone_login.not_regex'     =>'Điện thoại chỉ bao gồm chữ số',
                // 'phone_login.max'           =>'Điện thoại gồm 10 chữ số',
                // 'phone_login.min'           =>'Điện thoại gồm 10 chữ số',

                // 'password_login.required'   =>'Vui lòng điền Mật khẩu',
                // 'password_login.alpha_dash' =>'Mật khẩu chỉ gồm chữ cái và chữ số',
                // 'password_login.min'        =>'Mật khẩu phải từ 8 ký tự trở lên',

                'cmnd_login.required'       =>'Vui lòng điền CMND hoặc Thẻ Căn cước',
                'cmnd_login.regex'          =>'CMND/TCC từ 10 đến 12 ký tự',

                // 'ngaysinh.required'              => 'Vui lòng điền ngày sinh',
                // 'ngaysinh.date'                  => 'Ngày sinh không hợp lệ',
                // 'ngaysinh.before'                => 'Ngày sinh phải trước ngày hiện tại',
                // 'cmnd_login.unique'         =>'CMND đã được đăng ký',

            ]
        );
    if ($validator->fails()) {
        return response()->json($validator->errors());
    }else{
        // $dt = DB::table('24_thongtincanhan')
        // ->where('cccd',$requets ->input('cmnd_login'))
        // ->where('ngaysinh',$requets ->input('ngaysinh'))
        // ->first();
        // if($dt){
            $finduser = Account24::where('cccd_bo', $requets ->input('cmnd_login'))->first();
            if($finduser){
                Auth::guard('loginbygoogles')->login($finduser);
                if (Auth::guard('loginbygoogles')->check()) {
                    return 1;
                } else {
                    return 0;
                }
            }else{
                return 0;
            }
        // }else{
        //     return 0;
        // }
    }
}





























    function dangnhap(Request $a)
    {
        $validator = Validator::make(
            $a->all(),
            [
                'email'     => 'required|email',
                'pass'      => 'required|alpha_dash|min:8'
            ],
            [
                'email.email'         => 'Email chưa đúng định dạng',
                'email.required'      => 'Vui lòng điền email',
                'pass.required'   => 'Vui lòng điền Mật khẩu',
                'pass.alpha_dash' => 'Mật khẩu chỉ gồm chữ cái và chữ số',
                'pass.min'        => 'Mật khẩu phải từ 8 ký tự trở lên',
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else {
            if (Auth::guard('loginbygoogle')->attempt(
                [
                    'email' => $a->input('email'),
                    'password' =>  $a->input('pass'),
                ]
            )) {
                return  1;
            } else {
                return 0;
            }
        }
    }
}
