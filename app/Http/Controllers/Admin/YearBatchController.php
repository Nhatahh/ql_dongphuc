<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\Expenses_back;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

class YearBatchController extends Controller

{

    public function batch_active(){
        $method = DB::table('l_year_batch')
        ->join('l_batch','l_batch.id','l_year_batch.id_batch')
        ->where('active_year_batch',1)
        ->select('l_year_batch.id_batch as id','l_batch.name_batch as text')
        ->get();
        return $method;
    }

    public function method_active(){
        $check_batch = DB::table('l_year_batch')
        ->join('l_batch','l_batch.id','l_year_batch.id_batch')
        ->where('active_year_batch',1)
        ->select('l_year_batch.id_batch as id','l_batch.name_batch as text')
        ->get();
        if(count($check_batch) == 1){
            $method = DB::table('l_batch_method')
            ->join('l_method','l_method.id','l_batch_method.id_method')
            ->where('active_batch_method',1)
            ->select('l_batch_method.id_method as id','l_method.name_method as text')
            ->get();
            $result = array(
                'method' => $method,
                'fail' => 0,
            );
        }else{
            if(count($check_batch) == 0){
                $result = array(
                    'method' => array(
                        'id' => 0,
                        'text' => "Không có Phương thức đang mở",
                    ),
                    'fail' => 1,
                );
            }else{
                $result = array(
                    'method' => array(
                        'id' => 0,
                        'text' => "Lỗi cài đặt hệ thống",
                    ),
                    'fail' => 2,
                );
            }
        }
        return $result;
    }
}
