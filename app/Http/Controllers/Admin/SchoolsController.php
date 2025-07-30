<?php

namespace App\Http\Controllers\Admin;
use App\Http\Requests\Menu\CreateFormRequest;

use App\Models\Menu;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\JsonDecoder;

class SchoolsController extends Controller
{

    public function create(){
        return view('admin.schools.schools');
    }



    public function load_province_shools(){
        $menus = DB::table('l_province')
        ->select(DB::raw('ROW_NUMBER() OVER(ORDER BY l_province.id) as stt'),'l_province.id','l_province.id_province',DB::raw("CONCAT(l_province.name_province,'xxx',id) as name_province"),DB::raw("CONCAT(l_province.active_province,'xxx',id) as active_province"),DB::raw('CONCAT(0,"_",id) as end'))
        // ->where('active_province',1)
        ->get();

        $json_data['data'] = $menus;
        $data = json_encode($json_data);
        echo  $data;
    }

    public function load_shools($id){
        $schools = DB::table('l_school')
        ->select(DB::raw('ROW_NUMBER() OVER(ORDER BY l_school.id) as stt'), DB::raw("CONCAT(l_school.name_school,'xxx',l_school.id,'xxx',l_school.id_province) as name_school"),'l_school.id_school as id_school', DB::raw('CONCAT(l_school.active_school,"xxx",l_school.id_province) as active_school'), 'l_school.id as id','l_school.priority_area_school', DB::raw("CONCAT(l_school.note_school,'xxx',l_school.id,'xxx',l_school.id_province) as note_school"),DB::raw('CONCAT(0,"_",l_school.id) as end'))
        // ->join('l_priority_area','l_school.priority_area_school','l_priority_area.id')
        // ->join('l_province','l_province.id_province','l_school.id_province')
        ->where('id_province',$id)
        ->get();
        $priority_area = DB::table('l_priority_area')
        ->where('l_priority_area.active_priority_area',1)
        ->get();

        $option0 = array(
            'id' => 0,
            'id_priority_area' => 'Chọn KV',
            'selected' => '',

        );
        $option = [];
        foreach ($schools as $key => $value) {
            $id_school = $value->id;
            // $id_province = $value->id_province;
            $option[] = $option0;
            foreach ($priority_area as $key => $area) {
                if($value->priority_area_school == $area->id){
                    $selected = 'selected';
                }else{
                    $selected = '';
                }
                $option1 = array(
                    'id' => $area->id,
                    'id_priority_area' => $area->id_priority_area,
                    'selected' => $selected,

                );
                $option[] = $option1;
            }

            $value ->priority_area = array(
                'option' => $option,
                'id' => $id_school,
                'id_province' => $id,
            );
            $option = [];
        }

        $option[] = $option0;
        foreach ($priority_area as $key => $area) {

            $option1 = array(
                'id' => $area->id,
                'id_priority_area' => $area->id_priority_area,
                'selected' => '',
            );
            $option[] = $option1;
        }

        $school0 = array(
            'stt' =>1 + count($schools),
            'id' => '',
            'name_school' => '0xxx0xxx'.$id,
            'note_school' => ' xxx0xxx'.$id,
            'active_school' => '0xxx'.$id,
            'end' => "1_0",
            'id_priority_area' => '',
            'id_school' => '',
            'priority_area' => array(
                'option' => $option,
                'id' => 0,
                'id_province' => $id,
            )
        );
        $schools[] = $school0;

        $json_data['data'] = $schools;
        $data = json_encode($json_data);
        echo  $data;
    }

}
