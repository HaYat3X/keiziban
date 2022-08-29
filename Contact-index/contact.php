<?php

// セッションスタート
session_start();

// エラー回避のため配列を初期化
$form = [
    'nickname' => '',
    'email' => '',
    'message' => '',
    'form' => '',
];

$error = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // inputタグの情報を変数に格納
    $form['nickname'] = filter_input(INPUT_POST, 'nickname', FILTER_SANITIZE_STRING);
    $form['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $form['message'] = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    if (empty($error)) {
        $_SESSION['form'] = $form;

        header('Location: contactcheck.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- cssのインポート -->
    <link rel="stylesheet" href="../Css/contact.css">

    <!-- タイトルの指定 -->
    <title>お問い合わせ / Real intentioN</title>

    <!-- ファビコンのインポート -->
    <link rel="icon" href="../img/favicon.png">

    <!-- font-awesomeのインポート -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
</head>

<body>
    <div class="header">
        <div class="header-nav">
            <img src="../img/favicon.png" alt="" width="80" height="80">

            <a href="../Home-index/home.php">
                <h1>Real intentioN</h1>
            </a>
        </div>

        <ul>
            <li>
                <a href="../Topic-index/topic.php"><i class="fa-solid fa-star"></i><span>topic</span></a>
            </li>

            <li>
                <a href="../Home-index/myprofile.php?id=<?php echo htmlspecialchars($id); ?>"><i class=" fa fa-user"></i><span>Profile</span></a>
            </li>

            <li>
                <a href="../Service-index/home.php"><i class="fa fa-briefcase"></i><span>Intern</span></a>
            </li>

            <li>
                <a href="../Contact-index/contact.php"><i class="fa-solid fa-file-signature"></i><span>Contact</span></a>
            </li>
        </ul>
    </div>

    <div class="container">
        <div class="main-contents">
            <form action="" method="post">
                <div class="user-box">
                    <label>お名前</label>
                    <br>
                    <input type="text" name="nickname" maxlength="200" placeholder="　山田　太郎" value="<?php echo htmlspecialchars($form['nickname']); ?>" required>
                </div>

                <div class="user-box">
                    <label>メールアドレス</label>
                    <br>
                    <input type="email" name="email" placeholder="　info@co.jp" value="<?php echo htmlspecialchars($form['email']); ?>" required>
                </div>

                <div class="user-box">
                    <label>お問い合わせ内容</label>
                    <br>
                    <textarea name="message" required></textarea>
                </div>

                <button type="submit">確認</button>
            </form>
        </div>

        <div class=" side-contents">
            <div class="calendar">
                <iframe src="https://calendar.google.com/calendar/embed?src=ja.japanese%23holiday%40group.v.calendar.google.com&ctz=Asia%2FTokyo" style="border: 0" frameborder="0" scrolling="no"></iframe>
            </div>

            <div class="site-content">
                <div class="site">
                    <a href="https://job.career-tasu.jp/2024/top/"><img src="../img/link1.png" alt=""></a>
                    <a href="https://job.mynavi.jp/24/pc/toppage/displayTopPage/index"><img src="../img/ogp.jpeg" alt=""></a>
                </div>

                <div class="site">
                    <a href="https://job.rikunabi.com/2024/?isc=r21rcnz02954"><img src="../img/link2.png" alt=""></a>
                    <a href="https://www.wantedly.com/"><img src="../img/2328bac9-3f7c-4510-a392-8b112f5e22ad.jpeg" alt=""></a>
                </div>
            </div>
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