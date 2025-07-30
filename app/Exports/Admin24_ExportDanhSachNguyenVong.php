<?php
namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class Admin24_ExportDanhSachNguyenVong implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings
{
    private $dotts;
    private $start;
    private $end;

    public function __construct($dotts,$start,$end)
    {
        $this->dotts = $dotts;
        $this->start = $start;
        $this->end = $end;
    }

    public function query()
    {
        $dotts = $this->dotts;
        $start = $this->start;
        $end = $this->end;

        return DB::table('24_nguyenvong as nv')
        ->selectRaw("
            @row := @row + 1 AS stt,
            nv.id_taikhoan,
            ttcn.hoten,
            ttcn.cccd,
            ng.id_major as manganh,
            ng.name_major as nganh,
            if(nv.idphuongthuc = 1,'HB','THPT') as phuongthuc,
            nv.thutu,
            gr.id_group as tohop,
            nv.diemtohop,
            nv.diemuutien,
            nv.diemxettuyen,
            if(nv.tts = 1,'x','') as tts
        ")
        ->leftJoin('24_thongtincanhan as ttcn', 'nv.id_taikhoan', '=', 'ttcn.id_taikhoan')
        ->join('l_major as ng', 'nv.idnganh', '=', 'ng.id')
        ->leftJoin('l_group as gr', 'nv.tohop', '=', 'gr.id')
        ->offset($start)
        ->limit($end)
        ->where('nv.iddot', $dotts)
        ->orderBy('nv.id') // Đảm bảo có thứ tự sắp xếp.
        ->crossJoin(DB::raw('(SELECT @row := 0) r'));
    }

    public function map($row): array
    {
        return [
            $row->stt,
            $row->id_taikhoan,
            $row->hoten,
            $row->cccd,
            $row->manganh,
            $row->nganh,
            $row->phuongthuc,
            $row->thutu,
            $row->tohop,
            $row->diemtohop,
            $row->diemuutien,
            $row->diemxettuyen,
            $row->tts,
        ];
    }

    public function headings(): array
    {
        return [
            'STT', 'ID', 'Họ tên', 'Căn cước công dân', 'Mã ngành', 'Ngành', 'Phương thức', 'TTNV', 'Tổ hợp', 'Điểm tổ hợp', 'Điểm ưu tiên', 'Điểm xét tuyển', 'Trúng tuyển sớm'
        ];
    }



//     public function registerEvents(): array
//     {
//         return [
//             AfterSheet::class => function(AfterSheet $event) {
//                 // Merge and set styles for title cell
//                 $event->sheet->setCellValue('A1', 'DANH SÁCH THÍ SINH CỦA HỆ THỐNG');
//                 $event->sheet->mergeCells('A1:M1');
//                 $event->sheet->getStyle('A1:M1')->applyFromArray([
//                     'font' => [
//                         'name' => 'Times New Roman',
//                         'bold' => true,
//                         'size' => 16,
//                         'color' => ['argb' => '000000'],
//                     ],
//                     'alignment' => [
//                         'horizontal' => Alignment::HORIZONTAL_CENTER,
//                         'vertical' => Alignment::VERTICAL_CENTER,
//                     ],
//                 ]);

//                 $event->sheet->getStyle('A1:M1')->applyFromArray([
//                     'font' => [
//                         'name' => 'Times New Roman',
//                         'size' => 13,
//                         'bold' => true,
//                         'color' => ['argb' => '000000'],
//                     ],
//                     'alignment' => [
//                         'horizontal' => Alignment::HORIZONTAL_CENTER,
//                         'vertical' => Alignment::VERTICAL_CENTER,
//                     ],
//                     'fill' => [
//                         'fillType' => Fill::FILL_SOLID,
//                         'startColor' => ['argb' => 'CCCCCC'],
//                     ],
//                     'borders' => [
//                         'outline' => [
//                             'borderStyle' => Border::BORDER_THIN,
//                         ],
//                     ],
//                 ]);

//                 $event->sheet->getPageMargins()->setTop(0.5);
//                 $event->sheet->getPageMargins()->setBottom(0.5);
//                 $event->sheet->getPageMargins()->setLeft(0.5);
//                 $event->sheet->getPageMargins()->setRight(0.5);

//                 // Set landscape orientation and fit to width for printing
//                 $event->sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
//                 $event->sheet->getPageSetup()->setFitToWidth(1);
//             },
//         ];
//     }
}
