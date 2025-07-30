<?php

namespace App\Http\Controllers\Dongphuc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;


class Size1Controller extends Controller
{
    public function sizes(Request $request)
    {
        $sizes = Size::select('id as id', 'size as text')->get();
        return response()->json($sizes);
    }

}

