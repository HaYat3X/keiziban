<?php
session_start();

unset($_SESSION['id']);
unset($_SESSION['user_id']);
unset($_SESSION['user_name']);

header('Location: ../Login-index/login.php');
exit();
