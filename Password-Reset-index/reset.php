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
    <!-- タイトルをパスワードリセットフォームに指定 -->
    <title>パスワードをリセットする / Real intentioN</title>
    <!-- ファビコンの読み込み -->
    <link rel="icon" href="../img/名称未設定-3.png">
    <link rel="stylesheet" href="../Css/reset.css">
</head>

<body>
    <div class="card">
        <div class="content">
            <h2>パスワードをリセットする</h2>

            <div class="user-box">
                <label>Email</label>
                <p><?php echo htmlspecialchars($email); ?></p>
            </div>

            <div class="user-box">
                <label>Password</label>
                <?php if ($_SESSION['email'] === $email) : ?>
                    <form action="reset_do.php" method="post">
                        <input type="password" name="password" required pattern="[A-Za-z0-9]{6}" placeholder="　パスワードを入力してください（6文字以上）">
                        <?php if (isset($error['password']) && $error['password'] === 'length') : ?>
                            <h5 class="error">*パスワードは6文字以上で入力してください!</h5>
                        <?php endif; ?>
                        <button>
                            変更
                        </button>
                    </form>
                <?php endif; ?>
            </div>



        </div>
    </div>
</body>

</html>