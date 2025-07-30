<?php
namespace App\Imports;

// use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportPassBo implements ToCollection
{
    private $id_batch_ts,$id_batch;

    public function __construct(int $id_batch_ts,int $id_batch)
    {
        $this->id_batch_ts = $id_batch_ts;
        $this->id_batch = $id_batch;
    }

    public function collection(Collection $rows)
    {
        $year = DB::table('l_year_active')
        ->get();
        if($year[0] ->id_batch ==  $this->id_batch_ts){
            DB::table('l_go_batch_pass')
            ->where('id_batch',$this->id_batch)
            ->update([
                'pass_bo' => 0,
            ]);

            for($i = 1; $i<count($rows); $i++){
                if($rows[$i][0] == 'STT'){
                    continue;
                }else{
                    if($rows[$i][10] == "Đỗ"){
                        $pass = 1;
                    }else{
                        $pass = 0;
                    }
                    $id = DB::select("SELECT l_go_batch_pass.id as id FROM l_go_batch_pass INNER JOIN l_wish ON l_wish.id = l_go_batch_pass.id_wish INNER JOIN l_users ON l_users.id = l_wish.id_user WHERE l_wish.id_batch = ".$this->id_batch_ts." AND l_go_batch_pass.id_batch = ".$this->id_batch." AND l_users.id_card_users = '".$rows[$i][4]."'");
                    if(count($id) >0){
                        DB::table('l_go_batch_pass')
                        ->where('id',$id[0]->id)
                        ->update(
                            [
                                'pass_bo' =>  $pass,
                            ]
                        );
                    }
                }
            }
        }
    }
}
