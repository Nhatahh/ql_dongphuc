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

class Admin24_DanhSachHoaDonThongke implements FromCollection, WithMapping, WithHeadings, WithStyles, WithEvents
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

    public function __construct($dotphat, $mahoadon, $loai, $size, $nsx, $trangthai, $cccd, $start, $end)
    {
        $this->dotphat = $dotphat;
        $this->mahoadon = $mahoadon;
        $this->loai = $loai;
        $this->size = $size;
        $this->nsx = $nsx;
        $this->trangthai = $trangthai;
        $this->cccd = $cccd;
        $this->start = $start ? $start . ' 00:00:00' : null;
        $this->end = $end ? $end . ' 23:59:59' : null;
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
                'tt_sanpham.ten_loai AS loai',
                'tt_sanpham.ten_size AS size',
                'tt_sanpham.ten_nhasanxuat AS nsx',
                DB::raw('SUM(24_hoadon.sl_phat) AS tong_sl_phat') // Thêm tổng số lượng phát
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
            })
            ->groupBy(
                'tt_sanpham.ten_loai',
                'tt_sanpham.ten_size',
                'tt_sanpham.ten_nhasanxuat'
            )
            ->get();

    
    
    
            $data = $ds_thongke_phat->map(function ($item, $index) {
                $item->stt = $index + 1;
                return $item;
            });
            $data_ex = new Collection();
            foreach ($data as $key => $value) {
                $a = [$value->stt, $value->loai, $value->size, $value->nsx, $value->tong_sl_phat];
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
        return ["STT", 'Loại đồng phục', 'Size', 'Nhà sản xuất', 'Tổng Số lượng đã phát '];
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

                // Lấy số hàng cuối cùng của sheet
                $highestRow = $sheet->getHighestRow();

                // Định dạng kích thước cột
                foreach (range('A', 'E') as $columnID) {
                    $sheet->getColumnDimension($columnID)->setAutoSize(true);
                }

                // Áp dụng kiểu viền cho toàn bộ cột A
                $event->sheet->getStyle('A1:E' . $highestRow)->applyFromArray([
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
