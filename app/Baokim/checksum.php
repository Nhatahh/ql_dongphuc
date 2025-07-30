<?php
$webhookData = [
    'created_at' => '2023-04-19 08:42:00',
    'id' => '119339',
    'mrc_order_id' => 'BAOKIM_62085725',
    'stat' => 'c',
    'total_amount' => '3742500.00',
    'txn_id' => '109047',
    'updated_at' => '2023-04-19 08:42:58',
];

ksort($webhookData);
$baokimSign = 'd129c273630a32e749ea31ab2350463f55da464711f45ff42c5811401f8568a1';
//API key/sec: a18ff78e7a9e44f38de372e093d87ca1 / 9623ac03057e433f95d86cf4f3bef5cc
$secret = '9623ac03057e433f95d86cf4f3bef5cc';
$mySign = hash_hmac('sha256', http_build_query($webhookData, '', '&'), $secret);

if ($baokimSign == $mySign) {
    echo 'chữ ký đúng';
} else {
    echo 'sai chữ ký';
}
?>