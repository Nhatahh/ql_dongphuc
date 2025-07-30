<?php
namespace App\Imports;

// use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Hash;

class ImportGoPolicyList implements ToCollection
{
    public function collection(Collection $rows)
    {
        // $year = DB::table('l_year_active')
        // ->get();
        $i = 0;
        foreach ($rows as $key => $value) {
            if($i == 0){
                $i++;
            }else{
                $find = DB::table('l_policy_users')
                ->where('id_policy_user', $value[1])
                ->get();
                $user =  DB::table('l_users')
                ->where('id', $value[0])
                ->get();
                if(count($find) == 1 && count($user) == 1 ){
                    DB::table('l_policy_users_reg')
                    ->updateOrInsert(
                        [
                            'id_user' => $value[0],
                        ],
                        [
                            'id_policy_users' => $find[0] ->id,
                        ],
                    );
                }
                $i++;
            }
        }
    }
}

