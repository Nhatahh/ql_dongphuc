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

class Admin24_ExportThongKeSoLuongTrungTuyen implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings
{
    private $dotxt;
    private $dotts;

    public function __construct($dotxt,$dotts)
    {
        $this->dotxt = $dotxt;
        $this->dotts = $dotts;
    }

    public function query()
    {
        $dotxt = $this->dotxt;
        $dotts = $this->dotts;
       return DB::table('24_chuyennganh_dotxettuyen')
        ->join('24_chuyennganh', '24_chuyennganh.id', '=', '24_chuyennganh_dotxettuyen.id_chuyennganh')
        ->join('l_major', 'l_major.id', '=', '24_chuyennganh_dotxettuyen.id_nganh')
        ->join('24_chuyennganh_xettuyen', '24_chuyennganh_xettuyen.id', '=', '24_chuyennganh_dotxettuyen.id_nganh_dotxt')
        ->selectRaw('
            @rownum := @rownum + 1 AS stt,
            id_major AS manganh,
            name_major AS nganh,
            id_major AS machuyennganh,
            24_chuyennganh.tenchuyennganh AS chuyennganh,
            24_chuyennganh_xettuyen.soluong_chuyennganh AS chitieuchuyennganh,
            24_chuyennganh_xettuyen.soluong_nganh AS chitieunganh,
            24_chuyennganh_dotxettuyen.diemlocaohocba AS diemlocaohocba,
            24_chuyennganh_dotxettuyen.diemchuanhocba AS diemchuanhocba,
            24_chuyennganh_dotxettuyen.trungtuyenhocba AS trungtuyenhocba,
            24_chuyennganh_dotxettuyen.trungtuyensom AS trungtuyensom,
            24_chuyennganh_dotxettuyen.diemlocaothpt AS diemlocaothpt,
            24_chuyennganh_dotxettuyen.trungtuyenthpt AS trungtuyenthpt,
            24_chuyennganh_dotxettuyen.diemchuanthpt AS diemchuanthpt,
            24_chuyennganh_dotxettuyen.tong AS tong,
            IF(24_chuyennganh_xettuyen.soluong_nganh = 0, 0, ROUND(24_chuyennganh_dotxettuyen.tong/24_chuyennganh_xettuyen.soluong_nganh*100, 2)) AS tiletruong,
            24_chuyennganh_dotxettuyen.trungtuyennhom AS trungtuyennhom,
            IF(24_chuyennganh_xettuyen.soluong_nganh = 0, 0, ROUND(24_chuyennganh_dotxettuyen.trungtuyennhom/24_chuyennganh_xettuyen.soluong_nganh*100, 2)) AS tilenhom,
            24_chuyennganh_dotxettuyen.trungtuyenbo AS trungtuyenbo,
            IF(24_chuyennganh_xettuyen.soluong_nganh = 0, 0, ROUND(24_chuyennganh_dotxettuyen.trungtuyenbo/24_chuyennganh_xettuyen.soluong_nganh*100, 2)) AS tilenbo
        ')
        ->where('24_chuyennganh_dotxettuyen.iddot', '=', $dotts)
        ->where('24_chuyennganh_dotxettuyen.iddotxt', '=', $dotxt)
        ->orderBy('24_chuyennganh_xettuyen.id') // Đảm bảo có thứ tự sắp xếp.
        ->crossJoin(DB::raw('(SELECT @rownum := 0) AS r'));
    }

    public function map($value): array
    {
        return [
            $value ->stt,
            $value ->manganh,
            $value ->nganh,
            $value ->chitieunganh,

            $value ->machuyennganh,
            $value ->chuyennganh,
            $value ->chitieuchuyennganh,

            $value ->diemchuanhocba,
            $value ->trungtuyenhocba,
            $value ->trungtuyensom,

            $value ->diemchuanthpt,
            $value ->trungtuyenthpt,

            $value ->tong,
            $value ->tiletruong,
            $value ->trungtuyennhom,
            $value ->tilenhom,
            $value ->trungtuyenbo,
            $value ->tilenbo,
        ];
    }

    public function headings(): array
    {
        return [
            ['STT','Mã ngành','Ngành','CT Ngành','Chuyên ngành','Mã chuyên ngành','CT Chuyên ngành','Điểm chuẩn HB','SL Học bạ','SL TTSớm','Điểm chuẩn THPT','SL THPT','TT Trường','TLTT Trường','TT Nhóm','TLTT Nhóm','TT Bộ','TLTT Bộ']
        ];
    }
}
