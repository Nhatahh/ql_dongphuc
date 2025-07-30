<?php

namespace App\Http\Controllers\Admin;

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
use PhpParser\Node\Expr\FuncCall;
use \App\Http\Controllers\User\Main\InfoUserController;
use \App\Http\Controllers\Admin\YearBatchController;

use \App\Http\Controllers\User\Main\RegisterWishController;
use Exception;
use LDAP\Result;
use Psy\Command\WhereamiCommand;

use function PHPUnit\Framework\countOf;

class UpdateTtsvController extends Controller

{

    // public function index(){


    //     // $wish = DB::select("SELECT TT.pass_bo, if(TT.check_end = 1,'Đã xác nhận','Xác nhận') as check_end ,TT.id as id_search, if(TT.id_wish is null,0,1) as id_check, if(TT.pass_bo = 0  or TT.pass_bo is null, 'Trượt', 'Đỗ') as tt, INFO.* FROM (SELECT l_policy_users.name_policy_user, l_priority_area.id_priority_area, l_group.id_group as name_group, if(l_wish.tts = 1,'x','') as tts, l_wish.id_method as id_method_id ,priority_mark,group_mark,l_wish.id_batch as id_batch,l_wish.id_user,l_wish.mark,l_wish.number_bo, l_wish.id as id, l_wish.id_method as method, l_wish.id_major as id_major, l_major.name_major,l_method.id_method as id_method,l_method_major.min_mark, l_wish.id_group as id_group  FROM `l_wish` INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_method_major.id_major = l_major.id INNER JOIN l_batch_method ON l_batch_method.id = l_wish.id_method INNER JOIN l_method ON l_batch_method.id_method = l_method.id INNER JOIN l_group ON l_group.id = l_wish.id_group INNER JOIN l_info_users ON l_info_users.id_user = l_wish.id_user INNER JOIN l_priority_area ON l_priority_area.id = l_info_users.id_priority_area_user LEFT JOIN l_policy_users_reg ON l_policy_users_reg.id_user = l_wish.id_user LEFT JOIN l_policy_users ON l_policy_users.id = l_policy_users_reg.id_policy_users WHERE l_wish.id_user = ".$id_user.") AS INFO LEFT JOIN (SELECT * FROM l_go_batch_pass WHERE id_batch = 18) AS TT ON INFO.id = TT.id_wish");
    //     // $info = DB::select("SELECT date_dukien, l_info_users.id as id,sothebhyt, address_user, tencha_sv, nghenghiepcha_sv, dienthoaicha_sv, tenme_sv, nghenghiepme_sv, dienthoaime_sv, dodau_sv, nghenghiepdodau_sv, dienthoaidodau_sv, noisinh_cccd, name_province_quequan_xa,name_province_quequan_tinh, name_province_quequan_huyen, dow_quequan_xa, l_province3.name_province3 as name_province3, l_province2.name_province2 as name_province2, l_province.name_province as name_province, down_province3,doan_sv, dang_sv,l_info_users.date_card, l_users.id_card_users, l_users.phone_users, sex_user, l_info_users.name_user, l_info_users.birth_user FROM l_info_users INNER JOIN l_users ON l_users.id = l_info_users.id_user LEFT JOIN l_province ON l_province.id = l_info_users.id_khttprovince_user LEFT JOIN l_province2 ON l_province2.id = l_info_users.id_khttprovince2_user LEFT JOIN l_province3 ON l_info_users.id_khttprovince3_user = l_province3.id LEFT JOIN (SELECT id_user,l_province.name_province as name_province_quequan_tinh, l_province2.name_province2 as name_province_quequan_huyen, l_province3.name_province3 as name_province_quequan_xa FROM l_info_users INNER JOIN l_province ON l_province.id = l_info_users.quequan_tinh INNER JOIN l_province2 ON l_province2.id = l_info_users.quequan_huyen INNER JOIN l_province3 ON l_info_users.quequan_xa = l_province3.id) AS QQ ON QQ.id_user = l_info_users.id_user WHERE l_info_users.id_user = ".$id_user);
    //     // $nation = DB::select("SELECT l_nation.id as id, name_nation,if(l_info_users.id_nation_user is null,'','selected') as selected FROM l_nation LEFT JOIN (SELECT id_nation_user FROM l_info_users WHERE id_user = ".$id_user.") as l_info_users ON l_info_users.id_nation_user = l_nation.id");
    //     // $religion = DB::select("SELECT l_religion.id as id, l_religion.tentongiao,if(l_info_users.id_religion is null,'','selected') as selected FROM l_religion LEFT JOIN (SELECT l_info_users.id_religion FROM l_info_users WHERE id_user = ".$id_user.") as l_info_users ON l_info_users.id_religion = l_religion.id");
    //     // $nationality = DB::select("SELECT l_nationality.id as id, l_nationality.name_nationality,if(l_info_users.id_nationality is null,'','selected') as selected FROM l_nationality LEFT JOIN (SELECT l_info_users.id_nationality FROM l_info_users WHERE id_user = ".$id_user.") as l_info_users ON l_info_users.id_nationality = l_nationality.id");
    //     // $province_place_card = DB::select("SELECT l_province.id as id, l_province.name_province,if(l_info_users.id_place_card is null,'','selected') as selected FROM l_province LEFT JOIN (SELECT l_info_users.id_place_card FROM l_info_users WHERE id_user = ".$id_user.") as l_info_users ON l_info_users.id_place_card = l_province.id ");
    //     // $province_httttinh = DB::select("SELECT l_province.id as id, l_province.name_province,if(l_info_users.id_khttprovince_user is null,'','selected') as selected FROM l_province LEFT JOIN (SELECT id_khttprovince_user FROM l_info_users WHERE id_user = ".$id_user.") as l_info_users ON l_info_users.id_khttprovince_user = l_province.id");
    //     // $province_httthuyen = DB::select("SELECT huyen.id as id, huyen.name_province2 as name_province2, if(USER.id is null,'','selected') as selected FROM (SELECT l_province2.id as id, l_province2.name_province2 FROM l_province2 INNER JOIN (SELECT l_info_users.id_khttprovince_user,id_khttprovince2_user FROM l_info_users WHERE id_user = ".$id_user.") as l_info_users ON l_info_users.id_khttprovince_user = l_province2.id_province) as huyen LEFT JOIN (SELECT l_info_users.id_khttprovince2_user as id FROM l_info_users WHERE  id_user = ".$id_user.") AS USER  ON USER.id = huyen.id");
    //     // $province_htttxa = DB::select("SELECT xa.id as id, xa.name_province3 as name_province3, if(USER.id is null,'','selected') as selected FROM (SELECT l_province3.id as id, l_province3.name_province3 FROM l_province3 INNER JOIN (SELECT l_info_users.id_khttprovince2_user,id_khttprovince3_user FROM l_info_users WHERE id_user =".$id_user.") as l_info_users ON l_info_users.id_khttprovince2_user = l_province3.id_province2) as xa LEFT JOIN (SELECT l_info_users.id_khttprovince3_user as id FROM l_info_users WHERE  id_user = ".$id_user.") AS USER  ON USER.id = xa.id");

    //     // $province_quequan_tinh = DB::select("SELECT l_province.id as id, l_province.name_province,if(l_info_users.quequan_tinh is null,'','selected') as selected FROM l_province LEFT JOIN (SELECT quequan_tinh FROM l_info_users WHERE id_user = ".$id_user.") as l_info_users ON l_info_users.quequan_tinh = l_province.id");
    //     // $province_quequan_huyen = DB::select("SELECT huyen.id as id, huyen.name_province2 as name_province2, if(USER.quequan_huyen is null,'','selected') as selected FROM (SELECT l_province2.id as id, l_province2.name_province2 FROM l_province2 INNER JOIN (SELECT l_info_users.quequan_tinh, quequan_huyen FROM l_info_users WHERE id_user = ".$id_user.") as l_info_users ON l_info_users.quequan_tinh = l_province2.id_province) as huyen LEFT JOIN (SELECT * FROM l_info_users WHERE l_info_users.id_user = ".$id_user.") AS USER ON USER.quequan_huyen = huyen.id");
    //     // $province_quequan_xa = DB::select("SELECT xa.id as id, xa.name_province3 as name_province3, if(USER.quequan_xa is null,'','selected') as selected FROM (SELECT l_province3.id as id, l_province3.name_province3 FROM l_province3 INNER JOIN (SELECT l_info_users.quequan_huyen, quequan_xa FROM l_info_users WHERE id_user =".$id_user.") as l_info_users ON l_info_users.quequan_huyen = l_province3.id_province2) as xa LEFT JOIN (SELECT * FROM l_info_users WHERE l_info_users.id_user = ".$id_user.") AS USER  ON USER.quequan_xa = xa.id");

    //     // $province_noisinh_tinh = DB::select("SELECT l_province.id as id, l_province.name_province,if(l_info_users.id_place_user is null,'','selected') as selected FROM l_province LEFT JOIN (SELECT id_place_user FROM l_info_users WHERE id_user = ".$id_user.") as l_info_users ON l_info_users.id_place_user = l_province.id");
    //     // $province_noisinh_huyen = DB::select("SELECT huyen.id as id, huyen.name_province2 as name_province2, if(USER.noisinh_huyen is null,'','selected') as selected FROM (SELECT l_province2.id as id, l_province2.name_province2 FROM l_province2 INNER JOIN (SELECT l_info_users.id_place_user, noisinh_huyen FROM l_info_users WHERE id_user = ".$id_user.") as l_info_users ON l_info_users.id_place_user = l_province2.id_province) as huyen LEFT JOIN (SELECT * FROM l_info_users WHERE l_info_users.id_user = ".$id_user.") AS USER  ON USER.noisinh_huyen = huyen.id");
    //     // $province_noisinh_xa = DB::select("SELECT xa.id as id, xa.name_province3 as name_province3, if(USER.noisinh_xa is null,'','selected') as selected FROM (SELECT l_province3.id as id, l_province3.name_province3 FROM l_province3 INNER JOIN (SELECT l_info_users.noisinh_huyen, noisinh_xa FROM l_info_users WHERE id_user = ".$id_user.") as l_info_users ON l_info_users.noisinh_huyen = l_province3.id_province2) as xa LEFT JOIN (SELECT * FROM l_info_users WHERE l_info_users.id_user =  ".$id_user.") AS USER ON USER.noisinh_xa = xa.id");

    //     // $chinhsach = DB::select("SELECT l_chinhsach.id as id, l_chinhsach.name_chinhsach, if(CS.id_chinhsach is null, '', 'selected') as selected FROM `l_chinhsach` LEFT JOIN (SELECT l_info_users.id_chinhsach  FROM l_info_users WHERE id_user = ".$id_user.") AS CS ON l_chinhsach.id = CS.id_chinhsach");
    //     // $khuyettat = DB::select("SELECT l_khuyettat.id as id, l_khuyettat.name_khuyettat, if(CS.id_khuyettat is null, '', 'selected') as selected FROM `l_khuyettat` LEFT JOIN (SELECT l_info_users.id_khuyettat  FROM l_info_users WHERE id_user = ".$id_user.") AS CS ON l_khuyettat.id = CS.id_khuyettat");


    //     // $data =
    //     // [
    //     //     // 'title' => base64_encode($id_user." X ".$wish[0]->id),
    //     //     'title' =>base64_encode($id_user."_".$wish[0]->id),
    //     //     'wish' => $wish,
    //     //     'info' => $info,
    //     //     'nation' => $nation,
    //     //     'religion' => $religion,
    //     //     'nationality' => $nationality,
    //     //     'province_place_card' => $province_place_card,

    //     //     'province_httttinh' => $province_httttinh,
    //     //     'province_httthuyen' => $province_httthuyen,
    //     //     'province_htttxa' => $province_htttxa,

    //     //     'province_quequan_tinh' => $province_quequan_tinh,
    //     //     'province_quequan_huyen' => $province_quequan_huyen,
    //     //     'province_quequan_xa' => $province_quequan_xa,

    //     //     'province_noisinh_tinh' => $province_noisinh_tinh,
    //     //     'province_noisinh_huyen' => $province_noisinh_huyen,
    //     //     'province_noisinh_xa' => $province_noisinh_xa,
    //     //     'chinhsach' => $chinhsach,
    //     //     'khuyettat' => $khuyettat,
    //     //     'check_save_ìnfo' =>base64_encode($id_user."_".$info[0]->id),
    //     //     'pass' => $this ->check_pass()
    //     //     // 'hktt'  =>  $info[0]->down_province3.",".$info[0]->name_province3.",".$info[0]->name_province3.",".$info[0]->name_province3
    //     // ];
    //     return view('admin.update_ttsv.index');

    // }

    public function index(){

        // return redirect('admin/update_ttsv');
        return view('admin.update_ttsv.index_temp',
        [
            'title' => "CTUT|Hệ thống đăng ký xét tuyển",
        ]);
    }


    public function login1(){

        // return redirect('admin/update_ttsv');
        return view('admin.update_ttsv.index',
        [
            'title' => "CTUT|Hệ thống quản lý hồ sơ",
        ]);
    }

    public function update_ttsv_slide($batch,$cmnd){
        $id_user = DB::table('l_users')
        ->select('id')
        ->where('id_batch',$batch)
        ->where('id_card_users',$cmnd)
        ->get();
        if( count($id_user) > 0){
            $sliders = DB::table('l_image_hocba')
            ->select('link_img','note_type')
            ->where('id_user' , $id_user[0]->id)
            ->orderBy('number_img','ASC')
            ->get();
            $html =  "";
            if(count($sliders)>0){
                foreach ($sliders as $key => $slider) {
                    $html .= '<div class="swiper-slide">';
                    $html .= '<div class="swiper-zoom-container"><img  style="height:450px;width:auto"   src="'.$slider->link_img.'" title="'.$slider->note_type.'"></div>';
                    $html .= '</div>';
                }
            }else{
                $html .= '<div class="swiper-slide">';
                    $html .= '<div class="swiper-zoom-container">Chưa có ảnh</div>';
                $html .= '</div>';
            }
            return $html;
        }else{
            $html = '<div class="swiper-slide">';
                $html .= '<div class="swiper-zoom-container">Chưa có ảnh</div>';
            $html .= '</div>';
        }
    }


    public function update_ttsv_load($batch,$cmnd){
        $id_user = DB::table('l_users')
        ->select('id')
        ->where('id_batch',$batch)
        ->where('id_card_users',$cmnd)
        ->get()[0]->id;

        $info = DB::select("SELECT id_card_users,l_info_users.id as id,sothebhyt, address_user, tencha_sv, nghenghiepcha_sv, dienthoaicha_sv, tenme_sv, nghenghiepme_sv, dienthoaime_sv, dodau_sv, nghenghiepdodau_sv, dienthoaidodau_sv, noisinh_cccd, dow_quequan_xa, down_province3,doan_sv, dang_sv,l_info_users.date_card, l_users.id_card_users, l_users.phone_users, sex_user, l_info_users.name_user, l_info_users.birth_user FROM l_info_users INNER JOIN l_users ON l_users.id = l_info_users.id_user LEFT JOIN l_province ON l_province.id = l_info_users.id_khttprovince_user LEFT JOIN l_province2 ON l_province2.id = l_info_users.id_khttprovince2_user LEFT JOIN l_province3 ON l_info_users.id_khttprovince3_user = l_province3.id LEFT JOIN (SELECT id_user,l_province.name_province as name_province_quequan_tinh, l_province2.name_province2 as name_province_quequan_huyen, l_province3.name_province3 as name_province_quequan_xa FROM l_info_users INNER JOIN l_province ON l_province.id = l_info_users.quequan_tinh INNER JOIN l_province2 ON l_province2.id = l_info_users.quequan_huyen INNER JOIN l_province3 ON l_info_users.quequan_xa = l_province3.id) AS QQ ON QQ.id_user = l_info_users.id_user WHERE l_info_users.id_user = ".$id_user);
        $nation = DB::select("SELECT l_nation.id as id, name_nation as text,if(l_info_users.id_nation_user is null,'','selected') as selected FROM l_nation LEFT JOIN (SELECT id_nation_user FROM l_info_users WHERE id_user = ".$id_user.") as l_info_users ON l_info_users.id_nation_user = l_nation.id");
        $religion = DB::select("SELECT l_religion.id as id, l_religion.tentongiao as text,if(l_info_users.id_religion is null,'','selected') as selected FROM l_religion LEFT JOIN (SELECT l_info_users.id_religion FROM l_info_users WHERE id_user = ".$id_user.") as l_info_users ON l_info_users.id_religion = l_religion.id");
        $nationality = DB::select("SELECT l_nationality.id as id, l_nationality.name_nationality as text,if(l_info_users.id_nationality is null,'','selected') as selected FROM l_nationality LEFT JOIN (SELECT l_info_users.id_nationality FROM l_info_users WHERE id_user = ".$id_user.") as l_info_users ON l_info_users.id_nationality = l_nationality.id");
        $province_place_card = DB::select("SELECT l_province.id as id, l_province.name_province as text,if(l_info_users.id_place_card is null,'','selected') as selected FROM l_province LEFT JOIN (SELECT l_info_users.id_place_card FROM l_info_users WHERE id_user = ".$id_user.") as l_info_users ON l_info_users.id_place_card = l_province.id ");

        $province_noisinh_tinh = DB::select("SELECT l_province.id as id, l_province.name_province as text,if(l_info_users.id_place_user is null,'','selected') as selected FROM l_province LEFT JOIN (SELECT id_place_user FROM l_info_users WHERE id_user = ".$id_user.") as l_info_users ON l_info_users.id_place_user = l_province.id");
        $province_noisinh_huyen = DB::select("SELECT huyen.id as id, huyen.name_province2 as  text, if(USER.noisinh_huyen is null,'','selected') as selected FROM (SELECT l_province2.id as id, l_province2.name_province2 FROM l_province2 INNER JOIN (SELECT l_info_users.id_place_user, noisinh_huyen FROM l_info_users WHERE id_user = ".$id_user.") as l_info_users ON l_info_users.id_place_user = l_province2.id_province) as huyen LEFT JOIN (SELECT * FROM l_info_users WHERE l_info_users.id_user = ".$id_user.") AS USER  ON USER.noisinh_huyen = huyen.id");
        $province_noisinh_xa = DB::select("SELECT xa.id as id, xa.name_province3 as text, if(USER.noisinh_xa is null,'','selected') as selected FROM (SELECT l_province3.id as id, l_province3.name_province3 FROM l_province3 INNER JOIN (SELECT l_info_users.noisinh_huyen, noisinh_xa FROM l_info_users WHERE id_user = ".$id_user.") as l_info_users ON l_info_users.noisinh_huyen = l_province3.id_province2) as xa LEFT JOIN (SELECT * FROM l_info_users WHERE l_info_users.id_user =  ".$id_user.") AS USER ON USER.noisinh_xa = xa.id");

        $province_noisinh_tinh0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Tỉnh/TP",
                'selected' => false
            ]
        );
        $province_noisinh_tinh[] = $province_noisinh_tinh0;
        $province_noisinh_huyen0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Quận/Huyện",
                'selected' => false
            ]
        );
        $province_noisinh_huyen[] = $province_noisinh_huyen0;
        $province_noisinh_xa0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Xã/Phường",
                'selected' => false
            ]
        );
        $province_noisinh_xa[] = $province_noisinh_xa0;

        $province_httttinh = DB::select("SELECT l_province.id as id, l_province.name_province as text,if(l_info_users.id_khttprovince_user is null,'','selected') as selected FROM l_province LEFT JOIN (SELECT id_khttprovince_user FROM l_info_users WHERE id_user = ".$id_user.") as l_info_users ON l_info_users.id_khttprovince_user = l_province.id");
        $province_httthuyen = DB::select("SELECT huyen.id as id, huyen.name_province2 as text, if(USER.id is null,'','selected') as selected FROM (SELECT l_province2.id as id, l_province2.name_province2 FROM l_province2 INNER JOIN (SELECT l_info_users.id_khttprovince_user,id_khttprovince2_user FROM l_info_users WHERE id_user = ".$id_user.") as l_info_users ON l_info_users.id_khttprovince_user = l_province2.id_province) as huyen LEFT JOIN (SELECT l_info_users.id_khttprovince2_user as id FROM l_info_users WHERE  id_user = ".$id_user.") AS USER  ON USER.id = huyen.id");
        $province_htttxa = DB::select("SELECT xa.id as id, xa.name_province3 as text, if(USER.id is null,'','selected') as selected FROM (SELECT l_province3.id as id, l_province3.name_province3 FROM l_province3 INNER JOIN (SELECT l_info_users.id_khttprovince2_user,id_khttprovince3_user FROM l_info_users WHERE id_user = ".$id_user.") as l_info_users ON l_info_users.id_khttprovince2_user = l_province3.id_province2) as xa LEFT JOIN (SELECT l_info_users.id_khttprovince3_user as id FROM l_info_users WHERE  id_user = ".$id_user.") AS USER  ON USER.id = xa.id");

        $province_httttinh0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Tỉnh/TP",
                'selected' => false
            ]
        );
        $province_httttinh[] = $province_httttinh0;
        $province_httthuyen0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Quận/Huyện",
                'selected' => false
            ]
        );
        $province_httthuyen[] = $province_httthuyen0;
        $province_htttxa0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Xã/Phường",
                'selected' => false
            ]
        );
        $province_htttxa[] = $province_htttxa0;


        $province_quequan_tinh = DB::select("SELECT l_province.id as id, l_province.name_province as text,if(l_info_users.quequan_tinh is null,'','selected') as selected FROM l_province LEFT JOIN (SELECT quequan_tinh FROM l_info_users WHERE id_user = ".$id_user.") as l_info_users ON l_info_users.quequan_tinh = l_province.id");
        $province_quequan_huyen = DB::select("SELECT huyen.id as id, huyen.name_province2 as text, if(USER.quequan_huyen is null,'','selected') as selected FROM (SELECT l_province2.id as id, l_province2.name_province2 FROM l_province2 INNER JOIN (SELECT l_info_users.quequan_tinh, quequan_huyen FROM l_info_users WHERE id_user = ".$id_user.") as l_info_users ON l_info_users.quequan_tinh = l_province2.id_province) as huyen LEFT JOIN (SELECT * FROM l_info_users WHERE l_info_users.id_user = ".$id_user.") AS USER ON USER.quequan_huyen = huyen.id");
        $province_quequan_xa = DB::select("SELECT xa.id as id, xa.name_province3 as text, if(USER.quequan_xa is null,'','selected') as selected FROM (SELECT l_province3.id as id, l_province3.name_province3 FROM l_province3 INNER JOIN (SELECT l_info_users.quequan_huyen, quequan_xa FROM l_info_users WHERE id_user =".$id_user.") as l_info_users ON l_info_users.quequan_huyen = l_province3.id_province2) as xa LEFT JOIN (SELECT * FROM l_info_users WHERE l_info_users.id_user = ".$id_user.") AS USER  ON USER.quequan_xa = xa.id");
        $province_quequan_tinh0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Tỉnh/TP",
                'selected' => false
            ]
        );
        $province_quequan_tinh[] = $province_quequan_tinh0;
        $province_quequan_huyen0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Quận/Huyện",
                'selected' => false
            ]
        );
        $province_quequan_huyen[] = $province_quequan_huyen0;
        $province_quequan_xa0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Xã/Phường",
                'selected' => false
            ]
        );
        $province_quequan_xa[] = $province_quequan_xa0;
        $khuyettat = DB::select("SELECT l_khuyettat.id as id, l_khuyettat.name_khuyettat as text, if(CS.id_khuyettat is null, '', 'selected') as selected FROM `l_khuyettat` LEFT JOIN (SELECT l_info_users.id_khuyettat  FROM l_info_users WHERE id_user = ".$id_user.") AS CS ON l_khuyettat.id = CS.id_khuyettat");
        $khuyettat0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Loại khuyết tật",
                'selected' => true
            ]
        );
        $khuyettat[] = $khuyettat0;
        $result = array(
            'info' => $info,
            'nation' => $nation,
            'religion' => $religion,
            'nationality' => $nationality,
            'province_place_card' => $province_place_card,

            'province_noisinh_xa' => $province_noisinh_xa,
            'province_noisinh_huyen' => $province_noisinh_huyen,
            'province_noisinh_tinh' => $province_noisinh_tinh,

            'province_httttinh' => $province_httttinh,
            'province_httthuyen' => $province_httthuyen,
            'province_htttxa' => $province_htttxa,

            'province_quequan_tinh' => $province_quequan_tinh,
            'province_quequan_huyen' => $province_quequan_huyen,
            'province_quequan_xa' => $province_quequan_xa,
            'khuyettat' => $khuyettat,


        );
        return $result;
    }


    public function update_ttsv_load_batch(){
        $batch0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Đợt tuyển sinh",
                'selected' => true
            ]
        );
        $batchs = DB::table('l_batch')
        ->select('id','name_batch as text')
        ->get();
        $batchs[] = $batch0;


        return $batchs;
    }


    public function ttsv_submit(Request $request){
        DB::beginTransaction();
        try{
            $id_user = DB::table('l_users')
            ->select('id')
            ->where('id_batch',$request->input('id_batch_temp'))
            ->where('id_card_users',$request->input('cmnd_temp'))
            ->get();
            $id=$id_user[0]->id;
            if(count($id_user)>0){
                if(count($id_user) == 1){
                    $del1 = DB::table('l_users')
                    ->where('id',$id)
                    ->update(
                        [
                            'phone_users' => $request->input('ttsv_phone_users'),
                        ]
                    );
                    $del = DB::table('l_info_users')
                    ->where('id_user',$id)
                    ->update(
                        [
                            'sex_user'  => $request->input('ttsv_sex_user'),
                            'birth_user'  => $request->input('ttsv_birth_user'),
                            'id_nation_user'  => $request->input('ttsv_id_nation_user'),
                            'id_religion'  => $request->input('ttsv_id_religion'), //Toosn giao
                            'id_nationality'  => $request->input('ttsv_id_nationality'), //Daan toocj
                            'id_nationality'  => $request->input('ttsv_id_nationality'), //Daan toocj
                            'date_card'  => $request->input('ttsv_date_card'), //Daan toocj
                            'doan_sv'  => $request->input('ttsv_doan_sv'), //Daan toocj
                            'dang_sv'  => $request->input('ttsv_dang_sv'), //Daan toocj
                            'noisinh_huyen'  => $request->input('ttsv_noisinh_huyen'), //Daan toocj
                            'noisinh_xa'  =>  $request->input('ttsv_noisinh_xa'), //Daan toocj
                            'id_place_user'  => $request->input('ttsv_id_place_user'), //Daan toocj
                            'noisinh_cccd'  => $request->input('ttsv_noisinh_cccd'), //Daan toocj
                            'id_khttprovince_user'  => $request->input('ttsv_id_khttprovince_user'), //Daan toocj
                            'id_khttprovince2_user'  => $request->input('ttsv_id_khttprovince2_user'), //Daan toocj
                            'id_khttprovince3_user'  => $request->input('ttsv_id_khttprovince3_user'), //Daan toocj
                            'down_province3'  => $request->input('ttsv_dow_province3'), //Daan toocj

                            'id_place_card'  => $request->input('ttsv_id_place_card'), //Daan toocj


                            'quequan_tinh'  => $request->input('ttsv_quequan_tinh'), //Daan toocj
                            'quequan_huyen'  => $request->input('ttsv_quequan_huyen'), //Daan toocj
                            'quequan_xa'  => $request->input('ttsv_quequan_xa'), //Daan toocj
                            'dow_quequan_xa'  => $request->input('ttsv_down_quequan_xa'), //Daan toocj

                            'tencha_sv'  => $request->input('ttsv_tencha_sv'), //Daan toocj
                            'dienthoaicha_sv'  =>  $request->input('ttsv_dienthoaicha_sv'),
                            'nghenghiepcha_sv'  => $request->input('ttsv_nghenghiepcha_sv'), //Daan toocj

                            'tenme_sv'  => $request->input('ttsv_tenme_sv'), //Daan toocj
                            'dienthoaime_sv'  => $request->input('ttsv_dienthoaime_sv'), //Daan toocj
                            'nghenghiepme_sv'  => $request->input('ttsv_nghenghiepme_sv'), //Daan toocj

                            'dodau_sv'  => $request->input('ttsv_dodau_sv'), //Daan toocj
                            'dienthoaidodau_sv'  => $request->input('ttsv_dienthoaidodau_sv'), //Daan toocj
                            'nghenghiepdodau_sv'  => $request->input('ttsv_nghenghiepdodau_sv'), //Daan toocj

                            // 'id_chinhsach'  => $request->input('id_chinhsach'), //Daan toocj
                            'id_khuyettat'  => $request->input('ttsv_id_khuyettat'), //Daan toocj
                            'sothebhyt'  => $request->input('ttsv_sothebhyt'), //Daan toocj
                            'address_user'  => $request->input('ttsv_address_user'), //Daan toocj

                            // 'id_save'  => 1, //Daan toocj
                            'date_dukien'  => $request->input('ttsv_date_dukien'), //Daan toocj

                        ]
                    );
                    if($del + $del1 > 0){
                        $user_agent = $_SERVER['HTTP_USER_AGENT'];
                        DB::table('l_history')
                        ->insert([
                            'id_student'    =>  $id,
                            'id_user'       =>  Auth::user()->id,
                            'name_history'  =>  'Xác nhận nhập học',
                            'content'       =>  'Lưu thông tin đăng ký nhập học',
                            'ip'            => request()->ip(),
                            'info_client'   => $user_agent
                        ]);
                        DB::commit();
                        return 1;
                    }else{
                        return 4; //KHông có dữ liệu mới
                    }
                }else{
                    return 3; //Hệ thống bị lỗi, 1 thí sinh nhiều tài khoản
                }
            }else{
                return 2; //Không tồn tại thí sinh
            }
        }catch(Exception $e){
            DB::rollBack();
            return 0; //Hệ thống lỗi
        }

    }

    function check_year(){
        $check_year = DB::table('l_year_active')
        ->get();
        if(count($check_year) > 0 ){
            if(count($check_year) == 1){
                $result = array(
                    'sus' => 1,
                    'id_year' => $check_year[0]->id_year,
                );
            }else{
                $result = array(
                    'sus' => 0,
                    'id_year' => 0,
                );
            }
        }else{
            $result = array(
                'sus' => 0,
                'id_year' => 0,
            );
        }
        return $result;
    }


    public function ttsv_load_list_file($batch,$cmnd){

        $id_user = DB::table('l_users')
        ->select('id')
        ->where('id_batch',$batch)
        ->where('id_card_users',$cmnd)
        ->get();
        $id = $id_user[0]->id;

        if($this ->check_year()['sus'] == 1){
            $list = DB::select('select if(USER.active is null OR USER.active = 0,0,1) as checked, `l_file_list_hssv`.`name_file` as `name_file`, `l_file_list_hssv`.`id` as `id`,`USER`.`active` as `active` from `l_file_list_hssv` left join (SELECT * FROM `l_file_list_student_hssv` WHERE  `l_file_list_student_hssv`.`id_user` = '.$id.') AS USER on `USER`.`id_file` = `l_file_list_hssv`.`id` WHERE id_year IN (SELECT id_year FROM l_year_active)  order by `stt` asc');
            return $list;
        }else{
            return 0;
        }
    }

    public function ttsv_file_save(Request $request){
        $id_user = DB::table('l_users')
        ->select('id')
        ->where('id_batch',$request->input('batch'))
        ->where('id_card_users',$request->input('cmnd'))
        ->get();

        $id = $id_user[0]->id;

        $datas = $request ->input('data');

        if($this ->check_year()['sus'] == 1){
            DB::beginTransaction();
            try{
                foreach ($datas as $key => $data) {
                    DB::table('l_file_list_student_hssv')
                        ->updateOrInsert(
                        [
                            'id_user' => $id,
                            'id_file' => $data[0],
                        ],
                        [
                            'active' => $data[1],
                            'id_admin' => Auth::user()->id,
                        ],
                    );

                    if($data[2] == 1){
                        if($data[1] == 1){
                            $trangthai = "Thêm hồ sơ";
                        }else{
                            $trangthai = "Xóa hồ sơ";
                        }
                        $name_file = DB::table('l_file_list_hssv')
                        ->where('id', $data[0])
                        ->get();

                        $user_agent = $_SERVER['HTTP_USER_AGENT'];
                        DB::table('l_history')
                        ->insert([
                            'id_student'    =>  $id,
                            'id_user'       =>  Auth::user()->id,
                            'name_history'  =>  "Thu hồ sơ sinh viên",
                            'content'       =>  $trangthai.': '.$name_file[0]->name_file,
                            'ip'            => request()->ip(),
                            'info_client'   => $user_agent
                        ]);
                    }else{
                        continue;
                    }
                }
                DB::commit();
                return 1;
            }catch(Exception $e){
                DB::rollBack();
                return 0;
            }
        }else{
            return 2;
        }

    }



    public function change_selectbox(Request $request) {
        $table = $request ->input('name_table');
        $value = $request ->input('value');
        $value2 = $request ->input('col_table_value');
        $doituong = new Collection(
            [
                'id' => 0,
                'text' => $request->input('value0'),
                'selected' => true
            ]
        );
        $col = $request ->input('col_table').' as text';
        $provinces = DB::table($table)
        ->select('id as id',$col)
        ->where($value2,$value)
        ->get();
        foreach ($provinces as $province ){
            $province ->selected = false;
        }
        $provinces[] = $doituong;
        echo $provinces;
    }

}
