<?php
namespace App\Imports;

// use App\Invoice;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Admin24_ImportMSSV implements ToCollection
{
    private $namts,$dotts;

    public function __construct($namts,$dotts)
    {
        $this->namts = $namts;
        $this->dotts = $dotts;
    }

    public function collection(Collection $rows)
    {



        for($i = 1; $i<count($rows); $i++){
            $data_temp = array(
                'id_taikhoan' => $rows[$i][1],
                'mssv' => $rows[$i][0],
                'namts' =>$this->namts,
                'iddotts' =>$this->dotts,
                'id_lop' => $rows[$i][2]
            );
            $data_taikhoan[] = $data_temp;
        }
        DB::table('24_mssv')
        ->upsert(
            $data_taikhoan,
            ['id_taikhoan','namts'],
            ['mssv','iddotts','id_lop'],
        );
    }
}
