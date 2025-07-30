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

class Admin24_ExportDanhSachLocAo implements FromCollection
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
        ->select('cccd','thutu','l_major.id_major','24_thongtincanhan.id_taikhoan')
        ->join('l_major','l_major.id','24_danhsachxettuyentheodotxt.idnganh')
        ->join('24_thongtincanhan','24_thongtincanhan.id_taikhoan','24_danhsachxettuyentheodotxt.id_taikhoan')
        ->where('iddot',$dotts)
        ->where('iddotxt',$dotxt)
        ->where('trungtuyentam',1)
        ->get();

        $data_ex = new Collection([
            ['STT','CMND','Thứ tự nguyện vọng','Mã ngành']
        ]);
        foreach ( $data as  $key => $value) {
        $a = [
                $value ->id_taikhoan,
                $value ->cccd,
                $value ->thutu,
                $value ->id_major
            ];
        $data_ex[] = $a;
        }

        return $data_ex;
    }


}
