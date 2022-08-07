<?php
// セッションスタート
session_start();

if (isset($_SESSION['id'])) {
    $id = $_SESSION['user_id'];
    $name = $_SESSION['user_name'];
} else {
    // ログインしていない場合index.phpを経由して、ログインページへ戻す
    header('Location: ../Home-index/index.php');
    exit();
}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/success.css">
    <script src="./countdown.js"></script>
    <title>送信完了</title>
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
            <li><a href="../Topic-index/topic.php"><i class="fa-solid fa-star"></i><span>topic</span></a></li>
            <li><a href="../Home-index/myprofile.php?id=<?php echo htmlspecialchars($id); ?>"><i class=" fa fa-user"></i><span>Profile</span></a></li>
            <li><a href="../Service-index/home.php"><i class="fa fa-briefcase"></i><span>Intern</span></a></li>
            <li><a href="../Contact-index/contact.php"><i class="fa-solid fa-file-signature"></i><span>Contact</span></a></li>

        </ul>
    </div>

    <div class="container">
        <div class="main-contents">
            <form action="">
                <div class="user-box">
                    <label>お問い合わせが完了しました。</label>
                </div>

                <div class="user-box">
                    <label>お問い合わせ内容を確認し、返信いたします。</label>
                </div>
                <br>
                <br>
                <div class="countdown" id="countdown"></div>
            </form>
        </div>


        <div class="side-contents">














            <!-- カレンダーの表示 -->
            <div class="calendar">
                <iframe src="https://calendar.google.com/calendar/embed?src=ja.japanese%23holiday%40group.v.calendar.google.com&ctz=Asia%2FTokyo" style="border: 0" frameborder="0" scrolling="no"></iframe>
            </div>


            <div class="site-content">
                <div class="site">
                    <a href="https://job.career-tasu.jp/2024/top/"><img src="../img/ダウンロード.png" alt=""></a>
                    <a href="https://job.mynavi.jp/24/pc/toppage/displayTopPage/index"><img src="../img/ogp.jpeg" alt=""></a>
                </div>

                <div class="site">
                    <a href="https://job.rikunabi.com/2024/?isc=r21rcnz02954"><img src="../img/ダウンロードのコピー.png" alt=""></a>
                    <a href="https://www.wantedly.com/"><img src="../img/2328bac9-3f7c-4510-a392-8b112f5e22ad.jpeg" alt=""></a>
                </div>
            </div>

            <div class="btn_arrow">
                <a href="../Logout-index/logout2.php">ログアウト</a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="content">
            <!-- お問い合わせ完了のお知らせ -->
            <h2>success</h2>
            <p class="thank">
                お問い合わせありがとうございました。
            </p>
            <p class="thank">
                お問い合わせ内容を確認して対応いたします。
            </p>
            <p><button><a href="../home.php">ホームへ戻る</a></button></p>
        </div>
    </div>
    </div>
</body>

</html>

<?php
// 10s redirect
header('refresh:10;url=../Home-index/home.php');
exit();
?>