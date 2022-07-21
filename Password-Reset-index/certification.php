<?php

// エラー回避のために配列を初期化
$error = [];
$email = '';
$tel = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ユーザーが入力した情報を変数に置き換え
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $tel = filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_STRING);

    // 何も入力しないで認証しようとした場合のバリデーション
    if ($email === '') {
        $error['login'] = 'blank';
    }

    // 何も入力しないで認証しようとした場合のバリデーション
    if ($tel === '') {
        $error['login2'] = 'blank';
    } else {

        // db接続
        $db = new mysqli('localhost', 'root', 'root', 'user_db');

        // SQL発行
        $stmt = $db->prepare('SELECT tel FROM members WHERE email=? LIMIT 1');

        // ユーザーが入力したメールアドレスに存在するデーターを呼び出す
        $stmt->bind_param('s', $email);

        // SQL実行
        $success = $stmt->execute();

        // 呼び出した情報を変数に置き換え
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
}
?>
<a href="../Password-Reset-index/reset.php"></a>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- タイトルをパスワードリセットフォームで指定 -->
    <title>パスワードをリセットする / Real intentioN</title>
    <!-- ファビコンの読み込み -->
    <link rel="icon" href="../img/名称未設定-3.png">
    <link rel="stylesheet" href="../Css/certification.css">
</head>

<body>
    <div class="card">
        <div class="content">
            <h2>パスワードをリセットする</h2>
            <form action="" method="post">

                <!-- メールアドレスの認証欄 -->
                <div class="user-box">
                    <input placeholder="　メールアドレスを入力してください" required type="email" name="email" size="35" maxlength="255" value="<?php echo htmlspecialchars($email); ?>">


                </div>

                <!-- 携帯電話番号の確認欄 -->
                <div class="user-box">
                    <input required placeholder="　携帯電話番号を入力してください" pattern="\d{11}" type="tel" name="tel" size="35" maxlength="255" value="<?php echo htmlspecialchars($tel); ?>">



                    <!-- 認証失敗のバリデーション -->
                    <?php if (isset($error['login']) && $error['login'] === 'failed') : ?>
                        <p class="error">*認証に失敗しました。正しくご記入ください。</p>
                    <?php endif; ?>
                </div>

                <!-- 認証ボタンの装飾 -->
                <button>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    認証
                </button>
            </form>


        </div>
</body>

</html>