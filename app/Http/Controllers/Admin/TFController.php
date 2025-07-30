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

class TFController extends Controller
{

    public function index(){
        return view('admin.tfjs.index');
    }

    // public function loadComboxMenu(){
    //     $menus = DB::table('l_menus')->where('parent_id',0)->get();
    //     return  $menus;
    // }

    // public function loadMenu(){
    //     $menus = DB::table('l_menus')->orderBy('number', 'asc')->get();
    //     $this->menu($menus,0,"",$result);
    //     $json_data['data'] = $result;
    //     $data = json_encode($json_data);
    //     echo  $data;
    // }

    // function menu($menus,$parent_id = 0,$char = 0,&$result){
    //     foreach($menus as $key => $menu){
    //         if($menu->parent_id === $parent_id ){
    //             $menu->name = $char.$menu->name;
    //             $result[] = $menu;
    //             unset($menus[$key]);
    //             self::menu($menus,$menu->id,$char."|---",$result);
    //         }
    //     }
    // }


    // public function destroy($id){
    //     $menu = DB::table('l_menus')->where('id',$id)->get();
    //     if($menu){
    //         DB::table('l_menus')->where('id',$id)->orWhere('parent_id',$id)->delete();
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }

    public function store(Request $request){
        // $validator = Validator::make($request->all(),
        //     [
        //         'name'      =>'required|unique:l_menus,name',
        //         'content'   =>'required',
        //         'parent_id' =>'numeric|min:0',
        //         'number'    =>'alpha_num',
        //     ],
        //     [
        //         'name.required'     =>'Điền tên chức năng',
        //         'name.unique'       =>'Trùng tên chức năng!',
        //         'content.required'  =>'Mô tả ngắn gọn chức năng',
        //         'parent_id.min'     =>'Chọn chức năng gốc',
        //         'link.required'     =>'Đường đẫn không được trống',
        //         'number.alpha_num'  =>'Thứ tự phải là số',
        //     ]
        // );

    //     if ($validator->fails()) {
    //         return response()->json($validator->errors());
    //     }else{
    //         if($request->input('active') == 'true' ){
    //             $active = 1;
    //         }else{
    //             $active = 0;
    //         }

    //         DB::table('l_menus')->insert([
    //             'name' => $request->input('name'),
    //             'content' => $request->input('content'),
    //             'parent_id' => $request->input('parent_id'),
    //             'slug' => Str::slug($request ->input('name'),'-'),
    //             'active' =>  $active,
    //             'number' =>  $request->input('number'),
    //             'link' =>  $request->input('link'),
    //         ]);

    //         // Menu::create([
    //         //     'name' => $request->input('name'),
    //         //     'content' => $request->input('content'),
    //         //     'parent_id' => $request->input('parent_id'),
    //         //     'slug' => Str::slug($request ->input('name'),'-'),
    //         //     'active' =>  $active,
    //         //     'number' =>  $request->input('number'),
    //         //     'link' =>  $request->input('link'),
    //         // ]);

    //         $menu = DB::table('l_menus')
    //         ->where('name', $request->input('name'))
    //         ->get();
    //         if($menu){
    //             return 1;
    //         }else{
    //             return 0;
    //         }
    //     }

    $image = $request->file('file_council');
    $path = 'images/years/2023/HDTS';
    $image->move($path, $image->getClientOriginalName());
    return response()->json($path);
    }


    // public function load($id){
    //     $menu = DB::table('l_menus')->where('id', $id)->get();
    //     return $menu;
    // }

    // public function edit(Request $request){
    //     $validator = Validator::make($request->all(),
    //         [
    //             'name'      =>'required',
    //             'content'   =>'required',
    //             'parent_id' =>'numeric|min:0',
    //             'number'    =>'alpha_num',
    //             'link'      =>'required',
    //         ],
    //         [
    //             'name.required'     =>'Điền tên chức năng',
    //             'content.required'  =>'Mô tả ngắn gọn chức năng',
    //             'parent_id.min'     =>'Chọn chức năng gốc',
    //             'link.required'     =>'Đường đẫn không được trống',
    //             'number.alpha_num'  =>'Thứ tự phải là số',
    //         ]
    //     );

    //     if ($validator->fails()) {
    //         return response()->json($validator->errors());
    //     }else{
    //         if($request->input('active') == 'true' ){
    //                 $active = 1;
    //             }else{
    //                 $active = 0;
    //             }
    //         DB::table('l_menus')
    //             ->where('id', $request->input('id'))
    //             ->update([
    //                 'name' => $request->input('name'),
    //                 'content' => $request->input('content'),
    //                 'parent_id' => $request->input('parent_id'),
    //                 'slug' => Str::slug($request ->input('name'),'-'),
    //                 'active' =>  $active,
    //                 'number' =>  $request->input('number'),
    //                 'link' =>  $request->input('link'),
    //                 'root_ad' =>  0,
    //             ]);
    //         $menu = DB::table('l_menus')
    //         ->where('name', $request->input('name'))
    //         ->get();
    //         if($menu){
    //             return 1;
    //         }else{
    //             return 0;
    //         }
    //     }
    // }

    // function datasidebar($menus,$parent_id = 0,$level=0,&$html){


    //     // $menus = DB::table('menus')
    //     // ->join('roles', 'menus.id', '=', 'roles.iduser')
    //     // // ->select('menus.*')
    //     // ->where('active', 1)
    //     // ->orWhere('iduser',10)
    //     // ->orderBy('number', 'asc')
    //     // ->get();





    //     // $menus = DB::table('menus')
    //     //     ->where('active', 1)
    //     //     ->orderBy('number', 'asc')
    //     //     ->get();
    //     foreach($menus as $key => $menu){
    //         if($menu->parent_id === $parent_id ){
    //             $menu ->level = $level;
    //             if( $menu ->level == 0){
    //                 $html .= '<li class = "nav-item">';
    //                     $html .= '<a class="nav-link">';
    //                         $html .= '<i class="nav-icon fas fa-edit"></i>';
    //                         $html .=  '<p>'.$menu ->name;
    //                             $html .= '<i class="fas fa-angle-left right"></i>';
    //                         $html .= '</p>';
    //                     $html .='</a>';

    //             }else{
    //                 $html .= "<ul class='nav nav-treeview'>";
    //                 $html .= '<li class="nav-item">';
    //                     $html .= "<a  onclick = 'loadpage(".$menu ->id.")' class='nav-link'>";
    //                         $html .=  '<i class="far fa-circle nav-icon"></i>';
    //                         $html .= '<p>'.$menu ->name.'</p>';
    //                     $html .= '</a>';
    //                     $html .= '</li>';
    //             }
    //             unset($menus[$key]);
    //             self::datasidebar($menus,$menu->id,$level + 1,$html);
    //             $html .= '</li>';
    //             $html .= "</ul>";
    //         }
    //     }

    // }

    // public function sidebar(){

    //     switch (Auth::user()->level_ad) {
    //         case '1':
    //             $menus = DB::table('l_menus')->orderBy('number', 'asc')
    //             ->where('active', 1)
    //             ->get();
    //             # root
    //             break;
    //         case '2':
    //             $menus = DB::table('l_roles')
    //             ->join('l_menus', 'l_roles.idmenu', '=', 'l_menus.id')
    //             ->where('iduser', Auth::id())
    //             ->where('active', 1)
    //             ->where('root_ad', 0)
    //             ->orderBy('number', 'asc')
    //             ->get();
    //             break;
    //         default:
    //              # admin
    //             break;
    //     }

    //     $this->datasidebar($menus,0,0,$result);
    //     echo $result;
    // }

    // public function loadpage($id){
    //     $page = DB::table('l_menus')->where('id',$id)->get();
    //     return $page;
    // }
}

