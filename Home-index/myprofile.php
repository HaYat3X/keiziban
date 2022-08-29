<?php

// セッションスタート 
session_start();

// functionの読み込み
require('../function.php');

// DB接続
$db = db_connection();

if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
} else {
    header('Location: ../Login-index/login.php');
    exit();
}

$stmt = $db->prepare('SELECT * FROM members WHERE id=?');
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->bind_result($my_id, $name, $email, $birth, $tel, $password, $picture, $status, $course, $School_year, $comment, $uuid, $created, $modifild);
$result = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- cssのインポート -->
    <link rel="stylesheet" href="../Css/myprofile.css">

    <!-- font-awesomeのインポート -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

    <!-- タイトルの指定 -->
    <title>プロフィールを確認する / Real intentioN</title>

    <!-- ファビコンのインポート -->
    <link rel="icon" href="../img/favicon.png">
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
            <div class="profile">
                <div class="img">
                    <?php if ($picture) : ?>
                        <img src="../member_picture/<?php echo htmlspecialchars($picture); ?>" alt="">
                    <?php endif; ?>

                    <?php if (!$picture) : ?>
                        <img src="../img/default.png" alt="">
                    <?php endif; ?>
                </div>

                <div class="user_box">
                    <label>ニックネーム</label>
                    <p><?php echo $name; ?></p>
                </div>

                <div class="user_box">
                    <label>生年月日</label>
                    <p><?php echo $birth; ?></p>
                </div>

                <div class="user_box">
                    <label>所属学科</label>
                    <p><?php echo $status; ?></p>
                </div>

                <div class="user_box">
                    <label>所属コース</label>
                    <p><?php echo $course; ?></p>
                </div>

                <div class="user_box">
                    <div class="user_box">
                        <label>学年</label>
                        <p><?php echo $School_year; ?></p>
                    </div>

                    <div class="user_box">
                        <label>自己紹介</label>
                        <p><?php echo $comment; ?></p>
                    </div>

                    <div class="user_box-last">
                        <label>サービス登録時間</label>
                        <p><?php echo $created ?></p>
                    </div>

                    <div class="user_box-a">
                        <?php if ($_SESSION['user_id'] === $my_id) : ?>
                            <a href="../Profile-index/profile.php?id=<?php echo htmlspecialchars($id); ?>">更新する</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="side-contents">

            <!-- カレンダーの表示 -->
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

            <div class="btn_arrow">
                <a href="../Logout-index/logout2.php">ログアウト</a>
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