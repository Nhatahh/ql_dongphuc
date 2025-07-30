<?php
namespace App\Exports;

// use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\GoController;
use Maatwebsite\Excel\Concerns\FromCollection;



class GoMark implements FromCollection
{
    private $active,$year,$id_batch;

    public function __construct(int $active,$year,$id_batch)
    {
        $this->active = $active;
        // $this->data = $data;
        $this->year = $year;
        $this->id_batch = $id_batch;

    }

    public function collection()
    {
        $data = DB::select('SELECT * FROM l_result INNER JOIN l_subject ON l_subject.id = l_result.id_subject INNER JOIN (SELECT l_users.id as id, l_users.id_card_users,l_info_users.name_user,l_years.course FROM l_users LEFT JOIN l_info_users ON l_users.id = l_info_users.id_user INNER JOIN l_years ON l_years.id = l_users.id_year WHERE l_users.id_batch = '.$this->id_batch.' AND l_years.id = '.$this->year.') as USER ON USER.id = l_result.id_student_result WHERE l_result.id_batch = '.$this->id_batch.' ORDER BY USER.id ASC, l_result.id_class_result ASC, l_result.id_semester_result ASC, l_result.id_subject ASC');

        $data_ex = new Collection([
            ['ID','CMND/TCC',"Họ tên",'Lớp','Học kì','Môn','Điểm','Năm tuyển sinh','Phương thức'],
        ]);

        foreach ($data as $key => $value) {
           $a = [$value ->id,$value ->id_card_users,$value ->name_user,$value ->id_class_result,$value ->id_semester_result,$value ->name_subject,$value ->mark_result,$value ->course,$value ->note_subject];
           $data_ex[] = $a;
        }
        return $data_ex;
    }
}
