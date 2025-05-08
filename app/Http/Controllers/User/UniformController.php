<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;


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

    public function showDetail($sp_id)
    {
        $ct_sp = DB::table('sanpham as sp')
            ->leftJoin('danhmuc', 'sp.dm_id', '=', 'danhmuc.dm_id')
            ->leftJoin('nhasanxuat', 'sp.nsx_id', '=', 'nhasanxuat.nsx_id')
            ->leftJoin('kho', 'kho.sp_id', '=', 'sp.sp_id')
            ->leftJoin('size', 'size.size_id', '=', 'kho.size_id')
            ->leftJoin('mau', 'mau.mau_id', '=', 'kho.mau_id')
            ->leftJoin('danhgia', 'danhgia.kho_id', '=', 'kho.kho_id')
            ->leftJoin('users', 'users.user_id', '=', 'danhgia.user_id')
            ->where('sp.sp_id', $sp_id)
            ->select(
                'sp.*', 
                'danhmuc.ten as ten_danhmuc', 
                'nhasanxuat.ten as ten_nsx', 
                'kho.tonkho', 
                'size.ten as ten_size', 
                'mau.ten as ten_mau', 
                'users.username as username',
                'danhgia.created_at as created_at',
                
            )
            ->first();

        if (!$ct_sp) {
            abort(404, 'Không tìm thấy sản phẩm');
        }

        $sizes = DB::table('size')->get();

        $danhgias = DB::table('danhgia as dg')
            ->leftJoin('kho', 'kho.kho_id', '=', 'dg.kho_id')
            ->where('sp_id', $sp_id)
            ->get();

        return view('user.uniforms.show_detail', compact('ct_sp', 'sizes', 'danhgias'));
    }

    public function dm_select2()
    {
        return $this->load_seclectbox('danhmuc', 'id', 'ten', 0, '--- Chọn loai ---');
    }
}