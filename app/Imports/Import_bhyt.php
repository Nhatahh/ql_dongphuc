<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class Import_bhyt implements ToCollection
{
    // public function collection(Collection $rows)
    // {
    //     // $i = 0;
    //     foreach ($rows as $key => $value) {
    //         if($key > 0){
    //            $temp = array(
    //             'mssv' => $value[1],
    //             'bhyt' => $value[7],
    //            );
    //            $data[] = $temp;
    //         }
    //     }

    //     DB::table('24_hosonhaphoc')
    //     ->upsert(
    //         $data,
    //         ['id_taikhoan'],
    //         ['bhyt']
    //     );
    // }
    public function collection(Collection $rows)
    {
        $data = [];
        $invalidMSSVs = [];
        foreach ($rows as $key => $value) 
        {
            if ($key > 0) {
                $mssv = $value[1];
                $bhyt = $value[7];
                $idTaikhoan = DB::table('24_mssv')->where('mssv', $mssv)->value('id_taikhoan');
                if ($idTaikhoan) {    
                    $data[] = [
                        'id_taikhoan' => $idTaikhoan,
                        'bhyt' => $bhyt,
                    ];
                } else {
                    $invalidMSSVs[] = $mssv;
                }
            }
        }
        if (!empty($invalidMSSVs)) 
        {
            $invalidMSSVsList = implode(', ', $invalidMSSVs);
            throw new \Exception("Các MSSV không khớp: $invalidMSSVsList");
        }
        DB::table('24_hosonhaphoc')
            ->upsert(
                $data,
                ['id_taikhoan'], 
                ['bhyt']         
            );
    }

}
