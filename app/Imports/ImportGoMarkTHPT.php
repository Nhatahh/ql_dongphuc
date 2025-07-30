<?php
namespace App\Imports;

// use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportGoMarkTHPT implements ToCollection
{
    public function collection(Collection $rows)
    {
        $year = DB::table('l_year_active')
        ->get();
        $j = 0;
        $a = 0;
        // DB::table('l_result')
        // ->where('id_batch',$year[0]->id_batch)
        // ->where('id_method',2)
        // ->delete();
        for($i = 1; $i<count($rows); $i++){
            if($rows[$i][0] == 'ID'){
                continue;
            }else{
                for($j = 0; $j<count($rows[$i]);$j++){
                    switch ($rows[0][$j]) {
                        case 'TO':
                            $id_subject = 11;
                            $id_semester_result = "PT";
                            break;
                        case 'LI':
                            $id_subject = 12;
                            $id_semester_result = "PT";
                            break;
                        case 'HO':
                            $id_subject = 13;
                            $id_semester_result = "PT";
                            break;
                        case 'SI':
                            $id_subject = 14;
                            $id_semester_result = "PT";
                            break;
                        case 'VA':
                            $id_subject = 15;
                            $id_semester_result = "PT";
                            break;
                        case 'SU':
                            $id_subject = 16;
                            $id_semester_result = "PT";
                            break;
                        case 'DI':
                            $id_subject = 17;
                            $id_semester_result = "PT";
                            break;
                        case 'NN':
                            $id_subject = 18;
                            $id_semester_result = "PT";
                            break;
                        case 'GDCD':
                            $id_subject = 19;
                            $id_semester_result = "PT";
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
                                'id_semester_result' => "PT",
                                'id_class_result' => "TN",
                                'year_result' => 1,
                                'id_batch' => $year[0]->id_batch,
                                'id_method' => 2,
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
