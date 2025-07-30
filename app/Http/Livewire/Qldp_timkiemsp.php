<?php
namespace App\Http\Livewire;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
class Qldp_timkiemsp extends Component
{
    public $idchuyennganh = 900;

    public function render()
    {
        $trungtuyen = DB::table('24_thongtincanhan')
        // ->join('24_danhmuc_sanpham','24_kho.idsanpham','24_danhmuc_sanpham.id')
        // ->join('24_loaisanpham','24_danhmuc_sanpham.id_loai','24_loaisanpham.id')
        ->where('id_taikhoan',$this->idchuyennganh)
        ->get();
        $this->emit('message');
        return view('livewire.qldp-timkiemsp',[
            'trungtuyen' => $trungtuyen,
            // 'nganh' => $nganh,
        ]);
    }
}
