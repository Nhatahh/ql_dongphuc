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

use function PHPUnit\Framework\countOf;

use BaoKim\BaokimSdk\Connect;
use BaoKim\BaokimSdk\getRequirement;
use BaoKim\BaokimSdk\Webhook;


use \DomainException;
use \InvalidArgumentException;
use \UnexpectedValueException;
use \DateTime;

/**
 * JSON Web Token implementation, based on this spec:
 * https://tools.ietf.org/html/rfc7519
 *
 * PHP version 5
 *
 * @category Authentication
 * @package  Authentication_JWT
 * @author   Neuman Vong <neuman@twilio.com>
 * @author   Anant Narayanan <anant@php.net>
 * @license  http://opensource.org/licenses/BSD-3-Clause 3-clause BSD
 * @link     https://github.com/firebase/php-jwt
 */

class JWT
{

    /**
     * When checking nbf, iat or expiration times,
     * we want to provide some extra leeway time to
     * account for clock skew.
     */
    public static $leeway = 0;

    /**
     * Allow the current timestamp to be specified.
     * Useful for fixing a value within unit testing.
     *
     * Will default to PHP time() value if null.
     */
    public static $timestamp = null;

    public static $supported_algs = array(
        'HS256' => array('hash_hmac', 'SHA256'),
        'HS512' => array('hash_hmac', 'SHA512'),
        'HS384' => array('hash_hmac', 'SHA384'),
        'RS256' => array('openssl', 'SHA256'),
        'RS384' => array('openssl', 'SHA384'),
        'RS512' => array('openssl', 'SHA512'),
    );

    /**
     * Decodes a JWT string into a PHP object.
     *
     * @param string        $jwt            The JWT
     * @param string|array  $key            The key, or map of keys.
     *                                      If the algorithm used is asymmetric, this is the public key
     * @param array         $allowed_algs   List of supported verification algorithms
     *                                      Supported algorithms are 'HS256', 'HS384', 'HS512' and 'RS256'
     *
     * @return object The JWT's payload as a PHP object
     *
     * @throws UnexpectedValueException     Provided JWT was invalid
     * @throws SignatureInvalidException    Provided JWT was invalid because the signature verification failed
     * @throws BeforeValidException         Provided JWT is trying to be used before it's eligible as defined by 'nbf'
     * @throws BeforeValidException         Provided JWT is trying to be used before it's been created as defined by 'iat'
     * @throws ExpiredException             Provided JWT has since expired, as defined by the 'exp' claim
     *
     * @uses jsonDecode
     * @uses urlsafeB64Decode
     */
    public static function decode($jwt, $key, array $allowed_algs = array())
    {
        $timestamp = is_null(static::$timestamp) ? time() : static::$timestamp;

        if (empty($key)) {
            throw new InvalidArgumentException('Key may not be empty');
        }
        $tks = explode('.', $jwt);
        if (count($tks) != 3) {
            throw new UnexpectedValueException('Wrong number of segments');
        }
        list($headb64, $bodyb64, $cryptob64) = $tks;
        if (null === ($header = static::jsonDecode(static::urlsafeB64Decode($headb64)))) {
            throw new UnexpectedValueException('Invalid header encoding');
        }
        if (null === $payload = static::jsonDecode(static::urlsafeB64Decode($bodyb64))) {
            throw new UnexpectedValueException('Invalid claims encoding');
        }
        if (false === ($sig = static::urlsafeB64Decode($cryptob64))) {
            throw new UnexpectedValueException('Invalid signature encoding');
        }
        if (empty($header->alg)) {
            throw new UnexpectedValueException('Empty algorithm');
        }
        if (empty(static::$supported_algs[$header->alg])) {
            throw new UnexpectedValueException('Algorithm not supported');
        }
        if (!in_array($header->alg, $allowed_algs)) {
            throw new UnexpectedValueException('Algorithm not allowed');
        }
        if (is_array($key) || $key instanceof \ArrayAccess) {
            if (isset($header->kid)) {
                if (!isset($key[$header->kid])) {
                    throw new UnexpectedValueException('"kid" invalid, unable to lookup correct key');
                }
                $key = $key[$header->kid];
            } else {
                throw new UnexpectedValueException('"kid" empty, unable to lookup correct key');
            }
        }

        // Check the signature
        if (!static::verify("$headb64.$bodyb64", $sig, $key, $header->alg)) {
            throw new SignatureInvalidException('Signature verification failed');
        }

        // Check if the nbf if it is defined. This is the time that the
        // token can actually be used. If it's not yet that time, abort.
        if (isset($payload->nbf) && $payload->nbf > ($timestamp + static::$leeway)) {
            throw new BeforeValidException(
                'Cannot handle token prior to ' . date(DateTime::ISO8601, $payload->nbf)
            );
        }

        // Check that this token has been created before 'now'. This prevents
        // using tokens that have been created for later use (and haven't
        // correctly used the nbf claim).
        if (isset($payload->iat) && $payload->iat > ($timestamp + static::$leeway)) {
            throw new BeforeValidException(
                'Cannot handle token prior to ' . date(DateTime::ISO8601, $payload->iat)
            );
        }

        // Check if this token has expired.
        if (isset($payload->exp) && ($timestamp - static::$leeway) >= $payload->exp) {
            throw new ExpiredException('Expired token');
        }

        return $payload;
    }

    /**
     * Converts and signs a PHP object or array into a JWT string.
     *
     * @param object|array  $payload    PHP object or array
     * @param string        $key        The secret key.
     *                                  If the algorithm used is asymmetric, this is the private key
     * @param string        $alg        The signing algorithm.
     *                                  Supported algorithms are 'HS256', 'HS384', 'HS512' and 'RS256'
     * @param mixed         $keyId
     * @param array         $head       An array with header elements to attach
     *
     * @return string A signed JWT
     *
     * @uses jsonEncode
     * @uses urlsafeB64Encode
     */
    public static function encode($payload, $key, $alg = 'HS256', $keyId = null, $head = null)
    {
        $header = array('typ' => 'JWT', 'alg' => $alg);
        if ($keyId !== null) {
            $header['kid'] = $keyId;
        }
        if (isset($head) && is_array($head)) {
            $header = array_merge($head, $header);
        }
        $segments = array();
        $segments[] = static::urlsafeB64Encode(static::jsonEncode($header));
        $segments[] = static::urlsafeB64Encode(static::jsonEncode($payload));
        $signing_input = implode('.', $segments);

        $signature = static::sign($signing_input, $key, $alg);
        $segments[] = static::urlsafeB64Encode($signature);

        return implode('.', $segments);
    }

    /**
     * Sign a string with a given key and algorithm.
     *
     * @param string            $msg    The message to sign
     * @param string|resource   $key    The secret key
     * @param string            $alg    The signing algorithm.
     *                                  Supported algorithms are 'HS256', 'HS384', 'HS512' and 'RS256'
     *
     * @return string An encrypted message
     *
     * @throws DomainException Unsupported algorithm was specified
     */
    public static function sign($msg, $key, $alg = 'HS256')
    {
        if (empty(static::$supported_algs[$alg])) {
            throw new DomainException('Algorithm not supported');
        }
        list($function, $algorithm) = static::$supported_algs[$alg];
        switch ($function) {
            case 'hash_hmac':
                return hash_hmac($algorithm, $msg, $key, true);
            case 'openssl':
                $signature = '';
                $success = openssl_sign($msg, $signature, $key, $algorithm);
                if (!$success) {
                    throw new DomainException("OpenSSL unable to sign data");
                } else {
                    return $signature;
                }
        }
    }

    /**
     * Verify a signature with the message, key and method. Not all methods
     * are symmetric, so we must have a separate verify and sign method.
     *
     * @param string            $msg        The original message (header and body)
     * @param string            $signature  The original signature
     * @param string|resource   $key        For HS*, a string key works. for RS*, must be a resource of an openssl public key
     * @param string            $alg        The algorithm
     *
     * @return bool
     *
     * @throws DomainException Invalid Algorithm or OpenSSL failure
     */
    private static function verify($msg, $signature, $key, $alg)
    {
        if (empty(static::$supported_algs[$alg])) {
            throw new DomainException('Algorithm not supported');
        }

        list($function, $algorithm) = static::$supported_algs[$alg];
        switch ($function) {
            case 'openssl':
                $success = openssl_verify($msg, $signature, $key, $algorithm);
                if ($success === 1) {
                    return true;
                } elseif ($success === 0) {
                    return false;
                }
                // returns 1 on success, 0 on failure, -1 on error.
                throw new DomainException(
                    'OpenSSL error: ' . openssl_error_string()
                );
            case 'hash_hmac':
            default:
                $hash = hash_hmac($algorithm, $msg, $key, true);
                if (function_exists('hash_equals')) {
                    return hash_equals($signature, $hash);
                }
                $len = min(static::safeStrlen($signature), static::safeStrlen($hash));

                $status = 0;
                for ($i = 0; $i < $len; $i++) {
                    $status |= (ord($signature[$i]) ^ ord($hash[$i]));
                }
                $status |= (static::safeStrlen($signature) ^ static::safeStrlen($hash));

                return ($status === 0);
        }
    }

    /**
     * Decode a JSON string into a PHP object.
     *
     * @param string $input JSON string
     *
     * @return object Object representation of JSON string
     *
     * @throws DomainException Provided string was invalid JSON
     */
    public static function jsonDecode($input)
    {
        if (version_compare(PHP_VERSION, '5.4.0', '>=') && !(defined('JSON_C_VERSION') && PHP_INT_SIZE > 4)) {
            /** In PHP >=5.4.0, json_decode() accepts an options parameter, that allows you
             * to specify that large ints (like Steam Transaction IDs) should be treated as
             * strings, rather than the PHP default behaviour of converting them to floats.
             */
            $obj = json_decode($input, false, 512, JSON_BIGINT_AS_STRING);
        } else {
            /** Not all servers will support that, however, so for older versions we must
             * manually detect large ints in the JSON string and quote them (thus converting
             *them to strings) before decoding, hence the preg_replace() call.
             */
            $max_int_length = strlen((string) PHP_INT_MAX) - 1;
            $json_without_bigints = preg_replace('/:\s*(-?\d{' . $max_int_length . ',})/', ': "$1"', $input);
            $obj = json_decode($json_without_bigints);
        }

        if (function_exists('json_last_error') && $errno = json_last_error()) {
            static::handleJsonError($errno);
        } elseif ($obj === null && $input !== 'null') {
            throw new DomainException('Null result with non-null input');
        }
        return $obj;
    }

    /**
     * Encode a PHP object into a JSON string.
     *
     * @param object|array $input A PHP object or array
     *
     * @return string JSON representation of the PHP object or array
     *
     * @throws DomainException Provided object could not be encoded to valid JSON
     */
    public static function jsonEncode($input)
    {
        $json = json_encode($input);
        if (function_exists('json_last_error') && $errno = json_last_error()) {
            static::handleJsonError($errno);
        } elseif ($json === 'null' && $input !== null) {
            throw new DomainException('Null result with non-null input');
        }
        return $json;
    }

    /**
     * Decode a string with URL-safe Base64.
     *
     * @param string $input A Base64 encoded string
     *
     * @return string A decoded string
     */
    public static function urlsafeB64Decode($input)
    {
        $remainder = strlen($input) % 4;
        if ($remainder) {
            $padlen = 4 - $remainder;
            $input .= str_repeat('=', $padlen);
        }
        return base64_decode(strtr($input, '-_', '+/'));
    }

    /**
     * Encode a string with URL-safe Base64.
     *
     * @param string $input The string you want encoded
     *
     * @return string The base64 encode of what you passed in
     */
    public static function urlsafeB64Encode($input)
    {
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }

    /**
     * Helper method to create a JSON error.
     *
     * @param int $errno An error number from json_last_error()
     *
     * @return void
     */
    private static function handleJsonError($errno)
    {
        $messages = array(
            JSON_ERROR_DEPTH => 'Maximum stack depth exceeded',
            JSON_ERROR_STATE_MISMATCH => 'Invalid or malformed JSON',
            JSON_ERROR_CTRL_CHAR => 'Unexpected control character found',
            JSON_ERROR_SYNTAX => 'Syntax error, malformed JSON',
            JSON_ERROR_UTF8 => 'Malformed UTF-8 characters' //PHP >= 5.3.3
        );
        throw new DomainException(
            isset($messages[$errno])
                ? $messages[$errno]
                : 'Unknown JSON error: ' . $errno
        );
    }

    /**
     * Get the number of bytes in cryptographic strings.
     *
     * @param string
     *
     * @return int
     */
    private static function safeStrlen($str)
    {
        if (function_exists('mb_strlen')) {
            return mb_strlen($str, '8bit');
        }
        return strlen($str);
    }
}

class BaoKimAPI
{

    /* Bao Kim API key */
    const API_KEY = "iflZheFyqlHLUXOVPVL0z6LvujrNTk7d";
    const API_SECRET = "U8JzoxNxUUnVEAPC2issEbecoRBKUg4N";
    const TOKEN_EXPIRE = 86400; //token expire time in seconds
    const ENCODE_ALG = 'HS256';
    private static $_jwt = null;

    public static function refreshToken()
    {
        $tokenId    = base64_encode(random_bytes(32));
        $issuedAt   = time();
        $notBefore  = $issuedAt;
        $expire     = $notBefore + self::TOKEN_EXPIRE;

        $data = [
            'iat'  => $issuedAt,         // Issued at: time when the token was generated
            'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
            'iss'  => self::API_KEY,     // Issuer
            'nbf'  => $notBefore,        // Not before
            'exp'  => $expire,           // Expire
        ];
        self::$_jwt = JWT::encode(
            $data,      //Data to be encoded in the JWT
            self::API_SECRET, // The signing key
            'HS256'     // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
        );
        return self::$_jwt;
    }

    /**
     * Get JWT
     */
    public static function getToken()
    {
        if (!self::$_jwt)
            self::refreshToken();
        try {
            JWT::decode(self::$_jwt, self::API_SECRET, array('HS256'));
        } catch (Exception $e) {
            self::refreshToken();
        }
        return self::$_jwt;
    }
}

class Thanhtoanlephi24Controller extends Controller
{
    // protected $apiKey = 'a18ff78e7a9e44f38de372e093d87ca1';
    // protected $apiSecret = '9623ac03057e433f95d86cf4f3bef5cc';
    protected $apiKey = 'iflZheFyqlHLUXOVPVL0z6LvujrNTk7d';
    protected $apiSecret = 'U8JzoxNxUUnVEAPC2issEbecoRBKUg4N';

    function checkdangky()
    {
        $id_taikhoan = Auth::guard('loginbygoogles')->id();
        $dangky = DB::table('24_khoadangky')
            ->where('id_taikhoan', $id_taikhoan)
            ->get();
        if(count($dangky) == 1){
            $dangky[0]->trangthai == 1 ||  $dangky[0]->trangthai == 3 ?  $trangthai = 1 :  $trangthai =  2; // 1 --> Khóa, 2 --> Cập nhật
        } else {
            $trangthai = 0;
        }
        return $trangthai;
    }


    function tinhtien()
    {
        $id_taikhoan = Auth::guard('loginbygoogles')->id();
        $checkdangky = $this->checkdangky();
        //Tính tiền
        $songuyenvong = DB::table('24_nguyenvong')
            ->where('id_taikhoan', $id_taikhoan)
            ->where('iddot', $this->kiemtradot())
            ->count();
        $tongtien = DB::table('24_ketquathanhtoan')
            ->where('id_taikhoan', $id_taikhoan)
            ->sum('total_amount');

        $total_amount =  $songuyenvong * 20000 - $tongtien; //Số tiền phải đóng
        //Xác định trạng thái thanh toán
        if ($checkdangky == 1) {
            $total_amount > 0 ? $trangthai = 1 : $trangthai = 2; //2 Đã thanh toán;  1 là được thanh toán
        }else{
            $trangthai = 0;
        }
        $res = array(
            'sotien' => $total_amount,
            'trangthai' => $trangthai,
            'tongtien' => $songuyenvong * 20000,
            'dathanhtoan' => $tongtien,
        );
        return $res;
    }
    public function thanhtoanlephi()
    {
        $id_taikhoan = Auth::guard('loginbygoogles')->id();
        $img_slider = DB::select("SELECT 24_image_chuan.id, 24_image_chuan.funtion_id,24_image_chuan.ghichu,24_image_chuan.loaianh,if(image.path_img is null,'/img/test.png',image.path_img) as path_img,if(image.id is null,0,image.id) as test  FROM `24_image_chuan` LEFT JOIN (SELECT * FROM 24_image WHERE id_taikhoan = " . $id_taikhoan . " AND loaianh > 1) AS image ON 24_image_chuan.id = image.id_image_chuan ORDER BY thutu ASC");
        $nguyenvong = DB::table('24_nguyenvong')
            ->join('24_chuyennganh', '24_nguyenvong.id_chuyennganh', '24_chuyennganh.id')
            ->leftJoin('l_major', '24_chuyennganh.id_nganh', 'l_major.id')
            ->join('l_group', 'l_group.id', '24_nguyenvong.tohop')
            ->where('id_taikhoan', $id_taikhoan)
            ->orderBy('thutu', 'asc')
            ->get();
        $sql_dienthoai = DB::table('24_thongtincanhan')->where('id_taikhoan',$id_taikhoan)->get();

        $dienthoai = $sql_dienthoai == null ? 0 : $sql_dienthoai[0]->dienthoai;

        // getRequirement::setKey($this->apiKey, $this->apiSecret);
        // $data = [];
        // $webhook = new Connect();

        // $json_data['data'] =  $webhook->getBpmList($data)['data'][0];
        // $data = json_encode($json_data);

        // $data =$webhook->getBpmList($data)['data'];
        $kt = DB::select('SELECT IF(create_at>SUBTIME(CURRENT_TIMESTAMP(),"00:30:0.000000"),24_dataresponse.Qr,"/img/test.png") as kiemtra_img,create_at>SUBTIME(CURRENT_TIMESTAMP(),"00:30:0.000000") as kiemtra_tg, thanhtoan FROM `24_dataresponse` WHERE id_taikhoan=' . $id_taikhoan . ' ORDER BY create_at DESC LIMIT 0,1 ');
        if ($kt) {
            $tontai = $kt[0]->kiemtra_tg;
            $img_qr = $kt[0]->kiemtra_img;
        } else {
            $tontai = 0;
            $img_qr = "/img/test.png";
        }

        if (count($kt) > 0) {
            $thanhtoan = $kt[0]->thanhtoan;
        } else {
            $thanhtoan = 0;
        }

        $sotien = $this->tinhtien()['sotien'];
        if (count($img_slider) > 0 && count($nguyenvong) > 0) {
            return view(
                'user_24.thanhtoanlephi',
                [
                    'img_slider_right' =>  $img_slider,
                    'nguyenvong' => $nguyenvong,
                    'img_slider' => $img_slider,
                    'tongtien' => $this->tinhtien()['tongtien'],
                    'dathanhtoan' => $this->tinhtien()['dathanhtoan'],
                    // 'bank' =>   $data,
                    'tontai' => $tontai,
                    'qr' => $img_qr,
                    'sotienthanhtoan' => $sotien,
                    'thanhtoan' => $thanhtoan,
                    'dienthoai' => $dienthoai
                ]
            );
        } else {
            return view(
                'user_24.thanhtoanlephi',
                [
                    'img_slider_right' =>  $img_slider,
                    'nguyenvong' => "",
                    'img_slider' => $img_slider,
                    'tongtien' => $this->tinhtien()['tongtien'],
                    'dathanhtoan' => $this->tinhtien()['dathanhtoan'],
                    // 'bank' =>  $data,
                    'tontai' => $tontai,
                    'qr' => $img_qr,
                    'sotienthanhtoan' => $sotien,
                    'thanhtoan' => $thanhtoan,
                    'dienthoai' => $dienthoai
                ]
            );
        }
    }

    function load_tg()
    {
        $id_taikhoan = Auth::guard('loginbygoogles')->id();
        $tg = DB::table('24_dataresponse')->where('id_taikhoan', $id_taikhoan)->orderBy('create_at', 'DESC')->first();
        if ($tg) {
            return $tg->create_at;
        } else {
            return 0;
        }
    }

    // function load_bank()
    // {
    //     getRequirement::setKey($this->apiKey, $this->apiSecret);
    //     $data = [];
    //     $webhook = new Connect();
    //     return $webhook->getBpmList($data);
    // }

    function kiemtra($order_id)
    {
        $qr_check = DB::table('24_dataresponse')
            ->where('order_id', $order_id)->first();
        if ($qr_check) {
            $kiemtra = 1;
        } else {
            $kiemtra = 0;
        }
        return $kiemtra;
    }

    function kiemtradot()
    {
        $dot = DB::table('24_dottuyensinh')
            ->where('trangthai', 1)
            ->first();
        if ($dot) {
            return $dot->id;
        } else {
            return -1;
        }
    }

    function layqrcode(Request $r)
    {
        $client = new \GuzzleHttp\Client(['timeout' => 20.0]);
        $id_taikhoan = Auth::guard('loginbygoogles')->id();
        $taikhoan = DB::table('24_thongtincanhan')
            ->where('id_taikhoan', $id_taikhoan)
            ->first();
        $dangky = DB::table('account24s')
            ->where('id', $id_taikhoan)
            ->first();
        $sotien = $this->tinhtien()['sotien'];
        $trangthai = $this->tinhtien()['trangthai'];
        if($trangthai == 1){
            $mrc_order_id = 'ABCD_' . time();
            $options['query']['jwt'] = BaoKimAPI::getToken();
            $options['form_params'] = [
                'mrc_order_id' => $mrc_order_id,
                'total_amount' => $sotien,
                'description' => 'dbt test',
                'url_success' => 'https://congmotcua.ctuet.edu.vn/thanhtoanlephi',
                // 'url_success' => 'https://congmotcua.ctuet.edu.vn/api/ketquathanhtoan',

                'bpm_id' => '295',
                // 'merchant_id' => '40002',
                'merchant_id' => '36324',
                'customer_email' => $dangky->email,
                'customer_phone' => $taikhoan->dienthoai,
                'customer_name' => $taikhoan->hoten,
                'customer_address' => $taikhoan->diachi,
                // 'webhooks' => 'https://xettuyentest.ctuet.edu.vn/api/ketquathanhtoan',
                'webhooks' => 'https://congmotcua.ctuet.edu.vn/api/ketquathanhtoan',
            ];
            $db = DB::table('24_donguithanhtoan')
            ->insert([
                'id_taikhoan' => $id_taikhoan,
                'mrc_order_id' => $mrc_order_id,
                'total_amount' => $sotien,
                'description' => 'dbt test',
                'url_success' => 'https://congmotcua.ctuet.edu.vn/thanhtoanlephi',
                // 'url_success' => 'https://congmotcua.ctuet.edu.vn/api/ketquathanhtoan',
                'bpm_id' => '295',
                // 'merchant_id' => '40002',
                'merchant_id' => '36324',
                'customer_email' => $dangky->email,
                'customer_phone' => $taikhoan->dienthoai,
                'customer_name' => $taikhoan->hoten,
                'customer_address' => $taikhoan->diachi,
                // 'webhooks' => 'https://xettuyentest.ctuet.edu.vn/api/ketquathanhtoan',
                'webhooks' => 'https://congmotcua.ctuet.edu.vn/api/ketquathanhtoan',
            ]);
            if ($db == 1) {
                $response = $client->request("POST", "https://api.baokim.vn/payment/api/v5/order/send", $options);
                $dataResponse = json_decode($response->getBody()->getContents());
                // $tmp = "";
                // foreach ($dataResponse->message as $val) {
                //     $tmp .= $val;
                // }
                DB::table('24_dataresponse')
                ->insert([
                    'idnam' =>  1,
                    'id_taikhoan' => $id_taikhoan,
                    'code' => $dataResponse->code,
                    'count' => $dataResponse->count,
                    'AccName' => $dataResponse->data->bank_account->AccName,
                    'AccNo' => $dataResponse->data->bank_account->AccNo,
                    'BankBranch' => $dataResponse->data->bank_account->BankBranch,
                    'BankName' => $dataResponse->data->bank_account->BankName,
                    'BankShortName' => $dataResponse->data->bank_account->BankShortName,
                    'Qr' => $dataResponse->data->bank_account->Qr,
                    'redirect_url' => $dataResponse->data->bank_account->redirect_url,
                    'data_qr' => $dataResponse->data->data_qr,
                    'momo_url' => $dataResponse->data->momo_url,
                    'order_id' => $dataResponse->data->order_id,
                    'payment_amount' => $dataResponse->data->payment_amount,
                    'payment_txn_id' => $dataResponse->data->payment_txn_id,
                    'payment_url' => $dataResponse->data->payment_url,
                    'message' => "test",
                ]);
                $kiemtra = $this->kiemtra($dataResponse->data->order_id);
                // $kiemtra = 1;
            } else {
                $dataResponse = 0;
                $kiemtra = 0;
            }
            $arr = array(
                'dataResponse' => $dataResponse,
                'luuqr' => $kiemtra
            );
            return $arr;
        }else{
            if($trangthai == 2){
                return 'dathanhtoan';
            }else{
                if($trangthai == 0){
                    return 'dangky_chua';
                }else{
                    return -100;
                }
            }
        }
    }
}
