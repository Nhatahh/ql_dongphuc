<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


use Illuminate\Support\Facades\DB;


class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    // private $major;
    private $id_noidung;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id_noidung)
    {
        // $this ->major = $major;$
        $this ->id_noidung = $id_noidung;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail_gui = DB::table('24_noidungmail')
        ->select('tieude','noidung')
        ->where('id',$this ->id_noidung)
        ->first();
        return $this->view('user.mail.testmail')
        ->subject($mail_gui->tieude)
        ->from('tuvantuyensinh@ctuet.edu.vn','Trường Đại học Kỹ thuật - Công nghệ Cần Thơ')
        ->with([
                'noidung'=> $mail_gui->noidung
        ]);
    }

}
