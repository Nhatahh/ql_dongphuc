<?php
namespace App\Imports;

// use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportGoMarkHB implements ToCollection
{
    public function collection(Collection $rows)
    {
        $year = DB::table('l_year_active')
        ->get();
        $j = 0;
        $a = 0;
        // DB::table('l_result')
        // ->where('id_batch',$year[0]->id_batch)
        // ->where('id_method',1)
        // ->delete();
        for($i = 1; $i<count($rows); $i++){
            if($rows[$i][0] == 'ID'){
                continue;
            }else{
                for($j = 0; $j<count($rows[$i]);$j++){
                    switch ($rows[0][$j]) {
                        case 'Toán HK I':
                            $id_subject = 1;
                            $id_semester_result = 1;
                            break;
                        case 'Toán HK II':
                            $id_subject = 1;
                            $id_semester_result = 2;
                            break;
                        case 'Toán CN':
                            $id_subject = 1;
                            $id_semester_result = "CN";
                            break;
                        case 'Văn HK I':
                            $id_subject = 5;
                            $id_semester_result = 1;
                            break;
                        case 'Văn HK II':
                            $id_subject = 5;
                            $id_semester_result = 2;
                            break;
                        case 'Văn CN':
                            $id_subject = 5;
                            $id_semester_result = "CN";
                            break;
                        case 'Vật lí HK I':
                            $id_subject = 2;
                            $id_semester_result = 1;
                            break;
                        case 'Vật lí HK II':
                            $id_subject = 2;
                            $id_semester_result = 2;
                            break;
                        case 'Vật lí CN':
                            $id_subject = 2;
                            $id_semester_result = "CN";
                                break;
                        case 'Hóa học HK I':
                            $id_subject = 3;
                            $id_semester_result = 1;
                            break;
                        case 'Hóa học HK II':
                            $id_subject = 3;
                            $id_semester_result = 2;
                            break;
                        case 'Hóa học CN':
                            $id_subject = 3;
                            $id_semester_result = "CN";
                                break;
                        case 'Sinh học HK I':
                            $id_subject = 4;
                            $id_semester_result = 1;
                                break;
                        case 'Sinh học HK II':
                            $id_subject = 4;
                            $id_semester_result = 2;
                                break;
                        case 'Sinh học CN':
                            $id_subject = 4;
                            $id_semester_result = "CN";
                                break;
                        case 'Lịch sử HK I':
                            $id_subject = 6;
                            $id_semester_result = 1;
                                break;
                        case 'Lịch sử HK II':
                            $id_subject = 6;
                            $id_semester_result = 2;
                                break;
                        case 'Lịch sử CN':
                            $id_subject = 6;
                            $id_semester_result = "CN";
                                break;
                        case 'Địa lí HK I':
                            $id_subject = 7;
                            $id_semester_result = 1;
                                break;
                        case 'Địa lí HK II':
                            $id_subject = 7;
                            $id_semester_result = 2;
                                break;
                        case 'Địa lí CN':
                            $id_subject = 7;
                            $id_semester_result = "CN";
                                break;
                        case 'Ngoại ngữ HK I':
                            $id_subject = 8;
                            $id_semester_result = 1;
                                break;
                        case 'Ngoại ngữ HK II':
                            $id_subject = 8;
                            $id_semester_result = 2;
                                break;
                        case 'Ngoại ngữ CN':
                            $id_subject = 8;
                            $id_semester_result = "CN";
                                break;
                        case 'GDCD HK I':
                            $id_subject = 9;
                            $id_semester_result = 1;
                                break;
                        case 'GDCD HK II':
                            $id_subject = 9;
                            $id_semester_result = 2;
                                break;
                        case 'GDCD CN':
                            $id_subject = 9;
                            $id_semester_result = "CN";
                                break;
                        default:
                            $a = 1;
                            break;
                    }
                    if($rows[$i][$j] != ""){
                        $mark = $rows[$i][$j];
                    }else{
                        $mark = 0;
                    }
                    if($a == 0){
                        DB::table('l_result')
                        ->updateOrInsert(
                            [
                                'id_student_result' => $rows[$i][0],
                                'id_subject' => $id_subject,
                                'id_semester_result' => $id_semester_result,
                                'id_class_result' =>$rows[$i][5],
                                'year_result' => 1,
                                'id_batch' => $year[0]->id_batch,
                                'id_method' => 1,
                            ],
                            [
                                'mark_result' => $mark,
                            ]
                        );
                    }
                    $a = 0;
                }
            }
        }
    }
}
