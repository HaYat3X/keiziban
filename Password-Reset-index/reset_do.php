<?php

// セッションスタート
session_start();

// セッション情報を受け取る
if (isset($_SESSION['id'])) {

    // メールアドレスの取得
    $email_ID = $_SESSION['email'];
} else {

    // セッション情報がない場合エラーページへ飛ばす
    header('Location: ../Password-Reset-index/index.php');
    exit();
}

// db接続
$db = new mysqli('localhost', 'root', 'root', 'user_db');

// ユーザーのメールアドレス情報
$email = $email_ID;

// ユーザーが入力したパスワードを取得
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

// ユーザーが入力したパスワードの暗号化
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// SQL発行
$stmt = $db->prepare('update members set password=? where email=?');

// パウワードをDBに保存
$stmt->bind_param('si', $password_hash, $email);

// SQL実行
$success = $stmt->execute();

header('Location: ../Login-index/login.php');
