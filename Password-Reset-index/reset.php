<?php

// セッションスタート
session_start();

// セッションがセットされていない場合はログイン画面へ戻す
if (isset($_SESSION['id'])) {

    // ユーザーが入力したメールアドレスをセッションで受け取る
    $email_ID = $_SESSION['email'];
} else {

    //  セッションがない場合エラーページへ飛ばす
    header('Location: ../Password-Reset-index/index.php');
    exit();
}

// DB接続
$db = new mysqli('localhost', 'root', 'root', 'user_db');

// SQL発行
$stmt = $db->prepare('SELECT * FROM members WHERE email=?');

// セッションのメールアドレスを変数に代入
$email = $email_ID;
$stmt->bind_param('s', $email_ID);

// SQL実行
$stmt->execute();

// DBからの情報を変数にバインド
$stmt->bind_result($id, $name, $email, $birth, $tel, $password, $picture, $status, $course, $School_year, $comment, $uuid, $created, $modifild);
$result = $stmt->fetch();


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/reset.css">
    <title>パスワードをリセットする / Real intentioN</title>
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
                        <button>
                            変更
                        </button>
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