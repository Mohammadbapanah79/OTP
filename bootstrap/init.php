<?php
session_start();
date_default_timezone_set('Asia/Tehran');
require 'constans.php';
require 'config.php';
// require BASE_PATH . 'vendor/autoload.php';
require BASE_PATH . 'libs/helpers.php';
require BASE_PATH . 'libs/auth-lib.php';
require 'mail.php';
// require BASE_PATH . 'vendor/autoload.php';

try {
    $pdo = new PDO("mysql:host={$database_config->host};dbname={$database_config->dbname};charset={$database_config->charset}", $database_config->user, $database_config->password);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}
