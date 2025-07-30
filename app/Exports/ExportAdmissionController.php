<?php
namespace App\Exports;

// use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Concerns\FromCollection;


class ExportAdmissionController implements FromCollection
{
    private $elect_year,$elect_batch,$elect_method,$elect_majo,$elect_id_card,$elect_id,$elect_hktt,$type_tops;


    public function __construct($elect_year,$elect_batch,$elect_method,$elect_majo,$elect_id_card,$elect_id,$elect_hktt,$type_tops)
    {

        $this->elect_year = $elect_year;
        $this->elect_batch = $elect_batch;
        $this->elect_method = $elect_method;
        $this->elect_id_card = $elect_id_card;
        $this->elect_majo = $elect_majo;
        $this->elect_id = $elect_id;
        $this->elect_hktt = $elect_hktt;
        $this->type_tops = $type_tops;
    }

    public function collection()
    {
        if($this->elect_hktt == 0){
            $hktt = 'AND l_info_users.id_khttprovince_user is not null';
        }else{
            $hktt = 'AND l_info_users.id_khttprovince_user  = '. $this->elect_hktt;
        }


        if($this->elect_year == 0){
            $year = 'AND l_users.id_year is not null';
        }else{
            $year = 'AND l_users.id_year  = '.$this->elect_year;
        }

        if($this->elect_batch == 0){
            $batch = 'AND l_info_users.id_batch is not null';
        }else{
            $batch = 'AND l_info_users.id_batch  = '.$this->elect_batch;
        }

        if( $this->elect_method == 0){
            $method1 = 'AND l_method.id is not null';
            $method2 = 'l_wish.id_method is not null';
        }else{
            $method1 = 'AND l_method.id  = '.$this->elect_method;
            $method2 = 'l_wish.id_method  = '.$this->elect_method;
        }

        if( $this->elect_majo == 0){
            $major = 'AND l_major.id  is not null';
        }else{
            $major = 'AND l_major.id  = '.$this->elect_majo;
        }

        if( $this->elect_id_card == 0 ){
            $nvqs_id_card = 'AND  l_users.id_card_users is not null';
        }else{
            $nvqs_id_card = 'AND l_users.id_card_users = "'. $this->elect_id_card.'"';
        }

        if($this->elect_id == 0 ){
            $elect_id = 'AND l_info_users.id_user is not null';
        }else{
            $elect_id = 'AND l_info_users.id_user =  "'.$this->elect_id.'"';
        }

        if( $this->type_tops == 1){

            $sql = "SELECT l_nation.name_nation, l_wish.group_mark, l_wish.priority_mark, CONCAT(l_group.id_group,'-',l_group.name_group) as name_group, l_method.name_method, ROW_NUMBER() OVER(ORDER BY l_info_users.id_user) as stt, l_wish.mark, if(l_info_users.sex_user = 0,'Nam','Nữ') as sex_user, l_info_users.id_user, l_info_users.name_user, DATE_FORMAT(l_info_users.birth_user,'%d/%m/%Y') as birth_user, l_users.id_card_users,l_users.phone_users, l_users.email_users, l_major.name_major FROM `l_wish` INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_major.id = l_method_major.id_major INNER JOIN l_users ON l_users.id = l_wish.id_user INNER JOIN l_info_users ON l_info_users.id_user = l_users.id INNER JOIN l_method ON l_method.id = l_wish.id_method INNER JOIN l_group ON l_group.id = l_wish.id_group INNER JOIN l_nation ON l_nation.id = l_info_users.id_nation_user WHERE l_wish.id IN (SELECT l_go_batch_pass.id_wish FROM l_go_batch_pass WHERE l_go_batch_pass.id_batch = 18 AND l_go_batch_pass.pass_bo = 1) AND l_wish.id_user IN (SELECT l_go_mssv.id_user FROM l_go_mssv)".$batch." ".$major." ".$nvqs_id_card." ".$elect_id." ".$year." ".$method1." ".$hktt." ORDER BY l_wish.mark DESC";
            $data = DB::select($sql);
        }else{
            $sql = "SELECT l_nation.name_nation, l_wish.group_mark, l_wish.priority_mark, CONCAT(l_group.id_group,'-',l_group.name_group) as name_group, l_method.name_method, ROW_NUMBER() OVER(ORDER BY l_info_users.id_user) as stt, l_wish.mark, if(l_info_users.sex_user = 0,'Nam','Nữ') as sex_user, l_info_users.id_user, l_info_users.name_user, DATE_FORMAT(l_info_users.birth_user,'%d/%m/%Y') as birth_user, l_users.id_card_users,l_users.phone_users, l_users.email_users, l_major.name_major FROM `l_wish` INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_major.id = l_method_major.id_major INNER JOIN l_users ON l_users.id = l_wish.id_user INNER JOIN l_info_users ON l_info_users.id_user = l_users.id INNER JOIN l_method ON l_method.id = l_wish.id_method INNER JOIN l_group ON l_group.id = l_wish.id_group INNER JOIN l_nation ON l_nation.id = l_info_users.id_nation_user INNER JOIN (SELECT * FROM l_go_mssv INNER JOIN (SELECT l_wish.id_user as id_user1, l_major.id as id1 FROM l_go_batch_pass INNER JOIN l_wish ON l_wish.id = l_go_batch_pass.id_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_go_batch_pass.id_batch = 18 AND l_go_batch_pass.pass_bo = 1) AS TT ON TT.id_user1 = l_go_mssv.id_user) AS NH ON l_wish.id_user = NH.id_user1 AND l_major.id = NH.id1 WHERE ".$method2." ".$batch." ".$major." ".$nvqs_id_card." ".$elect_id." ".$year." ".$hktt." ORDER BY l_wish.mark DESC";
            $data = DB::select($sql);
        }

        $data_ex = new Collection([
            ['STT','ID', 'MSSV','CMND/TCC',"Họ tên",'Ngày sinh','Giới tính','Dân tộc','Điện thoại','Email','HKTT dưới Xã/Phường','HKTT Xã/Phường','HKTT Huyện/Quận','HKTT Tỉnh/TP','Phương thức', 'Ngành','Tổ hợp','Điểm tổ hợp','Điểm ưu tiên','Điểm xét tuyển'],
        ]);

        foreach ($data as $key => $value) {
           $a = [$value ->stt,$value ->id_user,$value ->mssv,$value ->id_card_users,$value ->name_user,$value ->birth_user,$value ->sex_user,$value ->name_nation,$value ->phone_users,$value ->email_users,$value ->hkttduoixa,$value ->hkttxa,$value ->hktthuyen,$value ->hktttinh,$value ->qqduoixa,$value ->qqxa,$value ->qqhuyen,$value ->qqtinh,$value ->name_method,$value ->name_major,$value ->name_group,$value ->group_mark,$value ->priority_mark,$value ->mark];
           $data_ex[] = $a;
        }
        return $data_ex;
    }

}

