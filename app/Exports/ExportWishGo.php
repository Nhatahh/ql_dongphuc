<?php
namespace App\Exports;

// use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Concerns\FromCollection;


class ExportWishGo implements FromCollection
{

    public function collection()
    {
        $data = DB::select("SELECT l_wish.id as id,l_wish.id_user as id_user,l_major.name_major as name_major,l_wish.number as number,l_wish.mark,l_wish.group_mark, l_wish.priority_mark,CONCAT(l_group.id_group,'',l_group.name_group) as name_group, l_users.id_card_users, l_info_users.name_user, l_method.name_method as name_method FROM `l_wish` INNER JOIN l_users ON l_users.id = l_wish.id_user INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_method ON l_method_major.id_method = l_method.id INNER JOIN l_major ON l_major.id = l_method_major.id_major INNER JOIN l_group ON l_wish.id_group = l_group.id INNER JOIN l_info_users ON l_info_users.id_user = l_wish.id_user WHERE l_wish.id_user IN (SELECT id_student FROM l_check_assuser WHERE l_check_assuser.pass = 1) ORDER BY l_wish.id_user ASC, l_wish.number ASC");

        $data_ex = new Collection([
            ['ID','IDNV','CMND/TCC',"Họ tên",'Ngành','Phương thức','Nguyện vọng','Tổ hợp','Điểm ưu tiên','Điểm tổ hợp','Điểm xét tuyển'],
        ]);
        foreach ($data as $key => $value) {
           $a = [$value ->id_user,$value ->id,$value ->name_user,$value ->id_card_users,$value ->name_major,$value ->name_method,$value ->number,$value ->name_group,$value ->priority_mark,$value ->group_mark,$value ->mark];
           $data_ex[] = $a;
        }
        return $data_ex;
    }
}



