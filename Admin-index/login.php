<?php

// function読み込み
require('../function.php');

// error回避のために配列を初期化
$error = [];
$email = '';
$password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ユーザの入力情報を変数に代入
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // データベースとの接続
    $db = db_connection();
    $stmt = $db->prepare('SELECT id, name, password FROM Admin WHERE email=? LIMIT 1');
    $stmt->bind_param('s', $email);
    $success = $stmt->execute();

    // 取得したデータを変数に置き換える
    $stmt->bind_result($id, $name, $hash);
    $stmt->fetch();

    // 暗号化されたパスワードとユーザーが入力したパスワードが一致しているか確認
    if ($password === $hash) {

        // 一致した場合はセッションを発行する
        session_start();
        $ses_id = session_id();
        $_SESSION['hayate'] = $ses_id;

        header('Location: ../Admin-index/home.php');
        exit();
    } else {

        // ログインできなかった時のバリデーション
        $error['login'] = 'failed';
    }
}
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- cssのインポート -->
    <link rel="stylesheet" href="../Css/hayate1.css">

    <!-- タイトルの指定 -->
    <title>管理者専用ページ / Real intentioN</title>

    <!-- ファビコンの読み込み -->
    <link rel="icon" href="../img/favicon.png">
</head>

<body>
    <div class="card">
        <div class="content">
            <h2>管理者ログイン</h2>
            <form action="" method="post">
                <div class="user-box">
                    <label>Email</label>
                    <br>
                    <input type="email" name="email" size="35" id="email" maxlength="255" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>

                <div class="user-box">
                    <label>Password</label>
                    <br>
                    <input type="password" name="password" size="35" id="password" maxlength="255" value="<?php echo htmlspecialchars($password); ?>" required>

                    <!-- ログイン不成立のバリデーション -->
                    <?php if (isset($error['login']) && $error['login'] === 'failed') : ?>
                        <p class="error">*ログインに失敗しました。正しくご記入ください。</p>
                    <?php endif; ?>
                </div>

                <button id="login_btn">ログイン</button>
            </form>
        </div>
    </div>
</body>

</html>