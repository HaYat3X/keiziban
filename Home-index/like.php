<?php

session_start();
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
} else {
    // ログインしていない場合、ログインページへ戻す
    header('Location: ../Login/login.php');
    exit();
}
require('../db.php');


$db = new mysqli('localhost', 'root', 'root', 'user_db');
$ID = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$count = +2;

$stmt2 = $db->prepare("UPDATE posts SET iine = iine + 1 where id=?");
$stmt2->bind_param('i', $ID);
$stmt2->execute();


header("Location: home.php");
