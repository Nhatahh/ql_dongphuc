<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UniformController extends Controller
{
<<<<<<< Updated upstream
=======
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

>>>>>>> Stashed changes
    public function store() {
        return view('user.uniforms.store');
    }

    public function show_detail() {
        return view('user.uniforms.show_detail');
    }
}
