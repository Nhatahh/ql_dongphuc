<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use PhpOption\Option;
use PhpParser\Node\Expr\FuncCall;
use \App\Http\Controllers\User\Main\RegisterWishController;
use Exception;
use FFI\Exception as FFIException;

use function PHPUnit\Framework\countOf;

class SearchResultBoController extends Controller
{

    public function main(){

        $wish = DB::select("SELECT TT.pass_bo, if(TT.check_end = 1,'Đã xác nhận','Xác nhận') as check_end ,TT.id as id_search, if(TT.id_wish is null,0,1) as id_check, if(TT.pass_bo = 0  or TT.pass_bo is null, 'Trượt', 'Đỗ') as tt, INFO.* FROM (SELECT l_policy_users.name_policy_user, l_priority_area.id_priority_area, l_group.id_group as name_group, if(l_wish.tts = 1,'x','') as tts, l_wish.id_method as id_method_id ,priority_mark,group_mark,l_wish.id_batch as id_batch,l_wish.id_user,l_wish.mark,l_wish.number_bo, l_wish.id as id, l_wish.id_method as method, l_wish.id_major as id_major, l_major.name_major,l_method.id_method as id_method,l_method_major.min_mark, l_wish.id_group as id_group  FROM `l_wish` INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_method_major.id_major = l_major.id INNER JOIN l_batch_method ON l_batch_method.id = l_wish.id_method INNER JOIN l_method ON l_batch_method.id_method = l_method.id INNER JOIN l_group ON l_group.id = l_wish.id_group INNER JOIN l_info_users ON l_info_users.id_user = l_wish.id_user INNER JOIN l_priority_area ON l_priority_area.id = l_info_users.id_priority_area_user LEFT JOIN l_policy_users_reg ON l_policy_users_reg.id_user = l_wish.id_user LEFT JOIN l_policy_users ON l_policy_users.id = l_policy_users_reg.id_policy_users WHERE l_wish.id_user = ".Auth::guard('search')->user()->id.") AS INFO LEFT JOIN (SELECT * FROM l_go_batch_pass WHERE id_batch = 18) AS TT ON INFO.id = TT.id_wish");

        // $wish = DB::select('SELECT pass_bo, if(l_go_batch_pass.check_end = 1,"Đã xác nhận","Xác nhận") as check_end ,l_go_batch_pass.id as id_search, if(l_go_batch_pass.id_wish is null,0,1) as id_check,l_policy_users.name_policy_user,l_priority_area.id_priority_area, l_group.id_group as name_group, if(l_wish.tts = 1,"x","") as tts, if(l_go_batch_pass.pass_bo = 0  or l_go_batch_pass.pass_bo is null, "Trượt", "Đỗ") as tt, l_wish.id_method as id_method_id ,priority_mark,group_mark,l_wish.id_batch as id_batch,l_wish.id_user,l_wish.mark,l_wish.number_bo, l_wish.id as id, l_wish.id_method as method, l_wish.id_major as id_major, l_major.name_major,l_method.id_method as id_method,l_method_major.min_mark, l_wish.id_group as id_group  FROM `l_wish` INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_method_major.id_major = l_major.id INNER JOIN l_batch_method ON l_batch_method.id = l_wish.id_method INNER JOIN l_method ON l_batch_method.id_method = l_method.id INNER JOIN l_group ON l_group.id = l_wish.id_group INNER JOIN l_info_users ON l_info_users.id_user = l_wish.id_user INNER JOIN l_priority_area ON l_priority_area.id = l_info_users.id_priority_area_user LEFT JOIN l_policy_users_reg ON l_policy_users_reg.id_user = l_wish.id_user LEFT JOIN l_policy_users ON l_policy_users.id = l_policy_users_reg.id_policy_users LEFT JOIN l_go_batch_pass ON l_wish.id = l_go_batch_pass.id_wish WHERE l_wish.id_user = '.Auth::guard('search')->user()->id.' AND l_go_batch_pass.id_batch = 18 ORDER BY l_wish.number ASC');
        // $info = DB::select("SELECT l_info_users.id as id,sothebhyt, address_user, tencha_sv, nghenghiepcha_sv, dienthoaicha_sv, tenme_sv, nghenghiepme_sv, dienthoaime_sv, dodau_sv, nghenghiepdodau_sv, dienthoaidodau_sv, noisinh_cccd, name_province_quequan_xa,name_province_quequan_tinh, name_province_quequan_huyen, dow_quequan_xa, l_province3.name_province3 as name_province3, l_province2.name_province2 as name_province2, l_province.name_province as name_province, down_province3,doan_sv, dang_sv,l_info_users.date_card, l_users.id_card_users, l_users.phone_users, sex_user, l_info_users.name_user, l_info_users.birth_user FROM l_info_users INNER JOIN l_users ON l_users.id = l_info_users.id_user INNER JOIN l_province ON l_province.id = l_info_users.id_khttprovince_user INNER JOIN l_province2 ON l_province2.id = l_info_users.id_khttprovince2_user INNER JOIN l_province3 ON l_info_users.id_khttprovince3_user = l_province3.id INNER JOIN (SELECT id_user,l_province.name_province as name_province_quequan_tinh, l_province2.name_province2 as name_province_quequan_huyen, l_province3.name_province3 as name_province_quequan_xa FROM l_info_users INNER JOIN l_province ON l_province.id = l_info_users.quequan_tinh INNER JOIN l_province2 ON l_province2.id = l_info_users.quequan_huyen INNER JOIN l_province3 ON l_info_users.quequan_huyen = l_province3.id) AS QQ ON QQ.id_user = l_info_users.id_user WHERE l_info_users.id_user = ".Auth::guard('search')->user()->id);

        $info = DB::select("SELECT date_dukien, l_info_users.id as id,sothebhyt, address_user, tencha_sv, nghenghiepcha_sv, dienthoaicha_sv, tenme_sv, nghenghiepme_sv, dienthoaime_sv, dodau_sv, nghenghiepdodau_sv, dienthoaidodau_sv, noisinh_cccd, name_province_quequan_xa,name_province_quequan_tinh, name_province_quequan_huyen, dow_quequan_xa, l_province3.name_province3 as name_province3, l_province2.name_province2 as name_province2, l_province.name_province as name_province, down_province3,doan_sv, dang_sv,l_info_users.date_card, l_users.id_card_users, l_users.phone_users, sex_user, l_info_users.name_user, l_info_users.birth_user FROM l_info_users INNER JOIN l_users ON l_users.id = l_info_users.id_user LEFT JOIN l_province ON l_province.id = l_info_users.id_khttprovince_user LEFT JOIN l_province2 ON l_province2.id = l_info_users.id_khttprovince2_user LEFT JOIN l_province3 ON l_info_users.id_khttprovince3_user = l_province3.id LEFT JOIN (SELECT id_user,l_province.name_province as name_province_quequan_tinh, l_province2.name_province2 as name_province_quequan_huyen, l_province3.name_province3 as name_province_quequan_xa FROM l_info_users INNER JOIN l_province ON l_province.id = l_info_users.quequan_tinh INNER JOIN l_province2 ON l_province2.id = l_info_users.quequan_huyen INNER JOIN l_province3 ON l_info_users.quequan_xa = l_province3.id) AS QQ ON QQ.id_user = l_info_users.id_user WHERE l_info_users.id_user = ".Auth::guard('search')->user()->id);
        $nation = DB::select("SELECT l_nation.id as id, name_nation,if(l_info_users.id_nation_user is null,'','selected') as selected FROM l_nation LEFT JOIN (SELECT id_nation_user FROM l_info_users WHERE id_user = ".Auth::guard('search')->user()->id.") as l_info_users ON l_info_users.id_nation_user = l_nation.id");
        $religion = DB::select("SELECT l_religion.id as id, l_religion.tentongiao,if(l_info_users.id_religion is null,'','selected') as selected FROM l_religion LEFT JOIN (SELECT l_info_users.id_religion FROM l_info_users WHERE id_user = ".Auth::guard('search')->user()->id.") as l_info_users ON l_info_users.id_religion = l_religion.id");
        $nationality = DB::select("SELECT l_nationality.id as id, l_nationality.name_nationality,if(l_info_users.id_nationality is null,'','selected') as selected FROM l_nationality LEFT JOIN (SELECT l_info_users.id_nationality FROM l_info_users WHERE id_user = ".Auth::guard('search')->user()->id.") as l_info_users ON l_info_users.id_nationality = l_nationality.id");
        $province_place_card = DB::select("SELECT l_province.id as id, l_province.name_province,if(l_info_users.id_place_card is null,'','selected') as selected FROM l_province LEFT JOIN (SELECT l_info_users.id_place_card FROM l_info_users WHERE id_user = ".Auth::guard('search')->user()->id.") as l_info_users ON l_info_users.id_place_card = l_province.id ");

        $province_httttinh = DB::select("SELECT l_province.id as id, l_province.name_province,if(l_info_users.id_khttprovince_user is null,'','selected') as selected FROM l_province LEFT JOIN (SELECT id_khttprovince_user FROM l_info_users WHERE id_user = ".Auth::guard('search')->user()->id.") as l_info_users ON l_info_users.id_khttprovince_user = l_province.id");
        $province_httthuyen = DB::select("SELECT huyen.id as id, huyen.name_province2 as name_province2, if(USER.id is null,'','selected') as selected FROM (SELECT l_province2.id as id, l_province2.name_province2 FROM l_province2 INNER JOIN (SELECT l_info_users.id_khttprovince_user,id_khttprovince2_user FROM l_info_users WHERE id_user = ".Auth::guard('search')->user()->id.") as l_info_users ON l_info_users.id_khttprovince_user = l_province2.id_province) as huyen LEFT JOIN (SELECT l_info_users.id_khttprovince2_user as id FROM l_info_users WHERE  id_user = ".Auth::guard('search')->user()->id.") AS USER  ON USER.id = huyen.id");
        $province_htttxa = DB::select("SELECT xa.id as id, xa.name_province3 as name_province3, if(USER.id is null,'','selected') as selected FROM (SELECT l_province3.id as id, l_province3.name_province3 FROM l_province3 INNER JOIN (SELECT l_info_users.id_khttprovince2_user,id_khttprovince3_user FROM l_info_users WHERE id_user =".Auth::guard('search')->user()->id.") as l_info_users ON l_info_users.id_khttprovince2_user = l_province3.id_province2) as xa LEFT JOIN (SELECT l_info_users.id_khttprovince3_user as id FROM l_info_users WHERE  id_user = ".Auth::guard('search')->user()->id.") AS USER  ON USER.id = xa.id");

        $province_quequan_tinh = DB::select("SELECT l_province.id as id, l_province.name_province,if(l_info_users.quequan_tinh is null,'','selected') as selected FROM l_province LEFT JOIN (SELECT quequan_tinh FROM l_info_users WHERE id_user = ".Auth::guard('search')->user()->id.") as l_info_users ON l_info_users.quequan_tinh = l_province.id");
        $province_quequan_huyen = DB::select("SELECT huyen.id as id, huyen.name_province2 as name_province2, if(USER.quequan_huyen is null,'','selected') as selected FROM (SELECT l_province2.id as id, l_province2.name_province2 FROM l_province2 INNER JOIN (SELECT l_info_users.quequan_tinh, quequan_huyen FROM l_info_users WHERE id_user = ".Auth::guard('search')->user()->id.") as l_info_users ON l_info_users.quequan_tinh = l_province2.id_province) as huyen LEFT JOIN (SELECT * FROM l_info_users WHERE l_info_users.id_user = ".Auth::guard('search')->user()->id.") AS USER ON USER.quequan_huyen = huyen.id");
        $province_quequan_xa = DB::select("SELECT xa.id as id, xa.name_province3 as name_province3, if(USER.quequan_xa is null,'','selected') as selected FROM (SELECT l_province3.id as id, l_province3.name_province3 FROM l_province3 INNER JOIN (SELECT l_info_users.quequan_huyen, quequan_xa FROM l_info_users WHERE id_user =".Auth::guard('search')->user()->id.") as l_info_users ON l_info_users.quequan_huyen = l_province3.id_province2) as xa LEFT JOIN (SELECT * FROM l_info_users WHERE l_info_users.id_user = ".Auth::guard('search')->user()->id.") AS USER  ON USER.quequan_xa = xa.id");

        $province_noisinh_tinh = DB::select("SELECT l_province.id as id, l_province.name_province,if(l_info_users.id_place_user is null,'','selected') as selected FROM l_province LEFT JOIN (SELECT id_place_user FROM l_info_users WHERE id_user = ".Auth::guard('search')->user()->id.") as l_info_users ON l_info_users.id_place_user = l_province.id");
        $province_noisinh_huyen = DB::select("SELECT huyen.id as id, huyen.name_province2 as name_province2, if(USER.noisinh_huyen is null,'','selected') as selected FROM (SELECT l_province2.id as id, l_province2.name_province2 FROM l_province2 INNER JOIN (SELECT l_info_users.id_place_user, noisinh_huyen FROM l_info_users WHERE id_user = ".Auth::guard('search')->user()->id.") as l_info_users ON l_info_users.id_place_user = l_province2.id_province) as huyen LEFT JOIN (SELECT * FROM l_info_users WHERE l_info_users.id_user = ".Auth::guard('search')->user()->id.") AS USER  ON USER.noisinh_huyen = huyen.id");
        $province_noisinh_xa = DB::select("SELECT xa.id as id, xa.name_province3 as name_province3, if(USER.noisinh_xa is null,'','selected') as selected FROM (SELECT l_province3.id as id, l_province3.name_province3 FROM l_province3 INNER JOIN (SELECT l_info_users.noisinh_huyen, noisinh_xa FROM l_info_users WHERE id_user = ".Auth::guard('search')->user()->id.") as l_info_users ON l_info_users.noisinh_huyen = l_province3.id_province2) as xa LEFT JOIN (SELECT * FROM l_info_users WHERE l_info_users.id_user =  ".Auth::guard('search')->user()->id.") AS USER ON USER.noisinh_xa = xa.id");

        $chinhsach = DB::select("SELECT l_chinhsach.id as id, l_chinhsach.name_chinhsach, if(CS.id_chinhsach is null, '', 'selected') as selected FROM `l_chinhsach` LEFT JOIN (SELECT l_info_users.id_chinhsach  FROM l_info_users WHERE id_user = ".Auth::guard('search')->user()->id.") AS CS ON l_chinhsach.id = CS.id_chinhsach");
        $khuyettat = DB::select("SELECT l_khuyettat.id as id, l_khuyettat.name_khuyettat, if(CS.id_khuyettat is null, '', 'selected') as selected FROM `l_khuyettat` LEFT JOIN (SELECT l_info_users.id_khuyettat  FROM l_info_users WHERE id_user = ".Auth::guard('search')->user()->id.") AS CS ON l_khuyettat.id = CS.id_khuyettat");

        $data =
        [
            // 'title' => base64_encode(Auth::guard('search')->user()->id." X ".$wish[0]->id),
            'title' =>base64_encode(Auth::guard('search')->user()->id."_".$wish[0]->id),
            'wish' => $wish,
            'info' => $info,
            'nation' => $nation,
            'religion' => $religion,
            'nationality' => $nationality,
            'province_place_card' => $province_place_card,

            'province_httttinh' => $province_httttinh,
            'province_httthuyen' => $province_httthuyen,
            'province_htttxa' => $province_htttxa,

            'province_quequan_tinh' => $province_quequan_tinh,
            'province_quequan_huyen' => $province_quequan_huyen,
            'province_quequan_xa' => $province_quequan_xa,

            'province_noisinh_tinh' => $province_noisinh_tinh,
            'province_noisinh_huyen' => $province_noisinh_huyen,
            'province_noisinh_xa' => $province_noisinh_xa,
            'chinhsach' => $chinhsach,
            'khuyettat' => $khuyettat,
            'check_save_ìnfo' =>base64_encode(Auth::guard('search')->user()->id."_".$info[0]->id),
            'pass' => $this ->check_pass()
            // 'hktt'  =>  $info[0]->down_province3.",".$info[0]->name_province3.",".$info[0]->name_province3.",".$info[0]->name_province3
        ];
        return view('search.main',$data);

    }

    function check_save_sv(){
        $check = DB::table('l_info_users')
        ->where('id_user',Auth::guard('search')->user()->id)
        ->get();
        if(count($check) >0){
            if($check[0]->id_save == 1){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }

    public function search_check(Request $request){
        if($this->check_pass() == 0){
            return 6;
        }else{
            if($this->check_save_sv() == 1){
                $id = (int)$request ->input('id_check');
                $check = DB::table('l_go_batch_pass')
                // ->select(DB::raw("if(CONCAT(l_wish.id_user,'_',l_wish.id) = l_go_batch_pass.id_user,1,0) as check_save"),'check_end','block_check')
                // ->join('l_wish','l_wish.id','l_go_batch_pass.id_wish')
                ->where('l_go_batch_pass.id',$id)
                ->get();
                if(count($check) > 0){
                    // if($check[0]->block_check == 0){
                    //     if($check[0]->check_save == 1){
                            if($check[0]->check_end == 1){
                                return 2;
                            }else{
                                DB::table('l_go_batch_pass')
                                ->where('id',$id)
                                ->update(
                                    [
                                        'check_end' => 1
                                    ]
                                );
                                return 1;
                            }
                    //     }else{
                    //         return 3;
                    //     }
                    // }else{
                    //     return 4;
                    // }
                }else{
                    return 5;
                }
            }else{
                return 7;
            }
        }
    }

    public function pronvince(Request $request){
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

    function check_pass(){
        $check = DB::select('SELECT USER.id FROM (SELECT id FROM l_users WHERE id = '.(int)Auth::guard('search')->user()->id.') AS USER INNER JOIN l_wish ON l_wish.id_user = USER.id INNER JOIN l_go_batch_pass ON l_go_batch_pass.id_wish = l_wish.id INNER JOIN l_year_active ON l_year_active.id_batch_locao = l_go_batch_pass.id_batch WHERE pass_bo = 1');
        if(count($check) > 0){
            if(count($check) == 1){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }

    function load_swiper_search(){
        $sliders = DB::table('l_image_hocba')
        ->select('link_img','note_type')
        ->where('id_user' , Auth::guard('search')->user()->id)
        ->orderBy('number_img','ASC')
        ->get();
        $html =  "";
        if(count($sliders)>0){
            foreach ($sliders as $key => $slider) {
                $html .= '<div class="swiper-slide">';
                $html .= '<div class="swiper-zoom-container"><img class = "img-fluid" style="width:inherit" src="'.$slider->link_img.'" title="'.$slider->note_type.'"></div>';
                $html .= '</div>';
            }
        }else{
            $html .= '<div class="swiper-slide">';
            $html .= '<div class="swiper-zoom-container"><img class = "img-fluid" style="width:inherit" src="" title="Chưa có ảnh"></div>';
            $html .= '</div>';
        }
        return $html;
    }

    public function search_upload_cmnd_submit(Request $request){
        $validator = Validator::make($request->all(),
            [
                'search_upload_cmnd' =>  'mimes:jpeg,jpg,png|required',
            ],
            [
                'search_upload_cmnd.required' => 'Upload ảnh CMND/CCCD mặt trước',
                'search_upload_cmnd.mimes' => 'Upload file ảnh'
            ]
        );
        if($this ->check_pass() == 1){
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }else{
                DB::beginTransaction();
                try{
                    $old_link_cccd_truoc = DB::table('l_image_hocba')
                    ->where('id_user' , Auth::guard('search')->user()->id)
                    ->where('type_img' , 0)
                    ->where('id_img' , 1)
                    ->get();
                    if(count($old_link_cccd_truoc)>0){
                        if(File::exists(ltrim($old_link_cccd_truoc[0]->link_img,"/"))){
                            unlink(ltrim($old_link_cccd_truoc[0]->link_img,"/"));
                        }
                    }
                    $data_cccd_truoc = $request ->file('search_upload_cmnd');
                    $name = $data_cccd_truoc->hashName();
                    $path = '/images/hocba/'.Auth::guard('search')->user()->id.'/cmnd_truoc/'.$name;
                    DB::table('l_image_hocba')
                    ->updateOrInsert(
                        [
                            'id_user' => Auth::guard('search')->user()->id,
                            'type_img' => 0,
                            'id_img' => 1,
                        ],
                        [
                            'link_img' => $path,
                            'note_type' => "CMND/CCCD Mặt trước",
                            'block_img' => 0,
                            'number_img' => 1,
                            'batbuoc' => 1,
                        ]
                    );
                    $storage = Storage::disk('local');
                    $storage->put('/hocba'.'/'.Auth::guard('search')->user()->id.'/cmnd_truoc', $data_cccd_truoc, 'public');
                    DB::commit();
                    return 1;
                }catch(Exception $e){
                    DB::rollBack();
                    return 0;
                }
            }
        }else{
            return 2;
        }
    }


    public function search_upload_cmnd2_submit(Request $request){
        $validator = Validator::make($request->all(),
            [
                'search_upload_cmnd2' =>  'mimes:jpeg,jpg,png|required',
            ],
            [
                'search_upload_cmnd2.required' => 'Upload ảnh CMND/CCCD mặt trước',
                'search_upload_cmnd2.mimes' => 'Upload file ảnh'
            ]
        );
        if($this ->check_pass() == 1){
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }else{
                DB::beginTransaction();
                try{
                    $old_link = DB::table('l_image_hocba')
                    ->where('id_user' , Auth::guard('search')->user()->id)
                    ->where('type_img' , 0)
                    ->where('id_img' , 2)
                    ->get();
                    if(count($old_link)>0){
                        if(File::exists(ltrim($old_link[0]->link_img,"/"))){
                            unlink(ltrim($old_link[0]->link_img,"/"));
                        }
                    }

                    $data = $request ->file('search_upload_cmnd2');
                    $name = $data->hashName();
                    $path = '/images/hocba/'.Auth::guard('search')->user()->id.'/cmnd_sau/'.$name;
                    DB::table('l_image_hocba')
                    ->updateOrInsert(
                        [
                            'id_user' => Auth::guard('search')->user()->id,
                            'type_img' => 0,
                            'id_img' => 2,
                        ],
                        [
                            'link_img' => $path,
                            'note_type' => "CMND/CCCD Mặt sau",
                            'block_img' => 0,
                            'number_img' => 2,
                            'batbuoc' => 1,
                        ]
                    );
                    $storage = Storage::disk('local');
                    $storage->put('/hocba'.'/'.Auth::guard('search')->user()->id.'/cmnd_sau', $data, 'public');
                    DB::commit();
                    return 1;
                }catch(Exception $e){
                    DB::rollBack();
                    return 0;
                }
            }
        }else{
            return 2;
        }

    }


    public function search_upload_kqthi_submit(Request $request){
        $validator = Validator::make($request->all(),
            [
                'search_upload_kqthi' =>  'mimes:jpeg,jpg,png|required',
            ],
            [
                'search_upload_kqthi.required' => 'Upload ảnh CMND/CCCD mặt trước',
                'search_upload_kqthi.mimes' => 'Upload file ảnh'
            ]
        );
        if($this ->check_pass() == 1){
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }else{
                DB::beginTransaction();
                $nam = DB::table('l_info_users')
                ->where('id_user',Auth::guard('search')->user()->id)
                ->get();
                if($nam[0]->graduation_year_user == 2023){
                    $batbuoc = 1;
                }else{
                    $batbuoc = 0;
                }
                try{
                    $old_link = DB::table('l_image_hocba')
                    ->where('id_user' , Auth::guard('search')->user()->id)
                    ->where('type_img' , 2)
                    ->where('id_img' , 1 )
                    ->get();
                    if(count($old_link)>0){
                        if(File::exists(ltrim($old_link[0]->link_img,"/"))){
                            unlink(ltrim($old_link[0]->link_img,"/"));
                        }
                    }

                    $data = $request ->file('search_upload_kqthi');
                    $name = $data->hashName();
                    $path = '/images/hocba/'.Auth::guard('search')->user()->id.'/kqthi/'.$name;
                    DB::table('l_image_hocba')
                    ->updateOrInsert(
                        [
                            'id_user' => Auth::guard('search')->user()->id,
                            'type_img' => 2,
                            'id_img' => 1,
                        ],
                        [
                            'link_img' => $path,
                            'note_type' => "Kết quả thi THPT",
                            'block_img' => 0,
                            'number_img' => 3,
                            'batbuoc' =>  $batbuoc,
                        ]
                    );
                    $storage = Storage::disk('local');
                    $storage->put('/hocba'.'/'.Auth::guard('search')->user()->id.'/kqthi', $data, 'public');
                    DB::commit();
                    return 1;
                }catch(Exception $e){
                    DB::rollBack();
                    return 0;
                }
            }
        }else{
            return 2;
        }

    }

    public function search_upload_tn_submit(Request $request){
        $validator = Validator::make($request->all(),
            [
                'search_upload_tn' =>  'mimes:jpeg,jpg,png|required',
            ],
            [
                'search_upload_tn.required' => 'Upload ảnh CMND/CCCD mặt trước',
                'search_upload_tn.mimes' => 'Upload file ảnh'
            ]
        );
        if($this ->check_pass() == 1){
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }else{
                DB::beginTransaction();
                try{

                    $nam = DB::table('l_info_users')
                    ->where('id_user',Auth::guard('search')->user()->id)
                    ->get();
                    if($nam[0]->graduation_year_user == 2023){
                        $batbuoc = 1;
                    }else{
                        $batbuoc = 0;
                    }
                    $old_link = DB::table('l_image_hocba')
                    ->where('id_user' , Auth::guard('search')->user()->id)
                    ->where('type_img' , 3)
                    ->where('id_img' , 1 )
                    ->get();
                    if(count($old_link)>0){
                        if(File::exists(ltrim($old_link[0]->link_img,"/"))){
                            unlink(ltrim($old_link[0]->link_img,"/"));
                        }
                    }

                    $data = $request ->file('search_upload_tn');
                    $name = $data->hashName();
                    $path = '/images/hocba/'.Auth::guard('search')->user()->id.'/totnghiep/'.$name;
                    DB::table('l_image_hocba')
                    ->updateOrInsert(
                        [
                            'id_user' => Auth::guard('search')->user()->id,
                            'type_img' => 3,
                            'id_img' => 1,
                        ],
                        [
                            'link_img' => $path,
                            'note_type' => "GCN Tốt nghiệp THPT",
                            'block_img' => 0,
                            'number_img' => 4,
                            'batbuoc' => $batbuoc,
                        ]
                    );
                    $storage = Storage::disk('local');
                    $storage->put('/hocba'.'/'.Auth::guard('search')->user()->id.'/totnghiep', $data, 'public');
                    DB::commit();
                    return 1;
                }catch(Exception $e){
                    DB::rollBack();
                    return 0;
                }
            }
        }else{
            return 2;
        }

    }

    public function search_upload_10_submit(Request $request){
        $validator = Validator::make($request->all(),
            [
                'search_upload_10' =>  'mimes:jpeg,jpg,png|required',
            ],
            [
                'search_upload_10.required' => 'Upload ảnh CMND/CCCD mặt trước',
                'search_upload_10.mimes' => 'Upload file ảnh'
            ]
        );
        if($this ->check_pass() == 1){
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }else{
                DB::beginTransaction();
                try{
                    $old_link = DB::table('l_image_hocba')
                    ->where('id_user' , Auth::guard('search')->user()->id)
                    ->where('type_img' , 4)
                    ->where('id_img' , 2 )
                    ->get();
                    if(count($old_link)>0){
                        if(File::exists(ltrim($old_link[0]->link_img,"/"))){
                            unlink(ltrim($old_link[0]->link_img,"/"));
                        }
                    }

                    $data = $request ->file('search_upload_10');
                    $name = $data->hashName();
                    $path = '/images/hocba/'.Auth::guard('search')->user()->id.'/lop10/'.$name;
                    DB::table('l_image_hocba')
                    ->updateOrInsert(
                        [
                            'id_user' => Auth::guard('search')->user()->id,
                            'type_img' => 4,
                            'id_img' => 2,
                        ],
                        [
                            'link_img' => $path,
                            'note_type' => "Học bạ lớp 10",
                            'block_img' => 0,
                            'number_img' => 5,
                            'batbuoc' => 1,
                        ]
                    );
                    $storage = Storage::disk('local');
                    $storage->put('/hocba'.'/'.Auth::guard('search')->user()->id.'/lop10', $data, 'public');
                    DB::commit();
                    return 1;
                }catch(Exception $e){
                    DB::rollBack();
                    return 0;
                }
            }
        }else{
            return 2;
        }

    }

    public function search_upload_9_submit(Request $request){
        $validator = Validator::make($request->all(),
            [
                'search_upload_9' =>  'mimes:jpeg,jpg,png|required',
            ],
            [
                'search_upload_9.required' => 'Upload ảnh CMND/CCCD mặt trước',
                'search_upload_9.mimes' => 'Upload file ảnh'
            ]
        );
        if($this ->check_pass() == 1){
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }else{
                DB::beginTransaction();
                try{
                    $old_link = DB::table('l_image_hocba')
                    ->where('id_user' , Auth::guard('search')->user()->id)
                    ->where('type_img' , 4)
                    ->where('id_img' , 1 )
                    ->get();
                    if(count($old_link)>0){
                        if(File::exists(ltrim($old_link[0]->link_img,"/"))){
                            unlink(ltrim($old_link[0]->link_img,"/"));
                        }
                    }

                    $data = $request ->file('search_upload_9');
                    $name = $data->hashName();
                    $path = '/images/hocba/'.Auth::guard('search')->user()->id.'/trangdau/'.$name;
                    DB::table('l_image_hocba')
                    ->updateOrInsert(
                        [
                            'id_user' => Auth::guard('search')->user()->id,
                            'type_img' => 4,
                            'id_img' => 1,
                        ],
                        [
                            'link_img' => $path,
                            'note_type' => "Học bạ trang đầu",
                            'block_img' => 0,
                            'number_img' => 6,
                            'batbuoc' => 1,
                        ]
                    );
                    $storage = Storage::disk('local');
                    $storage->put('/hocba'.'/'.Auth::guard('search')->user()->id.'/trangdau', $data, 'public');
                    DB::commit();
                    return 1;
                }catch(Exception $e){
                    DB::rollBack();
                    return 0;
                }
            }
        }else{
            return 2;
        }

    }

    public function search_upload_11_submit(Request $request){
        $validator = Validator::make($request->all(),
            [
                'search_upload_11' =>  'mimes:jpeg,jpg,png|required',
            ],
            [
                'search_upload_11.required' => 'Upload ảnh CMND/CCCD mặt trước',
                'search_upload_11.mimes' => 'Upload file ảnh'
            ]
        );
        if($this ->check_pass() == 1){
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }else{
                DB::beginTransaction();
                try{
                    $old_link = DB::table('l_image_hocba')
                    ->where('id_user' , Auth::guard('search')->user()->id)
                    ->where('type_img' , 4)
                    ->where('id_img' , 3 )
                    ->get();
                    if(count($old_link)>0){
                        if(File::exists(ltrim($old_link[0]->link_img,"/"))){
                            unlink(ltrim($old_link[0]->link_img,"/"));
                        }
                    }

                    $data = $request ->file('search_upload_11');
                    $name = $data->hashName();
                    $path = '/images/hocba/'.Auth::guard('search')->user()->id.'/lop11/'.$name;
                    DB::table('l_image_hocba')
                    ->updateOrInsert(
                        [
                            'id_user' => Auth::guard('search')->user()->id,
                            'type_img' => 4,
                            'id_img' => 3,
                        ],
                        [
                            'link_img' => $path,
                            'note_type' => "Lớp 11",
                            'block_img' => 0,
                            'number_img' => 7,
                            'batbuoc' => 1,
                        ]
                    );
                    $storage = Storage::disk('local');
                    $storage->put('/hocba'.'/'.Auth::guard('search')->user()->id.'/lop11', $data, 'public');
                    DB::commit();
                    return 1;
                }catch(Exception $e){
                    DB::rollBack();
                    return 0;
                }
            }
        }else{
            return 2;
        }

    }

    public function search_upload_12_submit(Request $request){
        $validator = Validator::make($request->all(),
            [
                'search_upload_12' =>  'mimes:jpeg,jpg,png|required',
            ],
            [
                'search_upload_12.required' => 'Upload ảnh CMND/CCCD mặt trước',
                'search_upload_12.mimes' => 'Upload file ảnh'
            ]
        );
        if($this ->check_pass() == 1){
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }else{
                DB::beginTransaction();
                try{
                    $old_link = DB::table('l_image_hocba')
                    ->where('id_user' , Auth::guard('search')->user()->id)
                    ->where('type_img' , 4)
                    ->where('id_img' , 4 )
                    ->get();
                    if(count($old_link)>0){
                        if(File::exists(ltrim($old_link[0]->link_img,"/"))){
                            unlink(ltrim($old_link[0]->link_img,"/"));
                        }
                    }

                    $data = $request ->file('search_upload_12');
                    $name = $data->hashName();
                    $path = '/images/hocba/'.Auth::guard('search')->user()->id.'/lop12/'.$name;
                    DB::table('l_image_hocba')
                    ->updateOrInsert(
                        [
                            'id_user' => Auth::guard('search')->user()->id,
                            'type_img' => 4,
                            'id_img' => 4,
                        ],
                        [
                            'link_img' => $path,
                            'note_type' => "Lớp 12",
                            'block_img' => 0,
                            'number_img' => 8,
                            'batbuoc' => 1,
                        ]
                    );
                    $storage = Storage::disk('local');
                    $storage->put('/hocba'.'/'.Auth::guard('search')->user()->id.'/lop12', $data, 'public');
                    DB::commit();
                    return 1;
                }catch(Exception $e){
                    DB::rollBack();
                    return 0;
                }
            }
        }else{
            return 2;
        }

    }

    public function search_upload_gks_submit(Request $request){
        $validator = Validator::make($request->all(),
            [
                'search_upload_gks' =>  'mimes:jpeg,jpg,png|required',
            ],
            [
                'search_upload_gks.required' => 'Upload ảnh CMND/CCCD mặt trước',
                'search_upload_gks.mimes' => 'Upload file ảnh'
            ]
        );
        if($this ->check_pass() == 1){
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }else{
                DB::beginTransaction();
                try{
                    $old_link = DB::table('l_image_hocba')
                    ->where('id_user' , Auth::guard('search')->user()->id)
                    ->where('type_img' , 5)
                    ->where('id_img' , 1 )
                    ->get();
                    if(count($old_link)>0){
                        if(File::exists(ltrim($old_link[0]->link_img,"/"))){
                            unlink(ltrim($old_link[0]->link_img,"/"));
                        }
                    }

                    $data = $request ->file('search_upload_gks');
                    $name = $data->hashName();
                    $path = '/images/hocba/'.Auth::guard('search')->user()->id.'/gks/'.$name;
                    DB::table('l_image_hocba')
                    ->updateOrInsert(
                        [
                            'id_user' => Auth::guard('search')->user()->id,
                            'type_img' => 5,
                            'id_img' => 1,
                        ],
                        [
                            'link_img' => $path,
                            'note_type' => "Giấy khai sinh",
                            'block_img' => 0,
                            'number_img' => 9,
                            'batbuoc' => 1,
                        ]
                    );
                    $storage = Storage::disk('local');
                    $storage->put('/hocba'.'/'.Auth::guard('search')->user()->id.'/gks', $data, 'public');
                    DB::commit();
                    return 1;
                }catch(Exception $e){
                    DB::rollBack();
                    return 0;
                }
            }
        }else{
            return 2;
        }

    }

    public function search_upload_btn_submit(Request $request){
        $validator = Validator::make($request->all(),
            [
                'search_upload_btn' =>  'mimes:jpeg,jpg,png|required',
            ],
            [
                'search_upload_btn.required' => 'Upload ảnh Bằng tốt nghiệp',
                'search_upload_btn.mimes' => 'Upload file ảnh'
            ]
        );
        if($this ->check_pass() == 1){
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }else{
                DB::beginTransaction();
                try{
                    $nam = DB::table('l_info_users')
                    ->where('id_user',Auth::guard('search')->user()->id)
                    ->get();
                    if($nam[0]->graduation_year_user == 2023){
                        $batbuoc = 0;
                    }else{
                        $batbuoc = 1;
                    }
                    $old_link = DB::table('l_image_hocba')
                    ->where('id_user' , Auth::guard('search')->user()->id)
                    ->where('type_img' , 6)
                    ->where('id_img' , 1 )
                    ->get();
                    if(count($old_link)>0){
                        if(File::exists(ltrim($old_link[0]->link_img,"/"))){
                            unlink(ltrim($old_link[0]->link_img,"/"));
                        }
                    }

                    $data = $request ->file('search_upload_btn');
                    $name = $data->hashName();
                    $path = '/images/hocba/'.Auth::guard('search')->user()->id.'/bangtotnghiep/'.$name;
                    DB::table('l_image_hocba')
                    ->updateOrInsert(
                        [
                            'id_user' => Auth::guard('search')->user()->id,
                            'type_img' => 6,
                            'id_img' => 1,
                        ],
                        [
                            'link_img' => $path,
                            'note_type' => "Bằng tốt nghiệp",
                            'block_img' => 0,
                            'number_img' => 10,
                            'batbuoc' => $batbuoc,
                        ]
                    );
                    $storage = Storage::disk('local');
                    $storage->put('/hocba'.'/'.Auth::guard('search')->user()->id.'/bangtotnghiep', $data, 'public');
                    DB::commit();
                    return 1;
                }catch(Exception $e){
                    DB::rollBack();
                    return 0;
                }
            }
        }else{
            return 2;
        }

    }

    public function check_save_file_hssv(){
        $check = DB::table('l_file_list_student_hssv')
        ->where('id_user',Auth::guard('search')->user()->id)
        ->where('active',1)
        ->get();
        if(count($check) >0){
            return 1;
        }else{
            return 0;
        }
    }
    public function search_submit(Request $request){
        if($this->check_save_file_hssv() == 1){
            return 5;
        }else{
            $validator = Validator::make($request->all(),
            [
                'sex_user'     =>'boolean|required',
                'birth_user'     =>'required',
                'id_place_user' => 'required|numeric|min:1',
                'noisinh_cccd' => 'required',
                'date_card'     =>'required',
                'id_religion' => 'required|numeric|min:1',
                'id_nationality' => 'required|numeric|min:1',
                'id_place_card' => 'required|numeric|min:1',
                'date_card'     =>'required',
                'id_khttprovince_user'  =>'required|numeric|min:1',
                'id_khttprovince2_user'  =>'required|numeric|min:1',
                'id_khttprovince3_user'  =>'required|numeric|min:1',
                'quequan_tinh'  =>'required|numeric|min:1',
                'quequan_huyen'  =>'required|numeric|min:0',
                'quequan_xa'  =>'required|numeric|min:0',
                'address_user' => 'required',
                'sothebhyt'  => 'required|regex:/[0-9]/|not_regex:/[a-z]/|min:10|max:10',
                'phone_users'  => 'required|regex:/[0-9]/|not_regex:/[a-z]/|min:10|max:10',
                'date_dukien'     =>'required',
                // 'search_upload_cmnd' =>  'mimes:jpeg,jpg,png|required',

            ],
            [
                'sex_user.boolean'         =>'Chọn Nam hoặc Nữ',
                'sex_user.required'         =>'Chọn giới tính',
                'birth_user.required'         =>'Điền ngày sinh theo Giấy Khai sinh',
                'id_place_user.min'         =>'Chọn Nơi sinh Tỉnh',
                'noisinh_cccd.required'         =>'Điền nơi sinh theo Giấy khai sinh',

                'id_nation_user.min'         =>'Chọn Dân tộc',
                'id_religion.min'         =>'Chọn Tôn giáo',
                'id_nationality.min'         =>'Chọn Quốc tịch',
                'id_place_card.min'         =>'Chọn Nơi cấp',

                'date_card.required'         =>'Điền ngày cấp theo CMND/TCC',
                'id_khttprovince_user.min'         =>'Chọn Tỉnh theo CMND/CCCD',
                'id_khttprovince_user.required'         =>'Chọn Xã theo CMND/CCCD',
                'id_khttprovince2_user.min'         =>'Chọn Huyện theo CMND/CCCD',
                'id_khttprovince2_user.required'         =>'Chọn Xã theo CMND/CCCD',
                'id_khttprovince3_user.required'         =>'Chọn Xã theo CMND/CCCD',
                'id_khttprovince3_user.min'         =>'Chọn Xã theo CMND/CCCD',

                'quequan_tinh.required'         =>'Chọn Tỉnh theo CMND/CCCD',
                'quequan_huyen.min'         =>'Chọn Huyện theo CMND/CCCD',
                'quequan_xa.required'         =>'Chọn Xã theo CMND/CCCD',
                'quequan_tinh.min'         =>'Chọn Tỉnh theo CMND/CCCD',
                'quequan_huyen.required'         =>'Chọn Huyện theo CMND/CCCD',
                'quequan_xa.min'         =>'Chọn Xã theo CMND/CCCD',

                'sothebhyt.required'      =>'Điền số bảo hiểm y tế',
                'sothebhyt.not_regex'     =>'Chỉ điền 10 chữ só phía sau',
                'sothebhyt.min'           =>'Số BHYT gồm 10 chữ số',
                'address_user.required'   =>'Điền địa chỉ liên lạc',
                'address_user.required'   =>'Điền địa chỉ liên lạc',

                'phone_users.required'      =>'Điền số điện thoại',
                'phone_users.not_regex'     =>'Điện thoại gồm 10 chữ số',
                'phone_users.max'           =>'Điện thoại gồm 10 chữ số',

                'date_dukien.required'         =>'Điền ngày có thể đến trường làm thủ tục nhập học',

                // 'search_upload_cmnd.required' => 'Upload ảnh CMND/CCCD mặt trước',
                // 'search_upload_cmnd.mimes' => 'Upload file ảnh'
            ]
        );
        if($this ->check_pass() == 1){
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }else{
                DB::beginTransaction();
                try{
                    $del1 = DB::table('l_users')
                    ->where('id',Auth::guard('search')->user()->id)
                    ->update(
                        [
                            'phone_users' => $request->input('phone_users'),
                        ]
                    );
                    $del = DB::table('l_info_users')
                    ->where('id_user',Auth::guard('search')->user()->id)
                    ->update(
                        [
                            'sex_user'  => $request->input('sex_user'),
                            'birth_user'  => $request->input('birth_user'),
                            'id_nation_user'  => $request->input('id_nation_user'),
                            'id_religion'  => $request->input('id_religion'), //Toosn giao
                            'id_nationality'  => $request->input('id_nationality'), //Daan toocj
                            'id_nationality'  => $request->input('id_nationality'), //Daan toocj
                            'date_card'  => $request->input('date_card'), //Daan toocj
                            'doan_sv'  => $request->input('doan_sv'), //Daan toocj
                            'dang_sv'  => $request->input('dang_sv'), //Daan toocj
                            'noisinh_huyen'  => $request->input('noisinh_huyen'), //Daan toocj
                            'noisinh_xa'  =>  $request->input('noisinh_xa'), //Daan toocj
                            'id_place_user'  => $request->input('id_place_user'), //Daan toocj
                            'noisinh_cccd'  => $request->input('noisinh_cccd'), //Daan toocj
                            'id_khttprovince_user'  => $request->input('id_khttprovince_user'), //Daan toocj
                            'id_khttprovince2_user'  => $request->input('id_khttprovince2_user'), //Daan toocj
                            'id_khttprovince3_user'  => $request->input('id_khttprovince3_user'), //Daan toocj
                            'down_province3'  => $request->input('down_province3'), //Daan toocj

                            'id_place_card'  => $request->input('id_place_card'), //Daan toocj


                            'quequan_tinh'  => $request->input('quequan_tinh'), //Daan toocj
                            'quequan_huyen'  => $request->input('quequan_huyen'), //Daan toocj
                            'quequan_xa'  => $request->input('quequan_xa'), //Daan toocj
                            'dow_quequan_xa'  => $request->input('dow_quequan_xa'), //Daan toocj

                            'tencha_sv'  => $request->input('tencha_sv'), //Daan toocj
                            'dienthoaicha_sv'  =>  $request->input('dienthoaicha_sv'),
                            'nghenghiepcha_sv'  => $request->input('nghenghiepcha_sv'), //Daan toocj

                            'tenme_sv'  => $request->input('tenme_sv'), //Daan toocj
                            'dienthoaime_sv'  => $request->input('dienthoaime_sv'), //Daan toocj
                            'nghenghiepme_sv'  => $request->input('nghenghiepme_sv'), //Daan toocj

                            'dodau_sv'  => $request->input('dodau_sv'), //Daan toocj
                            'dienthoaidodau_sv'  => $request->input('dienthoaidodau_sv'), //Daan toocj
                            'nghenghiepdodau_sv'  => $request->input('nghenghiepdodau_sv'), //Daan toocj

                            // 'id_chinhsach'  => $request->input('id_chinhsach'), //Daan toocj
                            'id_khuyettat'  => $request->input('id_khuyettat'), //Daan toocj
                            'sothebhyt'  => $request->input('sothebhyt'), //Daan toocj
                            'address_user'  => $request->input('address_user'), //Daan toocj

                            'id_save'  => 1, //Daan toocj
                            'date_dukien'  => $request->input('date_dukien'), //Daan toocj

                        ]
                    );
                    if($del + $del1 > 0){
                        $user_agent = $_SERVER['HTTP_USER_AGENT'];
                        DB::table('l_history')
                        ->insert([
                            'id_student'    =>  Auth::guard('search')->user()->id,
                            'id_user'       =>  0,
                            'name_history'  =>  'Xác nhận nhập học',
                            'content'       =>  'Lưu thông tin đăng ký nhập học',
                            'ip'            => request()->ip(),
                            'info_client'   => $user_agent
                        ]);
                        DB::commit();
                        return 1;
                    }else{
                        return 2;
                    }
                }catch(Exception $e){
                    DB::rollBack();
                    return 0;
                }
            }
        }else{
            return 4;
        }
        }

    }

    public function search_bosung(Request $request){
        $validator = Validator::make($request->all(),
        [
        'dt_bosung'  => 'required|regex:/[0-9]/|not_regex:/[a-z]/|min:10|max:10',
        ],
        [
            'dt_bosung.required'      =>'Điện thoại gồm 10 chữ só',
            'dt_bosung.not_regex'     =>'Điện thoại gồm 10 chữ s',
            'dt_bosung.max'           =>'Điện thoại gồm 10 chữ s',
            'dt_bosung.min'           =>'Điện thoại gồm 10 chữ s',
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }else{
            try{
                $ins = DB::table('l_go_batch_insv')
                ->updateOrInsert(
                    [
                        'id_user' => Auth::guard('search')->user()->id
                    ],
                    [
                        'id_invs' => 1,
                        'phone' => $request ->input('dt_bosung')

                    ]
                );
                if($ins == 0){
                    return 2;
                }else{
                    return 1;
                }
            }catch(Exception $e){
                return 0;
            }
        }
    }

    public function insv(Request $request){
        // try{
            $ins = DB::table('l_go_insv')
            ->insert(
                [
                    'id_user' => Auth::guard('search')->user()->id,
                    'id_seen' => 1,
                ],

            );
        //     return 1;
        // }catch(Exception $e){
        //     return 0;
        // }
    }

}
