<?php
namespace App\Exports;

// use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class Admin24_DanhSachChiTietTheoDot implements FromCollection
{
    private $dotxt;
    private $dotts;

    public function __construct($dotxt,$dotts)
    {
        $this->dotxt = $dotxt;
        $this->dotts = $dotts;
    }

        public function collection()
    {

        $dotxt = $this->dotxt;
        $dotts = $this->dotts;

        $data = DB::table('24_danhsachxettuyentheodotxt')
        ->select(DB::raw('DATE_FORMAT(ngaysinh, "%d/%m/%Y") as ngaysinh'),DB::raw('if(idphuongthuc = 1,"200","100") as phuongthuc'),'cccd','hoten','thutu','l_major.id_major','24_thongtincanhan.id_taikhoan','l_major.name_major','24_chuyennganh.tenchuyennganh','l_group.id_group','diemxettuyen','diemuutien','diemtohop',DB::raw('if(trungtuyentam = 1,"Đỗ","") as trungtuyentam'),DB::raw('if(trungtuyennhom = 1,"Đỗ","") as trungtuyennhom'),DB::raw('if(trungtuyenbo = 1,"Đỗ","") as trungtuyenbo'),DB::raw('if(ttsom = 1,"Đỗ","") as ttsom'))
        ->join('l_major','l_major.id','24_danhsachxettuyentheodotxt.idnganh')
        ->join('24_chuyennganh','24_danhsachxettuyentheodotxt.id_chuyennganh','24_chuyennganh.id')
        ->join('24_thongtincanhan','24_thongtincanhan.id_taikhoan','24_danhsachxettuyentheodotxt.id_taikhoan')
        ->join('l_group','24_danhsachxettuyentheodotxt.tohop','l_group.id')
        ->where('iddot',$dotts)
        ->where('iddotxt',$dotxt)
        ->where('trungtuyentam',1)
        ->get();

        $data_ex = new Collection([
            ['STT','CMND','Họ và tên','Ngày sinh','Thứ tự nguyện vọng','Mã ngành','Tên Ngành','Mã chuyên ngành','Tên chuyên ngành','Phương thức','Tổ hợp','Điểm Tổ hợp','Điểm Ưu tiên','Điểm xét tuyển','Trường','Nhóm','Bộ','Ghi chú']
        ]);
        foreach ( $data as  $key => $value) {
        $a = [
                $value ->id_taikhoan,
                $value ->cccd,
                $value ->hoten,
                $value ->ngaysinh,
                $value ->thutu,
                $value ->id_major,
                $value ->name_major,
                $value ->id_major,
                $value ->tenchuyennganh,
                $value ->phuongthuc,
                $value ->id_group,
                $value ->diemtohop,
                $value ->diemuutien,
                $value ->diemxettuyen,
                $value ->trungtuyentam,
                $value ->trungtuyennhom,
                $value ->trungtuyenbo,
                $value ->ttsom,
            ];
        $data_ex[] = $a;
        }
        return $data_ex;
    }


}
