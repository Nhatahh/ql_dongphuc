<?php
namespace App\Imports;

// use App\Invoice;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Admin24_ImportXacnhanBo implements ToCollection
{
    private $namts;
    private $dotts;

    public function __construct($namts,$dotts)
    {
        $this->namts = $namts;
        $this->dotts = $dotts;

    }

    public function collection(Collection $rows)
    {
        for($i = 3; $i<count($rows); $i++){
            $data_temp = array(
                'id_taikhoan' => $rows[$i][11],
                'thoigian' => $rows[$i][7],
                // 'mssv' => $rows[$i][1],
                'namts' =>$this->namts,
                'iddotts' =>$this->dotts,
            );
            $data_taikhoan[] = $data_temp;
        }
        DB::table('24_xacnhanbo')
        ->upsert(
            $data_taikhoan,
            ['id_taikhoan','namts'],
            ['thoigian','iddotts'],
        );
    }
}
