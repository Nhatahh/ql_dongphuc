<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


use Illuminate\Support\Facades\DB;


class Mail_Chuan_24 extends Mailable
{
    use Queueable, SerializesModels;

    // private $major;
    private $noidung_mail;
    private $tieude_mail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($noidung_mail, $tieude_mail)
    {
        // $this ->major = $major;$
        $this ->noidung_mail = $noidung_mail;
        $this ->tieude_mail = $tieude_mail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('user_24.admin24.manage.mail.testmail')
        ->subject($this ->tieude_mail)
        ->from('tuvantuyensinh@ctuet.edu.vn','Trường Đại học Kỹ thuật - Công nghệ Cần Thơ')
        ->with([
            'noidung'=>  $this ->noidung_mail
        ]);
    }

}


