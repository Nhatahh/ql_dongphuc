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

class Admin24_ImportKetQuaNhom implements ToCollection
{
    private $dotts;
    private $iddotxt;
    public function __construct($dotts,$iddotxt)
    {
        $this->dotts = $dotts;
        $this->iddotxt = $iddotxt;
    }

    public function collection(Collection $rows)
    {

        $dotts =  $this->dotts;
        $iddotxt =  $this->iddotxt;
        $trungtuyentam = DB::table('24_danhsachxettuyentheodotxt')
        ->select('cccd','24_thongtincanhan.id_taikhoan','24_danhsachxettuyentheodotxt.id as id')
        ->join('24_thongtincanhan','24_thongtincanhan.id_taikhoan','=','24_danhsachxettuyentheodotxt.id_taikhoan')
        ->where('iddot',$dotts)
        ->where('iddotxt',$iddotxt)
        ->where('trungtuyentam',1)
        ->get();

        $trungtuyentam_cccd = $trungtuyentam->pluck('cccd')->toArray();
        $trungtuyentam_id = $trungtuyentam->pluck('id')->toArray();
        for($i = 1; $i<count($rows); $i++){
            $cccd[] = $rows[$i][4];
        }

        // $cccd = array_column($rows, 4);

        // $cccd=['089206004396','091306012834','094306002615'];
        // if (count($trungtuyentam_cccd) === count($cccd) && !array_diff($trungtuyentam_cccd, $cccd) && !array_diff($cccd, $trungtuyentam_cccd)) {
        //     for($i = 1; $i<count($rows); $i++){
        //         foreach ($trungtuyentam as $value) {
        //             if($value->cccd == $rows[$i][4] && $rows[$i][10] == "Đỗ"){
        //                 $data_temp = array(
        //                     'id' =>  $value->id,
        //                     'trungtuyennhom' => 1
        //                 );
        //                 $data[] = $data_temp;
        //                 break;
        //             }
        //         }
        //     }
        // }
 if (count($trungtuyentam_cccd) === count($cccd) && !array_diff($trungtuyentam_cccd, $cccd) && !array_diff($cccd, $trungtuyentam_cccd)) {
        DB::table('24_danhsachxettuyentheodotxt')
        ->whereIn('id',$trungtuyentam_id)
        ->update([
            'trungtuyennhom' => 1,
        ]);
    }
}
}

