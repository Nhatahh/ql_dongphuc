<?php
namespace App\Exports;

// use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class Admin24_ExportDanhSachPhanCong implements FromCollection
{
    private $hoten;
    private $email;
    private $kiemtra;
    private $trangthai;
    private $trangthaiduyet;
    private $trangthaikhoa;
    private $id_nam;
    public function __construct($hoten,$email,$kiemtra,$trangthaiduyet,$trangthaikhoa,$trangthai,$id_nam)
    {
        $this->hoten = $hoten;
        $this->email = $email;
        $this->kiemtra = $kiemtra;
        $this->trangthaiduyet = $trangthaiduyet;
        $this->trangthaikhoa = $trangthaikhoa;
        $this->trangthai = $trangthai;
        $this->id_nam = $id_nam;
    }

        public function collection()
    {
        $data=DB::select("SELECT ROW_NUMBER() OVER (ORDER BY id_trangthai) AS stt ,24_trangthaihoso.id_trangthai as id_trangthai,24_trangthaihoso.tentrangthai, 24_trangthaihoso.icon,24_trangthaihoso.class_small, if(nhansu.email is null,'',nhansu.email) as email_nhansu ,24_kiemtrahoso.trangthai,24_kiemtrahoso.id AS id ,24_kiemtrahoso.id_taikhoan ,thisinh.email ,24_thongtincanhan.hoten ,24_thongtincanhan.cccd as cccd,IF(24_khoadangky.trangthai IS NULL, 0,24_khoadangky.trangthai) AS trangthaidangky,24_kiemtrahoso.khoa AS trangthaikhoa,24_kiemtrahoso.duyet AS trangthaiduyet,24_kiemtrahoso.thoigiankhoa as thoigiankhoa ,24_kiemtrahoso.thoigiancapnhat as thoigiancapnhat ,24_kiemtrahoso.thoigianduyet as thoigianduyet FROM 24_kiemtrahoso JOIN (SELECT * FROM account24s) as thisinh ON 24_kiemtrahoso.id_taikhoan = thisinh.id LEFT JOIN (SELECT * FROM account24s) as nhansu ON 24_kiemtrahoso.id_nhansu = nhansu.id INNER JOIN 24_thongtincanhan ON 24_thongtincanhan.id_taikhoan = 24_kiemtrahoso.id_taikhoan LEFT JOIN 24_trangthaihoso ON 24_trangthaihoso.id_trangthai = 24_kiemtrahoso.trangthai LEFT JOIN 24_khoadangky ON 24_khoadangky.id_taikhoan = thisinh.id  INNER JOIN (SELECT DISTINCT(id_taikhoan) as id_taikhoan, idnam FROM 24_nguyenvong) AS nguyenvong  ON nguyenvong.id_taikhoan = 24_kiemtrahoso.id_taikhoan WHERE nguyenvong.idnam =  ".$this->id_nam." AND 24_thongtincanhan.hoten ".$this->hoten."  AND thisinh.email ".$this->email." AND nhansu.email ".$this->kiemtra." AND 24_kiemtrahoso.trangthai ".$this->trangthai." AND 24_kiemtrahoso.khoa ".$this->trangthaikhoa." AND 24_kiemtrahoso.duyet ".$this->trangthaiduyet);
        $data_ex = new Collection([
            ["STT",'Họ tên','Email','Người kiểm tra','Trạng thái','Trạng thái khóa','Trạng thái duyệt','Cập nhật duyệt','Cập nhật khóa','Thời gian cập nhật'],
        ]);
        foreach ($data as $key => $value) {
            switch ($value ->trangthaikhoa) {
                case 0:
                    $value ->trangthaikhoa="Chưa khóa";
                    break;
                case 1:
                    $value ->trangthaikhoa="Đã khóa";
                    break;
                default:
                    echo "xxx";
                    break;
            }
            switch ($value ->trangthaiduyet) {
                case 0:
                    $value ->trangthaiduyet="Chưa duyệt";
                    break;
                case 1:
                    $value ->trangthaiduyet="Đã duyệt";
                    break;
                default:
                    echo "xxx";
                    break;
            }
           $a = [$value ->stt, $value ->hoten, $value ->email, $value ->email_nhansu, $value ->tentrangthai , $value ->trangthaikhoa, $value ->trangthaiduyet, $value ->thoigiankhoa, $value ->thoigianduyet, $value ->thoigiancapnhat];
           $data_ex[] = $a;
        }
        return $data_ex;
    }

}
