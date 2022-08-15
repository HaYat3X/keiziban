<?php

// セッションスタート
session_start();

// function呼び出し
require('../function.php');

// DB接続
$db = db_connection();

// データを受け取る
if (isset($_SESSION['id'])) {
    $id = $_SESSION['user_id'];
    $name = $_SESSION['user_name'];
} else {
    header('Location: ../Home-index/index.php');
    exit();
}

$ID = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$count = +2;
$stmt2 = $db->prepare("UPDATE keizi SET iine = iine + 1 where id=?");
$stmt2->bind_param('i', $ID);
$stmt2->execute();

header("Location: home.php");
