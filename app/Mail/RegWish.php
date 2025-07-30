<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegWish extends Mailable
{
    use Queueable, SerializesModels;

    private $major;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($major)
    {
        $this ->major = $major;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('user.mail.reg_wish')
            ->subject('Thông tin nguyện vọng thí sinh đã đăng ký')
            ->from('tuvantuyensinh@ctuet.edu.vn','Trường Đại học Kỹ thuật - Công nghệ Cần Thơ')
            ->with([
                    'major'=> $this->major
            ]);
    }
}
