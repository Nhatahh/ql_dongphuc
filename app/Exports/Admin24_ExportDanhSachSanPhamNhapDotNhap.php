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

class Admin24_ExportDanhSachSanPhamNhapDotNhap implements FromCollection, WithMapping, WithHeadings, WithStyles, WithEvents
{
    private $id_dotnhap;

    public function __construct($id_dotnhap)
    {
        $this->id_dotnhap = $id_dotnhap;
    }

    public function collection()
    {
        $ds_sanpham_dot =DB::table('24_dotnhap_sanpham')
        ->select(
            '24_dotnhap_sanpham.id as id',
            '24_dotnhap_sanpham.id_sanpham as id_sanpham',
            '24_dotnhap_sanpham.id_dotnhap as id_dotnhap',
            '24_loaisanpham.loai as loai',
            '24_danhmuc_size.size as size',
            '24_dotnhap_sanpham.soluong as soluong',
            '24_danhmuc_nhasanxuat.nhasanxuat as nhasanxuat',
            '24_accountsadmin.dienthoai as dienthoai',

            '24_dotnhap.dotnhap as tendot',
            DB::raw('COALESCE(SUM(24_kiemtranhap.soluongnhap), 0) as soluongnhap'),
            DB::raw('COALESCE(MAX(24_kiemtranhap.ngaynhap), 0) as ngaynhap'),
            '24_danhmuc_sanpham.thongso as thongso'
        )
        ->where('24_dotnhap_sanpham.id_dotnhap', '=', $this->id_dotnhap)
        ->leftJoin('24_kiemtranhap', '24_kiemtranhap.id_dot_sanpham', '=', '24_dotnhap_sanpham.id')
        ->join('24_danhmuc_sanpham', '24_danhmuc_sanpham.id', '=', '24_dotnhap_sanpham.id_sanpham')
        ->join('24_loaisanpham', '24_loaisanpham.id', '=', '24_danhmuc_sanpham.id_loai')
        ->join('24_danhmuc_size', '24_danhmuc_size.id', '=', '24_danhmuc_sanpham.id_size')
        ->join('24_danhmuc_nhasanxuat', '24_danhmuc_nhasanxuat.id', '=', '24_danhmuc_sanpham.id_nhasanxuat')
        ->join('24_dotnhap','24_dotnhap.id','=','24_dotnhap_sanpham.id_dotnhap')
        ->leftJoin('24_accountsadmin','24_accountsadmin.id','=','24_kiemtranhap.id_admin')
        ->groupBy(
            '24_dotnhap_sanpham.id',
            '24_dotnhap_sanpham.id_sanpham',
            '24_dotnhap_sanpham.id_dotnhap',
            '24_loaisanpham.loai',
            '24_danhmuc_size.size',
            '24_danhmuc_nhasanxuat.nhasanxuat',
            '24_dotnhap_sanpham.soluong',
            '24_danhmuc_sanpham.thongso',
            '24_accountsadmin.dienthoai'
        ) ->get();



        $data = $ds_sanpham_dot->map(function ($item, $index) {
            $item->stt = $index + 1;
            return $item;
        });
        // $data_ex = new Collection([
        //     ["STT",'Loại sản phẩm','Nhà sản xuất','Size','Thông số','Số lượng','Ngày nhập','Người nhập'],
        // ]);
        $data_ex = new Collection();


        foreach ($data as $key => $value) {
            $a = [$value->stt, $value->loai, $value->nhasanxuat, $value->size, $value->thongso, $value->tendot, $value->soluongnhap];
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
        return ["STT", 'Loại sản phẩm', 'Nhà sản xuất', 'Size', 'Thông số', 'Đợt nhập','Số lượng nhập'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFFF00'], // Màu nền vàng
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

                // Đặt độ rộng cột tự động
                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $sheet->getColumnDimension('F')->setAutoSize(true);
                $sheet->getColumnDimension('G')->setAutoSize(true);
                // $sheet->getColumnDimension('H')->setAutoSize(true);
                // $sheet->getColumnDimension('I')->setAutoSize(true);

                // Thêm khung cho các ô
                $event->sheet->getStyle('A1:G'.($event->sheet->getHighestRow()))->applyFromArray([
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
