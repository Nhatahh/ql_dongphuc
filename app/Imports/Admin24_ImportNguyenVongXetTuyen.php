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

class Admin24_ImportNguyenVongXetTuyen implements ToCollection
{
    private $dotts;

    public function __construct($dotts)
    {
        $this->dotts = $dotts;
    }

    public function collection(Collection $rows)
    {
        $dotts = $this->dotts;
        for($i = 1; $i<count($rows); $i++){
            $tts = $rows[$i][5];
            $id_taikhoan = $rows[$i][1];
            $thutu = $rows[$i][2];
            $id_nganh = $rows[$i][3];
            $id_chuyennganh = $rows[$i][4];
            if( $tts == 1){
                $data_temp = array(
                    'id_taikhoan' =>  $id_taikhoan,
                    'thutu' =>  $thutu,
                    'iddot' => 3,
                    'idnganh' =>  $id_nganh,
                    'id_chuyennganh' =>  $id_chuyennganh,
                    'idphuongthuc' => 1,
                    'tts' => 1,
                );
                $data[] = $data_temp;
            }else{
                $data_temp1 = array(
                    'id_taikhoan' =>  $id_taikhoan,
                    'thutu' =>  $thutu,
                    'iddot' => 3,
                    'idnganh' =>  $id_nganh,
                    'id_chuyennganh' =>  $id_chuyennganh,
                    'idphuongthuc' => 1,
                    'tts' => 0,
                );
                $data[] = $data_temp1;
                $data_temp2 = array(
                    'id_taikhoan' =>  $id_taikhoan,
                    'thutu' =>  $thutu,
                    'iddot' => 3,
                    'idnganh' => $id_nganh,
                    'id_chuyennganh' =>  $id_chuyennganh,
                    'idphuongthuc' => 2,
                    'tts' => 0,
                );
                $data[] = $data_temp2;
            }
        }
        DB::table('24_nguyenvong')
        ->upsert(
            $data,
            ['id_taikhoan','thutu','iddot','idphuongthuc'],
            ['idnganh','tts','id_chuyennganh'],
        );
    }
}
