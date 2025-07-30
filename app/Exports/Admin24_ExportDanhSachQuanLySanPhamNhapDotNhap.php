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

class Admin24_ExportDanhSachQuanLySanPhamNhapDotNhap implements FromCollection, WithMapping, WithHeadings, WithStyles, WithEvents
{
    private $id_dotnhap;

    public function __construct($id_dotnhap)
    {
        $this->id_dotnhap = $id_dotnhap;
    }

    public function collection()
    {
        $ds_sanpham_dot = DB::table('24_kiemtranhap')
        ->select(
            '24_kiemtranhap.id as id',
            '24_kiemtranhap.soluongnhap as soluongnhap',
            '24_kiemtranhap.id_dot_sanpham as id_dot_sanpham',
            '24_dotnhap_sanpham.id_sanpham as id_sanpham',
            '24_dotnhap_sanpham.id_dotnhap as id_dotnhap',
            '24_dotnhap.dotnhap as tendot',
            '24_loaisanpham.loai as loai',
            '24_danhmuc_size.size as size',
            '24_danhmuc_nhasanxuat.nhasanxuat as nhasanxuat',
            '24_kiemtranhap.ngaynhap as ngaynhap',
            '24_danhmuc_sanpham.thongso as thongso',
            '24_accountsadmin.dienthoai as dienthoai'
        )
        ->where('24_dotnhap_sanpham.id_dotnhap', '=', $this->id_dotnhap)
        ->join('24_dotnhap_sanpham','24_dotnhap_sanpham.id', '=', '24_kiemtranhap.id_dot_sanpham' )
        ->join('24_danhmuc_sanpham', '24_danhmuc_sanpham.id', '=', '24_dotnhap_sanpham.id_sanpham')
        ->join('24_loaisanpham', '24_loaisanpham.id', '=', '24_danhmuc_sanpham.id_loai')
        ->join('24_danhmuc_size', '24_danhmuc_size.id', '=', '24_danhmuc_sanpham.id_size')
        ->join('24_danhmuc_nhasanxuat', '24_danhmuc_nhasanxuat.id', '=', '24_danhmuc_sanpham.id_nhasanxuat')
        ->join('24_accountsadmin', '24_accountsadmin.id', '=', '24_kiemtranhap.id_admin')
        ->join('24_dotnhap','24_dotnhap.id', '=', '24_dotnhap_sanpham.id_dotnhap' )
        ->orderBy('24_dotnhap_sanpham.id', 'asc')
        ->get();
        $data = $ds_sanpham_dot->map(function ($item, $index) {
            $item->stt = $index + 1;
            return $item;
        });
        $data_ex = new Collection();
        foreach ($data as $key => $value) {
            $a = [$value->stt, $value->loai, $value->nhasanxuat, $value->size, $value->thongso, $value->soluongnhap, $value->ngaynhap, $value->tendot, $value->dienthoai];
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
        return ["STT", 'Loại sản phẩm', 'Nhà sản xuất', 'Size', 'Thông số','Số lượng nhập', 'Ngày nhập', 'Đợt nhập', 'Người nhập'];
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
                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $sheet->getColumnDimension('F')->setAutoSize(true);
                $sheet->getColumnDimension('G')->setAutoSize(true);
                $sheet->getColumnDimension('H')->setAutoSize(true);
                $sheet->getColumnDimension('I')->setAutoSize(true);
                $event->sheet->getStyle('A1:I'.($event->sheet->getHighestRow()))->applyFromArray([
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
