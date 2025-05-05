<?php

use PHPMailer\PHPMailer\SMTP;

function isUserExists(?string $email = null, ?string $phone = null)
{
    global $pdo;
    $sql = "SELECT * FROM users WHERE email = :email OR phone = :phone";
    $stmt = $pdo->prepare($sql);
    $record = $stmt->execute([':email' => $email ?? '', ':phone' => $phone ?? '']);
    $user = $stmt->fetch(PDO::FETCH_OBJ);
    return $user ? true : false;
}
function createUser(array $userData): bool
{
    global $pdo;
    $sql = "INSERT INTO users (name,email,phone) VALUES (:name, :email, :phone)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':name' => $userData['name'], ':email' => $userData['email'], ':phone' => $userData['phone']]);
    return $stmt->rowCount() ? true : false;
}

# token genrate

function createLoginToken(): array
{
    global $pdo;
    $hash = bin2hex(random_bytes(8));
    $token = rand(100000, 999999);
    $expired_at = time() + 600;
    $sql = "INSERT INTO tokens (token,hash, expired_at) VALUES (:token,:hash, :expired_at)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':token' => $token, ':hash' => $hash, ':expired_at' => date("Y-m-d H:i:s", $expired_at)]);
    return [
        'token' => $token,
        'hash' => $hash,
    ];
}

function isAliveToken(string $hash): bool
{
    $record = findTokenByHash($hash);
    if (!$record)
        return false;
    return strtotime($record->expired_at)  > time() + 120;
}



function findTokenByHash(string $hash): object|bool
{
    global $pdo;
    $sql = "SELECT * FROM tokens where hash = :hash";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':hash' => $hash]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}
# send token
function sendTokenByMail(string $email, string|int $token): bool
{
    global $mail;
    $mail->addAddress($email);
    $mail->Subject = 'Verify Token';
    $mail->Body = 'Your Token is : ' . $token;
    $result =  $mail->send();
    return $result;
}

function changeLoginSession(string $email, string $session = null): bool
{
    global $pdo;
    $sql = "UPDATE users SET session=:session WHERE email=:email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':session' => $session, ':email' => $email]);
    return $stmt->rowCount() ? true : false;
}

function deleteToenByHash(string $hash): bool
{
    global $pdo;
    $sql = "DELETE FROM tokens WHERE hash=:hash";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':hash' => $hash]);
    return $stmt->rowCount() ? true : false;
}


function getAuthenticateUserBySession(string $session): object|bool
{
    global $pdo;
    $sql = "SELECT * FROM users where session=:session";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':session' => $session]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}

function isLoggedIn(): bool
{
    if (empty($_COOKIE['auth']))
        return false;
    return getAuthenticateUserBySession($_COOKIE['auth']) ? true : false;
}

function deleteExpiredTokens(): int
{
    global $pdo;
    $sql = 'delete form tokens where expired_at < now()';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->rowCount();
}

function logout(string $email): void
{
    changeLoginSession($email);
    setcookie('auth', '', time() - 60, '/');
    redirect('auth.php?action=login');
}
