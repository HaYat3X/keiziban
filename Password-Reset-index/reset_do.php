<?php

// セッションスタート
session_start();

// functionの読み込み
require('../function.php');

// DB接続
$db = db_connection();

if (isset($_SESSION['id'])) {
    $email_ID = $_SESSION['email'];
} else {
    header('Location: ../Password-Reset-index/index.php');
    exit();
}

$email = $email_ID;
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

// パスワードの暗号化
$password_hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $db->prepare('UPDATE members SET password=? WHERE email=?');
$stmt->bind_param('si', $password_hash, $email);
$success = $stmt->execute();

header('Location: ../Login-index/login.php');
exit();
