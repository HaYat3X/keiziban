<?php

// functionの読み込み
require('../function.php');

// エラー回避のために配列を初期化
$error = [];
$email = '';
$tel = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ユーザーが入力した情報を変数に置き換え
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $tel = filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_STRING);

    // db接続
    $db = db_connection();
    $stmt = $db->prepare('SELECT tel FROM members WHERE email=? LIMIT 1');
    $stmt->bind_param('s', $email);
    $success = $stmt->execute();
    $stmt->bind_result($tel_result);
    $stmt->fetch();

    if ($tel === $tel_result) {

        // 認証が成功した場合セッションを発行
        session_start();
        $ses_id = session_id();
        $_SESSION['id'] = $ses_id;
        $_SESSION['email'] = $email;

        // パスワードリセットフォームへ飛ばす
        header('Location: ../Password-Reset-index/reset.php');
        exit();
    } else {

        // 認証失敗のバリデーション
        $error['login'] = 'failed';
    }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- タイトルの指定指定 -->
    <title>パスワードをリセットする / Real intentioN</title>

    <!-- ファビコンの読み込み -->
    <link rel="icon" href="../img/favicon.png">

    <!-- cssの読み込み -->
    <link rel="stylesheet" href="../Css/certification.css">

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
            <form action="" method="post">
                <div class="user-box">
                    <label>Email</label>
                    <br>
                    <input required type="email" name="email" size="35" maxlength="255" value="<?php echo htmlspecialchars($email); ?>">
                </div>

                <div class="user-box">
                    <label>Tel</label>
                    <br>
                    <input required pattern="\d{11}" type="tel" name="tel" size="35" maxlength="255" value="<?php echo htmlspecialchars($tel); ?>">

                    <!-- 認証失敗のバリデーション -->
                    <?php if (isset($error['login']) && $error['login'] === 'failed') : ?>
                        <p class="error">*認証に失敗しました。正しくご記入ください。</p>
                    <?php endif; ?>
                </div>

                <button>認証</button>
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