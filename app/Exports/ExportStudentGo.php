<?php
namespace App\Exports;

// use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Concerns\FromCollection;


class ExportStudentGo implements FromCollection
{

    public function collection()
    {
        $data = DB::select('SELECT l_info_users.phonesc_user, if(l_info_users.emailsc_user is null,"",l_info_users.emailsc_user) as emailsc_user, l_info_users.name_user, DATE_FORMAT(l_info_users.birth_user,"%d/%m/%Y") as birth_user, if(l_info_users.sex_user = 1,"Nữ","Nam") as sex_user, l_info_users.graduation_year_user, if(l_priority_area.id_priority_area is null,"",l_priority_area.id_priority_area) as id_priority_area, if(policy.name_policy_user is null,"",policy.name_policy_user) as name_policy_user,l_users.id as id, l_users.id_card_users as id_card_users, l_users.email_users as email_users,l_users.phone_users as phone_users  FROM l_info_users INNER JOIN l_users ON l_users.id = l_info_users.id_user LEFT JOIN l_priority_area ON l_priority_area.id = l_info_users.id_priority_area_user LEFT JOIN (SELECT l_policy_users_reg.id_user as id_user, l_policy_users.name_policy_user as name_policy_user FROM l_policy_users_reg INNER JOIN l_policy_users ON l_policy_users_reg.id_policy_users = l_policy_users.id) as policy ON policy.id_user = l_info_users.id_user INNER JOIN l_check_assuser ON l_check_assuser.id_student = l_info_users.id_user WHERE pass = 1');

        $data_ex = new Collection([
            ['ID', "Họ tên",'CMND/TCC','Ngày sinh','Giới tính','Điện thoại','Điện thoại 2','Email','Email 2','Năm TN','Khu vực ưu tiên','Đối tượng ưu tiên'],
        ]);
        foreach ($data as $key => $value) {
           $a = [$value ->id,$value ->name_user,$value ->id_card_users,$value ->birth_user,$value ->sex_user,$value ->phone_users,$value ->phonesc_user,$value ->email_users,$value ->emailsc_user,$value ->graduation_year_user,$value ->id_priority_area,$value ->name_policy_user];
           $data_ex[] = $a;
        }
        return $data_ex;
    }
}



