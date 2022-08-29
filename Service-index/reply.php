<?php

//セッションスタート 
session_start();

// function読み込み
require('../function.php');

// DB接続
$db = db_connection();

if (isset($_SESSION['id'])) {
    $id = $_SESSION['user_id'];
    $name = $_SESSION['user_name'];
} else {
    header('Location: ../Home-index/index.php');
    exit();
}

$ID = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 値を変数に格納
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
    $stmt = $db->prepare('INSERT INTO keizi_reply (message, member_id, post_id) VALUES (?, ?, ?)');
    $stmt->bind_param('sis', $message, $id, $ID);
    $success = $stmt->execute();

    header('Location: reply.php?id=' . $ID);
    exit();
}

$stmt2 = $db->prepare('SELECT p.id, p.message, p.member_id, p.post_id, p.created, m.name, m.picture, m.status, m.course, m.School_year FROM keizi_reply p, members m WHERE m.id=p.member_id ORDER BY id DESC');
$stmt2->execute();
$stmt2->bind_result($r_id, $r_message, $r_member_id, $post_id, $r_created, $name, $picture, $status, $course, $School_year);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- cssのインポート -->
    <link rel="stylesheet" href="../Css/reply.css">

    <!-- ファビコンのインポート -->
    <link rel="icon" href="../img/favicon.png">

    <!-- font-awesomeのインポート -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

    <!-- タイトルの指定 -->
    <title>返信する / Real intentioN</title>
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

    <div class="content">
        <div class="main-content">
            <label class="open" for="pop-up"><i class="fa-solid fa-pen-clip"></i>返信する</label>
            <input type="checkbox" id="pop-up">
            <div class="overlay">
                <div class="window">
                    <label class="close" for="pop-up"><i class="fa-solid fa-circle-xmark"></i></label>
                    <form action="" method="post" enctype="multipart/form-data">

                        <textarea name="message" placeholder=" 　　Real intentioNへようこそ" required></textarea>

                        <button><i class="fa-solid fa-pen"></i>返信する</button>
                    </form>
                </div>
            </div>

            <?php while ($stmt2->fetch()) : ?>

                <!-- 投稿IDと返信IDが一致したものだけを表示 -->
                <?php if ($post_id === $ID) : ?>
                    <div class="post">

                        <!-- 写真の表示 -->
                        <div class="icon">
                            <?php if ($picture) : ?>
                                <a href="./myprofile.php?id=<?php echo htmlspecialchars($r_member_id); ?>">
                                    <img src="../member_picture/<?php echo htmlspecialchars($picture); ?>" alt="" width="80" height="80">
                                </a>
                            <?php endif; ?>

                            <!-- ユーザーが写真を登録していない場合はデフォルトの画像を表示 -->
                            <?php if (!$picture) : ?>
                                <a href="./myprofile.php?id=<?php echo htmlspecialchars($r_member_id); ?>">
                                    <img src="../img/default.png" alt="" width="80" height="80">
                                </a>
                            <?php endif; ?>
                        </div>

                        <li>
                            <p>
                                <!-- ユーザー情報の表示 -->
                                <span class="user_name"><?php echo htmlspecialchars($name); ?></span>
                                <span class="user_number"><?php echo ('@user' . $r_member_id); ?></span>
                            </p>

                            <p class="koube">
                                <span class="a"><?php echo $status; ?></span>
                                <span class="b"><?php echo $course; ?></span>
                                <span class="c"><?php echo $School_year; ?></span>
                            </p>

                            <div class="newline">
                                <?php
                                $r_message;
                                $pattern = '/((?:https?|ftp):\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+)/';
                                $replace = '<a href="$1">$1</a>';
                                $r_message = preg_replace($pattern, $replace, $r_message);
                                ?>
                                <p><?php echo $r_message; ?></p>
                            </div>

                            <div class="time">
                                <small><?php echo htmlspecialchars($r_created); ?></small>

                                <?php if ($_SESSION['user_id'] === $r_member_id) : ?>
                                    <a href="../Delete-Service-reply-index/delete.php?id=<?php echo htmlspecialchars($r_id); ?>" class="a" style="color: red;"><i class="fa-solid fa-trash"></i></a>
                                <?php endif; ?>
                            </div>
                        </li>
                    </div>
                <?php endif; ?>
            <?php endwhile; ?>
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