<?php

// セッションスタート
session_start();

// functionの読み込み
require('../function.php');

// DB接続
$db = db_connection();

// セッションがセットされていない場合はログイン画面へ戻す
if (isset($_SESSION['id'])) {
    $email_ID = $_SESSION['email'];
} else {
    header('Location: ../Password-Reset-index/index.php');
    exit();
}

// SQL発行
$stmt = $db->prepare('SELECT * FROM members WHERE email=?');
$email = $email_ID;
$stmt->bind_param('s', $email_ID);
$stmt->execute();
$stmt->bind_result($id, $name, $email, $birth, $tel, $password, $picture, $status, $course, $School_year, $comment, $uuid, $created, $modifild);
$result = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- cssのインポート -->
    <link rel="stylesheet" href="../Css/reset.css">

    <!-- タイトルの指定 -->
    <title>パスワードをリセットする / Real intentioN</title>

    <!-- ファビコンのインポート -->
    <link rel="icon" href="../img/favicon.png">

    <!-- font-awesomeのインポート -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
</head>

<body>
    <div class="header">
        <img src="../img/favicon.png" alt="">
        <h1>Real intentioN</h1>

        <ul>
            <li>
                <a href="../Contact-index/contact.php"><i class="fa-solid fa-file-signature"></i>contact</a>
            </li>
        </ul>
    </div>

    <div class="content">
        <div class="msg">
            <h1>
                Reset<br>
                Real intentioN
            </h1>
        </div>

        <div class="Reset">
            <form action="reset_do.php" method="post">
                <div class="user-box">
                    <label>Email</label>
                    <input type="text" value="<?php echo htmlspecialchars($email); ?>" readonly>
                </div>

                <div class="user-box">
                    <label>Password</label>
                    <?php if ($_SESSION['email'] === $email) : ?>
                        <br>
                        <input type="password" name="password" required minlength="6" placeholder="　パスワードを入力してください（6文字以上）">

                        <button>変更</button>
                    <?php endif; ?>
                </div>
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