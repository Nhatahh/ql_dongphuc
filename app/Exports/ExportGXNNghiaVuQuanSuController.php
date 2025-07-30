<?php
namespace App\Exports;

// use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Concerns\FromCollection;


class ExportInvestigateController implements FromCollection
{
    private $major;


    public function __construct($major)
    {

        $this->major = $major;
        // $this->seen = $seen;
        // $this->onl = $onl;
        // $this->off = $off;
        // $this->go = $go;
        // $this->xnnh = $xnnh;

    }

    public function collection()
    {

        $sql ='SELECT if(l_go_xanhannhaphoc.id_user is null,"Chưa xác nhận","Đã xác nhận") as check_bo, l_go_insv_admin.note as note1,if(l_go_insv_admin.active = 1,"Sẽ nhập học", if(l_go_insv_admin.active = 2, "Không nhâp học",if(l_go_insv_admin.active = 0,"Đổi trạng thái về chưa điều tra","Chưa điều tra"))) as xngo,if(PASS.check_user = 3,"Đã xác nhận","Chưa xác nhận") as xnoff, CONCAT(if(PASS.check_user = 3,1,0),"-",if(l_go_insv_admin.note is null,"",l_go_insv_admin.note),"-",l_info_users.id_user) as note, CONCAT(if(PASS.check_user = 3,1,0),"-",if(l_go_insv_admin.active is null,0,l_go_insv_admin.active),"-",l_info_users.id_user) as active, if(PASS.check_user = 3,1,0) as check_user, l_info_users.name_user, l_users.id as id_user, if(INSV.id_ins is null,"Chưa xem","Đã xem") as id_ins, l_users.id_card_users, l_users.phone_users, l_users.email_users,TT.name_major,if(TT.check_end = 1,"Đã xác nhận","Chưa xác nhận") as check_end FROM l_info_users INNER JOIN l_users ON l_users.id = l_info_users.id_user INNER JOIN (SELECT l_wish.id_user, l_major.id, l_major.name_major, l_go_batch_pass.check_end FROM l_go_batch_pass INNER JOIN l_wish ON l_go_batch_pass.id_wish = l_wish.id INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE  l_go_batch_pass.id_batch IN (SELECT l_year_active.id_batch_locao FROM l_year_active) '.$this->onl.' AND pass_bo = 1 '.$this->major.' ) AS TT ON TT.id_user = l_info_users.id_user LEFT JOIN (SELECT DISTINCT(id_user) as id_ins FROM l_go_insv)  AS INSV ON INSV.id_ins = l_info_users.id_user LEFT JOIN (SELECT * FROM l_check_assuser WHERE check_user = 3) AS PASS ON l_info_users.id_user = PASS.id_student LEFT JOIN l_go_insv_admin ON l_go_insv_admin.id_student = l_info_users.id_user  LEFT JOIN l_go_xanhannhaphoc ON l_go_xanhannhaphoc.id_user = l_info_users.id_user WHERE l_info_users.id_user '.$this->go.' '.$this->seen.' '.$this->off.' '.$this->xnnh;
        $data = DB::select($sql);

        $data_ex = new Collection([
            ['ID', 'CMND/TCC',"Họ tên",'Điện thoại','Email', 'Ngành','Đã xem','Xác nhận Onl','Xác nhận Off','Xác nhận Bộ','Thông tin điều tra','Ghi chú'],
        ]);

        foreach ($data as $key => $value) {
           $a = [$value ->id_user,$value ->id_card_users,$value ->name_user,$value ->phone_users,$value ->email_users,$value ->name_major,$value ->id_ins,$value ->check_end,$value ->xnoff,$value ->check_bo,$value ->xngo,$value ->note1];
           $data_ex[] = $a;
        }
        return $data_ex;
    }



}

