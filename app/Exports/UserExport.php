<?php
namespace App\Exports;

// use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UserExport implements FromCollection
// class UserExport implements WithMultipleSheets

{
    private $batch;

    public function __construct(int $batch)
    {
        $this->batch = $batch;

    }

    public function collection()
    {
        $data = DB::select('SELECT l_users.id_card_users, l_users.phone_users, l_users.email_users,result.id_user, l_info_users.phonesc_user, if(l_info_users.emailsc_user is null,"",l_info_users.emailsc_user) as emailsc_user, l_info_users.name_user, DATE_FORMAT(l_info_users.birth_user,"%d/%m/%Y") as birth_user, if(l_info_users.sex_user = 1,"Nữ","Nam") as sex_user, l_info_users.graduation_year_user, if(l_priority_area.id_priority_area is null,"",l_priority_area.id_priority_area) as id_priority_area, if(policy.name_policy_user is null,"",policy.name_policy_user) as name_policy_user , l_major.name_major, l_method.name_method, result.number,l_group.id_group, result.group_mark, result.mark, result.priority_mark, l_go_setup.mark_basic FROM (SELECT l_go.id_wish as id_wish, l_wish.id_user, l_wish.id_group, l_wish.id_method, l_wish.number, l_wish.group_mark, l_wish.priority_mark, l_wish.mark,l_wish.id_major FROM `l_go` INNER JOIN l_wish ON l_wish.id = l_go.id_wish WHERE l_wish.id_batch = '.$this->batch.') AS result INNER JOIN l_info_users ON l_info_users.id_user = result.id_user INNER JOIN l_method_major ON l_method_major.id = result.id_major INNER JOIN l_major ON l_major.id = l_method_major.id_major INNER JOIN l_method ON l_method.id = result.id_method INNER JOIN l_group ON l_group.id = result.id_group LEFT JOIN l_priority_area ON l_priority_area.id = l_info_users.id_priority_area_user INNER JOIN l_go_setup ON l_go_setup.id_major = l_method_major.id LEFT JOIN (SELECT l_policy_users_reg.id_user,l_policy_users.name_policy_user FROM l_policy_users_reg INNER JOIN l_policy_users ON l_policy_users.id = l_policy_users_reg.id_policy_users) AS policy ON result.id_user = policy.id_user INNER JOIN l_users ON l_users.id = result.id_user');

        $data_ex = new Collection([
            ['ID', "Họ tên",'CMND/TCC','Ngày sinh','Giới tính','Điện thoại','Điện thoại 2','Email','Email 2','Năm TN','Khu vực ưu tiên','Đối tượng ưu tiên','Ngành trúng tuyển','Phương thức','Thứ tự NV','Tổ hợp','Điểm tổ hợp','Điểm ưu tiên','Điểm xét tuyển','Điểm chuẩn'],
        ]);
        foreach ($data as $key => $value) {
           $a = [$value ->id_user,$value ->name_user,$value ->id_card_users,$value ->birth_user,$value ->sex_user,$value ->phone_users,$value ->phonesc_user,$value ->email_users,$value ->emailsc_user,$value ->graduation_year_user,$value ->id_priority_area,$value ->name_policy_user,$value ->name_major,$value ->name_method,$value ->number,$value ->id_group,$value ->group_mark,$value ->priority_mark,$value ->mark,$value ->mark_basic];
           $data_ex[] = $a;
        }
        return $data_ex;
    }
}



