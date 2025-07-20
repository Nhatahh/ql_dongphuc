<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;
use DataTables;

class AdminSizeController extends Controller
{
    public function index()
    {
        return view('admin.size');
    }
    public function getData(Request $request)
    {
        $data = [
            'sizes' => Size::select('size_id', 'ten')->get(),
        ];

        return response()->json($data);
    }

}
