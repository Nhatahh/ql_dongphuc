<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Check_user extends Mailable
{
    use Queueable, SerializesModels;

    private $user_student,$content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_student,$content)
    {
        $this ->user_student = $user_student;
        $this ->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('user.mail.check_user')
            ->subject('Thông báo cập nhật hồ sơ')
            ->from('tuvantuyensinh@ctuet.edu.vn','Trường Đại học Kỹ thuật - Công nghệ Cần Thơ')
            ->with([
                    'user_student'=> $this->user_student,
                    'content'=> $this->content,
            ]);
    }
}
