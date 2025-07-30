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

class Admin24_ExportDanhSachTrungTuyenTheoDotTS implements FromCollection, ShouldAutoSize, WithEvents
{
    private $nguyenvong;
    public function __construct($nguyenvong)
    {
        $this->nguyenvong = $nguyenvong;
    }

        public function collection()
    {
        $data_ex = new Collection([
            ['','','','','','','','','','','','',''],
            ['','','','','','','','','','','','',''],
            ['STT','Ngành/Chuyên ngành','Chỉ tiêu','Đăng ký','NV1','TLNV1','NV2','NV3','Trúng tuyển','TL trúng tuyển','XN Trường','TLXN Trường','XN Bộ','TLXN Bộ','Nhập học','TL Nhập học','SL Đồng ý/Chưa NH'],
        ]);
        foreach ( $this->nguyenvong as $key => $value) {
           $a = [
                $value ->sothutu,
                $value ->tenchuyennganh,
                $value ->chitieu,
                $value ->soluongdangky,
                $value ->soluongnv1,
                $value ->tilenv1,
                $value ->soluongnv2,
                $value ->soluongnv3,
                $value ->soluongtrungtuyen,
                $value ->tiletrungtuyen,
                // $value ->diemchuan,
                $value ->soluongxacnhan,
                $value ->tilexacnhan,
                $value ->soluongxacnhanbo,
                $value ->tilexacnhanbo,
                $value ->soluongnhaphoc,
                $value ->tilenhaphoc,
                $value ->soluongdieutra
            ];
           $data_ex[] = $a;
        }
        return $data_ex;
    }
    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Merge and set styles for title cell
                $event->sheet->setCellValue('A1', 'BẢNG THỐNG KÊ TÌNH HÌNH NHẬP HỌC');
                $event->sheet->mergeCells('A1:O1');
                $event->sheet->getStyle('A1:O1')->applyFromArray([
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
                $event->sheet->getStyle('A3:O3')->applyFromArray([
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

                // Format content rows starting from row 3 (A3:M3)
                $startRow = 3;
                $lastRow = $startRow + count($this->nguyenvong); // Calculate last row dynamically
                $lastColumn = $event->sheet->getHighestColumn();
                $dataRange = 'A' . $startRow . ':' . $lastColumn . $lastRow;
                $event->sheet->getStyle($dataRange)->applyFromArray([
                    'font' => [

                        'name' => 'Times New Roman',
                        'size' => 13, // Cỡ chữ 13pt
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                foreach (range('A', $lastColumn) as $column) {
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }

                $event->sheet->getStyle('B' . $startRow . ':' . 'B' . $lastRow)->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                    ],
                ]);

                //Bold and align right for the summary row
                $event->sheet->getStyle('C' . $lastRow . ':' . $lastColumn . $lastRow)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => '000000'],
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
