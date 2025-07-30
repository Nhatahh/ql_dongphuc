<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Facades\Excel;

class Admin24_Import_ThongTinSinhVien_DP implements ToCollection
{
    private $dotts;

    public function __construct($dotts)
    {
        $this->dotts = $dotts;
    }

    // Xử lý dữ liệu (có tham số vào)
    public function collection(Collection $rows)
    {
        $data_upload = [];
        $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        $pattern_cccd = '/^[a-zA-Z0-9]{9}$|^[a-zA-Z0-9]{12}$/';

        for ($i = 1; $i < count($rows); $i++) {
            $check_email = preg_match($pattern, $rows[$i][0]);
            $check_cccd = preg_match($pattern_cccd, $rows[$i][1]);

            if ($check_email && $check_cccd) {
                $tmp_row = array(
                    'name' => 'IP_TTSV' . $rows[$i][0],
                    'email' => $rows[$i][0],
                    'password' => '$2a$12$JDFLwwliUgN5bIgD0fgRseDldXUjf0wwHuI5a8DCbpUiluVhTrkPu',
                    'google_id' => 0,
                    'cccd_bo' => $rows[$i][1]
                );
                $data_upload[] = $tmp_row;
                $rows[$i][] = 'Thành công';  // Thêm thông báo thành công
            } else {
                !$check_email ? $re_mail = 'Email chưa đúng định dạng.' : $re_mail = "";
                !$check_cccd ? $re_cccd = 'Cccd chưa đúng định dạng.' : $re_cccd = "";
                $rows[$i][] = $re_mail . ';' . $re_cccd;  // Thêm thông báo lỗi
            }
        }

        // Cập nhật dữ liệu vào database
        DB::table('account24s')
            ->upsert(
                $data_upload,
                ['cccd_bo'],
                ['name', 'email', 'password', 'google_id'],
            );

        // Trả về dữ liệu đã xử lý để xuất ra file Excel
        return $rows;
    }

}


