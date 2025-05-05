<?php
require_once __DIR__ . '/../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'sandbox.smtp.mailtrap.io';
$mail->SMTPAuth = true;
$mail->Port = 2525;
// $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Username = '24945bb725ffb6';
$mail->Password = 'b6a9bb614f76f3';
$mail->setFrom('mhmmad8745@gmail.com', 'Mailer');
$mail->isHTML(true);
