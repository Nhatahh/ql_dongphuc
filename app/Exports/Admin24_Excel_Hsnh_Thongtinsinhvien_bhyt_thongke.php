<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;

class Admin24_Excel_Hsnh_Thongtinsinhvien_bhyt_thongke implements FromCollection
{
    use Exportable;

    private $khoa;
    private $lop;
    private $nam;
    public function __construct($lop,$nam,$khoa)
    {
        $this->khoa = $khoa;
        $this->lop = $lop;
        $this->nam = $nam;

    }
    public function collection()
    {
        $khoa = $this->khoa;
        $lop = $this->lop;
        $nam = $this->nam;

        $khoa == 0 ? $khoa_fix = 'ms.id IS NOT NULL' : $khoa_fix = 'l.idkhoa ='.$khoa;
        $lop == 0 ? $lop_fix = 'ms.id IS NOT NULL' : $lop_fix = 'l.id ='.$lop;
        $sql = 'SELECT
                ROW_NUMBER() OVER (ORDER BY l.tenlop) AS stt,
                ms.id_lop,
                l.tenlop,
                lop.namnhaphoc,
                COUNT(ms.id_lop) AS "Sỉ số",
                COUNT(CASE WHEN hs.bhyt IS NOT NULL AND hs.bhyt != "" THEN 1 END) AS "Có BHYT",
                COUNT(CASE WHEN hs.bhyt IS NULL OR hs.bhyt = "" THEN 1 END) AS "Chưa có BHYT"
            FROM
                24_mssv ms
            INNER JOIN 24_lop l ON ms.id_lop = l.id
            LEFT JOIN 24_hosonhaphoc hs ON hs.id_taikhoan = ms.id_taikhoan
            LEFT JOIN (
                SELECT k.namnhaphoc, l.id
                FROM 24_lop l
                INNER JOIN 24_khoas k ON k.id = l.idkhoas
            ) AS lop ON lop.id = ms.id_lop
            WHERE
                l.idkhoas ='.$nam.'
                AND '.$khoa_fix.'
                AND '.$lop_fix.'
            GROUP BY
                ms.id_lop';
        $data = DB::select($sql);
        $data_ex = new Collection([
            ['STT', 'Lớp', 'Sỉ số', 'Có BHYT', 'Chưa có BHYT','Năm nhập học'],
        ]);
        foreach ($data as $value) {
            $data_ex->push([

                $value->stt,
                $value->tenlop,
                (string)($value->{'Sỉ số'} ?? '0'),
                (string)($value->{'Có BHYT'} ?? '0'),
                (string)($value->{'Chưa có BHYT'} ?? '0')  ,
                $value->namnhaphoc,
            ]);
        }
        return $data_ex;
    }
}
