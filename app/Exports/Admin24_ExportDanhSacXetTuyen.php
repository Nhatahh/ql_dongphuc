<?php
namespace App\Exports;

// use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class Admin24_ExportDanhSacXetTuyen implements FromCollection, ShouldAutoSize
{
    private $nguyenvong;
    public function __construct($nguyenvong)
    {
        $this->nguyenvong = $nguyenvong;
    }

        public function collection()
    {
        $data_ex = new Collection([
            ['STT','IDNV','ID Tài khoản','Họ tên thí sinh','Đối tượng','Khu vực','Phương thức','Chuyên ngành/Ngành','Thứ tự','Năm tốt nghiệp','Tổ hợp','Điểm tổ hợp','Điểm ưu tiên','Điểm xét tuyển','TTXT'],
        ]);
        foreach ( $this->nguyenvong as $key => $value) {
           $a = [$value ->sothutu,$value ->id,$value ->id_taikhoan,$value ->hoten,$value ->name_policy_user,$value ->id_priority_area,$value ->idphuongthuc,$value ->tenchuyennganh,$value ->thutu,$value ->namtotnghiep,$value ->id_group,$value ->diemtohop,$value ->diemuutien,$value ->diemxettuyen,$value ->trangthaixettuyen,];
           $data_ex[] = $a;
        }
        return $data_ex;
    }
}
