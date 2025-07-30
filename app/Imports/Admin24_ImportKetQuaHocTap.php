<?php
namespace App\Imports;

// use App\Invoice;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class Admin24_ImportKetQuaHocTap implements ToCollection
{
    // private $dotts;

    // public function __construct($dotts)
    // {
    //     $this->dotts = $dotts;
    // }

    public function collection(Collection $rows)
    {
        DB::table('24_ketquahoctap')->update([
            'id_method' => 0,
        ]);
        for($i = 1; $i<count($rows); $i++){
            $data_temp = array(
                'id_student_result' => $rows[$i][0],
                'id_subject' => $rows[$i][1],
                'id_class_result' => $rows[$i][2],
                'id_semester_result' => $rows[$i][3],
                'mark_result' => $rows[$i][4],
                'id_method' => 1
            );
            $data[] = $data_temp;
        }
        DB::table('24_ketquahoctap')
        ->upsert(
            $data,
            ['id_student_result','id_subject','id_class_result','id_semester_result'],
            ['mark_result','id_method'],
        );
    }
}
