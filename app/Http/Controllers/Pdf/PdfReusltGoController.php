<?php

namespace App\Http\Controllers\Pdf;


class PdfReusltGoController extends Controller
{

    public function dowload_result_go()
    {


            return view('pdf.resullt_go',[
                'title' => "CTUT|Quản lý người dùng",
            ]);



        // $data = [
        //     'title' => 'Welcome to Viet Nam'
        // ];


        // $pdf = PDF::loadView('pdf.resullt_go', $data);
        // //Nếu muốn hiển thị file pdf theo chiều ngang
        // // $pdf->setPaper('A4', 'landscape');

        // //Nếu muốn download file pdf
        // return $pdf->download('myPDF.pdf');

        // //Nếu muốn preview in pdf
        // //return $pdf->stream('myPDF.pdf');
    }
}
