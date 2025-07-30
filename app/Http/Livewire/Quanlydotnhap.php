<?php

namespace App\Http\Livewire;
use Illuminate\Support\Facades\DB;

use Livewire\Component;


class Quanlydotnhap extends Component
{
    public $dot_nhap_mobile = -1;
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

    protected $listeners = ['updateData', 'data_iddotnhap','Scan_QR'];
    public function data_iddotnhap($id_dot)
    {
        $this->dot_nhap_mobile = $id_dot;

        $this->id_loai = null;
        $this->id_nhasanxuat = null;
        $this->id_size = null;

        $this->ma_loai = null;
        $this->ma_nhasanxuat = null;
        $this->ma_size = null;
    }
    public function Scan_QR($ma_loai, $ma_nhasanxuat, $ma_size)
    {
        $this->ma_loai = $ma_loai;
        $this->ma_nhasanxuat = $ma_nhasanxuat;
        $this->ma_size = $ma_size;

        $this->id_loai = null;
        $this->id_nhasanxuat = null;
        $this->id_size = null;
    }
    public function loadDotnhaps()
    {
        $this->dotnhaps = DB::table('24_dotnhap')->select('id', 'dotnhap')->where('trangthai',1)->get();
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
        ->select(
            '24_danhmuc_sanpham.id as id',
            '24_danhmuc_sanpham.masp as masp',
            '24_loaisanpham.loai as loai',
            '24_danhmuc_size.size as size',
            '24_danhmuc_sanpham.thongso as thongso',
            '24_danhmuc_nhasanxuat.nhasanxuat as nhasanxuat',
            DB::raw('IF(sanphamnhap.soluong IS NOT NULL, sanphamnhap.soluong, 0) as soluong')
        )
        ->join('24_loaisanpham', '24_loaisanpham.id', '=', '24_danhmuc_sanpham.id_loai')
        ->join('24_danhmuc_size', '24_danhmuc_size.id', '=', '24_danhmuc_sanpham.id_size')
        ->join('24_danhmuc_nhasanxuat', '24_danhmuc_nhasanxuat.id', '=', '24_danhmuc_sanpham.id_nhasanxuat')
        ->leftJoin(DB::raw('(SELECT id_sanpham, soluong FROM 24_dotnhap_sanpham WHERE id_dotnhap = ' .  $this->dot_nhap_mobile . ') as sanphamnhap'),
                   'sanphamnhap.id_sanpham', '=', '24_danhmuc_sanpham.id')
        ->where('24_danhmuc_sanpham.trangthai',1)
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
    public function updateData()
    {
        $this->data = $this->loadSanpham();
        $this->emit('dataUpdated');
    }

    // public function updated($propertyName)
    // {
    //     if ($propertyName === 'dot_nhap_mobile') {
    //         $this->id_nhasanxuat = null;
    //         $this->id_loai = null;
    //         $this->id_size = null;
    //     }
    // }
    public function render()
    {
        $this->loadDotnhaps();
        $this->loadNhasanxuats();
        $this->loadLoais();
        $this->loadSizes();
        $trangthai = 0;
        $ds_sanpham_dot = $this->loadSanpham();
        if(count($ds_sanpham_dot) >= 1 || $this->id_nhasanxuat != null || $this->id_loai != null|| $this->id_size != null|| $this->ma_loai != null || $this->ma_nhasanxuat != null|| $this->ma_size != null){
            $trangthai = 1;
        }
        $this->emit('message');

        return view('livewire.quanlydotnhap',[
            'sanphamnhap' => $ds_sanpham_dot,
            'trangthai' => $trangthai,
            'dotnhaps' => $this->dotnhaps,
            'nhasanxuats' =>$this->nhasanxuats,
            'loais' =>$this->loais,
            'sizes' =>$this->sizes
        ]);
    }
}
