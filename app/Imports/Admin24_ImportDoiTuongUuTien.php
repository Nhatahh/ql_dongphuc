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

class Admin24_ImportDoiTuongUuTien implements ToCollection
{
    private $dotts;

    public function __construct($dotts)
    {
        $this->dotts = $dotts;
    }

    public function collection(Collection $rows)
    {
        for($i = 1; $i<count($rows); $i++){
            $dotts = $this->dotts;

            $data_temp = array(
                'id_taikhoan' => $rows[$i][0],
                'id_doituong' => $rows[$i][1],
                'dotts' =>  $dotts
            );
            $data[] = $data_temp;
        }
        DB::table('24_doituonguutien')
        ->upsert(
            $data,
            ['id_taikhoan','dotts'],
            ['id_doituong'],
        );
    }
}

