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
} else {
    header('Location: welcome.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Css/thank.css">
    <script src="./countdown.js"></script>
    <title>アカウント作成 / Real intentioN</title>
    <link rel="icon" href="../img/名称未設定-3.png">
    <!-- font-awesomeのインポート -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
</head>

<body>
    <div class="header">
        <img src="../img/favicon.png" alt="">
        <h1>Real intentioN</h1>
    </div>


    <div class="content">
        <div class="msg">
            <h1>
                Success<br>
                Real intentioN
            </h1>


        </div>

        <div class="Check">
            <form>
                <ul class="progressbar">
                    <li class="complete">ご入力</li>
                    <li class="complete">ご確認</li>
                    <li class="active">完了</li>
                </ul>
                <br>
                <br>
                <p>ご登録ありがとうございます。</p>
                <p>
                    ご登録完了メールが送信されますので、<br>
                    ご確認ください。
                </p>

                <div class="countdown" id="countdown"></div>
            </form>
        </div>
    </div>

    <div class="footer">
        <div class="SNS">
            <a href="https://github.com/Hayate12345"><i class="fa-brands fa-github"></i>Hayate12345</a>
            <a href="https://twitter.com/hayate_KIC"><i class="fa-brands fa-twitter"></i>hayate_KIC</a>
        </div>

        <p>2022-08/01 Hayate-studio</p>
    </div>

</body>

</html>

<?php
// 10s redirect
header('refresh:10;url=../Login-index/login.php');
exit();
?>