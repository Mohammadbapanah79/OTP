<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function assets(string $path): string
{
    return siteUrl('/assets/' . $path);
}
function siteUrl(string $uri = "")
{
    return BASE_URL . '' . $uri;
}
function redirect(string $target = BASE_URL): void
{
    header("Location: " . $target);
    exit;
}
function setErrorAndRedirect(string $message, string $target = BASE_URL): void
{
    $_SESSION['error'] = $message;
    redirect(siteUrl($target));
}
function sendTestEmail(PHPMailer $mail): bool
{
    try {
        $mail->addAddress('test@example.com'); // گیرنده تستی
        $mail->Subject = 'Test Subject';
        $mail->Body = 'This is a test email.';

        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->Debugoutput = 'html';

        $mail->send();
        echo "Email sent successfully!";
        return true;
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
        return false;
    }
}

function dd($var)
{
    echo "<pre style='direction: ltr; text-align: left;color: #9c4100; background: #fff; z-index: 999; position: relative; padding: 10px; margin: 10px; border-radius: 5px; border-left: 3px solid #c56705;'>";
    var_dump($var);
    echo "</pre>";
}
