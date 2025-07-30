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

class Admin24_ExportDanhSachThiSinh implements FromCollection, ShouldAutoSize, WithEvents
{
    private $dotts;
    public function __construct($dotts)
    {
        $this->dotts = $dotts;
    }

        public function collection()
    {
        $dotts = $this->dotts;
        $sql = "SELECT
            ROW_NUMBER() OVER (ORDER BY acc.id) AS thutu,
            acc.id AS id_taikhoan,
            acc.email,
            ttcn.hoten,
            acc.cccd_bo AS cccd,
            ttcn.dienthoai,
            DATE_FORMAT(ttcn.ngaysinh, '%d/%m/%Y') AS ngaysinh,
            IF(ttcn.gioitinh = 1, 'Nữ', 'Nam') AS gioitinh,
            kvut.khuvucuutien,
            dtut.doituonguutien,
            ntn.namtotnghiep
        FROM
            account24s acc
        LEFT JOIN 24_thongtincanhan ttcn  ON  acc.id = ttcn.id_taikhoan
        LEFT JOIN 24_namtotnghiep ntn  ON  acc.id = ntn.id_taikhoan
        LEFT JOIN (SELECT 24_khuvucuutien.id_taikhoan as id_taikhoan,l_priority_area.id_priority_area as khuvucuutien FROM 24_khuvucuutien INNER JOIN l_priority_area ON l_priority_area.id = 24_khuvucuutien.khuvucuutien WHERE dotts = ?) AS  kvut ON kvut.id_taikhoan = acc.id
        LEFT JOIN (SELECT 24_doituonguutien.id_taikhoan as id_taikhoan,l_policy_users.name_policy_user as doituonguutien FROM 24_doituonguutien INNER JOIN l_policy_users ON l_policy_users.id = 24_doituonguutien.id_doituong WHERE dotts = ?) AS  dtut ON dtut.id_taikhoan = acc.id
        WHERE
            acc.cccd_bo IS NOT NULL";
        $data = DB::select($sql,[$dotts,$dotts]);
        $data_ex = new Collection([
            ['','','','','','','','','','',''],
            ['','','','','','','','','','',''],
            ['STT','ID','Họ tên','Căn cước công dân','Email','Ngày sinh','Giới tính','Điện thoại','Khu vực','Đối tượng','Năm tốt nghiệp']
        ]);
        foreach ( $data as  $key => $value) {
           $a = [
                $value ->thutu,
                $value ->id_taikhoan,
                $value ->hoten,
                $value ->cccd,
                $value ->email,
                $value ->ngaysinh,
                $value ->gioitinh,
                $value ->dienthoai,
                $value ->khuvucuutien,
                $value ->doituonguutien,
                $value ->namtotnghiep,
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
                $event->sheet->setCellValue('A1', 'DANH SÁCH THÍ SINH CỦA HỆ THỐNG');
                $event->sheet->mergeCells('A1:K1');
                $event->sheet->getStyle('A1:K1')->applyFromArray([
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
                $event->sheet->getStyle('A3:K3')->applyFromArray([
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
