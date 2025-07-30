<?php
namespace App\Exports;

// use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\GoController;
use Maatwebsite\Excel\Concerns\FromCollection;



class GoSta implements FromCollection
{
    private $batch,$active;

    public function __construct(int $batch,$active)
    {
        $this->batch = $batch;
        // $this->data = $data;
        $this->active = $active;

    }

    public function collection()
    {



        // $data = GoController::load_go(1,1);

    //  $datas = new Collection([
    //         ['STT','Ngành xét tuyển','Tổng_Chỉ tiêu','Tổng_Đăng ký','Tổng_Trúng tuyển','Tổng_Trúng tuyển NV1','Tổng_Trúng tuyển NV2','Tổng_Trúng tuyển NV3','Tỉ lệ canh tranh','Tỉ lệ','HB1_Chỉ tiêu','HB1_Đăng ký','HB1_Ngưỡng','HB1_Điểm chuẩn','HB1_Trúng tuyển','Tỉ lệ','HB2_Chỉ tiêu','HB2_Đăng ký','HB2_Ngưỡng','HB2_Điểm chuẩn','HB2_Trúng tuyển','Tỉ lệ','NL_Chỉ tiêu','NL_Đăng ký','NL_Ngưỡng','NL_Điểm chuẩn','NL_Trúng tuyển','Tỉ lệ']
    //     ]);
    //     foreach ($data as $key => $value) {
    //         if($value['reg_all'] == 0 || $value['reg_pas'] == 0 ){
    //             $tlct = '';
    //             $tl = '';
    //         }else{
    //             $tlct = '1:'.round($value['reg_all']/$value['reg_pas'],2);
    //             $tl = round($value['reg_pas']/$value['min_major']*100,2);
    //         }

    //         if($value['reg_pas_hb1'] == 0 || $value['min_majorhb1'] == 0 ){
    //             $tl_hb1 = '';
    //         }else{
    //             $tl_hb1 = round($value['reg_pas_hb1']/$value['min_majorhb1']*100,2);
    //         }

    //         if($value['reg_pas_hb2'] == 0 || $value['min_majorhb2'] == 0 ){
    //             $tl_hb2 = '';
    //         }else{
    //             $tl_hb2 = round($value['reg_pas_hb2']/$value['min_majorhb2']*100,2);
    //         }

    //         if($value['reg_pas_nl'] == 0 || $value['min_majorhnl'] == 0 ){
    //             $tl_nl = '';
    //         }else{
    //             $tl_nl = round($value['reg_pas_nl']/$value['min_majornl']*100,2);
    //         }

    //         $a = [$value['id'],$value['name_major'],$value['min_major'],$value['reg_all'],$value['reg_pas'],$value['reg_pas_nv1'],$value['reg_pas_nv2'],$value['reg_pas_nv3'],$tlct,$tl,$value['min_majorhb1'],$value['reg_hb1'],$value['min_mark_hb1'],$value['min_major_hb1'],$value['reg_pas_hb1'],$tl_hb1,$value['min_majorhb2'],$value['reg_hb2'],$value['min_mark_hb2'],$value['min_major_hb2'],$value['reg_pas_hb2'],$tl_hb2,$value['min_majornl'],$value['reg_nl'],$value['min_mark_nl'],$value['min_major_nl'],$value['reg_pas_nl'],$tl_nl];
    //         $datas[] = $a;
    //     }


        return  $this->active;
    }
}
