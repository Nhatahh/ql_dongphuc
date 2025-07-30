<?php

namespace App\Http\Controllers\Dongphuc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sanpham;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class HomeController extends Controller
{
    public function index() {
       $sanphams = DB::select("
    
        SELECT 
            `24_loaisanpham`.id AS id_loai,
            `24_loaisanpham`.loai AS loai,
            `24_loaisanpham`.mota AS mota,
            `24_loaisanpham`.anhsanpham AS anhsanpham,
            (
                SELECT gia 
                FROM `24_gia` 
                WHERE `24_gia`.id_loai = `24_loaisanpham`.id 
                ORDER BY `24_gia`.id DESC 
                LIMIT 1
            ) AS gia,
            (
                SELECT SUM(hd.sl_phat)
                FROM `24_hoadon` AS hd
                INNER JOIN `24_danhmuc_sanpham` AS sp ON sp.id = hd.id_sanpham
                WHERE sp.id_loai = `24_loaisanpham`.id
            ) AS slphat,
            MAX(`24_kho`.trangthai) AS trangthai
        FROM `24_kho`
        INNER JOIN `24_dotnhap` ON `24_dotnhap`.id = `24_kho`.id_dotnhap
        INNER JOIN `24_danhmuc_sanpham` ON `24_danhmuc_sanpham`.id = `24_kho`.idsanpham
        INNER JOIN `24_danhmuc_nhasanxuat` ON `24_danhmuc_nhasanxuat`.id = `24_danhmuc_sanpham`.id_nhasanxuat
        INNER JOIN `24_loaisanpham` ON `24_loaisanpham`.id = `24_danhmuc_sanpham`.id_loai
        INNER JOIN `24_danhmuc_size` ON `24_danhmuc_size`.id = `24_danhmuc_sanpham`.id_size
        GROUP BY `24_loaisanpham`.id
     
");



        
        // dd ($sanphams);
        // $json_data['data'] = $sql;
        // $res = json_encode($json_data);
        // return  $res;
        return view('dongphuc.home.index', compact('sanphams'));
    }

}