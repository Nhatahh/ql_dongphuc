<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sanpham;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class HomeController extends Controller
{
    public function index() {
        $sanphams = Sanpham::withSum('chitiethoadon as so_luong_da_ban', 'soluong')
            ->orderByDesc('so_luong_da_ban')
            ->limit(8) // số lượng muốn gợi ý
            ->get();
        return view('user.home.index', compact('sanphams'));
    }

}