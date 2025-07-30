<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Role;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Exists;
use Nette\Utils\Strings;

class PriorityAreaController extends Controller
{
    public function index(){
        return view('admin.priority_area.index',[
            'title' => "CTUT|Quản lý người dùng",
        ]);
    }

    public function list_priority_area(){
        $json_data['data'] = DB::table('l_priority_area')->get();
        $data = json_encode($json_data);
        echo  $data;
    }
}


