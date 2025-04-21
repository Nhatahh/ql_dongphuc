<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class UniformController extends Controller
{
    function load_seclectbox($table, $feild_id, $feild_text, $selected_id, $text_0)
    {
        $data = [];

        $data[] = [
            'id' => 0,
            'text' => $text_0,
            'selected' => $selected_id == 0,
            'disabled' => true
        ];

        $rows = DB::table($table)
            ->select($feild_id . ' as id', $feild_text . ' as text')
            ->get();

        foreach ($rows as $row) {
            $data[] = [
                'id' => $row->id,
                'text' => $row->text,
                'selected' => $row->id == $selected_id
            ];
        }

        return response()->json($data); 
    }

    public function store() {
        $sanphams = DB::table('sanpham')->get();
        return view('user.uniforms.store', compact('sanphams'));
    }

    public function show_detail() {
        return view('user.uniforms.show_detail');
    }

    public function dm_select2()
    {
        return $this-> load_seclectbox('danhmuc', 'id', 'ten', 0, '--- Chọn loai ---');
    }

}
