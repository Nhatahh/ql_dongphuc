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

class Admin24_ExportDanhSachTrungTuyenChinhThuc implements FromCollection, ShouldAutoSize, WithEvents
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
            ['STT','ID thí sinh','Họ tên','Mã ngành','Ngành/Chuyên ngành','Thứ tự','Ngày sinh','Giới tính','CMND/CCCD','Điện thoại','Điện thoại phụ','Điểm xét tuyển','Đợt tuyển sinh','Đợt Lọc ảo','Đã xem','XN Cổng Trường','XN Cổng Bộ','Nhập học','CCCD/CMND xác nhận','Trạng thái điều tra','Ghi chú'],
        ]);
        foreach ( $this->nguyenvong as $key => $value) {
            switch ($value ->trangthaidieutra) {
                case '1':
                   $xacnhan_dieutra = "Xác nhận";
                    break;
                case '2':
                    $xacnhan_dieutra = "Không xác nhận";
                    break;
                case '3':
                    $xacnhan_dieutra = "Phân vân";
                    break;
                case '4':
                    $xacnhan_dieutra = "Không liên lạc được";
                    break;
                case '5':
                    $xacnhan_dieutra = "Chuyển ngành";
                    break;
                default:
                    $xacnhan_dieutra = "";
                    break;
            }
            $value->daxem == 1 ? $daxem = "X" : $daxem = "";
            $value->xacnhan == 1 ? $xacnhan = "X" : $xacnhan = "";
            $value->gioitinh == 1 ? $gioitinh = "Nữ" : $gioitinh = "Nam";

           $a = [
                $value ->sothutu,
                $value ->id,
                $value ->hoten,
                $value ->machuyennganh,
                $value ->tenchuyennganh,
                $value ->thutu,
                $value ->ngaysinh,
                $gioitinh,
                $value ->cccd,
                $value ->dienthoai,
                $value ->dienthoai_phu,
                // $value ->email,
                $value ->diemxettuyen,
                $value ->iddot,
                $value ->iddotxt,
                $daxem,
                $xacnhan,
                $value ->xacnhanbo,
                $value ->mssv,
                $value ->xacnhan_cccd,
                $xacnhan_dieutra,
                $value ->ghichu_xnnh,
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
                $event->sheet->setCellValue('A1', 'DANH SÁCH TRÚNG TUYỂN CHÍNH THỨC');
                $event->sheet->mergeCells('A1:T1');
                $event->sheet->getStyle('A1:T1')->applyFromArray([
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
                $event->sheet->getStyle('A3:T3')->applyFromArray([
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
