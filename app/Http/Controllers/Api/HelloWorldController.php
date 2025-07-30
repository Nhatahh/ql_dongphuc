<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HelloWorldController extends Controller
{
    public function test()
    {
        return response()->json(['message' => 'Hello World from Laravel API!']);
    }

    // public function test()
    // {
    //     return view('test.test',

    //     );
    // }

}

