<?php
// ここでやっていること
// DB用いたログイン認証

// function読み込み
require('../db.php');

// error回避のために配列を初期化
$error = [];
$email = '';
$password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ユーザの入力情報を変数に代入
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // 何も入力しないでログインしようとした場合のバリデーション
    if ($email === '') {
        $error['login'] = 'blank';
    }

    // 何も入力しないでログインしようとした場合のバリデーション
    if ($password === '') {
        $error['login2'] = 'blank';
    } else {

        // データベースとの接続
        $db = new mysqli('localhost', 'root', 'root', 'user_db');

        // SQL発行
        $stmt = $db->prepare('SELECT id, name, password, uuid FROM members WHERE email=? LIMIT 1');

        // ユーザーが入力したメールアドレスに存在するデーターを呼び出す
        $stmt->bind_param('s', $email);

        // SQL実行
        $success = $stmt->execute();

        // 取得したデータを変数に置き換える
        $stmt->bind_result($id, $name, $hash, $uuid);
        $stmt->fetch();

        // 暗号化されたパスワードとユーザーが入力したパスワードが一致しているか確認
        if (password_verify($password, $hash)) {

            // 一致した場合はセッションを発酵する
            session_start();
            $ses_id = session_id() . $uuid;

            // グローバル変数に置き換えておく
            $_SESSION['id'] = $ses_id;
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;



            // このデータを持ち、トップページへ移動する
            header('Location: ../Home-index/home.php');
            exit();
        } else {

            // ログインできなかった時のバリデーション
            $error['login'] = 'failed';
        }
    }
}
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/login.css">
    <!-- タイトル　Log in　で指定 -->
    <title>Real intentioNにログイン / Real intentioN</title>
    <!-- ファビコンの読み込み -->
    <link rel="icon" href="../img/favicon.png">
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

                <!-- メールアドレスのテェック -->
                <div class="user-box">
                    <label>Email</label>
                    <br>
                    <input type="email" name="email" size="35" maxlength="255" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>

                <!-- パスワードのテェック -->
                <div class="user-box">
                    <label>Password</label>
                    <br>
                    <input type="password" name="password" size="35" maxlength="255" value="<?php echo htmlspecialchars($password); ?>" required>



                    <!-- ログイン不成立のバリデーション -->
                    <?php if (isset($error['login']) && $error['login'] === 'failed') : ?>
                        <p class="error">*ログインに失敗しました。正しくご記入ください。</p>
                    <?php endif; ?>
                </div>

                <!-- ログインボタンの装飾 -->
                <button>
                    ログイン
                </button>

            </form>
        </div>
    </div>



    <!-- <div>
        <h2>ログイン</h2>
        <form action="" method="post"> -->

    <!-- メールアドレスのテェック -->
    <!-- <div class="user-box">
                <label>Email</label>
                <input type="email" name="email" size="35" maxlength="255" value="<?php echo htmlspecialchars($email); ?>" required>


            </div> -->

    <!-- パスワードのテェック -->
    <!-- <div class="user-box">
                <label>Password</label>
                <input type="password" name="password" size="35" maxlength="255" value="<?php echo htmlspecialchars($password); ?>" required> -->



    <!-- ログイン不成立のバリデーション -->
    <!-- <?php if (isset($error['login']) && $error['login'] === 'failed') : ?>
                    <p class="error">*ログインに失敗しました。正しくご記入ください。</p>
                <?php endif; ?>
            </div> -->

    <!-- ログインボタンの装飾 -->
    <!-- <button>

                ログイン
            </button>

        </form>

        <div class="guidance">
            <a href="../Register-index/welcome.php">会員登録はこちら&gt;&gt;</a>
        </div>

        <div class="guidance2">
            <a href="../Password-Reset-index/certification.php">パスワードを忘れた方はこちら&gt;&gt;</a>
        </div>
    </div> -->

    <div class="footer">
        <div class="SNS">
            <a href="https://github.com/Hayate12345"><i class="fa-brands fa-github"></i>Hayate12345</a>
            <a href="https://twitter.com/hayate_KIC"><i class="fa-brands fa-twitter"></i>hayate_KIC</a>
        </div>

        <p>2022-08/01 Hayate-studio</p>
    </div>
</body>

</html>