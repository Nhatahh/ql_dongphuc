<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ptThanhToan;


class ptThanhToanController extends Controller
{
    public function ptThanhToan(Request $request)
    {
        $ptThanhToan = ptThanhToan::select('pttt_id as id', 'ten as text')->get();
        return response()->json($ptThanhToan);
    }









}

