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
use \App\Http\Controllers\User\Main\RegisterWishController;
use LDAP\Result;

use function PHPUnit\Framework\countOf;

class ExpensesStaController extends Controller

{
    public function index(){
        return view('admin.expense_sta.index',
        [
            'title' => "CTUT|Hệ thống đăng ký xét tuyển",
        ]);
    }

    //Load search
    public function load_search_sta(){
        //Year
        $year0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Năm Tuyển sinh",
                'selected' => true
            ]
        );
        $years = DB::table('l_years')
        ->select('id','course as text')
        ->get();
        $years[] = $year0;

        $user0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Người thu",
                'selected' => true
            ]
        );
        $user = DB::table('l_menus')
        ->join('l_roles','l_roles.idmenu','l_menus.id')
        ->join('users','users.id','l_roles.iduser')
        ->where('l_menus.id',13)
        // ->where('l_menus.id',2)
        ->select('users.id as id','users.name as text')
        ->get();
        $user[] = $user0;


        $result = array(
            'year' => $years,
            'user' => $user
        );
        return $result;
    }

    public function load_list_ex(Request $request){
        $year = $request ->input('data')[0];
        $form = $request ->input('data')[1];
        $user = $request ->input('data')[2];
        $day = $request ->input('data')[3];
        if($year == 0){
            $year = 'l_expenses_user.id_year is not null';
        }else{
            $year = 'l_expenses_user.id_year = '.$year;
        }

        if( $form == 0){
            $form = 'form_check is not null';
        }else{
            $form = 'form_check = '.$form;
        }

        if( $user == 0){
            $user  = 'users.id is not null';
        }else{
            $user  = 'users.id  = '.$user;
        }

        if( $day == ''){
            $day  = 'l_expenses_user.create_at is not null';
        }else{
            $day  = "l_expenses_user.create_at LIKE  '".$day."%'";
        }

        $sql ='SELECT *,if(form_check = 1,"Chuyển khoản","Tiền mặt") as form_check1 FROM `l_expenses_user` INNER JOIN users ON users.id = l_expenses_user.id_ex_admin INNER JOIN l_info_users ON l_info_users.id_user = l_expenses_user.id_user INNER JOIN l_users ON l_users.id = l_expenses_user.id_user INNER JOIN l_years ON l_years.id = l_expenses_user.id_year WHERE '.$year.' AND '.$form.' AND '.$user.' AND '.$day.'  ORDER BY l_expenses_user.create_at ASC' ;

        $infor = DB::select($sql);
        $json_data['data'] = $infor;
        $data = json_encode($json_data);
        echo  $data;
    }
    //Load thông tin thí sinh (tìm kiếm trường hợp thiếu thông tin)
    public function load_list_infor(){
        $infor = DB::table('l_users')
        ->join('l_info_users','l_info_users.id_user','l_users.id')
        ->select('l_users.id as id_user','l_info_users.name_user','l_users.id_card_users','l_users.phone_users')
        ->get();

        $json_data['data'] = $infor;
        $data = json_encode($json_data);
        echo  $data;
    }


    function convert_number_to_words($number)
{
    if (strpos($number, '.')) {//có phần lẻ thập phân
        list($integer, $fraction) = explode(".", (string)$number);

    } else { //không có phần lẻ
        // $number = (int) $number."0";
        // list($integer, $fraction) = explode(".", (string)$number);

        $integer = $number;
        $fraction = NULL;
    }

    $output = "";

    // if ($integer[0] == "-") {
    //     $output = "âm ";
    //     $integer = ltrim($integer, "-");
    // } else if ($integer[0] == "+") {
    //     $output = "dương ";
    //     $integer = ltrim($integer, "+");
    // }

    $integer = str_pad($integer, 36, "0", STR_PAD_LEFT);
    $group = rtrim(chunk_split($integer, 3, " "), " ");
    $groups = explode(" ", $group);

    $groups2 = array();
    foreach ($groups as $g) {
        $groups2[] = $this ->convertThreeDigit($g[0], $g[1], $g[2]);
    }

    for ($z = 0; $z < count($groups2); $z++) {
        if ($groups2[$z] != "") {
            $output .= $groups2[$z] . $this->convertGroup(11 - $z) . (
                $z < 11
                && !array_search('', array_slice($groups2, $z + 1, -1))
                && $groups2[11] != ''
                && $groups[11][0] == '0'
                    ? " "
                    : ", "
                );
        }
    }

    $output = rtrim($output, ", ");

    if ($fraction > 0) {
        $output .= " phẩy";
        for ($i = 0; $i < strlen($fraction); $i++) {
            $output .= " " . $this ->convertDigit($fraction[$i]);
        }
    }

    return $output;
}

function convertGroup($index)
{
    switch ($index) {
        case 11:
            return " decillion";
        case 10:
            return " nonillion";
        case 9:
            return " octillion";
        case 8:
            return " septillion";
        case 7:
            return " sextillion";
        case 6:
            return " quintrillion";
        case 5:
            return " nghìn triệu triệu";
        case 4:
            return " nghìn tỷ";
        case 3:
            return " tỷ";
        case 2:
            return " triệu";
        case 1:
            return " nghìn";
        case 0:
            return "";
    }
}

function convertThreeDigit($digit1, $digit2, $digit3)
{
    $buffer = "";

    if ($digit1 == "0" && $digit2 == "0" && $digit3 == "0") {
        return "";
    }

    if ($digit1 != "0") {
        $buffer .= $this ->convertDigit($digit1) . " trăm";
        if ($digit2 != "0" || $digit3 != "0") {
            $buffer .= " ";
        }
    }

    if ($digit2 != "0") {
        $buffer .=  $this ->convertTwoDigit($digit2, $digit3);
    } else if ($digit3 != "0") {
        $buffer .=  $this ->convertDigit($digit3);
    }

    return $buffer;
}

function convertTwoDigit($digit1, $digit2)
{
    if ($digit2 == "0") {
        switch ($digit1) {
            case "1":
                return "mười";
            case "2":
                return "hai mươi";
            case "3":
                return "ba mươi";
            case "4":
                return "bốn mươi";
            case "5":
                return "năm mươi";
            case "6":
                return "sáu mươi";
            case "7":
                return "bảy mươi";
            case "8":
                return "tám mươi";
            case "9":
                return "chín mươi";
        }
    } else if ($digit1 == "1") {
        switch ($digit2) {
            case "1":
                return "mười một";
            case "2":
                return "mười hai";
            case "3":
                return "mười ba";
            case "4":
                return "mười bốn";
            case "5":
                return "mười lăm";
            case "6":
                return "mười sáu";
            case "7":
                return "mười bảy";
            case "8":
                return "mười tám";
            case "9":
                return "mười chín";
        }
    } else {
        $temp =  $this ->convertDigit($digit2);
        if ($temp == 'năm') $temp = 'lăm';
        if ($temp == 'một') $temp = 'mốt';
        switch ($digit1) {
            case "2":
                return "hai mươi $temp";
            case "3":
                return "ba mươi $temp";
            case "4":
                return "bốn mươi $temp";
            case "5":
                return "năm mươi $temp";
            case "6":
                return "sáu mươi $temp";
            case "7":
                return "bảy mươi $temp";
            case "8":
                return "tám mươi $temp";
            case "9":
                return "chín mươi $temp";
        }
    }
}

function convertDigit($digit)
{
    switch ($digit) {
        case "0":
            return "không";
        case "1":
            return "một";
        case "2":
            return "hai";
        case "3":
            return "ba";
        case "4":
            return "bốn";
        case "5":
            return "năm";
        case "6":
            return "sáu";
        case "7":
            return "bảy";
        case "8":
            return "tám";
        case "9":
            return "chín";
    }
}



    public function data_print($year,$form,$user1,$day){
        if($year == 0){
            $year = 'l_expenses_user.id_year is not null';
        }else{
            $year = 'l_expenses_user.id_year = '.$year;
        }

        if( $form == 0){
            $form = 'form_check is not null';
        }else{
            $form = 'form_check = '.$form;
        }

        if( $user1 == 0){
            $user  = 'users.id is not null';
        }else{
            $user  = 'users.id  = '.$user1;
        }

        if( $day == 0){
            $day  = 'l_expenses_user.create_at is not null';
        }else{
            $day  = "l_expenses_user.create_at LIKE  '".$day."%'";
        }

        $sql ='SELECT *,DATE_FORMAT(birth_user,"%d/%m/%y") as birth_user,if(form_check = 1,"Chuyển khoản","Tiền mặt") as form_check1 FROM `l_expenses_user` INNER JOIN users ON users.id = l_expenses_user.id_ex_admin INNER JOIN l_info_users ON l_info_users.id_user = l_expenses_user.id_user INNER JOIN l_users ON l_users.id = l_expenses_user.id_user INNER JOIN l_years ON l_years.id = l_expenses_user.id_year WHERE '.$year.' AND '.$form.' AND '.$user.' AND '.$day.'  ORDER BY l_expenses_user.create_at ASC' ;
        $infor = DB::select($sql);
        $user_print = DB::table('users')
        ->where('id',$user1)
        ->get();

        // Set the new timezone
        date_default_timezone_set('Asia/Ho_Chi_Minh');




        $sql_price = 'SELECT sum(price) as price FROM `l_expenses_user` INNER JOIN users ON users.id = l_expenses_user.id_ex_admin INNER JOIN l_years ON l_years.id = l_expenses_user.id_year WHERE '.$year.' AND '.$form.' AND '.$user.' AND '.$day;
        $total = DB::select($sql_price);
        $total_text = $this ->convert_number_to_words($total[0] ->price)." đồng.";
        $day = date('d');
        $month = date('m');
        $year1 = date('Y');
        $num = count($infor);
        if(count($user_print) == 1){
            return view('admin.expense_print.index',
            [
                'title' => "CTUT|Hệ thống đăng ký xét tuyển",
                'data' =>  $infor,
                "user"  => $user_print,
                'day'  => $day,
                'month'  => $month,
                'year'=> $year1,
                'num' =>$num,
                'total' => $total[0] ->price,
                'total_text' => $total_text,

            ]);
        }else{
            return "fail_user";
        }
    }



}//End Class
