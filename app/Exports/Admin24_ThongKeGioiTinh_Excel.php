<?php
namespace App\Exports;

// use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpParser\Node\Stmt\Return_;

class Admin24_ThongKeGioiTinh_Excel implements FromCollection
{

    private $namts;
    private $namtn;
    private $tinh;
    private $truongthpt;


    public function __construct($namts,$namtn,$tinh,$truongthpt)
    {
        $this->namts = $namts;
        $this->namtn = $namtn;
        $this->tinh =  $tinh;
        $this->truongthpt =  $truongthpt;
    }

    public function collection()
    {
        $namts = $this->namts;
        $namtn = $this->namtn;
        $tinh = $this->tinh;
        $truongthpt = $this->truongthpt;


        $data = DB::table('24_thongtincanhan')
        ->select('nguyenvong.namtuyensinh',DB::raw('COUNT(CASE WHEN 24_thongtincanhan.id_taikhoan is not null THEN 1 END) as dangky'),DB::raw('COUNT(CASE WHEN trungtuyen.id_taikhoan is not null THEN 1 END) as trungtuyen'),DB::raw('COUNT(CASE WHEN nhaphoc.id_taikhoan is not null AND nhaphoc.trangthai = 0 THEN 1 END) as danghoc'),DB::raw('COUNT(CASE WHEN nhaphoc.id_taikhoan is not null AND nhaphoc.trangthai = 1 THEN 1 END) as ruths'),DB::raw('COUNT(CASE WHEN gioitinh = 1 THEN 1 END) as sl_nu'),DB::raw('COUNT(CASE WHEN gioitinh = 0 THEN 1 END) as sl_nam'),DB::raw('COUNT(CASE WHEN trungtuyen.id_taikhoan is not null AND gioitinh = 0 THEN 1 END) as sl_nam_tt'),DB::raw('COUNT(CASE WHEN trungtuyen.id_taikhoan is not null AND gioitinh = 1 THEN 1 END) as sl_nu_tt'),DB::raw('COUNT(CASE WHEN nhaphoc.id_taikhoan is not null AND gioitinh = 0 AND nhaphoc.trangthai = 0 THEN 1 END) as sl_nam_nh'),DB::raw('COUNT(CASE WHEN nhaphoc.id_taikhoan is not null AND gioitinh = 1 AND nhaphoc.trangthai = 0 THEN 1 END) as sl_nu_nh'),DB::raw('COUNT(CASE WHEN nhaphoc.id_taikhoan is not null AND gioitinh = 1 AND nhaphoc.trangthai = 1 THEN 1 END) as sl_nu_rut'),DB::raw('COUNT(CASE WHEN nhaphoc.id_taikhoan is not null AND gioitinh = 0 AND nhaphoc.trangthai = 1 THEN 1 END) as sl_nam_rut'))
        ->join('24_namtotnghiep', '24_thongtincanhan.id_taikhoan', '24_namtotnghiep.id_taikhoan')
        ->join(DB::raw('(SELECT * FROM 24_truongthpt WHERE id_lop = 12) AS truong'), '24_thongtincanhan.id_taikhoan', 'truong.id_taikhoan')
        ->join('l_province', 'l_province.id', '=', 'truong.id_tinh')
        ->join('l_school', 'l_school.id', '=', 'truong.id_truong')
        ->join(DB::Raw('(SELECT id_taikhoan, namtuyensinh FROM `24_nguyenvong` INNER JOIN 24_danhmuc_namtuyensinh ON 24_danhmuc_namtuyensinh.id = 24_nguyenvong.idnam  GROUP BY id_taikhoan, namtuyensinh ) as nguyenvong'), 'nguyenvong.id_taikhoan', '=', '24_thongtincanhan.id_taikhoan')
        ->leftJoin(DB::Raw('(SELECT id_taikhoan, namtuyensinh FROM `24_trungtuyen` INNER JOIN 24_danhmuc_namtuyensinh ON 24_danhmuc_namtuyensinh.id = 24_trungtuyen.idnam  GROUP BY id_taikhoan, namtuyensinh) as trungtuyen'),'trungtuyen.id_taikhoan','=', '24_thongtincanhan.id_taikhoan')
        ->leftJoin(DB::Raw('(SELECT id_taikhoan, namts,trangthai FROM `24_mssv` INNER JOIN 24_danhmuc_namtuyensinh ON 24_danhmuc_namtuyensinh.id_nam = 24_mssv.namts  GROUP BY id_taikhoan, namts, trangthai) as nhaphoc'),'nhaphoc.id_taikhoan','=', '24_thongtincanhan.id_taikhoan')
        ->where(function($query) use ($namts) {
            if ($namts == 0) {
                $query->whereNotNull('nguyenvong.namtuyensinh');
            } else {
                $namtuyensinh = DB::table('24_danhmuc_namtuyensinh')->where('id',$namts)->first();
                $namtuyensinh ? $manam = $namtuyensinh->namtuyensinh  : $manam = -1;
                $query->where('nguyenvong.namtuyensinh', $manam);
            }
        })
        ->where(function($query) use ($namtn) {
            if ($namtn == 0) {
                $query->whereNotNull('24_namtotnghiep.namtotnghiep');
            } else {
                $query->where('24_namtotnghiep.namtotnghiep', $namtn);
            }
        })
        ->where(function($query) use ($tinh) {
            if ($tinh != 0) {
                $query->where('truong.id_tinh', $tinh);
            }
        })
        ->where(function($query) use ($truongthpt) {
            if ($truongthpt != 0) {
                $query->where('truong.id_truong', $truongthpt);
            }
        })
        ->groupBy('nguyenvong.namtuyensinh')
        ->get();

        $data_table = new Collection([
              ['Năm tuyển sinh','Đăng ký','Trúng tuyển','Nhập học','Rút HS','DK_Nam','DK_Nữ','TT_Nam','TT_Nữ','NH_Nam','NH_Nữ','RútHS_Nam','RútHS_Nữ']
        ]);

        foreach ($data as $key => $value) {
            $a = [
                $value ->namtuyensinh,

                $value ->dangky,
                $value ->trungtuyen,
                $value ->danghoc,
                $value ->ruths,

                $value ->sl_nam,
                $value ->sl_nu,

                $value ->sl_nam_tt,
                $value ->sl_nu_tt,

                $value ->sl_nam_nh,
                $value ->sl_nu_nh,

                $value ->sl_nam_rut,
                $value ->sl_nu_rut,
            ];
            $data_table[] = $a;
         }

        return $data_table;
    }


}
