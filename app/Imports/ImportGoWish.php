<?php
namespace App\Imports;

// use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportGoWish implements ToCollection
{
    public function collection(Collection $rows)
    {
        $year = DB::table('l_year_active')
        ->get();
        // DB::table('l_wish')
        // ->where('id_batch',$year[0] ->id_batch)
        // ->delete();
        for($i = 1; $i<count($rows); $i++){
            if($rows[$i][0] == 'ID'){
                continue;
            }else{
                $major = DB::table('l_method_major')
                ->select('l_method_major.id as id')
                ->join('l_major','l_major.id','l_method_major.id_major')
                ->where('l_major.id_major',$rows[$i][5])
                ->where('l_method_major.id_method',$rows[$i][20])
                ->get();

                DB::table('l_wish')
                ->updateOrInsert(
                    [
                        'id_user' => (int)$rows[$i][0],
                        'id_method'=>(int)$rows[$i][20],
                        'id_batch'=> $year[0] ->id_batch,
                        'id_major' => $major[0] ->id,
                        'id_year'=>  (int)$rows[$i][21],
                    ],
                    [
                        'number_bo' => (int)$rows[$i][2],
                        'tts' => (int)$rows[$i][19],
                    ]
                );
            }
        }

    }
}
