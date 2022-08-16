<?php

// sessionスタート
session_start();

// functionを呼び込む
require('../function.php');

// DB接続
$db = db_connection();

if (isset($_SESSION['id'])) {
    $id = $_SESSION['user_id'];
    $name = $_SESSION['name'];
} else {
    header('Location: ../Login/login.php');
    exit();
}

$post_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// 削除対策
$stmt = $db->prepare('DELETE FROM posts WHERE id=? AND member_id=? LIMIT 1');
$stmt->bind_param('ii', $post_id, $id);
$stmt->execute();

header('Location: ../Home-index/home.php');
exit();
