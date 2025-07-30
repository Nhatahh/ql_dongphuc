<?php

namespace App\Http\Livewire;
use Illuminate\Support\Facades\DB;

use Livewire\Component;


class Quanlysanpham extends Component
{
    public $id_sanpham = null;
    public $id_nhasanxuat = null;
    public $id_loai = null;
    public $id_size = null;
    public $ma_loai = null;
    public $ma_nhasanxuat = null;
    public $ma_size = null;
    public $dotnhaps;
    public $nhasanxuats;
    public $loais;
    public $sizes;
    public $data;

    protected $listeners = ['updateData','Scan_QR_quanlysanpham','reloadComponent'];
    public function reloadComponent()
    {
        $this->emit('$refresh');
        $this->emit('componentReloaded');
    }
    public function Scan_QR_quanlysanpham($ma_loai, $ma_nhasanxuat, $ma_size, $id_sanpham)
    {
        // $this->id_sanpham = $id_sanpham;
        $this->ma_loai = $ma_loai;
        $this->ma_nhasanxuat = $ma_nhasanxuat;
        $this->ma_size = $ma_size;

        $this->id_loai = null;
        $this->id_nhasanxuat = null;
        $this->id_size = null;
    }
    public function updatedIdNhasanxuat($value)
    {
        $this->id_nhasanxuat = $value;

        $this->ma_loai = null;
        $this->ma_nhasanxuat = null;
        $this->ma_size = null;

    }
    public function updatedIdLoai($value)
    {
        $this->id_loai = $value;

        $this->ma_loai = null;
        $this->ma_nhasanxuat = null;
        $this->ma_size = null;

    }
    public function updatedIdSize($value)
    {
        $this->id_size = $value;

        $this->ma_loai = null;
        $this->ma_nhasanxuat = null;
        $this->ma_size = null;

    }
    public function loadNhasanxuats()
    {
        $this->nhasanxuats = DB::table('24_danhmuc_nhasanxuat')->select('id', 'nhasanxuat')->where('trangthai',1)->get();
    }
    public function loadLoais()
    {
        $this->loais = DB::table('24_loaisanpham')->select('id', 'loai')->where('trangthai',1)->get();
    }
    public function loadSizes()
    {
        $this->sizes = DB::table('24_danhmuc_size')->select('id', 'size')->where('trangthai',1)->get();
    }
    public function loadSanpham()
    {
       return $results =DB::table('24_danhmuc_sanpham')
       ->select('24_danhmuc_sanpham.id as id','24_danhmuc_sanpham.masp as masp','24_accountsadmin.dienthoai as dienthoai','24_danhmuc_sanpham.qrcode as qrcode','24_danhmuc_sanpham.ghichu as ghichu','24_danhmuc_sanpham.create_at as create_at','24_loaisanpham.loai as loai','24_loaisanpham.id as idloai','24_loaisanpham.id as id_loai','24_danhmuc_nhasanxuat.nhasanxuat as nhasanxuat','24_danhmuc_nhasanxuat.id as id_nhasanxuat','24_danhmuc_nhasanxuat.id as id_nhasanxuat','24_danhmuc_size.size as size','24_danhmuc_size.id as id_size','24_danhmuc_size.id as id_size', '24_danhmuc_sanpham.thongso as thongso','24_danhmuc_sanpham.trangthai as trangthai','24_danhmuc_sanpham.anhsanpham as anhsanpham')
       ->join('24_loaisanpham','24_loaisanpham.id','=','24_danhmuc_sanpham.id_loai')
       ->join('24_danhmuc_size','24_danhmuc_size.id','=','24_danhmuc_sanpham.id_size')
       ->join('24_danhmuc_nhasanxuat','24_danhmuc_nhasanxuat.id','=','24_danhmuc_sanpham.id_nhasanxuat')
       ->join('24_accountsadmin','24_accountsadmin.id','=','24_danhmuc_sanpham.id_admin')
       ->when($this->id_sanpham, function ($query) {
           $query->where('24_danhmuc_sanpham.id', $this->id_sanpham);
        })
       ->when($this->id_nhasanxuat, function ($query) {
            $query->where('24_danhmuc_nhasanxuat.id', $this->id_nhasanxuat);
        })
       ->when($this->id_loai, function ($query) {
           $query->where('24_loaisanpham.id', $this->id_loai);
        })
       ->when($this->id_size, function ($query) {
           $query->where('24_danhmuc_size.id', $this->id_size);
        })
        ->when($this->ma_nhasanxuat, function ($query) {
            $query->where('24_danhmuc_nhasanxuat.mansx', $this->ma_nhasanxuat);
        })
        ->when($this->ma_loai, function ($query) {
            $query->where('24_loaisanpham.maloai', $this->ma_loai);
        })
        ->when($this->ma_size, function ($query) {
            $query->where('24_danhmuc_size.masize', $this->ma_size);
        })
        ->orderBy('24_loaisanpham.id')
        ->orderBy('24_danhmuc_nhasanxuat.id')
        ->orderBy('24_danhmuc_size.id')
        ->get();
    }

    // public function updateData()
    // {
    //     $this->data = $this->loadSanpham();
    //     $this->emit('dataUpdated');
    // }
    // public function Scan_QR_quanlynhap($id_loai, $id_nhasanxuat, $id_size)
    // {
    //     $this->id_loai = $id_loai;
    //     $this->id_nhasanxuat = $id_nhasanxuat;
    //     $this->id_size = $id_size;
    // }
    // public function updated($propertyName)
    // {
    //     if ($propertyName === 'id_dotnhap') {
    //         $this->id_nhasanxuat = null;
    //         $this->id_loai = null;
    //         $this->id_size = null;
    //     }
    // }
    public function render()
    {
        $this->loadNhasanxuats();
        $this->loadLoais();
        $this->loadSizes();
        $trangthai = 0;
        $ds_sanpham = $this->loadSanpham();
        if(count($ds_sanpham) >= 1){
            $trangthai = 1;
        }
        $this->emit('message');

        return view('livewire.quanlysanpham',[
            'sanphamnhap' => $ds_sanpham,
            'trangthai' => $trangthai,
            'dotnhaps' => $this->dotnhaps,
            'nhasanxuats' =>$this->nhasanxuats,
            'loais' =>$this->loais,
            'sizes' =>$this->sizes
        ]);
    }
}
