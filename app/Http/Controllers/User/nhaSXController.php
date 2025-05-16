<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\nhaSX;


class nhaSXController extends Controller
{
    public function nsx(Request $request)
    {
        $nsx = nhaSX::select('nsx_id as id', 'ten as text')->get();
        return response()->json($nsx);
    }









}

