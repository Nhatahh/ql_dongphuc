<?php
namespace App\Exports;

// use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Concerns\FromCollection;


class ExportAdmissionTTSVController implements FromCollection
{
    private $elect_year,$elect_id_card,$elect_id,$elect_hktt;


    public function __construct($elect_year,$elect_id_card,$elect_id,$elect_hktt)
    {

        $this->elect_year = $elect_year;
        // $this->elect_batch = $elect_batch;
        // $this->elect_method = $elect_method;
        $this->elect_id_card = $elect_id_card;
        // $this->elect_majo = $elect_majo;
        $this->elect_id = $elect_id;
        $this->elect_hktt = $elect_hktt;
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

        // if($this->elect_batch == 0){
        //     $batch = 'WHERE l_info_users.id_batch is not null';
        // }else{
        //     $batch = 'WHERE l_info_users.id_batch  = '.$this->elect_batch;
        // }

        // if( $this->elect_method == 0){
        //     $method1 = 'AND l_method.id is not null';
        //     $method2 = 'l_wish.id_method is not null';
        // }else{
        //     $method1 = 'AND l_method.id  = '.$this->elect_method;
        //     $method2 = 'l_wish.id_method  = '.$this->elect_method;
        // }

        // if( $this->elect_majo == 0){
        //     $major = 'AND l_major.id  is not null';
        // }else{
        //     $major = 'AND l_major.id  = '.$this->elect_majo;
        // }

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

        $sql = "SELECT l_religion.tentongiao, l_info_users.doan_sv,l_info_users.dang_sv,l_info_users.address_user, l_info_users.tencha_sv,l_info_users.nghenghiepcha_sv,l_info_users.dienthoaicha_sv,l_info_users.tenme_sv,l_info_users.nghenghiepme_sv,l_info_users.dienthoaime_sv,l_info_users.noisinh_cccd, NOISINH.noisinhtinh, NOISINH.noisinhhuyen, NOISINH.noisinhxa, l_info_users.sothebhyt,l_religion.tentongiao as tongiao, l_nationality.name_nationality as quoctich, l_info_users.dow_quequan_xa as qqduoixa, QUEQUAN.qqxa as qqxa, QUEQUAN.qqhuyen as qqhuyen, QUEQUAN.qqtinh as qqtinh, l_info_users.down_province3 as hkttduoixa,  HKTT.hkttxa, HKTT.hktthuyen, HKTT.hktttinh, l_go_mssv.mssv, l_nation.name_nation, ROW_NUMBER() OVER(ORDER BY l_info_users.id_user) as stt, if(l_info_users.sex_user = 0,'Nam','Nữ') as sex_user, l_info_users.id_user, l_info_users.name_user, DATE_FORMAT(l_info_users.birth_user,'%d/%m/%Y') as birth_user, l_users.id_card_users, l_users.phone_users, l_users.email_users FROM l_info_users INNER JOIN l_go_mssv ON l_go_mssv.id_user = l_info_users.id_user INNER JOIN l_users ON l_users.id = l_info_users.id_user LEFT JOIN (SELECT l_info_users.id_user as hktt_id_user, l_province.name_province as hktttinh, l_province2.name_province2 as hktthuyen, l_province3.name_province3 as hkttxa FROM l_province INNER JOIN l_info_users ON l_province.id = l_info_users.id_khttprovince_user INNER JOIN l_province2 ON l_province2.id = l_info_users.id_khttprovince2_user INNER JOIN l_province3 ON l_province3.id = l_info_users.id_khttprovince3_user) as HKTT ON HKTT.hktt_id_user = l_info_users.id_user LEFT JOIN (SELECT l_info_users.id_user as qq_id_user, l_province.name_province as qqtinh, l_province2.name_province2 as qqhuyen, l_province3.name_province3 as qqxa FROM l_province INNER JOIN l_info_users ON l_province.id = l_info_users.quequan_tinh LEFT JOIN l_province2 ON l_province2.id = l_info_users.quequan_huyen LEFT JOIN l_province3 ON l_province3.id = l_info_users.quequan_xa) as QUEQUAN ON QUEQUAN.qq_id_user = l_info_users.id_user LEFT JOIN (SELECT l_info_users.id_user as noisinh_id_user, l_province.name_province as noisinhtinh, l_province2.name_province2 as noisinhhuyen, l_province3.name_province3 as noisinhxa FROM l_province INNER JOIN l_info_users ON l_province.id = l_info_users.id_place_user LEFT JOIN l_province2 ON l_province2.id = l_info_users.noisinh_huyen LEFT JOIN l_province3 ON l_province3.id = l_info_users.noisinh_xa) as NOISINH ON NOISINH.noisinh_id_user = l_info_users.id_user INNER JOIN l_nationality ON l_nationality.id = l_info_users.id_nationality INNER JOIN l_religion ON l_religion.id = l_info_users.id_religion INNER JOIN l_nation ON l_nation.id = l_info_users.id_nation_user ".$nvqs_id_card." ".$elect_id." ".$year." ".$hktt;
        $data = DB::select($sql);

        $data_ex = new Collection([
            ['STT','ID', 'MSSV','CMND/TCC',"Họ tên",'Ngày sinh','Giới tính','Dân tộc','Tôn giáo','Điện thoại','Email','HKTT dưới Xã/Phường','HKTT Xã/Phường','HKTT Huyện/Quận','HKTT Tỉnh/TP','Quê quán dưới Xã/Phường','Quê quán Xã/Phường','Quê quán Huyện/Quận','Quê quán Tỉnh/TP','Nơi sinh CCCD','Nơi sinh Xã/Phường','Nơi sinh Huyện/Quận','Nơi sinh Tỉnh/TP','Số thẻ BHYT','Tên cha','Nghề nghiệp cha','Số điện thoại cha','Tên mẹ','Nghề nghiệp mẹ','Số điện thoại mẹ','Ngày vào Đoàn','Ngày vào Đảng','Địa chỉ'],
        ]);

        foreach ($data as $key => $value) {
           $a = [$value ->stt,$value ->id_user,$value ->mssv,$value ->id_card_users,$value ->name_user,$value ->birth_user,$value ->sex_user,$value ->name_nation,$value ->tentongiao,$value ->phone_users,$value ->email_users,$value ->hkttduoixa,$value ->hkttxa,$value ->hktthuyen,$value ->hktttinh,$value ->qqduoixa,$value ->qqxa,$value ->qqhuyen,$value ->qqtinh,$value ->noisinh_cccd,$value ->noisinhxa,$value ->noisinhhuyen,$value ->noisinhtinh,$value ->sothebhyt,$value ->tencha_sv,$value ->nghenghiepcha_sv,$value ->dienthoaicha_sv,$value ->tenme_sv,$value ->nghenghiepme_sv,$value ->dienthoaime_sv,$value ->doan_sv,$value ->dang_sv,$value ->address_user];
           $data_ex[] = $a;
        }
        return $data_ex;
    }



}

