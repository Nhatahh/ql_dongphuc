<?php
namespace App\Exports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Admin24_DanhSachKho implements FromCollection, WithMapping, WithHeadings, WithStyles, WithEvents
{
    private $dotnhap;
    private $trangthai;
    private $loai;
    private $size;
    private $nsx;

    public function __construct($dotnhap, $trangthai, $loai,$size,$nsx)
    {
        $this->dotnhap = $dotnhap;
        $this->trangthai = $trangthai;
        $this->loai = $loai;
        $this->size = $size;
        $this->nsx = $nsx;
    }

    public function collection()
    {
        $dotnhap=$this->dotnhap;
        $trangthai=$this->trangthai;
        $loai=$this->loai;
        $size=$this->size;
        $nsx=$this->nsx;

        $ds_kho = DB::table('24_kho')
        ->select(
            DB::raw('ROW_NUMBER() OVER(ORDER BY 24_kho.id) as stt'), // Sử dụng ROW_NUMBER để tạo cột stt
            // DB::raw('SUM(24_kho.soluongton) OVER(PARTITION BY 24_kho.idsanpham) as total_soluongton'), // Tổng số lượng tồn theo idsanpham
            '24_danhmuc_size.size as size',
            '24_kho.id as id',
            '24_loaisanpham.loai as loai',
            '24_danhmuc_nhasanxuat.nhasanxuat as nsx',
            '24_kho.soluongton as slton',
            '24_kho.trangthai as trangthai',
            '24_dotnhap.dotnhap as dotnhap',
            '24_dotnhap.id as id_dotnhap'
        )
        ->join('24_danhmuc_sanpham', '24_kho.idsanpham', '=', '24_danhmuc_sanpham.id')
        ->join('24_dotnhap', '24_kho.id_dotnhap', '=', '24_dotnhap.id')
        ->join('24_loaisanpham', '24_danhmuc_sanpham.id_loai', '=', '24_loaisanpham.id')
        ->join('24_danhmuc_size', '24_danhmuc_sanpham.id_size', '=', '24_danhmuc_size.id')
        ->join('24_danhmuc_nhasanxuat', '24_danhmuc_sanpham.id_nhasanxuat', '=', '24_danhmuc_nhasanxuat.id')
        ->when($dotnhap, function ($query, $dotnhap) {
            return $query->where('24_kho.id_dotnhap', $dotnhap);
        })
        ->when(isset($trangthai) && $trangthai != -1, function ($query) use ($trangthai) {
            return $query->where('24_kho.trangthai', $trangthai);
        })
        ->when($loai, function ($query, $loai) {
            return $query->where('24_danhmuc_sanpham.id_loai', $loai);
        })
        ->when($size, function ($query, $size) {
            return $query->where('24_danhmuc_sanpham.id_size', $size);
        })
        ->when($nsx, function ($query, $nsx) {
            return $query->where('24_danhmuc_sanpham.id_nhasanxuat', $nsx);
        });
        $ds_kho = $ds_kho->get();
        $data = $ds_kho->map(function ($item, $index) {
            $item->stt = $index + 1;
            return $item;
        });
        $data_ex = new Collection();
        foreach ($data as $key => $value) {
            $a = [$value->stt, $value->loai, $value->size, $value->nsx, $value->dotnhap,$value->slton, $value->trangthai];
            $data_ex[] = $a;
        }
        return $data_ex;
    }

    public function map($row): array
    {
        return $row;
    }

    public function headings(): array
    {
        return ["STT", 'Loại', 'Size', 'Nhà sản xuất','Đợt nhập', 'Số lượng tồn','Trạng thái'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFFF00'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                // Định dạng cột B thành dạng Text
                foreach ($sheet->getColumnIterator('B', 'B') as $column) {
                    foreach ($column->getCellIterator() as $cell) {
                        $cell->setValueExplicit($cell->getValue(), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    }
                }

                // Định dạng cột L với điều kiện
                $highestRow = $sheet->getHighestRow();
                for ($row = 2; $row <= $highestRow; $row++) {
                    $cellValue = $sheet->getCell('G' . $row)->getValue();
                    // Kiểm tra nếu giá trị là số và so sánh
                    if (is_numeric($cellValue) && $cellValue == 1) {
                        $sheet->setCellValue('G' . $row, 'Đã dừng hoạt động');
                    } else {
                        $sheet->setCellValue('G' . $row, '');
                    }
                }

                // Định dạng kích thước cột
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $sheet->getColumnDimension('F')->setAutoSize(true);
                $sheet->getColumnDimension('G')->setAutoSize(true);
                $sheet->getColumnDimension('H')->setAutoSize(true);
                // Áp dụng kiểu viền cho toàn bộ sheet
                $event->sheet->getStyle('A1:L' . $highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);
            },
        ];
    }


}
