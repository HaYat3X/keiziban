<?php

session_start();
// ログインしている場合
if (isset($_SESSION['hayate'])) {
} else {
    // ログインしていない場合index.phpを経由して、ログインページへ戻す
    header('Location: ../Admin-index/index.php');
    exit();
}

?>











<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>総合ページ</title>
</head>

<body>
    <h1>管理者ログインページ</h1>
    <p><a href="../Admin-index/member.php">会員情報管理</a></p>
    <p><a href="../Admin-index/service.php">掲示板投稿情報管理</a></p>
    <p><a href="#">お問い合わせ管理</a></p>
    <p></p>
</body>

</html>