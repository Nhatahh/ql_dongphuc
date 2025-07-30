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

class Admin24_NamTotNghiep implements ToCollection
{
    // private $dotts;

    // public function __construct($dotts)
    // {
    //     $this->dotts = $dotts;
    // }

    public function collection(Collection $rows)
    {
        for($i = 1; $i<count($rows); $i++){
            $data_temp = array(
                'id_taikhoan' => $rows[$i][0],
                'namtotnghiep' => $rows[$i][1],
            );
            $data[] = $data_temp;
        }
        DB::table('24_namtotnghiep')
        ->upsert(
            $data,
            ['id_taikhoan'],
            ['namtotnghiep'],
        );
    }
}

