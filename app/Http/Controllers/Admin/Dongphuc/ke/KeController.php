<?php

namespace App\Http\Controllers\ke;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class KeController extends Controller
{
    function ke_them(Request $request)
    {
        // $pdf = PDF::loadView('main');
        $data = DB::table('loai')
        ->where('id_loai',54)
        ->get();

        $sql = "SELECT *,loai.id_loai as id_loai, loai.id as id, if(soluong is null, 0,soluong) as soluong1 FROM (SELECT loai.id_loai, nsx.name as name1 , loai.name as name, nsx.id as id FROM `loai` INNER JOIN nsx ON nsx.id = loai.id WHERE loai.trangthai = 1) AS loai LEFT JOIN (SELECT id_loai, loai_nhap.id, if(sum(loai_nhap.soluong) is null,0,sum(loai_nhap.soluong)) as soluong FROM loai_nhap GROUP BY loai_nhap.id_loai,loai_nhap.id) as SL ON loai.id_loai = SL.id_loai AND loai.id = SL.id  LEFT JOIN
        (SELECT  ban.id_loai,ban.id_nsx, sum(soluong) as soluongban FROM ban GROUP BY ban.id_loai,ban.id_nsx) AS SLBAN ON loai.id_loai = SLBAN.id_loai AND loai.id = SLBAN.id_nsx";
        $danhmuc = DB::select($sql);
        
        $data = array(
            'id_loai' => $data[0]->id_loai,
            'danhmuc' => $danhmuc,
        );

        $pdf = PDF::loadView('test',$data);

        return $pdf->stream('document.pdf');
        // try {
        //     $existingRecord = DB::table('ke')->where('name', $request->input('ten'));
        //     if (!$existingRecord->exists()) {
        //         // Nếu không tồn tại, thì chèn một bản ghi mới
        //         $record = DB::table('ke')->insert([
        //             'name' => $request->input('ten'),
        //             'slmax' => $request->input('slmax'),
        //         ]);
        //         if ($record > 0) {
        //             return 1;
        //         }
        //     } else return 0;
        // } catch (Exception $e) {
        //     return 2;
        // }
    }
    function load_ke()
    {
        $ke = DB::table('ke')
        ->select('idk as id','name as text')->orderBy('idk', 'ASC')
        ->get();
        echo $ke;
    }
    function hienthike()
    {
        $layten_nhap="SELECT *
        FROM ke";
        // $loai_nhap = DB::table('loai_nhap')
        //     // ->select('id_loai as id','name as text')
        //     // ->orderBy('id_loai', 'ASC')
        //     ->get();
        $json_data['data'] = DB::select($layten_nhap);
        $data = json_encode($json_data);
        echo  $data;
    }
    function delete_ke($id)
    {
        $dlt_ke="DELETE FROM ke
        WHERE idk = $id";
        $result=DB::select($dlt_ke);
        if($result>0){
            return 1;
        }
    }
    function edit_ke($id)
    {
        $dlt_ke = DB::table('ke')
        ->select(['*']) // Danh sách cột bạn muốn lấy
        ->where('idk', $id)
        ->first(); // Lấy dữ liệu từ bảng 'ke'
    return response()->json($dlt_ke); 
    }
    function submit_ke(Request $request)
    {   
        try{
            $idk = $request->id;
            $name = $request->name;
            $slmax = $request->slmax;
            // Kiểm tra xem có bất kỳ hàng nào được cập nhật không
            $updatedRows = DB::table('ke')
                ->where('idk', $idk)
                ->update([
                    'name' => $name,
                    'slmax' => $slmax,
                ]);
            return 1;
        }
        catch(Exception $e)
        {
            return 0;
        }
    }
}
