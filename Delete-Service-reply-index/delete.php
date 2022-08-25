<?php
// sessionスタート
session_start();

// requireでfunctionを呼び込む
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
$reply_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// 削除対策
$stmt = $db->prepare('DELETE FROM keizi_reply WHERE id=? AND member_id=? LIMIT 1');
$stmt->bind_param('ii', $reply_id, $id);
$stmt->execute();

header('Location: ../Service-index/home.php');
exit();
