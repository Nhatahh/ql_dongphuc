<?php
namespace App\Exports;

// use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\GoController;
use Maatwebsite\Excel\Concerns\FromCollection;



class GoDataList implements FromCollection
{
    private $active,$year,$id_batch;

    public function __construct(int $active,$year,$id_batch)
    {
        $this->active = $active;
        // $this->data = $data;
        $this->year = $year;
        $this->id_batch = $id_batch;
    }

    public function collection()
    {
        $data = DB::table('l_users')
        ->select('l_users.id as id','id_card_users','name_user','birth_user','phone_users','email_users','course','sex_user','graduation_year_user','id_priority_area','name_policy_user')
        ->join('l_years','l_years.id','l_users.id_year')
        ->leftJoin('l_info_users','l_info_users.id_user','l_users.id')
        ->leftJoin('l_priority_area','l_priority_area.id','l_info_users.id_priority_area_user')
        ->leftJoin('l_policy_users_reg','l_policy_users_reg.id_user','l_users.id')
        ->leftJoin('l_policy_users','l_policy_users.id','l_policy_users_reg.id_policy_users')

        ->where('l_users.id_batch',$this->id_batch)
        ->where('id_year', $this->year)
        ->where('id_year', $this->active)
        ->get();

        // $data = DB::select("SELECT l_wish.id as id,l_wish.id_user as id_user,l_major.name_major as name_major,l_wish.number as number,l_wish.mark,l_wish.group_mark, l_wish.priority_mark,CONCAT(l_group.id_group,'',l_group.name_group) as name_group, l_users.id_card_users, l_info_users.name_user, l_method.name_method as name_method FROM `l_wish` INNER JOIN l_users ON l_users.id = l_wish.id_user INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_method ON l_method_major.id_method = l_method.id INNER JOIN l_major ON l_major.id = l_method_major.id_major INNER JOIN l_group ON l_wish.id_group = l_group.id INNER JOIN l_info_users ON l_info_users.id_user = l_wish.id_user WHERE l_wish.id_user IN (SELECT id_student FROM l_check_assuser WHERE l_check_assuser.pass = 1) ORDER BY l_wish.id_user ASC, l_wish.number ASC");

        $data_ex = new Collection([
            ['ID','CMND/TCC',"Họ tên",'Ngày sinh','Giới tính','Điện thoại','Email','Năm tuyển sinh','Khu vực','Đối tượng','Năm tốt nghiệp'],
        ]);

        foreach ($data as $key => $value) {
           $a = [$value ->id,$value ->id_card_users,$value ->name_user,$value ->birth_user,$value ->sex_user,$value ->phone_users,$value ->email_users,$value ->course,$value ->id_priority_area,$value ->name_policy_user,$value ->graduation_year_user];
           $data_ex[] = $a;
        }
        return $data_ex;
    }
}
