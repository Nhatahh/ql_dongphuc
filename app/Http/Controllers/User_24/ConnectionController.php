<?php

namespace App\Http\Controllers\User_24;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use PhpOption\Option;
use Carbon\Carbon;
use PhpParser\Node\Expr\FuncCall;
use \App\Http\Controllers\User\Main\InfoUserController;
use \App\Http\Controllers\User\Main\RegisterWishController;
use Exception;
use Illuminate\Support\Facades\Http;
use function PHPUnit\Framework\countOf;
use Tymon\JWTAuth\Contracts\JWTSubject;



use BaoKim\BaokimSdk\Connect;
use BaoKim\BaokimSdk\getRequirement;
use BaoKim\BaokimSdk\Webhook;

class ConnectionController extends Controller
{

  protected $merchantId = 40002;
  protected $apiKey = 'a18ff78e7a9e44f38de372e093d87ca1';
  protected $apiSecret = '9623ac03057e433f95d86cf4f3bef5cc';
  protected $apiUrl = 'https://dev-api.baokim.vn';


  public function thanhtoan(Request $request)
{
  getRequirement::setKey($this->apiKey, $this->apiSecret);
  $webhook = new Connect();

  $data = [
        "Payment_type" => "Pay and Create Token",
        "api_operation" => "PAY",
        "init_token" => 1,
        "merchant_id" => $this->merchantId,
        'mrc_order_id' => 'PAY'.time(),
        'total_amount' => 10000,
        'description' => 'test_package',
        'webhooks' => $this->apiUrl.'mso/callback-request',
        'customer_phone' => '0888888888',
        'customer_email' => 'nptu@ctuet.edu.vn',
        // 'url_success'=>'https://www.24h.com.vn/'
    ];

    return $webhook->createOrder($data);
}





// public function getList(Request $request)
// {
//   getRequirement::setKey($this->apiKey, $this->apiSecret);
//   $data = [];
//   $webhook = new Connect();
//   return $webhook->getBpmList($data);
// }

public function verifyWebhook(Request $request)
{
  $webhook = new Webhook('D8BB7icFvOTgQ9xgS2li0OufgWnDQLMm');
  return $webhook->verify($request->getContent());
}



}
