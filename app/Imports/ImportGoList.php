<?php
namespace App\Imports;

// use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportGoList implements ToCollection
{
    public function collection(Collection $rows)
    {
        $year = DB::table('l_year_active')
        ->get();
        $j = 0;

        // DB::table('l_users')
        // ->where('id_batch',$year[0]->id_batch)
        // ->delete();
        foreach ($rows as $key => $value) {
            if($value[0] == 'CMND/TCC'){
                continue;
            }else{
                DB::table('l_users')
                ->updateOrInsert(
                    [
                        'id_card_users' =>  $value[0],
                        'id_year' => $year[0]->id_year,
                        'id_batch' => $year[0]->id_batch,
                    ],
                    [
                        'phone_users' => $value[1],
                        'email_users' => $value[2],
                        'password' => Hash::make($value[3]),
                        'active_users' => 1,
                        'block' => 0,
                    ],
                );
            }
        }

    }
}
