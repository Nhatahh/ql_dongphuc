<?php

namespace App\Http\Controllers\Dongphuc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Danhmuc;


class DanhmucController extends Controller
{   
    public function danhmuc(Request $request)
    {
        $danhmuc = Danhmuc::select('dm_id as id', 'ten as text')->get();
        return response()->json($danhmuc);
    }









}

