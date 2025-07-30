<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


use Illuminate\Support\Facades\DB;


class MailDuyet extends Mailable
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

        // $mail = DB::table('24_noidungmail')->where('id',$this->id_mail)->first();
        // preg_match_all('/\$\$\$(.*?)\$\$\$/', $mail->noidung, $matches);

        // $pattern = '/(\$\$\$.*?\$\$\$)/';
        // $parts = preg_split($pattern, $mail->noidung, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        // $thongtin = DB::table('24_thongtincanhan')->where('id_taikhoan',$this->id_taikhoan)->first();
        // foreach ($parts as $key => $part) {
        //     foreach ($matches[1] as $key => $match) {
        //         if($part == '$$$'.$match.'$$$'){
        //             $array = str_replace($part, $thongtin->$match, $parts);
        //             $parts = $array;
        //         }
        //     }
        // }
        // $noidungmail = implode("", $parts);
        return $this->view('user.mail.testmail')
        ->subject($this ->tieude_mail)
        ->from('tuvantuyensinh@ctuet.edu.vn','Trường Đại học Kỹ thuật - Công nghệ Cần Thơ')
        ->with([
                'noidung'=>  $this ->noidung_mail
        ]);
    }

}
