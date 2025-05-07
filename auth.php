<?php
include "bootstrap/init.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $method = $_GET['action'];
    $params = $_POST;
    if ($method == 'register') {
        //validation 
        if (empty($params['name']) || empty($params['email']) || empty($params['phone'])) {
            setErrorAndRedirect('All inputs fields are required', 'auth.php?action=register');
        }
        if (!filter_var($params['email'], FILTER_VALIDATE_EMAIL)) {
            setErrorAndRedirect('Invalid email format', 'auth.php?action=register');
        }
        if (isUserExists($params['email'], $params['phone'])) {
            setErrorAndRedirect('User already exists', 'auth.php?action=register');
        }
        # requested data OK 
        if (createUser($params)) {
            $_SESSION['phone'] = $params['phone'];
            redirect('auth.php?action=verify');
        }
    }
    if ($method == 'login') {
        # validation data
        /*  if (empty($params['email']))
            setErrorAndRedirect('email is required!', 'auth.php?action=login');
        if (!isUserExists(email: $params['email']))
            setErrorAndRedirect('User Not Exists with this email: <br>' . $params['email'], 'auth.php?action=login');

        $_SESSION['email'] = $params['email'];
        redirect('auth.php?action=verify'); */
        if (empty($params['phone']))
            setErrorAndRedirect('phone is required!', 'auth.php?action=login');
        if (!isUserExists(phone: $params['phone']))
            setErrorAndRedirect('User Not Exists with this phone: <br>' . $params['phone'], 'auth.php?action=login');
        $_SESSION['phone'] = $params['phone'];
        redirect('auth.php?action=verify');
    }

    if ($method == 'verify') {
        $token = findTokenByHash($_SESSION['hash'])->token;
        if ($token == $params['token']) {
            $session = bin2hex(random_bytes(32));
            changeLoginSession($_SESSION['phone'], $session);
            setcookie('auth', $session, time() + 1728000, '/');
            deleteToenByHash($_SESSION['hash']);
            unset($_SESSION['hash'], $_SESSION['phone']);
            redirect();
        } else {
            setErrorAndRedirect('The entered token is wrong ', 'auth.php?action=verify');
        }
    }
}

$action = $_GET['action'] ?? 'login';

/* if (isset($_GET['action'])) {
    if ($_GET['action'] == 'register') {
        include "tpl/login-register-tpl.php";
    } else if ($_GET['action'] == 'verify') {
        if (!isset($_SESSION['email'])) {
            redirect('auth.php?action=verify');
        }
        include "tpl/verify-tpl.php";
    } else {
        redirect('auth.php?action=verify');
    }
} else {
    include "tpl/login-register-tpl.php";
} */

if (isset($_GET['action']) && $_GET['action'] == 'verify' && !empty($_SESSION['phone'])) {
    if (!isUserExists(phone: $_SESSION['phone'])) {
        setErrorAndRedirect('User not exists ', 'auth.php?action=login');
    }
    if (isset($_SESSION['hash']) && isAliveToken($_SESSION['hash'])) {
        #send old token 
        sendTokenBySms($_SESSION['phone'], findTokenByHash($_SESSION['hash'])->token);
    } else {
        $tokenResult = createLoginToken();
        sendTokenBySms($_SESSION['phone'], $tokenResult['token']);
        $_SESSION['hash'] = $tokenResult['hash'];
    }
    include "tpl/verify-tpl.php";
} else {
    include "tpl/login-register-tpl.php";
}
