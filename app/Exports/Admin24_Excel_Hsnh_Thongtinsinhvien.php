<?php
namespace App\Exports;

// use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class Admin24_Excel_Hsnh_Thongtinsinhvien implements FromCollection
// class UserExport implements WithMultipleSheets

{
    private $major;
    private $cccd;
    private $mssv;
    private $id_sinhvien;



    public function __construct($major,$cccd,$mssv, $id_sinhvien)
    {
        $this->major = $major;
        $this->cccd = $cccd;
        $this->mssv = $mssv;
        $this->id_sinhvien = $id_sinhvien;
    }

    public function collection()
    {
        $this->id_sinhvien == 0 ? $id_sinhvien_fix = '24_thongtincanhan.id_taikhoan IS NOT NULL' : $id_sinhvien_fix = '24_thongtincanhan.id_taikhoan IN ('.$this->id_sinhvien.')';
        $this->major == 0 ? $major_fix = 'lop.idnganh IS NOT NULL' : $major_fix = 'lop.idnganh ='.$this->major;
        $this->cccd == 0 ? $cccd_fix = 'cccd IS NOT NULL' : $cccd_fix = 'cccd = "'.$this->cccd.'"';
        $this->mssv == 0 ? $mssv_fix = '24_mssv.mssv IS NOT NULL' : $mssv_fix = '24_mssv.mssv = "'.$this->mssv.'"';
        $sql = 'SELECT
            ROW_NUMBER() OVER (ORDER BY 24_mssv.id_taikhoan) AS stt,
            hoten,
            24_thongtincanhan.id_taikhoan,
            24_thongtincanhan.cccd,
            24_mssv.mssv,
            24_thongtincanhan.gioitinh as gioitinh,
            ngaysinh,
            thuongthu.name_province3,
            thuongthu.name_province2,
            thuongthu.name_province,
            thuongthu.duoi_xa_ttru,
            24_thongtincanhan.dienthoai
        FROM 24_mssv
        INNER JOIN (SELECT id, idnganh FROM 24_lop) as lop ON lop.id = 24_mssv.id_lop
        INNER JOIN
            (
                SELECT 24_hosonhaphoc.id_taikhoan as id_taikhoan, duoi_xa_ttru, name_province3, name_province2, name_province
                FROM  24_hosonhaphoc
                INNER JOIN l_province ON l_province.id = 24_hosonhaphoc.id_tinh_ttru
                INNER JOIN l_province2 ON l_province2.id = 24_hosonhaphoc.id_huyen_ttru
                INNER JOIN l_province3 ON l_province3.id = 24_hosonhaphoc.id_xa_ttru
            ) as thuongthu ON thuongthu.id_taikhoan = 24_mssv.id_taikhoan
        INNER JOIN 24_thongtincanhan ON 24_thongtincanhan.id_taikhoan = 24_mssv.id_taikhoan
        WHERE '.$major_fix.'
        AND '.$cccd_fix.'
        AND '.$mssv_fix.'
        AND ' .$id_sinhvien_fix;
        $data = DB::select($sql);

        $data_ex = new Collection([
            ['STT','MSSV',"Họ tên",'CMND/TCC', 'Điện thoại','Ngày sinh','Giới tính','Tỉnh/Thành phố', 'Quận/Huyện', 'Xã/Phường', 'Ấp/Khu vực'],
        ]);

        foreach ($data as $key => $value) {
            $value ->gioitinh == 1 ? $gioitinh = "Nữ" : $gioitinh = "Nam";
            $a = [
                $value ->stt,
                $value ->hoten,
                $value ->mssv,$value ->cccd,
                $value->dienthoai,
                $value ->ngaysinh,
                $gioitinh,
                $value->name_province,
                $value->name_province2,
                $value->name_province3,
                $value->duoi_xa_ttru,
            ];
           $data_ex[] = $a;
        }
        return $data_ex;
    }
}



