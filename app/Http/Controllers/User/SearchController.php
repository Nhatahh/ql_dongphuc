<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Psy\Readline\Hoa\Console;
use App\Models\Sanpham;


class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');  

        $sanphams = Sanpham::where('tensp', 'like', '%' . $query . '%')
                            ->get();

        return response()->json($sanphams);  
    }
}
