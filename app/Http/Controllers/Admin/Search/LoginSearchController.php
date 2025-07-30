<?php

namespace App\Http\Controllers\Admin\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class LoginSearchController extends Controller
{
   public function index()
   {

        return view("search.login",[
            'title' => "CTUT|ĐĂNG NHẬP TÀI KHOẢN",
        ]);

   }

       //Load Search
       public function batch_login(){
        //Batch
        $batch0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Đợt tuyển sinh",
                'selected' => true
            ]
        );

        $batchs = DB::table('l_batch')
        ->select('id','name_batch as text')
        ->get();
        $batchs[] = $batch0;


        $result = array(
            'batch' => $batchs,
        );
        return $result;
    }


   public function login(Request $requets)
   {
        $validator = Validator::make($requets->all(),
        [
            'cmnd_login'      =>'required|regex:/[0-9a-zA-Z]{9,12}/',
            'batch_login'          => 'required|numeric|min:1',
        ],
        [
            'cmnd_login.required'       =>'Vui lòng điền CMND hoặc Thẻ Căn cước',
            'cmnd_login.regex'          =>'CMND/TCC từ 10 đến 12 ký tự',
            'batch_login.min'            =>'Chọn đợt tuyển sinh',
        ]
    );
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }else{
            $check =   DB::table('l_year_active')
            ->get();
            if(count($check) >0){
                if($check[0]->block == 1 && $check[0]->search == 1 ){
                    $id_card_users  = trim($requets->input('cmnd_login'));
                    $id_batch  = trim($requets->input('batch_login'));
                    if(Auth::guard('search')->attempt(
                        [
                            'id_card_users' => $id_card_users,
                            'password' => '12365878',
                            'id_batch' => $id_batch
                        ]
                        )
                    )
                    {
                        return 1;
                    }else{
                        return  0;
                    }
                }else{
                    return 2;
                }
            }
        }
    }

}
