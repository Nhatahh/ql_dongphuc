<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Expenses_back extends Mailable
{
    use Queueable, SerializesModels;

    private $user_name,$content,$id_user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id_user,$user_name,$content)
    {
        $this ->user_name = $user_name;
        $this ->content = $content;
        $this ->id_user = $id_user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('user.mail.expenses_back')
            ->subject('Thông tin lệ phí xét tuyển')
            ->from('tuvantuyensinh@ctuet.edu.vn','Trường Đại học Kỹ thuật - Công nghệ Cần Thơ')
            ->with([
                    'user_name'=> $this->user_name,
                    'content'=> $this->content,
                    'id_user'=> $this->id_user
            ]);
    }
}
