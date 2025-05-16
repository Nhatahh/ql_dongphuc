<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;


class SizeController extends Controller
{
    public function sizes(Request $request)
    {
        $sizes = Size::select('size_id as id', 'ten as text')->get();
        return response()->json($sizes);
    }









}

