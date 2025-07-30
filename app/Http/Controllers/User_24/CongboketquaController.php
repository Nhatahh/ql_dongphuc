<?php

namespace App\Http\Controllers\User_24;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use PhpOption\Option;
use Carbon\Carbon;
use PhpParser\Node\Expr\FuncCall;
use \App\Http\Controllers\User\Main\InfoUserController;
use \App\Http\Controllers\User\Main\RegisterWishController;
use Exception;

use function PHPUnit\Framework\countOf;

class CongboketquaController extends Controller

{
function motdottuyensinh(){
    return [2,3];
}

public function congboketqua(){
    $dotts = $this->motdottuyensinh();
    $id_taikhoan = Auth::guard('loginbygoogles')->id();
    $img_slider = DB::select("SELECT 24_image_chuan.id, 24_image_chuan.funtion_id,24_image_chuan.ghichu,24_image_chuan.loaianh,if(image.path_img is null,'/img/test.png',image.path_img) as path_img,if(image.id is null,0,image.id) as test  FROM `24_image_chuan` LEFT JOIN (SELECT * FROM 24_image WHERE id_taikhoan = ".$id_taikhoan." AND loaianh > 1) AS image ON 24_image_chuan.id = image.id_image_chuan ORDER BY thutu ASC");
    $avatar=DB::table('24_image')
        ->select('path_img')
        ->where('id_taikhoan',$id_taikhoan)
        ->where('loaianh',1)
        ->get();
    $name_user=DB::table('24_thongtincanhan')
        ->select('hoten','cccd')
        ->where('id_taikhoan',$id_taikhoan)
        ->first();
    $trungtuyen = DB::table('24_trungtuyen')
        ->select('24_trungtuyen.id as id','24_trungtuyen.*','24_chuyennganh.tenchuyennganh','ten_cvht','dienthoai_cvht','xacnhan','xacnhan_cccd','congbo')
        ->where('id_taikhoan', $id_taikhoan)
        ->whereIN('24_trungtuyen.iddot', $dotts)
        // ->orWhere('24_trungtuyen.iddot', 2)
        ->join('24_chuyennganh','24_chuyennganh.id','24_trungtuyen.id_chuyennganh')
        ->join('24_covanhoctap','24_covanhoctap.id_chuyennganh','24_trungtuyen.id_chuyennganh')
        ->get();
    if( count($avatar) <= 0 ){
    $avatar_tmp ='img/student_icon.jpg';
    }
    elseif($avatar[0]->path_img == null){
        $avatar_tmp ='img/student_icon.jpg';
    }else{
        $avatar_tmp =$avatar[0]->path_img;
    }


    if( $img_slider){
        return view('user_24.congboketqua',
        [
            'img_slider_right' =>  $img_slider,
            'avatar' =>  $avatar_tmp,
            'name_user' =>  $name_user->cccd,
            'trungtuyen' =>  $trungtuyen,
            'img_slider' =>  $img_slider,
            // 'sinhvien' =>   $sinhvien,
        ]);
    }else{
        return view('user_24.congboketqua',
        [
            'img_slider_right' =>  $img_slider,
            'avatar' => $avatar_tmp ,
            'name_user' =>  $name_user->cccd,
            'trungtuyen' =>  $trungtuyen,
            'img_slider' =>  $img_slider,
        ]);
    }
}

function loadthongtinsinhvien(){
    $id_taikhoan = Auth::guard('loginbygoogles')->id();
    $ttcn1 =  DB::table('24_thongtincanhan')
    ->leftjoin('24_bhyt', '24_thongtincanhan.id_taikhoan', '=', '24_bhyt.id_taikhoan')
    ->leftjoin('24_hosonhaphoc', '24_thongtincanhan.id_taikhoan', '=', '24_hosonhaphoc.id_taikhoan')
    ->select('id_tongiao', 'id_dantoc','id_quoctich', 'id_tinh_noisinh', 'id_huyen_noisinh', 'id_xa_noisinh', 'id_huyen_ttru', 'id_tongiao as tongiao',
            'id_tinh_ttru', 'id_xa_ttru', 'id_tinh_quequan', 'id_huyen_quequan', 'id_xa_quequan', 'ngaycapcccd', 'giaykhaisinh',
            'ngayvaodang', 'ngayvaodoan', 'duoi_xa_ttru', 'duoi_xa_quequan', 'hotencha', 'hotenme','nguoidodau', 'dienthoaicha',
            'dienthoaime', 'dienthoainguoidodau', 'nghenghiepcha', 'nghenghiepme', 'nghenghiepnguoidodau', 'khuyettat', '24_hosonhaphoc.bhyt',
            'diachilienlac','noicapcccd')
    ->where('24_thongtincanhan.id_taikhoan',$id_taikhoan)
    ->first();

    //Dân tộc
    $dt = $ttcn1->id_dantoc;
    $dantoc = DB::select("SELECT l_nation.id as id, name_nation as text FROM l_nation");
    foreach ($dantoc as $key => $row) {
        if($row->id == $dt){
            $row->selected = "selected";
        }else{
            $row->selected  = "";
        }
    }

    // return $dantoc;

    if($dt == 0){
        $dantoc0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Dân tộc",
                'selected' => "selected"
            ]
        );
        $dantoc[] = $dantoc0;
    }
    // return $dantoc;

    //Nơi cấp CMND
    $noicapcccd = DB::select("SELECT l_province.id as id, l_province.name_province as text FROM l_province");
    $noicap = $ttcn1->noicapcccd;
    foreach ($noicapcccd as $key => $row) {
        if($row->id == $noicap){
            $row->selected = "selected";
        }else{
            $row->selected  = "";
        }
    }
    if($noicap == 0){
        $noicapcccd0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Nơi câp",
                'selected' => "selected"
            ]
        );
        $noicapcccd[] = $noicapcccd0;
    }

    //Quôc tịch
    $quoctich = DB::select("SELECT l_nationality.id as id, l_nationality.name_nationality as text FROM l_nationality");
    $qt = $ttcn1->id_quoctich;
    foreach ($quoctich as $key => $row) {
        if($row->id == $qt){
            $row->selected = "selected";
        }else{
            $row->selected  = "";
        }
    }
    if($qt == 0){
        $quoctich0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Quốc tịch",
                'selected' => "selected"
            ]
        );
        $quoctich[] = $quoctich0;
    }

    //Tôn giáo
    $tg =  $ttcn1->tongiao;
    $tongiao = DB::select("SELECT l_religion.id as id, l_religion.tentongiao as text FROM l_religion");
    foreach ($tongiao as $key => $row) {
        if($row->id == $tg){
            $row->selected = "selected";
        }else{
            $row->selected  = "";
        }
    }
    if($tg == 0){
        $tongiao0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Tôn giáo",
                'selected' => "selected"
            ]
        );
        $tongiao[] = $tongiao0;
    }


    //noisinh
    $id_tinh_noisinh = $ttcn1->id_tinh_noisinh;
    $id_huyen_noisinh = $ttcn1->id_huyen_noisinh;
    $id_xa_noisinh = $ttcn1->id_xa_noisinh;
    $province_noisinh_tinh = DB::select("SELECT l_province.id as id, l_province.name_province as text FROM l_province");
    $province_noisinh_huyen = DB::select("SELECT l_province2.id as id, l_province2.name_province2 as text FROM l_province2 WHERE id_province = ?",[$id_tinh_noisinh]);
    $province_noisinh_xa = DB::select("SELECT l_province3.id AS id, l_province3.name_province3 AS text FROM l_province3 WHERE id_province2 = ?",[$id_huyen_noisinh]);
    foreach ($province_noisinh_tinh as $key => $row) {
    if($row->id == $id_tinh_noisinh){
            $row->selected = "selected";
    }else{
            $row->selected = "";
    }
    }
    if($id_tinh_noisinh == 0){
        $province_noisinh_tinh0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Tỉnh/TP",
                'selected' => "selected"
            ]
        );
        $province_noisinh_tinh[] = $province_noisinh_tinh0;
    }
    foreach ($province_noisinh_huyen as $key => $row) {
        if($row->id == $id_huyen_noisinh){
            $row->selected = "selected";
        }else{
            $row->selected = "";
        }
    }
    if($id_huyen_noisinh == 0){
        $province_noisinh_huyen0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Quận/Huyện",
                'selected' => "selected"
            ]
        );
        $province_noisinh_huyen[] = $province_noisinh_huyen0;
    }
    foreach ($province_noisinh_xa as $key => $row) {
        if($row->id == $id_xa_noisinh){
            $row->selected = "selected";
        }else{
            $row->selected = "";
        }
    }
    if($id_xa_noisinh == 0){
        $province_noisinh_xa0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Xã/Phường",
                'selected' => "selected"
            ]
        );
        $province_noisinh_xa[] = $province_noisinh_xa0;
    }
    //quequan
    $id_tinh_quequan = $ttcn1->id_tinh_quequan;
    $id_huyen_quequan = $ttcn1->id_huyen_quequan;
    $id_xa_quequan = $ttcn1->id_xa_quequan;
    $province_quequan_tinh = DB::select("SELECT l_province.id as id, l_province.name_province as text FROM l_province");
    $province_quequan_huyen = DB::select("SELECT l_province2.id as id, l_province2.name_province2 as text FROM l_province2 WHERE id_province = ?",[$id_tinh_quequan]);
    $province_quequan_xa = DB::select("SELECT l_province3.id AS id, l_province3.name_province3 AS text FROM l_province3 WHERE id_province2 = ?",[$id_huyen_quequan]);

    foreach ($province_quequan_tinh as $key => $row) {
        if($row->id == $id_tinh_quequan){
            $row->selected = "selected";
        }else{
            $row->selected = "";
        }
    }
    if($id_tinh_quequan == 0){
        $province_quequan_tinh0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Tỉnh/TP",
                'selected' => "selected"
            ]
        );
        $province_quequan_tinh[] = $province_quequan_tinh0;
    }
    foreach ($province_quequan_huyen as $key => $row) {
        if($row->id == $id_huyen_quequan){
            $row->selected = "selected";
        }else{
            $row->selected = "";
        }
    }
    if($id_huyen_quequan == 0){
        $province_quequan_huyen0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Quận/Huyện",
                'selected' => "selected"
            ]
        );
        $province_quequan_huyen[] = $province_quequan_huyen0;
    }
    foreach ($province_quequan_xa as $key => $row) {
        if($row->id == $id_xa_quequan){
            $row->selected = "selected";
        }else{
            $row->selected = "";
        }
    }
    if($id_xa_quequan == 0){
        $province_quequan_xa0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Xã/Phường",
                'selected' => "selected"
            ]
        );
        $province_quequan_xa[] = $province_quequan_xa0;
    }
    //thuongtru
    $id_tinh_ttru = $ttcn1->id_tinh_ttru;
    $id_huyen_ttru = $ttcn1->id_huyen_ttru;
    $id_xa_ttru = $ttcn1->id_xa_ttru;
    $province_ttru_tinh = DB::select("SELECT l_province.id as id, l_province.name_province as text FROM l_province");
    $province_ttru_huyen = DB::select("SELECT l_province2.id as id, l_province2.name_province2 as text FROM l_province2 WHERE id_province = ?",[$id_tinh_ttru]);
    $province_ttru_xa = DB::select("SELECT l_province3.id AS id, l_province3.name_province3 AS text FROM l_province3 WHERE id_province2 = ?",[$id_huyen_ttru]);
    foreach ($province_ttru_tinh as $key => $row) {
        if($row->id == $id_tinh_ttru){
            $row->selected = "selected";
        }else{
            $row->selected  = "";
        }
    }
    if($id_tinh_ttru == 0){
        $province_ttru_tinh0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Tỉnh/TP",
                'selected' => "selected"
            ]
        );
        $province_ttru_tinh[] = $province_ttru_tinh0;
    }
    foreach ($province_ttru_huyen as $key => $row) {
        if($row->id == $id_huyen_ttru){
            $row->selected = "selected";
        }else{
            $row->selected  = "";
        }
    }
    if($id_huyen_ttru == 0){
        $province_ttru_huyen0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Quận/Huyện",
                'selected' => "selected"
            ]
        );
        $province_ttru_huyen[] = $province_ttru_huyen0;
    }
    foreach ($province_ttru_xa as $key => $row) {
        if($row->id == $id_xa_ttru){
            $row->selected  = "selected";
        }else{
            $row->selected  = "";
        }
    }
    if($id_xa_ttru == 0){
        $province_ttru_xa0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Xã/Phường",
                'selected' => "selected"
            ]
        );
        $province_ttru_xa[] = $province_ttru_xa0;
    }



    $res = new Collection(
        [
            // 'noisinh' =>  $noisinh,
            'tongiao' => $tongiao,
            'quoctich' => $quoctich,
            'dantoc' => $dantoc,
            // 'ngaysinh' => $ttcn[0]->ngaysinh,
            'giaykhaisinh' =>$ttcn1->giaykhaisinh,
            'noicapcccd' =>$noicapcccd,
            // 'gioitinh' =>  $ttcn[0]->gioitinh,
            'ngaycapcccd' =>$ttcn1->ngaycapcccd,
            'ngayvaodang' =>$ttcn1->ngayvaodang,
            'ngayvaodoan' =>$ttcn1->ngayvaodoan,
            'noisinh_tinh' =>$province_noisinh_tinh,
            'noisinh_huyen' =>$province_noisinh_huyen,
            'noisinh_xa' =>$province_noisinh_xa,
            // 'duoi_xa_noisinh' =>$ttcn1->giaykhaisinh,
            'quequan_tinh' =>$province_quequan_tinh,
            'quequan_huyen' =>$province_quequan_huyen,
            'quequan_xa' =>$province_quequan_xa,
            'duoi_xa_quequan' =>$ttcn1->duoi_xa_quequan,
            'ttru_tinh' =>$province_ttru_tinh,
            'ttru_huyen' =>$province_ttru_huyen,
            'ttru_xa' =>$province_ttru_xa,
            'duoi_xa_ttru' =>$ttcn1->duoi_xa_ttru,
            'hotencha' =>$ttcn1->hotencha,
            'hotenme' =>$ttcn1->hotenme,
            'nguoidodau' =>$ttcn1->nguoidodau,
            'dienthoaicha' =>$ttcn1->dienthoaicha,
            'dienthoaime' =>$ttcn1->dienthoaime,
            'dienthoainguoidodau' =>$ttcn1->dienthoainguoidodau,
            'nghenghiepcha' =>$ttcn1->nghenghiepcha,
            'nghenghiepme' =>$ttcn1->nghenghiepme,
            'nghenghiepnguoidodau' =>$ttcn1->nghenghiepnguoidodau,
            // 'khuyettat' =>$ttcn1->khuyettat,
            'bhyt' =>$ttcn1->bhyt,
            'diachilienlac' =>$ttcn1->diachilienlac,
            // 'lichsu' => $lichsu,
        ]
    );
    return array(
        'data' => $res,
        'trangthai' => 1
    );

}


    //Noi sinh
// Hàm load tỉnh
public function loadtinh()
{
    $tinh =  DB::select('SELECT l_province.id, l_province.name_province as text FROM `l_province`');
    return $tinh;

}
// ham load huyen
public function loadhuyen($tinh1)
{
    $huyen_noisinh = DB::table('l_province2')
    ->select('id','name_province2 as text')
    ->where('id_province',$tinh1)
    ->get();
        // Thêm giá trị mặc định vào đầu danh sách
    $defaultHuyen = collect([['id' => 0, 'text' => 'Chọn huyện']]);
    $huyen_noisinh = $defaultHuyen->merge($huyen_noisinh);
    return $huyen_noisinh;
}
// ham load xa
public function loadxa($huyen1)
{
    $xa = DB::table('l_province3')
    ->select('id','name_province3 as text')
    ->where('id_province2',$huyen1)
    ->get();
    $defaultXa = collect([['id' => 0, 'text' => 'Chọn xã']]);
    $xa = $defaultXa->merge($xa);
    return $xa;
}

    //thuong tru
// Hàm load tỉnh
public function loadtinh2()
{
    $tinh =  DB::select('SELECT l_province.id, l_province.name_province as text FROM `l_province`');
    return $tinh;
}

    // ham load huyen
public function loadhuyen2($tinh1)
{
    $huyen = DB::table('l_province2')
    ->select('id','name_province2 as text')
    ->where('id_province',$tinh1)
    ->get();
    $defaultHuyen = collect([['id' => 0, 'text' => 'Chọn huyện']]);
    $huyen = $defaultHuyen->merge($huyen);
    return $huyen;
}

    // ham load xa
public function loadxa2($huyen1)
{
    $xa = DB::table('l_province3')
    ->select('id','name_province3 as text')
    ->where('id_province2',$huyen1)
    ->get();
    $defaultXa = collect([['id' => 0, 'text' => 'Chọn xã']]);
    $xa = $defaultXa->merge($xa);
    return $xa;
}

    //que quan
    // Hàm load tỉnh
public function loadtinh3()
{
    $tinh =  DB::select('SELECT l_province.id, l_province.name_province as text FROM `l_province`');
    return $tinh;
}


    // ham load huyen
public function loadhuyen3($tinh1)
{
    $huyen = DB::table('l_province2')
    ->select('id','name_province2 as text')
    ->where('id_province',$tinh1)
    ->get();
    $defaultHuyen = collect([['id' => 0, 'text' => 'Chọn huyện']]);
    $huyen = $defaultHuyen->merge($huyen);
    return $huyen;
}

    // ham load xa
public function loadxa3($huyen1)
{
    $xa = DB::table('l_province3')
    ->select('id','name_province3 as text')
    ->where('id_province2',$huyen1)
    ->get();
    $defaultXa = collect([['id' => 0, 'text' => 'Chọn xã']]);
    $xa = $defaultXa->merge($xa);
    return $xa;
}


function kiemtraxacnhan( $id){
    $data =  DB::table('24_trungtuyen')
    ->where('id',$id)
    ->first();
    if($data ->xacnhan == 1){
        $trangthai = 1;
        $cccd = $data ->xacnhan_cccd;
    }else{
        $trangthai = 0;
        $cccd = '';
    }
    return array(
        'trangthai' => $trangthai,
        'cccd' => $cccd
    );
}

function khoadot($id){
    $dot = DB::table('24_dotxettuyen')
    ->join('24_trungtuyen','24_dotxettuyen.iddotxt','24_trungtuyen.iddotxt')
    ->where('24_trungtuyen.id',$id)
    ->first()->khoadot;
    if($dot){
        return 1;
    }else{
        return 0;
    }
}

function xacnhannhaphoc(Request $request){
    $cccd = $request->input('cccd');
    $id = $request->input('id');
    $id_taikhoan = Auth::guard('loginbygoogles')->id();
    // $cccd = DB::table('24_thongtincanhan')->where('id_taikhoan',$id_taikhoan)->first()->cccd;
    if($this->khoadot( $id ) == 1){
        $trangthai = "khoadot_1";
        $noidung = "";
    }else{
        $kiemtraxacnhan = $this->kiemtraxacnhan( $id);
        if($kiemtraxacnhan['trangthai'] == 0){
            DB::beginTransaction();
            try{
                DB::table('24_trungtuyen')
                ->where('id',$id)
                ->update([
                    'xacnhan_cccd' => $cccd,
                    'xacnhan' => 1,
                ]);
                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                DB::table('24_lichsu')
                ->insert([
                    'id_taikhoan' => $id_taikhoan,
                    'noidung'   => "Xác nhận nhập học: ".$cccd,
                    'hienthi'   => 1,
                    'id_nhansu' => 0,
                    'thietbi'   => $user_agent,
                    'ip'        => request()->ip()
                ]);
                DB::commit();
                $noidung = $this->kiemtraxacnhan($id);
                $trangthai = 1;
            }catch(Exception $e){
                DB::rollBack();
                $trangthai = -100;
            }
        }else{
            $trangthai = 0;
            $noidung = $kiemtraxacnhan;
        }
    }
    return array(
        'trangthai' => $trangthai,
        'noidung' => $noidung,
    );
}

function daxemketqua(Request $request){
    $id_taikhoan = Auth::guard('loginbygoogles')->id();
    DB::table('24_trungtuyen')
    ->where('id_taikhoan',$id_taikhoan)
    ->where('iddot',$this->motdottuyensinh())
    ->update([
        'daxem' => 1,
    ]);
}

function capnhatthongtincannhan(Request $request)
{
    $id_taikhoan = Auth::guard('loginbygoogles')->id();
    $data = $request->input('data');
    $noidung = "";
    for ($i=0; $i < count($data) ; $i++) {
        $data1[$data[$i][0]] = $data[$i][1];
        $data1['id_taikhoan'] =  $id_taikhoan;

        if($data[$i][0] == 'diachilienlac' && $data[$i][1] != null && $data[$i][1] != 0){
            $diachi = $data[$i][1];
        }
        $noidung .= $data[$i][0].': '.$data[$i][1]. "-";
    }
    DB::table('24_thongtincanhan')
    ->where('id_taikhoan',$id_taikhoan)
    ->update(
        ['diachi' => $diachi]
    );
    // return $data1;
    DB::table('24_hosonhaphoc')->where('id_taikhoan',$id_taikhoan)->delete();
    $hs = DB::table('24_hosonhaphoc')
    ->insert($data1);

    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    DB::table('24_lichsu')
    ->insert([
        'id_taikhoan' => $id_taikhoan,
        'noidung'   => "Cập nhật thông tin sinh viên trên cổng xét tuyển ",
        'hienthi'   => 1,
        'id_nhansu' => 0,
        'thietbi'   => $user_agent,
        'ip'        => request()->ip(),
        'ghichu'   => "Cập nhật thông tin sinh viên trên cổng xét tuyển: ".$noidung,
    ]);
    if($hs == 1 ){
        return 'UpOrIns_1';
    }else{
        return 'UpOrIns_0';
    }
}

}
