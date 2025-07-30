<?php

namespace App\Http\Controllers\Admin\DoAn;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class DoanControler extends Controller
{

    function index(){
        return view('doan.index');
    }


}
