<?php
namespace App\Exports;

// use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class Admin24_ExportDanhSachGuiMail implements FromCollection
{
    public function __construct()
    {
        // $this->iddot = $iddot;
    }

        public function collection()
    {
        $data = DB::table('24_guimailtam')
        ->leftJoin('24_thongtincanhan','24_guimailtam.id_taikhoan','24_thongtincanhan.id_taikhoan')
        ->select('24_thongtincanhan.hoten as hoten', '24_guimailtam.email as email', '24_guimailtam.id_admin as id_admin', '24_guimailtam.create_at as create_at',DB::raw('ROW_NUMBER() OVER (ORDER BY 24_guimailtam.id_taikhoan) AS stt'),DB::raw('CASE WHEN 24_guimailtam.status = 1 THEN "Gửi thành công" ELSE "Gửi thất bại" END AS trangthai') )
        ->get();
        $data_ex = new Collection([
            ["STT",'Họ tên','Email','ID_admin','Ngày gửi','Trạng thái'],
        ]);
        foreach ($data as $key => $value) {
           $a = [$value ->stt,$value ->hoten,$value ->email,$value ->id_admin, $value ->create_at,$value ->trangthai];
           $data_ex[] = $a;
        }
        DB::table('24_guimailtam')->delete();
        return $data_ex;
    }

}
