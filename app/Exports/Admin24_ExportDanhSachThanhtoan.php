<?php
namespace App\Exports;

// use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class Admin24_ExportDanhSachThanhtoan implements FromCollection
{
    private $iddot;

    public function __construct($iddot)
    {
        $this->iddot = $iddot;
    }

        public function collection()
    {
        // $data = DB::table('24_ketquathanhtoan')
        // ->select('*',DB::raw('if(hinhthuc = 1,"Chuyển khoản",if(hinhthuc = 2,"Tiền mặt","BaoKim")) as hinhthuc'))
        // ->join('24_dataresponse','24_dataresponse.order_id','24_ketquathanhtoan.order_id')
        // ->join('24_dottuyensinh','24_dottuyensinh.id','24_ketquathanhtoan.id_dot')
        // ->where([
        //     '24_ketquathanhtoan.id_dot' => $this->iddot,
        // ])
        // ->get();
        $data = DB::table('24_ketquathanhtoan')
            ->join('24_thongtincanhan', '24_thongtincanhan.id_taikhoan', '24_ketquathanhtoan.id_taikhoan')
            ->join('account24s', 'account24s.id', '24_ketquathanhtoan.id_taikhoan')
            ->select(DB::raw('ROW_NUMBER() OVER (ORDER BY 24_ketquathanhtoan.id) AS stt'), DB::raw('if(hinhthuc = 1,"Chuyển khoản",if(hinhthuc = 2,"Tiền mặt","BaoKim")) as hinhthuc1'),'24_ketquathanhtoan.*', 'account24s.*', '24_thongtincanhan.*')
            ->where([
                '24_ketquathanhtoan.id_dot' => $this->iddot,
            ])
            ->get();
        $data_ex = new Collection([
            ['Mã hóa đơn',"Họ tên",'Email','Điện thoại','Số tiền','Ngày hoàn thành', 'Hinh thức'],
        ]);
        foreach ($data as $key => $value) {
           $a = [$value ->id_order,$value ->hoten,$value ->email,$value ->dienthoai,$value ->total_amount,$value ->completed_at,$value ->hinhthuc1];
           $data_ex[] = $a;
        }
        $tongthu = DB::table('24_ketquathanhtoan')
        ->where('id_dot',$this->iddot)
        ->sum('total_amount');
        $data_ex[] = ['Tổng thu',"",'','',$tongthu];
        return $data_ex;
    }
}
