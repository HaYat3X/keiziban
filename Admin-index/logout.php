<?php
session_start();

unset($_SESSION['hayate']);


header('Location: ../Login-index/login.php');
exit();
