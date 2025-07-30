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

class Admin24_DanhSachHoaDon implements FromCollection, WithMapping, WithHeadings, WithStyles, WithEvents
{
    private $dotphat;
    private $mahoadon;
    private $loai;
    private $size;
    private $nsx;
    private $cccd;
    private $trangthai;
    private $start;
    private $end;

    public function __construct($dotphat, $mahoadon, $loai,$size,$nsx, $trangthai,$cccd, $start,$end)
    {
        $this->dotphat = $dotphat;
        $this->mahoadon = $mahoadon;
        $this->loai = $loai;
        $this->size = $size;
        $this->nsx = $nsx;
        $this->trangthai = $trangthai;
        $this->cccd = $cccd;
        $this->start = $start;
        $this->end = $end;
    }

    public function collection()
    {
        $dotphat=$this->dotphat;
        $mahoadon=$this->mahoadon;
        $loai=$this->loai;
        $size=$this->size;
        $nsx=$this->nsx;
        $trangthai=$this->trangthai;
        $cccd=$this->cccd;
        $start=$this->start;
        $end=$this->end;

         $ds_thongke_phat = DB::table('24_hoadon')
            ->join('24_thongtincanhan', '24_hoadon.id_sinhvien', '=', '24_thongtincanhan.id_taikhoan')
            ->join('24_accountsadmin', '24_hoadon.id_nguoiphat', '=', '24_accountsadmin.id')
            ->join('24_danhmuc_dotphat', '24_hoadon.id_dotphat', '=', '24_danhmuc_dotphat.id')
            ->join('24_dotnhap', '24_hoadon.id_dotnhap', '=', '24_dotnhap.id')
            ->join(DB::raw('(SELECT
                24_danhmuc_sanpham.id AS id,
                24_danhmuc_nhasanxuat.nhasanxuat AS ten_nhasanxuat,
                24_danhmuc_nhasanxuat.id AS id_nhasanxuat,
                24_danhmuc_size.size AS ten_size,
                24_danhmuc_size.id AS id_size,
                24_loaisanpham.loai AS ten_loai,
                24_loaisanpham.id AS id_loai
            FROM 24_danhmuc_sanpham
            INNER JOIN 24_danhmuc_nhasanxuat ON 24_danhmuc_sanpham.id_nhasanxuat = 24_danhmuc_nhasanxuat.id
            INNER JOIN 24_danhmuc_size ON 24_danhmuc_sanpham.id_size = 24_danhmuc_size.id
            INNER JOIN 24_loaisanpham ON 24_danhmuc_sanpham.id_loai = 24_loaisanpham.id) AS tt_sanpham'), '24_hoadon.id_sanpham', '=', 'tt_sanpham.id')
            ->select([
                '24_thongtincanhan.hoten AS hoten_sv',
                '24_accountsadmin.name AS hoten_nguoiphat',
                '24_thongtincanhan.cccd AS cccd',
                '24_thongtincanhan.ngaysinh AS ngaysinh',
                '24_hoadon.mahoadon AS mahoadon',
                '24_hoadon.sl_phat AS sl_phat',
                '24_hoadon.id AS id',
                '24_hoadon.trangthai AS trangthai',
                '24_danhmuc_dotphat.dot AS dot_phat',
                '24_dotnhap.dotnhap AS dot_nhap',
                'tt_sanpham.ten_loai AS loai',
                'tt_sanpham.ten_size AS size',
                'tt_sanpham.ten_nhasanxuat AS nsx',
                DB::raw("DATE_FORMAT(24_hoadon.ngaytao, '%d-%m-%Y') AS ngaytao"),
                DB::raw('DAY(24_hoadon.ngaytao) AS ngay'),
                DB::raw('MONTH(24_hoadon.ngaytao) AS thang'),
                DB::raw('YEAR(24_hoadon.ngaytao) AS nam')
            ])
            ->when($dotphat, function ($query, $dotphat) {
                return $query->where('24_hoadon.id_dotphat', $dotphat);
            })
            ->when($mahoadon, function ($query, $mahoadon) {
                return $query->where('24_hoadon.mahoadon', $mahoadon);
            })
            ->when($loai, function ($query, $loai) {
                return $query->where('tt_sanpham.id_loai', $loai);
            })
            ->when($size, function ($query, $size) {
                return $query->where('tt_sanpham.id_size', $size);
            })
            ->when($nsx, function ($query, $nsx) {
                return $query->where('tt_sanpham.id_nhasanxuat', $nsx);
            })
            ->when($cccd, function ($query, $cccd) {
                return $query->where('24_thongtincanhan.cccd', $cccd);
            })
            ->when($start && $end && $start == $end, function ($query) use ($start) {
                return $query->whereDate('24_hoadon.ngaytao', '=', $start);
            })
            ->when($start && $end && $start != $end, function ($query) use ($start, $end) {
                return $query->whereBetween('24_hoadon.ngaytao', [$start, $end]);
            })
            ->when($start && !$end, function ($query, $start) {
                return $query->where('24_hoadon.ngaytao', '>=', $start);
            })
            ->when($end && !$start, function ($query, $end) {
                return $query->where('24_hoadon.ngaytao', '<=', $end);
            })
            ->when(isset($trangthai) && $trangthai != -1, function ($query) use ($trangthai) {
                return $query->where('24_hoadon.trangthai', $trangthai);
            });
        $ds_thongke_phat = $ds_thongke_phat->get();
        $data = $ds_thongke_phat->map(function ($item, $index) {
            $item->stt = $index + 1;
            return $item;
        });
        $data_ex = new Collection();
        foreach ($data as $key => $value) {
            $a = [$value->stt, $value->mahoadon, $value->dot_phat, $value->ngaytao, $value->hoten_sv, $value->cccd, $value->loai, $value->size, $value->nsx, $value->sl_phat, $value->dot_nhap, $value->trangthai];
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
        return ["STT", 'Mã hóa đơn', 'Đợt phát', 'Ngày Phát', 'Tên sinh viên','CCCD', 'Loại đồng phục', 'Size', 'Nhà sản xuất','Số lượng', 'Đợt nhập', 'Trạng thái'];
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
                    $cellValue = $sheet->getCell('L' . $row)->getValue();
                    // Kiểm tra nếu giá trị là số và so sánh
                    if (is_numeric($cellValue) && $cellValue == 1) {
                        $sheet->setCellValue('L' . $row, 'Đã xóa');
                    } else {
                        $sheet->setCellValue('L' . $row, ''); 
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
                $sheet->getColumnDimension('I')->setAutoSize(true);
                $sheet->getColumnDimension('J')->setAutoSize(true);
                $sheet->getColumnDimension('K')->setAutoSize(true);
                $sheet->getColumnDimension('L')->setAutoSize(true);
                
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