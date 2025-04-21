<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index() {
        $sanphams = DB::table('sanpham')->get();
        return view('user.home.index', compact('sanphams'));
    }

}