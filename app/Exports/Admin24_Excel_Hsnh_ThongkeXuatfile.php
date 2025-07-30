<?php
namespace App\Exports;

// use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Carbon\Carbon;
class Admin24_Excel_Hsnh_ThongkeXuatfile implements FromCollection
// class UserExport implements WithMultipleSheets

{

    private $nam;
    private $id_lop;
    private $idkhoa;


    public function __construct( $nam,$id_lop, $idkhoa)
    {

        $this->nam = $nam;
        $this->id_lop = $id_lop;
        $this->idkhoa = $idkhoa;

    }
    function ghep_2truyvan($data_goc,$data_ghep,$ten){
        if(count($data_ghep)>0){
            foreach ($data_goc as $key => $goc) {
                $dem = 0;
                foreach ($data_ghep as $key => $ghep) {
                    if($goc->id == $ghep->id){
                        $goc->$ten = $ghep->value;
                        break;
                    }
                    if($dem == 0){
                        $goc->$ten = "x";
                    }
                }
            }
        }else{
            foreach ($data_goc as $key => $goc) {
                $goc->$ten = "x";
            }
        }

        return $data_goc;
    }

    public function collection()
    {
        $nam = $this->nam;
        $id_lop = $this->id_lop;
        $khoa = $this->idkhoa;
        $data = DB::table('24_lop')
        ->select('24_lop.id','tenlop','tenkhoa', DB::raw('ROW_NUMBER() OVER (ORDER BY `24_lop`.`id`) AS stt'))
        ->join('24_khoas','24_khoas.id','24_lop.idkhoas')
        ->join('24_khoa','24_khoa.id','24_lop.idkhoa')
        ->where('idkhoas',$nam)
        ->where(function($query) use ($id_lop) {
            if ($id_lop == 0) {
                $query->whereNotNull('24_lop.id'); // Thay 'column_name' bằng tên cột thực tế
            } else {
                $query->where('24_lop.id',$id_lop);
            }
        })
        ->where(function($query) use ($khoa) {
            if ($khoa == 0) {
                $query->whereNotNull('24_lop.id'); // Thay 'column_name' bằng tên cột thực tế
            } else {
                $query->where('idkhoa',$khoa);
            }
        })
        ->get();
        $nvqs = DB::table('l_file_qlsv_nvqs')
        ->select('id_lop as id',DB::raw('COUNT(*) as value'))
        ->join('24_mssv','24_mssv.id_taikhoan','l_file_qlsv_nvqs.id_user')
        ->join('24_lop','24_lop.id','24_mssv.id_lop')
        ->where('id_year',$nam)
        ->where(function($query) use ($id_lop) {
            if ($id_lop == 0) {
                $query->whereNotNull('l_file_qlsv_nvqs.id'); // Thay 'column_name' bằng tên cột thực tế
            } else {
                $query->where('24_mssv.id_lop',$id_lop);
            }
        })
        ->where(function($query) use ($khoa) {
            if ($khoa == 0) {
                $query->whereNotNull('l_file_qlsv_nvqs.id'); // Thay 'column_name' bằng tên cột thực tế
            } else {
                $query->where('24_lop.idkhoa',$khoa);
            }
        })
        ->groupBy('id_lop')
        ->get();
        $vv = DB::table('l_file_qlsv_vv')
        ->select('id_lop as id',DB::raw('COUNT(*) as value'))
        ->join('24_mssv','24_mssv.id_taikhoan','l_file_qlsv_vv.id_user')
        ->join('24_lop','24_lop.id','24_mssv.id_lop')
        ->where('id_year',$nam)
        ->where(function($query) use ($khoa) {
            if ($khoa == 0) {
                $query->whereNotNull('l_file_qlsv_vv.id'); // Thay 'column_name' bằng tên cột thực tế
            } else {
                $query->where('24_lop.idkhoa',$khoa);
            }
        })
        ->where(function($query) use ($id_lop) {
            if ($id_lop == 0) {
                $query->whereNotNull('l_file_qlsv_vv.id'); // Thay 'column_name' bằng tên cột thực tế
            } else {
                $query->where('24_mssv.id_lop',$id_lop);
            }
        })
        ->groupBy('id_lop')
        ->get();
        $this->ghep_2truyvan($data,$vv,'slvv');
        $this->ghep_2truyvan($data,$nvqs,'slnvqs');

        $data_ex = new Collection([
            ['STT','Mã ngành', "Tên chuyên ngành",'NVQS','VV'],
        ]);

        foreach ($data as $key => $value) {
           $a = [$value ->stt,$value ->tenlop,$value ->tenkhoa,$value ->slnvqs, $value->slvv];
           $data_ex[] = $a;
        }
        return $data_ex;
    }
}



