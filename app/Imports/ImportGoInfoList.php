<?php
namespace App\Imports;

// use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Hash;

class ImportGoInfoList implements ToCollection
{
    public function collection(Collection $rows)
    {
        $year = DB::table('l_year_active')
        ->get();
        $i = 0;
        // DB::table('l_info_users')
        // ->where('id_batch',$year[0]->id_batch)
        // ->delete();
        foreach ($rows as $key => $value) {
            if($i == 0){
                $i++;
            }else{
                DB::table('l_info_users')
                ->updateOrInsert(
                    [
                        'id_user' => $value[0],
                        'id_batch' => $year[0]->id_batch,
                    ],
                    [
                        'name_user' => $value[1],
                        'birth_user' =>  $value[2],
                        'sex_user' => $value[3],
                        'graduation_year_user' => $value[4],
                        'id_priority_area_user' => $value[5],
                    ]
                );
            }
        }

    }
}
