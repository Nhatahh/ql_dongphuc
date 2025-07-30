<?php
namespace App\Exports;

// use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\GoController;
use Maatwebsite\Excel\Concerns\FromCollection;



class GoPassTT implements FromCollection
{
    private $id_batch_ts,$id_batch;

    public function __construct(int $id_batch_ts,$id_batch)
    {
        $this->id_batch_ts = $id_batch_ts;
        $this->id_batch = $id_batch;

    }

    public function collection()
    {
        $data = DB::select("SELECT l_wish.id_method as id_method, l_users.id as id, l_info_users.name_user, l_users.id_card_users as id_card_users, DATE_FORMAT(l_info_users.birth_user,'%d/%m/%Y') as birth_user, if(l_info_users.sex_user = 0,'Nữ','Nam') as sex_user, l_users.email_users, l_users.phone_users, po.name_policy_user, l_priority_area.name_priority_area, l_major.id_major as id_major, l_major.name_major, l_wish.number_bo as number_bo, l_wish.number,l_group.id_group, l_group.name_group, l_wish.group_mark, l_wish.priority_mark, l_wish.mark, if(l_wish.tts = 1,'x','') as tts FROM `l_go_batch_pass` INNER JOIN l_wish ON l_wish.id = l_go_batch_pass.id_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_major.id = l_method_major.id_major INNER JOIN l_group ON l_group.id =l_wish.id_group INNER JOIN l_users ON l_users.id = l_wish.id_user INNER JOIN l_info_users ON l_info_users.id_user = l_users.id LEFT JOIN l_priority_area ON l_priority_area.id = l_info_users.id_priority_area_user LEFT JOIN (SELECT l_policy_users_reg.id_user, l_policy_users.name_policy_user FROM l_policy_users_reg INNER JOIN l_policy_users ON l_policy_users_reg.id_policy_users = l_policy_users.id) AS po ON po.id_user = l_info_users.id_user WHERE l_go_batch_pass.id_batch_ts = ".$this ->id_batch_ts."  AND l_go_batch_pass.id_batch = ".$this ->id_batch);

        $data_ex = new Collection([
            ['STT','Họ và tên',"CMND/TCC",'Ngày sinh','Giới tính','Email','Điện thoại','Đối tượng','Khu vực','Mã ngành','Tên ngành','Nguyện vọng Bộ','Nguyện vọng Trường','Tổ hợp','Môn tổ hợp','Điểm tổ hợp','Điểm ưu tiên','Điểm xét tuyển','Trúng tuyển sớm','Phương thức'],
        ]);

        foreach ($data as $key => $value) {
           $a = [$value ->id,$value ->name_user,$value ->id_card_users,$value ->birth_user,$value ->sex_user,$value ->email_users,$value ->phone_users,$value ->name_policy_user,$value ->name_priority_area,$value ->id_major,$value ->name_major,$value ->number_bo,$value ->number,$value ->id_group,$value ->name_group,$value ->group_mark,$value ->priority_mark,$value ->mark,$value ->tts,$value ->id_method];
           $data_ex[] = $a;
        }
        return $data_ex;
    }
}
