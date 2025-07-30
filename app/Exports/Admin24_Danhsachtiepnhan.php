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

class Admin24_Danhsachtiepnhan implements FromCollection, WithMapping, WithHeadings, WithStyles, WithEvents
{
    private $data;


    public function __construct($data)
    {
        $this->data = $data;

    }

    public function collection()
{
    $data = $this->data;
    return  $data;
    // Lấy dữ liệu từ cơ sở dữ liệu
    // return
    //  DB::table('24_cmc_dangkygiay')
    // ->join('24_thongtincanhan', '24_cmc_dangkygiay.id_taikhoan', '=', '24_thongtincanhan.id_taikhoan')
    // ->join('24_mssv', '24_cmc_dangkygiay.id_taikhoan', '=', '24_mssv.id_taikhoan')
    // ->join('24_danhmuc_gxn', '24_cmc_dangkygiay.id_loaigiay', '=', '24_danhmuc_gxn.danhmuc_gxn_id')
    // ->join('24_hosonhaphoc', '24_cmc_dangkygiay.id_taikhoan', '=', '24_hosonhaphoc.id_taikhoan')
    // ->join('24_nam','24_cmc_dangkygiay.id_nam','=','24_nam.id_nam')
    // ->leftJoin('24_chuyennganh', '24_chuyennganh.id_nganh', '=', '24_mssv.id_nganh')
    // ->leftJoin('24_danhmuc_donvi', '24_danhmuc_gxn.donvi_id', '=', '24_danhmuc_donvi.donvi_id')
    // ->leftJoin('24_danhmuc_gioitinh', '24_thongtincanhan.gioitinh', '=', '24_danhmuc_gioitinh.ma_gioitinh')
    // ->leftJoin('tinh', '24_thongtincanhan.noisinh', '=', 'tinh.matinh')
    // ->select(
    //     '24_nam.nam',
    //     '24_thongtincanhan.id_taikhoan',
    //     '24_thongtincanhan.hoten',
    //     '24_thongtincanhan.ngaysinh',
    //     '24_thongtincanhan.gioitinh',
    //     '24_thongtincanhan.dienthoai',
    //     '24_thongtincanhan.diachi',
    //     '24_thongtincanhan.email_phu',
    //     '24_thongtincanhan.cccd',
    //     '24_mssv.mssv',
    //     '24_hosonhaphoc.ngaycapcccd',
    //     '24_hosonhaphoc.noicapcccd',
    //     '24_chuyennganh.tenchuyennganh',
    //     '24_danhmuc_gxn.danhmuc_gxn_tenloai AS loaigiay',
    //     '24_cmc_dangkygiay.tiendoxyly',
    //     '24_danhmuc_donvi.ten AS ten_donvi',
    //     '24_danhmuc_gioitinh.ten_gioitinh',
    //     'tinh.tentinh',
    //     '24_cmc_dangkygiay.id_loaigiay',
    // )
    // ->where('24_cmc_dangkygiay.id_nam',$id_nam)
    // ->get();
}
    public function map($row): array
{
    return [
        $row->id_taikhoan,
        $row->mssv,
        $row->hoten,
        $row->cccd,
        $row->loaigiay,
        $row->tiendoxyly
    ];
}

    public function headings(): array
    {
        return ['ID','MSSV','Họ Tên','CCCD','Loại giấy','trạng Thái'];
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
            AfterSheet::class => function(AfterSheet $event) {
                // Đặt định dạng cho hàng tiêu đề
                $event->sheet->getStyle('A1:F1')->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFCCCCCC'],
                    ],
                ]);
            },
        ];
    }
}

// $data = DB::table('24_cmc_dangkygiay')
        // ->join('24_thongtincanhan', '24_cmc_dangkygiay.id_taikhoan', '24_thongtincanhan.id_taikhoan')
        //     ->join('24_mssv', '24_cmc_dangkygiay.id_taikhoan', '24_mssv.id_taikhoan')
        //     ->join('24_danhmuc_gxn', '24_cmc_dangkygiay.id_loaigiay', '24_danhmuc_gxn.danhmuc_gxn_id')
        //     ->join('24_hosonhaphoc', '24_cmc_dangkygiay.id_taikhoan', '24_hosonhaphoc.id_taikhoan')
        //     ->leftJoin('24_chuyennganh', '24_chuyennganh.id_nganh', '24_mssv.id_nganh')
        //     ->leftJoin('24_danhmuc_donvi', '24_danhmuc_gxn.donvi_id', '24_danhmuc_donvi.donvi_id')
        //     ->leftJoin('24_danhmuc_gioitinh', '24_thongtincanhan.gioitinh', '24_danhmuc_gioitinh.ma_gioitinh')
        //     ->leftJoin('tinh', '24_thongtincanhan.noisinh', 'tinh.matinh')

        // ->select([
        //     '24_thongtincanhan.id_taikhoan',
        //     'mssv',
        //     'hoten',
        //     'cccd',
        //     '24_danhmuc_gxn.danhmuc_gxn_tenloai AS loaigiay',
        //     '24_cmc_dangkygiay.tiendoxyly'
        // ])
        // ->when($id_taikhoan, function ($query, $id_taikhoan) {
        //     return $query->where('id_taikhoan', $id_taikhoan);
        // })
        // ->when($mssv, function ($query, $mssv) {
        //     return $query->where('mssv', $mssv);
        // })
        // ->when($hoten, function ($query, $hoten) {
        //     return $query->where('hoten', $hoten);
        // })
        // ->when($cccd, function ($query, $cccd) {
        //     return $query->where('cccd', $cccd);
        // })->when($loaigiay, function ($query, $loaigiay) {
        //     return $query->where('loaigiay', $loaigiay);
        // })
        // ->when($tiendoxyly, function ($query, $tiendoxyly) {
        //     return $query->where('tiendoxyly', $tiendoxyly);
        // })

        // ->get();
        // return collect($data);
