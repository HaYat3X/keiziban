<?php

// セッションスタート
session_start();

// function呼び出し
require('../function.php');

// データを受け取る
if (isset($_SESSION['form'])) {
    $form = $_SESSION['form'];
} else {
    header('Location: welcome.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // DB接続
    $db = db_connection();

    // インサート文でテーブルにデータを登録する
    $stmt = $db->prepare('INSERT INTO members (name, email, birth, tel, password, picture, status, course, School_year, comment, uuid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

    // 所属学科の初期値を指定する
    $Department = '未設定';

    // 所属コースの初期値を指定する
    $course = '未設定';

    // 学年の初期値を設定する
    $School_year = '未設定';

    // 自己紹介の初期値を設定する
    $comment = '自己紹介を記入してください';

    // セキュリティー対策のためのランダム文字列作成
    $str2 = substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz0123456789"), 0, 16);

    // パスワードの暗号化
    $password = password_hash($form['password'], PASSWORD_DEFAULT);
    $stmt->bind_param('sssssssssss', $form['nickname'], $form['email'], $form['birth'], $form['tel'], $password, $form['image'], $Department, $course, $School_year, $comment, $str2);
    $success = $stmt->execute();

    header('Location: thank.php');
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- cssのインポート -->
    <link rel="stylesheet" href="../Css/check.css">

    <!-- タイトルの指定 -->
    <title>登録内容を確認する / Real intentioN</title>

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
                Check<br>
                Real intentioN
            </h1>

            <a href="welcome.php?action=Tofix">書き直す&gt;&gt;</a>
        </div>

        <div class="Check">
            <form action="" method="post">
                <ul class="progressbar">
                    <li class="complete">ご入力</li>
                    <li class="active">ご確認</li>
                    <li>完了</li>
                </ul>

                <div class="user-box">
                    <p>
                        <?php echo htmlspecialchars($form['nickname']); ?>
                    </p>
                </div>

                <div class="user-box">
                    <p>
                        <?php echo htmlspecialchars($form['birth']); ?>
                    </p>
                </div>

                <div class="user-box">
                    <p>
                        <?php echo htmlspecialchars($form['email']); ?>
                    </p>
                </div>

                <div class="user-box">
                    <p>
                        <?php echo htmlspecialchars($form['tel']); ?>
                    </p>
                </div>

                <div class="user-box">
                    <p>
                        <?php echo htmlspecialchars($form['password']); ?>
                    </p>
                </div>

                <div class="user-box">
                    <p>
                        <!-- ユーザー指定の画像 -->
                        <?php if ($form['image']) : ?>
                            <img src="../member_picture/<?php echo htmlspecialchars($form['image']); ?>" height="80" width="80">
                        <?php endif; ?>

                        <!-- デフォルト画像 -->
                        <?php if (!$form['image']) : ?>
                            <img src="../img/default.png" height="80" width="80">
                        <?php endif; ?>
                    </p>
                </div>

                <button>登録する</button>
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