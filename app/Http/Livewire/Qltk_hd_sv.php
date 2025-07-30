<?php
namespace App\Http\Livewire;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
class Qltk_hd_sv extends Component
{
    public $mahoadon;
    public $cccd_sv=0;
    public $dot_phat = -1;
    protected $listeners = ['get_cccdsv','refreshComponent' => 'refresh'];
    public function refresh(){
        $this->mahoadon=' ';
        $this->cccd_sv=' ';
    }
    public function get_cccdsv($cccd_sv){
        $this->cccd_sv = $cccd_sv;
    }
    public function render()
    {
        // Biến tìm kiếm
        $mahoadon = $this->mahoadon;
        $cccd_sv = $this->cccd_sv;

        $dot_phat = $this->dot_phat;
        // Select box
        $sql_dotphat = DB::select("SELECT `id` AS `id`, `dot` AS `text` FROM `24_danhmuc_dotphat`");
        $customItem = [
            [
                'id' => -1,
                'text' => 'Chọn đợt phát'
            ]
        ];
        $dot_phat_arr = array_merge($customItem, json_decode(json_encode($sql_dotphat), true));
        // Thông tin hóa đơn
        $tt_sinhvien=DB::table('24_thongtincanhan')->where('cccd',$cccd_sv)->first()->id_taikhoan;

        $sql = DB::table('24_hoadon')
        ->join('24_thongtincanhan', '24_hoadon.id_sinhvien', '=', '24_thongtincanhan.id_taikhoan')
        ->join('24_accountsadmin', '24_hoadon.id_nguoiphat', '=', '24_accountsadmin.id')
        ->join('24_danhmuc_dotphat', '24_hoadon.id_dotphat', '=', '24_danhmuc_dotphat.id')
        ->select(
            '24_hoadon.mahoadon as mahoadon',
            '24_hoadon.trangthai as trangthai',
            DB::raw('DATE_FORMAT(24_hoadon.ngaytao, "%d-%m-%Y %H:%i:%s") as ngaytao'),
            '24_thongtincanhan.hoten as nguoinhan',
            '24_thongtincanhan.cccd as cccd',
            '24_accountsadmin.name as nguoiphat',
            '24_danhmuc_dotphat.dot as dotphat'
        )
        ->where('24_hoadon.trangthai',0)
        ->where('24_hoadon.id_sinhvien',$tt_sinhvien)
        ->groupBy('24_hoadon.mahoadon', 'ngaytao', '24_thongtincanhan.hoten', '24_accountsadmin.name', '24_danhmuc_dotphat.dot','24_hoadon.trangthai','24_thongtincanhan.cccd');
        // Áp dụng các điều kiện tìm kiếm
        if (!empty($mahoadon) && strpos($mahoadon, ' ') === false) {
            $sql->where('24_hoadon.mahoadon', 'like', '%' . $mahoadon . '%');
        }
        if (!empty($cccd_sv) && strpos($cccd_sv, ' ') === false) {
            // Tìm kiếm thông tin sinh viên dựa trên cccd
            // $id_sv = DB::table('24_thongtincanhan')
                $sql->where('24_thongtincanhan.cccd', 'like', '%' . $cccd_sv . '%');
                // ->first();
            // if (!empty($id_sv)) {
            //     $sql->where('24_hoadon.id_sinhvien', $id_sv->id_taikhoan);
            // }
        }
        if ($dot_phat > 0) {
            $sql->where('24_hoadon.id_dotphat', $dot_phat);
        }
        $hoadon = $sql->get();
        // Dữ liệu ra
        $this->emit('message');
        return view('livewire.qldpphatdongphuc_hoadon', [
            'hoadon' => $hoadon,
            'dot_phat1' => $dot_phat_arr,
            'cccd_sv' => $cccd_sv,
        ]);
    }

}
