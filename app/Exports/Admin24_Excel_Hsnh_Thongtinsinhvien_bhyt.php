<?php
namespace App\Exports;

// use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class Admin24_Excel_Hsnh_Thongtinsinhvien_bhyt implements FromCollection
// class UserExport implements WithMultipleSheets

{

    private $id_sinhvien;


    public function __construct( $id_sinhvien)
    {

        $this->id_sinhvien = $id_sinhvien;
    }

    //
    public function collection()
{
    // Xác định điều kiện lọc

    $id_sinhvien = $this->id_sinhvien ;


        $sql = 'SELECT
            ROW_NUMBER() OVER (ORDER BY sv.id) AS stt,
            tt.hoten,
            tt.cccd as cccd,
            sv.mssv,
            lp.tenlop as lop,
            tt.ngaysinh,
            if(tt.gioitinh = 1, "Nữ","Nam") as gioitinh,
            hs.bhyt,
            thuongthu.name_province3,
            thuongthu.name_province2,
            thuongthu.name_province,
            thuongthu.duoi_xa_ttru,
            tt.dienthoai
            FROM 24_mssv sv
            LEFT JOIN
                24_hosonhaphoc hs ON  hs.id_taikhoan = sv.id_taikhoan
            LEFT JOIN
                (
                    SELECT 24_hosonhaphoc.id_taikhoan as id_taikhoan, duoi_xa_ttru, name_province3, name_province2, name_province
                    FROM  24_hosonhaphoc
                    LEFT JOIN l_province ON l_province.id = 24_hosonhaphoc.id_tinh_ttru
                    LEFT JOIN l_province2 ON l_province2.id = 24_hosonhaphoc.id_huyen_ttru
                    LEFT JOIN l_province3 ON l_province3.id = 24_hosonhaphoc.id_xa_ttru
                ) as thuongthu ON thuongthu.id_taikhoan = sv.id_taikhoan
            LEFT JOIN
                24_thongtincanhan tt ON  tt.id_taikhoan = sv.id_taikhoan
            INNER JOIN
                24_lop lp ON  lp.id = sv.id_lop

            WHERE sv.id_taikhoan IN ('.$id_sinhvien.')';

    $data = DB::select($sql); // Lấy dữ liệu từ truy vấn SQL

    // Tạo collection dữ liệu xuất excel
    $data_ex = new Collection([
        ['STT','MSVV', 'Họ tên','CMND','Điện thoại','Lớp', 'Ngày sinh', 'Giới tính', 'Số thẻ BHYT', 'Tỉnh/Thành phố', 'Quận/Huyện', 'Xã/Phường', 'Ấp/Khu vực'],
    ]);

    // Đưa dữ liệu vào collection
    foreach ($data as $value) {
        $gioitinh = $value->gioitinh == 1 ? "Nữ" : "Nam";
        $data_ex->push([
            $value->stt,
            $value->mssv,
            $value->hoten,
            $value->cccd,
            $value->dienthoai,
            $value->lop,
            $value->ngaysinh,
            $gioitinh,
            $value->bhyt,
            $value->name_province,
            $value->name_province2,
            $value->name_province3,
            $value->duoi_xa_ttru,
        ]);
    }

    return $data_ex;
}

}



