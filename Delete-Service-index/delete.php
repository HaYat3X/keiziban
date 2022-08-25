<?php

// sessionスタート
session_start();

// functionを読み込み
require('../function.php');

if (isset($_SESSION['id'])) {
    $id = $_SESSION['user_id'];
    $name = $_SESSION['name'];
} else {
    header('Location: ../Login-index/login.php');
    exit();
}

// DB接続
$db = db_connection();

$Service_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// 削除対策
$stmt = $db->prepare('DELETE FROM keizi WHERE id=? AND member_id=? LIMIT 1');
$stmt->bind_param('ii', $Service_id, $id);
$stmt->execute();

header('Location: ../Service-index/home.php');
exit();
