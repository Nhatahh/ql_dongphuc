<?php
namespace App\Http\Livewire;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
class ClickCounter extends Component
{
    public $hoten = "";
    public $cccd = "";
    // public $id_covanhoctap = "45";
    public $idchuyennganh = -1;
    public $daxem =  -1;
    public $xacnhan =  -1;
    public $trangthaidieutra = -1;
    // public $iddotxt = 1;
    public $iddotts = 2;
    public $namtotnghiep = -1;
    public $nhaphoc = -1;
    public $xacnhanbo = -1;

    public function render()
    {
        $id_admin = Auth::guard('loginadmin')->user()->id;
        $nganh = DB::table('24_covanhoctap')
        ->select('24_chuyennganh.id as id','24_chuyennganh.tenchuyennganh as text')
        ->join('24_chuyennganh','24_covanhoctap.id_chuyennganh','24_chuyennganh.id')
        ->where('24_covanhoctap.id_taikhoan_dangnhap',$id_admin)
        ->get();

        $id_chuyennganh = $this->idchuyennganh;
        // $iddotxt_fix = $this->iddotxt;
        $iddotts_fix = $this->iddotts;
        $namtotnghiep_fix = $this->namtotnghiep;
        $daxem_fix = $this->daxem;
        $xacnhan_fix = $this->xacnhan;
        $trangthaidieutra_fix = $this->trangthaidieutra;
        $hoten_fix = preg_replace('/\s+/', ' ', trim($this->hoten));
        $cccd_fix = preg_replace('/\s+/', ' ', trim($this->cccd));
        $nhaphoc_fix = $this->nhaphoc;
        $xacnhanbo_fix = $this->xacnhanbo;
        $trungtuyen = DB::table('24_trungtuyen')
        ->select(DB::raw('if(24_xacnhanbo.id_taikhoan is not null, 1, 0) as xacnhanbo'),DB::raw('if(24_mssv.id_taikhoan is not null, 1, 0) as nhaphoc'),'24_trungtuyen.ttsom','24_thongtincanhan.dienthoai_phu','24_namtotnghiep.namtotnghiep', '24_trungtuyen.ghichu_xnnh',DB::raw('ROW_NUMBER() OVER (ORDER BY 24_trungtuyen.diemxettuyen DESC) AS sothutu'),'account24s.email','24_thongtincanhan.cccd','24_thongtincanhan.hoten','24_thongtincanhan.dienthoai','24_trungtuyen.id as id','24_trungtuyen.diemxettuyen','24_chuyennganh.tenchuyennganh','trangthaidieutra','daxem','xacnhan')
        // ->where('id_taikhoan', $id_taikhoan)
        ->join('24_chuyennganh','24_chuyennganh.id','24_trungtuyen.id_chuyennganh')
        ->leftJoin('24_thongtincanhan','24_thongtincanhan.id_taikhoan','24_trungtuyen.id_taikhoan')
        ->leftJoin('24_namtotnghiep','24_namtotnghiep.id_taikhoan','24_trungtuyen.id_taikhoan')
        ->leftJoin('account24s','account24s.id','24_trungtuyen.id_taikhoan')
        ->leftJoin('24_mssv','24_mssv.id_taikhoan','24_trungtuyen.id_taikhoan')
        ->leftJoin('24_xacnhanbo','24_xacnhanbo.id_taikhoan','24_trungtuyen.id_taikhoan')
        ->join('24_covanhoctap','24_covanhoctap.id_chuyennganh','24_trungtuyen.id_chuyennganh')
        ->where('24_covanhoctap.id_taikhoan_dangnhap', $id_admin)
        // ->where('24_trungtuyen.iddotxt', $iddotxt_fix)
        ->where('24_trungtuyen.iddot', $iddotts_fix)
        ->where(function($query) use ($namtotnghiep_fix) {
            if ($this->namtotnghiep == -1) {
                $query->whereNotNull('24_trungtuyen.id'); // Thay 'column_name' bằng tên cột thực tế
            } else {
                $query->where('24_namtotnghiep.namtotnghiep', $namtotnghiep_fix);
            }
        })
        ->where(function($query) use ($id_chuyennganh) {
            if ($this->idchuyennganh == -1) {
                $query->whereNotNull('24_trungtuyen.id'); // Thay 'column_name' bằng tên cột thực tế
            } else {
                $query->where('24_trungtuyen.id_chuyennganh',$id_chuyennganh);
            }
        })
        ->where(function($query) use ($daxem_fix) {
            if ($this->daxem == -1) {
                $query->whereNotNull('24_trungtuyen.id'); // Thay 'column_name' bằng tên cột thực tế
            } else {
                $query->where('24_trungtuyen.daxem', $daxem_fix);
            }
        })
        ->where(function($query) use ($xacnhan_fix) {
            if ($this->xacnhan == -1) {
                $query->whereNotNull('24_trungtuyen.id'); // Thay 'column_name' bằng tên cột thực tế
            } else {
                $query->where('24_trungtuyen.xacnhan', $xacnhan_fix);
            }
        })
        ->where(function($query) use ($trangthaidieutra_fix) {
            if ($this->trangthaidieutra == -1) {
                $query->whereNotNull('24_trungtuyen.id'); // Thay 'column_name' bằng tên cột thực tế
            } else {
                $query->where('24_trungtuyen.trangthaidieutra', $trangthaidieutra_fix);
            }
        })
        ->where(function($query) use ($cccd_fix) {
            if ($this->cccd == "") {
                $query->whereNotNull('24_trungtuyen.id'); // Thay 'column_name' bằng tên cột thực tế
            } else {
                $query->where('24_thongtincanhan.cccd', 'LIKE', '%' . $cccd_fix . '%');
            }
        })
        ->where(function($query) use ($hoten_fix) {
            if ($this->hoten == "") {
                $query->whereNotNull('24_trungtuyen.id'); // Thay 'column_name' bằng tên cột thực tế
            } else {
                $query->where('24_thongtincanhan.hoten', 'LIKE', '%' . $hoten_fix . '%');
            }
        })
        ->where(function($query) use ($nhaphoc_fix) {
            if ($this->nhaphoc == 1) {
                $query->whereNotNull('24_mssv.id_taikhoan'); // Thay 'column_name' bằng tên cột thực tế
            } else {
                if($this->nhaphoc == 0){
                    $query->whereNull('24_mssv.id_taikhoan');
                }else{
                    $query->whereNotNull('24_trungtuyen.id_taikhoan');
                }
            }
        })
        ->where(function($query) use ($xacnhanbo_fix) {
            if ($this->xacnhanbo == 1) {
                $query->whereNotNull('24_xacnhanbo.id_taikhoan'); // Thay 'column_name' bằng tên cột thực tế
            } else {
                if($this->xacnhanbo == 0){
                    $query->whereNull('24_xacnhanbo.id_taikhoan');
                }else{
                    $query->whereNotNull('24_trungtuyen.id_taikhoan');
                }
            }
        })
        ->orderBy('24_trungtuyen.diemxettuyen','DESC')
        ->orderBy('24_trungtuyen.id_chuyennganh', 'ASC')
        ->get();

        $soluongdieutra = count(DB::table('24_trungtuyen')
        ->join('24_covanhoctap','24_covanhoctap.id_chuyennganh','24_trungtuyen.id_chuyennganh')
        ->where('24_covanhoctap.id_taikhoan_dangnhap', $id_admin)
        ->where('24_trungtuyen.iddot', $iddotts_fix)->get());
        $this->emit('message');
        return view('livewire.click-counter',[
            'trungtuyen' => $trungtuyen,
            'nganh' => $nganh,
            'soluong' => $soluongdieutra,
        ]);
    }
}
