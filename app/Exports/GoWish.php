<?php
namespace App\Exports;

// use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\GoController;
use Maatwebsite\Excel\Concerns\FromCollection;



class GoWish implements FromCollection
{
    private $active,$year;

    public function __construct(int $active,$year)
    {
        $this->active = $active;
        // $this->data = $data;
        $this->year = $year;

    }

    public function collection()
    {
        $data = DB::select("SELECT *, l_wish.number as number,if(l_wish.tts = 1,'x','') as tts1, USER.id as id_user,l_group.id_group as id_group FROM l_wish INNER JOIN (SELECT l_method.id_method, l_major.id_major as id_major, l_major.name_major,l_method_major.id as id FROM l_method_major INNER JOIN l_major ON l_major.id = l_method_major.id_major INNER JOIN l_method ON l_method.id = l_method_major.id_method) as MAJOR ON MAJOR.id = l_wish.id_major INNER JOIN (SELECT l_users.id as id, l_users.id_card_users,l_info_users.name_user FROM l_users LEFT JOIN l_info_users ON l_info_users.id_user = l_users.id WHERE l_users.id_batch = 2) AS USER ON USER.id = l_wish.id_user LEFT JOIN l_group ON l_wish.id_group = l_group.id WHERE l_wish.id_batch = 2 ORDER BY  l_wish.number_bo ASC, l_wish.number ASC");

        $data_ex = new Collection([
            ['ID','CMND/TCC',"Họ tên",'Phương thức','Mã Ngành','Tên ngành','Nguyện vọng (Bộ)','Nguyện vọng (Trường)','Tổ hợp','Điểm TH','Điểm UT','Tổng điểm','Trúng tuyển sớm'],
        ]);

        foreach ($data as $key => $value) {
           $a = [$value ->id_user,$value ->id_card_users,$value ->name_user,$value ->id_method,$value ->id_major,$value ->name_major,$value ->number_bo,$value ->number,$value ->id_group,$value ->group_mark,$value ->priority_mark,$value ->mark,$value ->tts1];
           $data_ex[] = $a;
        }
        return $data_ex;
    }
}
