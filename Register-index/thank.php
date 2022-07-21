<?php


session_start();



// データを受け取る
if (isset($_SESSION['form'])) {

    $form = $_SESSION['form'];
    // 登録完了メールの押しらせ
    $email = $form['email'];
    $name = $form['nickname'];


    mb_language('Japanese');
    mb_internal_encoding('UTF-8');

    $to = $email;
    $subject = "Real intentioN 登録完了のお知らせ";
    $message = $name . "様 Real intentioN にご登録いただきありがとうございます。";
    $headers = "From: hayate.syukatu1@gmail.com";

    mb_send_mail($to, $subject, $message, $headers);
    header('Location: ../Login-index/login.php');
    exit();
} else {


    header('Location: welcome.php');
    exit();
}
