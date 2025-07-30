<?php
namespace App\Exports;

// use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpParser\Node\Stmt\Return_;

class Admin24_Dsts_Excel implements FromCollection
{

    private $namts;
    private $dotts;
    private $namtn;
    private $tinh;
    private $truong;
    private $ngaydangky1;
    private $ngaydangky2;
    private $gioitinh;


    public function __construct($namts,$dotts,$namtn,$tinh,$truong,$ngaydangky1,$ngaydangky2,$gioitinh)
    {
        $this->namts = $namts;
        $this->dotts = $dotts;
        $this->namtn =  $namtn;
        $this->tinh =  $tinh;
        $this->truong = $truong;
        $this->ngaydangky1 =  $ngaydangky1;
        $this->ngaydangky2 =  $ngaydangky2;
        $this->gioitinh =  $gioitinh;
    }

    public function collection()
    {
        $namts = $this->namts;
        $dotts = $this->dotts;
        $namtn = $this->namtn;
        $tinh = $this->tinh;
        $truong = $this->truong;
        $ngaydangky1 = $this->ngaydangky1;
        $ngaydangky2 = $this->ngaydangky2;
        $gioitinh = $this->gioitinh;
        $data = DB::table('24_thongtincanhan')
        ->select(
            '24_namtotnghiep.namtotnghiep',
            '24_thongtincanhan.id_taikhoan',
            '24_thongtincanhan.cccd',
            '24_thongtincanhan.hoten',
            '24_thongtincanhan.ngaysinh',
            '24_thongtincanhan.gioitinh',
            'l_province.name_province',
            'l_school.name_school',
            DB::raw('ROW_NUMBER() OVER (ORDER BY 24_thongtincanhan.id_taikhoan) AS stt'),
            '24_thongtincanhan.create_at as create_at'
        )
        ->join('24_namtotnghiep', '24_thongtincanhan.id_taikhoan', '24_namtotnghiep.id_taikhoan')
        ->join(DB::raw('(SELECT * FROM 24_truongthpt WHERE id_lop = 12) AS truong'), '24_thongtincanhan.id_taikhoan', 'truong.id_taikhoan')
        ->join('l_province', 'l_province.id', '=', 'truong.id_tinh')
        ->join('l_school', 'l_school.id', '=', 'truong.id_truong')
        ->whereIn('24_thongtincanhan.id_taikhoan', function($query) use ($namts) {
            $query->select('id_taikhoan')
            ->from('24_nguyenvong')
            ->where(function($query1) use ($namts) {
                if ($namts == 0) {
                    $query1->whereNotNull('24_nguyenvong.idnam');
                } else {
                    $query1->where('24_nguyenvong.idnam', $namts);
                }
            });
        })
        ->whereIn('24_thongtincanhan.id_taikhoan', function($query) use ($dotts) {
            $query->select('id_taikhoan')
            ->from('24_nguyenvong')
            ->where(function($query1) use ($dotts) {
                if ($dotts == 0) {
                    $query1->whereNotNull('24_nguyenvong.iddot');
                } else {
                    $query1->where('24_nguyenvong.iddot', $dotts);
                }
            });
        })
        ->where(function($query) use ($namtn) {
            if ($namtn == 0) {
                $query->whereNotNull('24_namtotnghiep.namtotnghiep');
            } else {
                $query->where('24_namtotnghiep.namtotnghiep', $namtn);
            }
        })
        ->where(function($query) use ($tinh) {
            if ($tinh != 0) {
                $query->where('truong.id_tinh', $tinh);
            }
        })
        ->where(function($query) use ($truong) {
            if ($truong != 0) {
                $query->where('truong.id_truong', $truong);
            }
        })
        ->where(function($query) use ($ngaydangky1,$ngaydangky2) {
            if ($ngaydangky1 == 0 || $ngaydangky2 == 0) {
                $query->whereNotNull('24_thongtincanhan.id_taikhoan');
            } else {
                $query->whereBetween('24_thongtincanhan.create_at', [Carbon::createFromFormat('Y-m-d', $ngaydangky1)->startOfDay(),Carbon::createFromFormat('Y-m-d', $ngaydangky2)->endOfDay()]);
            }
        })
        ->where(function($query) use ($gioitinh) {
            if ($gioitinh == -1) {
                $query->whereNotNull('24_thongtincanhan.gioitinh');
            } else {
                $query->where('24_thongtincanhan.gioitinh', $gioitinh);
            }
        })
        ->get();

        $data_table = new Collection([
              ['STT','IDTS','CCCD','Họ tên','Ngày sinh','Giơi tính','Tỉnh','Trương THPT','Năm tốt nghiệp','Ngày tạo']
        ]);

        foreach ($data as $key => $value) {
            $value ->gioitinh == 1 ? $gioitinh = "Nũ" : $gioitinh = "Nam";
            $a = [
                $value ->stt,
                $value ->id_taikhoan,
                $value ->cccd,
                $value ->hoten,

                $value ->ngaysinh,
                $gioitinh,
                $value ->name_province,

                $value ->name_school,
                $value ->namtotnghiep,
                $value ->create_at,
            ];
            $data_table[] = $a;
         }

        return $data_table;
    }


}
