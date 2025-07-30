<?php
namespace App\Exports;

// use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\GoController;
use Maatwebsite\Excel\Concerns\FromCollection;



class GoPassAoExport implements FromCollection
{
    private $id_batch_ts,$id_batch;

    public function __construct(int $id_batch_ts,$id_batch)
    {
        $this->id_batch_ts = $id_batch_ts;
        $this->id_batch = $id_batch;

    }

    public function collection()
    {
        $data = DB::select("SELECT l_users.id as id, l_major.id_major as id_major,l_wish.number_bo as number_bo,l_users.id_card_users as id_card_users  FROM `l_go_batch_pass` INNER JOIN l_wish ON l_wish.id = l_go_batch_pass.id_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_major.id = l_method_major.id_major INNER JOIN l_users ON l_users.id = l_wish.id_user WHERE l_go_batch_pass.id_batch_ts = ".$this ->id_batch_ts."  AND l_go_batch_pass.id_batch = ".$this ->id_batch);

        $data_ex = new Collection([
            ['STT','CMND',"Thứ tự nguyện vọng",'Mã ngành'],
            ['','',"",''],
        ]);

        foreach ($data as $key => $value) {
           $a = [$value ->id,$value ->id_card_users,$value ->number_bo,$value ->id_major];
           $data_ex[] = $a;
        }
        return $data_ex;
    }
}
