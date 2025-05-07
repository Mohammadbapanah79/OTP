<?php
require 'vendor/autoload.php';

use Kavenegar\KavenegarApi;
use Kavenegar\Exceptions\ApiException;
use Kavenegar\Exceptions\HttpException;


$database_config = (object) [
    'host' => 'localhost',
    'user' => 'root',
    'password' => '',
    'dbname' => 'otp',
    'charset' => 'utf8mb4',
];
// Looking to send emails in production? Check out our Email API/SMTP product!

//SMS
$api = new KavenegarApi("7374526D4D6A6974413337706B51664F6C4A503173684E7334306A4975325174484C436369455969574B733D");
