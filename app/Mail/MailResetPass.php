<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailResetPass extends Mailable
{
    use Queueable, SerializesModels;

    private $email_register;
    private $phone_register;
    private $cmnd_register;
    private $password_register;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email_register,$phone_register,$cmnd_register,$password_register)
    {
        $this ->email_register = $email_register;
        $this ->phone_register = $phone_register;
        $this ->cmnd_register =  $cmnd_register;
        $this ->password_register = $password_register;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('user.mail.resetpass')
            ->subject('Thông tin cấp lại tài khoản xét tuyển')
            ->from('tuvantuyensinh@ctuet.edu.vn','Trường Đại học Kỹ thuật - Công nghệ Cần Thơ')
            ->with([
                'email_register'    => $this ->email_register,
                'phone_register'    => $this ->phone_register,
                'cmnd_register'     => $this ->cmnd_register,
                'password_register' => $this ->password_register
            ]);
    }
}
