<?php

// function読み込み
require('../function.php');

// DB接続
$db = db_connection();

// error回避のために配列を初期化
$error = [];
$email = '';
$password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // inputタグの情報を変数に格納
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // ユーザーが入力したEmail情報をもとにパスワードを取得
    $stmt = $db->prepare('SELECT id, name, password, uuid FROM members WHERE email=? LIMIT 1');
    $stmt->bind_param('s', $email);
    $success = $stmt->execute();

    // 取得したデータを変数に置き換える
    $stmt->bind_result($id, $name, $hash, $uuid);
    $stmt->fetch();

    // 暗号化されたパスワードとユーザーが入力したパスワードを比較
    if (password_verify($password, $hash)) {

        // 一致した場合はセッションを発酵する
        session_start();
        $ses_id = session_id() . $uuid;

        // グローバル変数に置き換えておく
        $_SESSION['id'] = $ses_id;
        $_SESSION['user_id'] = $id;
        $_SESSION['user_name'] = $name;

        header('Location: ../Home-index/home.php');
        exit();
    } else {

        // ログインできなかった時の処理
        $error['login'] = 'failed';
    }
}
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSSのインポート -->
    <link rel="stylesheet" href="../Css/login.css">

    <!-- タイトル　Log in　で指定 -->
    <title>Real intentioNにログイン / Real intentioN</title>

    <!-- ファビコンの読み込み -->
    <link rel="icon" href="../img/favicon.png">

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
                Login<br>
                Real intentioN
            </h1>

            <div class="guidance">
                <a href="../Register-index/welcome.php">会員登録はこちら&gt;&gt;</a>
            </div>

            <div class="guidance2">
                <a href="../Password-Reset-index/certification.php">パスワードを忘れた方はこちら&gt;&gt;</a>
            </div>
        </div>

        <div class="Login">
            <form action="" method="post">

                <div class="user-box">
                    <label>Email</label>
                    <br>
                    <input type="email" name="email" size="35" maxlength="255" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>

                <div class="user-box">
                    <label>Password</label>
                    <br>
                    <input type="password" name="password" size="35" maxlength="255" value="<?php echo htmlspecialchars($password); ?>" required>

                    <!-- エラーメッセージ -->
                    <?php if (isset($error['login']) && $error['login'] === 'failed') : ?>
                        <p class="error">*ログインに失敗しました。正しくご記入ください。</p>
                    <?php endif; ?>
                </div>

                <button>ログイン</button>
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