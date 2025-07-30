<?php
namespace App\Imports;

// use App\Invoice;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class Admin24_ImportThongTinThiSinh implements ToCollection
{
    // private $dotts;

    // public function __construct($dotts)
    // {
    //     $this->dotts = $dotts;
    // }

    public function collection(Collection $rows)
    {
        for($i = 1; $i<count($rows); $i++){
            $gioitinh = 1;
            $rows[$i][4] == "Nam" ? $gioitinh = 0 : $gioitinh = 1;
            $data_temp = array(
                'id_taikhoan' => $rows[$i][1],
                'cccd' => $rows[$i][0],
                'hoten' => $rows[$i][2],
                'ngaysinh' => '2006-01-01',
                'dienthoai' => $rows[$i][5],
                // 'ngaysinh' => Carbon::createFromFormat('d/m/Y', $rows[$i][3])->format('Y-m-d'),
                'gioitinh' => $gioitinh,
            );
            $data[] = $data_temp;
        }
        DB::table('24_thongtincanhan')
        ->upsert(
            $data,
            ['cccd'],
            ['id_taikhoan','hoten','ngaysinh','gioitinh','dienthoai'],
        );
    }
}

