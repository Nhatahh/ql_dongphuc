<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


use Illuminate\Support\Facades\DB;


class Guithu extends Mailable
{
    use Queueable, SerializesModels;

    // private $major;
    private $noidung;
    private $tieude;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($noidung,$tieude)
    {
        // $this ->major = $major;$
        $this ->noidung = $noidung;
        $this ->tieude = $tieude;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('user.mail.testmail')
        ->subject($this->tieude)
        ->from('tuvantuyensinh@ctuet.edu.vn','Trường Đại học Kỹ thuật - Công nghệ Cần Thơ')
        ->with([
                'noidung'=> $this->noidung
        ]);
    }

}
