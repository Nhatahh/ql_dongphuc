<?php

namespace App\Listeners;


use App\Events\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Support\Facades\View;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use \App\Http\Controllers\User_24\Admin\Admin_24Controller;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SendRegistrationEmail
{
    use InteractsWithQueue;
    public function handle(JobProcessed $event)
    {
        $user = $event->job->payload()['data']['command'];
        $email = unserialize($user)->mailable->to[0]['address'];



        // $response = Http::get('api/see');


        // $response = Http::withoutVerifying()->post('https://xettuyentest.ctuet.edu.vn/api/see');


        // $client = new \GuzzleHttp\Client(['timeout' => 20.0]);
        // $response = $client->request("POST", "https://xettuyentest.ctuet.edu.vn/admin24/email", [
        //     'email' => $email
        // ]);





    }
}
