<?php
namespace App\Imports;

// use App\Invoice;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Admin24_ImportDanhSachThiSinh implements ToCollection
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
                'name' => $rows[$i][1],
                'email' => $rows[$i][2],
                'password' => '$2a$12$JDFLwwliUgN5bIgD0fgRseDldXUjf0wwHuI5a8DCbpUiluVhTrkPu',
                'google_id' => 0,
                'cccd_bo' => $rows[$i][3]
            );
            $data_taikhoan[] = $data_temp;
        }
        DB::table('account24s')
        ->upsert(
            $data_taikhoan,
            ['cccd_bo'],
            ['password','name','email','google_id'],
        );
    }
}
