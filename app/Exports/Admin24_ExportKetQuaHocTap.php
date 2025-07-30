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

class Admin24_ExportKetQuaHocTap implements FromCollection, ShouldAutoSize, WithEvents
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

        public function collection()
    {
        $dotts = $this->dotts;
        $start = $this->start;
        $end = $this->end;
        // do {
            $sql = "SELECT
            ROW_NUMBER() OVER (ORDER BY acc.id) AS thutu,
            acc.id AS id_taikhoan,
            ttcn.hoten,
            ttcn.cccd AS cccd,
            mh.lop as lop,
            mh.hocki as hocki,
            mh.mon as mon,
            mh.diem as diem
            FROM
                account24s acc
            LEFT JOIN 24_thongtincanhan ttcn  ON  acc.id = ttcn.id_taikhoan
            LEFT JOIN
                (SELECT kqht.id_student_result as id_taikhoan, id_class_result as lop, id_semester_result as hocki, mark_result as diem, l_subject.id as id, l_subject.name_subject as mon FROM 24_ketquahoctap kqht INNER JOIN l_subject  ON  l_subject.id = kqht.id_subject) as mh
            ON acc.id = mh.id_taikhoan
            WHERE
                acc.cccd_bo IS NOT NULL AND acc.id IN (SELECT DISTINCT(id_taikhoan) as id FROM 24_nguyenvong WHERE iddot = ? AND acc.id >= ? AND acc.id <= ?
                )";
            $data = DB::select($sql,[$dotts,$start,$end]);
            $data_ex = new Collection([
                ['','','','','','','',''],
                ['','','','','','','',''],
                ['STT','ID','Họ tên','Căn cước công dân','Lớp','Học kì','Môn','Điểm']
            ]);
            foreach ( $data as  $key => $value) {
            $a = [
                    $value ->thutu,
                    $value ->id_taikhoan,
                    $value ->hoten,
                    $value ->cccd,
                    $value ->lop,
                    $value ->hocki,
                    $value ->mon,
                    $value ->diem,
                ];
            $data_ex[] = $a;
            }
            return $data_ex;
        // }while (count($data) > 0);
    }
    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Merge and set styles for title cell
                $event->sheet->setCellValue('A1', 'DANH SÁCH THÍ SINH CỦA HỆ THỐNG');
                $event->sheet->mergeCells('A1:H1');
                $event->sheet->getStyle('A1:H1')->applyFromArray([
                    'font' => [
                        'name' => 'Times New Roman',
                        'bold' => true,
                        'size' => 16,
                        'color' => ['argb' => '000000'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $event->sheet->getStyle('A3:H3')->applyFromArray([
                    'font' => [
                        'name' => 'Times New Roman',
                        'size' => 13,
                        'bold' => true,
                        'color' => ['argb' => '000000'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'CCCCCC'],
                    ],
                    'borders' => [
                        'outline' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);
                $event->sheet->getPageMargins()->setTop(0.5);
                $event->sheet->getPageMargins()->setBottom(0.5);
                $event->sheet->getPageMargins()->setLeft(0.5);
                $event->sheet->getPageMargins()->setRight(0.5);
                // Set landscape orientation and fit to width for printing
                $event->sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
                $event->sheet->getPageSetup()->setFitToWidth(1);
            },
        ];
    }
}
