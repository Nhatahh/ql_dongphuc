<?php
namespace App\Exports;

// use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\GoController;
use Maatwebsite\Excel\Concerns\FromCollection;



class DanhSachHSSV implements FromCollection
{
    private $batch,$start,$end,$user;

    public function __construct($batch,$start,$end,$user)
    {
        $this->batch = $batch;
        $this->start = $start;
        $this->end = $end;
        $this->user = $user;

    }


    public function collection()
    {
        $batch =  $this->batch;
        $start =  $this->start;
        $end =  $this->end;
        $user =  $this->user;
        if(($start == 0 && $end != 0) || ($start != 0 && $end == 0)){
            return -1;
        }else{
            if($start == 0 && $end == 0){
                $day = '';
            }else{
                $day = "AND update_at >=  STR_TO_DATE('".$start." 00:00:00', '%Y-%m-%d %H:%i:%s') AND update_at <=  STR_TO_DATE( '".$end." 23:59:59', '%Y-%m-%d %H:%i:%s')";
            }
            if($user == 0){
                $user =  "WHERE id_admin is not null";
            }else{
                $user = "WHERE id_admin = ".$user;
            }
            $files = DB::select('SELECT * FROM l_file_list_hssv WHERE l_file_list_hssv.id_year IN (SELECT l_year_batch.id_year FROM l_year_batch WHERE l_year_batch.id_batch = '.$batch.')');
            $sql = "SELECT l_info_users.graduation_year_user as 'Năm TN', l_info_users.name_user as 'Họ và tên', DATE_FORMAT(l_info_users.birth_user,'%d/%m/%Y') as 'Ngày sinh' ,l_users.id_card_users as 'CMND/CCCD', l_users.phone_users as 'Điện thoại', HS.*, if(l_go_mssv.mssv is null, '', l_go_mssv.mssv)  as MSSV FROM l_users INNER JOIN l_info_users ON l_info_users.id_user = l_users.id INNER JOIN  (SELECT id_user as IDXT,";
            $i = 1;
            foreach ($files as $key => $value) {
                if($i == count($files)){
                    $sql .= "IF(COUNT(CASE WHEN l_file_list_student_hssv.id_file = ".$value->id." AND l_file_list_student_hssv.active = 1 THEN l_file_list_student_hssv.id_file ELSE NULL END) >0,'x','') AS '".$value->id_file."' ";
                }else{
                    $sql .= "IF(COUNT(CASE WHEN l_file_list_student_hssv.id_file = ".$value->id." AND l_file_list_student_hssv.active = 1 THEN l_file_list_student_hssv.id_file ELSE NULL END) >0,'x','') AS '".$value->id_file."', ";
                }
                $i++;
            }

            $sql .= " ,DATE_FORMAT(MAX(update_at),'%d/%m/%Y') as 'Ngày thu' FROM l_file_list_student_hssv ".$user." ".$day."  GROUP BY l_file_list_student_hssv.id_user) AS HS ON HS.IDXT = l_info_users.id_user INNER JOIN l_go_mssv ON l_go_mssv.id_user = HS.IDXT WHERE l_users.id_batch = " .$batch;
            $data = DB::select($sql);
        }


        $title[0] =  "STT";
        $i = 1;
        foreach ($data[0] as $key => $value) {
            $title[$i] =  $key;
            $i++;
        }
        $data_ex = new Collection([
            $title
        ]);
        $k=1;
        for($i = 0; $i <count($data); $i++){
            $j=1;

            foreach ($data[$i] as $key => $value) {
                $data1[0] = $k;
                $data1[$j] = $value;
                $j++;

            }
            $data_ex[] = $data1;
            $data1 = [];
            $k++;
        }
        // foreach ($data as $key => $value) {
        //    $a = [$value ->id_user,$value ->id_card_users,$value ->name_user,$value ->id_method,$value ->id_major,$value ->name_major,$value ->number_bo,$value ->number,$value ->id_group,$value ->group_mark,$value ->priority_mark,$value ->mark,$value ->tts1];
        //    $data_ex[] = $a;
        // }
        return $data_ex;
    }
}
