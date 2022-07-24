<?php
// sessionスタート
session_start();

// requireでfunctionを呼び込む
require('../db.php');

// ログインしている場合
if (isset($_SESSION['id'])) {
    $id = $_SESSION['user_id'];
    $name = $_SESSION['name'];
} else {
    // ログインしていない場合、ログインページへ戻す
    header('Location: ../Login/login.php');
    exit();
}

// functionの呼びだし
$db = dbconnection();


$Service_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// 削除対策
$stmt = $db->prepare('DELETE FROM keizi WHERE id=? AND member_id=? LIMIT 1');
$stmt->bind_param('ii', $Service_id, $id);
$stmt->execute();

header('Location: ../Service-index/home.php');
exit();
