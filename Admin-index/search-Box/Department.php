<?php

// セッションスタート
session_start();

// functionを呼び込む
require('../../function.php');

// DB接続
$db = db_connection();

if (isset($_SESSION['hayate'])) {
} else {
    header('Location: ../Home-index/index.php');
    exit();
}

$stmt = $db->prepare("SELECT p.id, p.member_id, p.message, p.field, p.course, p.days, p.Expectation, p.Understanding, p.Communication, p.atmosphere, p.good, p.bad, p.trouble, p.Comprehensive, p.link, p.created, p.iine, m.name, m.picture, m.status, m.course, m.School_year, m.id FROM keizi p, members m WHERE status LIKE  '%" . $_POST["search_service1"] . "%' ORDER BY p.id DESC");

$stmt->execute();
$stmt->bind_result($id, $member_id, $message, $field, $course1, $days,  $Expectation, $Understanding, $Communication, $Atmosphere, $good, $bad, $trouble, $Comprehensive, $link, $created, $iine, $name, $picture, $status, $course, $School_year, $member_id2);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- cssのインポート -->
    <link rel="stylesheet" href="../../Css/hayate2.css">

    <!-- タイトルの指定 -->
    <title>管理者専用ページ / Real intentioN</title>

    <!-- ファビコンの読み込み -->
    <link rel="icon" href="../../img/favicon.png">
</head>

<body>
    <div class="home">
        <a href="../Home-index/home.php">ホームへ</a>
    </div>

    <div class="main-contents">
        <?php while ($stmt->fetch()) : ?>
            <?php if ($member_id === $member_id2) : ?>
                <div class="post">
                    <li>
                        <p class="koube">
                            <span class="a"><?php echo $status; ?></span>
                            <span class="b"><?php echo $course; ?></span>
                            <span class="c"><?php echo $School_year; ?></span>
                        </p>

                        <!-- メッセージの表示 -->
                        <p class="start">
                            <label>企業名：</label><span><?php echo htmlspecialchars($message); ?></span>
                        </p>

                        <p class="newline">
                            <label>参加した分野：</label><span><?php echo htmlspecialchars($field); ?></span>
                        </p>

                        <p class="newline">
                            <label>参加したカリキュラム：</label><span><?php echo htmlspecialchars($course1); ?></span>
                        </p>

                        <p class="newline">
                            <label>参加した日数：</label><span><?php echo htmlspecialchars($days); ?></span>
                        </p>

                        <p class="newline">
                            <label>体験内容について：</label><span><?php echo htmlspecialchars($Expectation); ?></span>
                        </p>

                        <p class="newline">
                            <label>企業、業界理解について：</label><span><?php echo htmlspecialchars($Understanding); ?></span>
                        </p>

                        <p class="newline">
                            <label>社員サポートについて：</label><span><?php echo htmlspecialchars($Communication); ?></span>
                        </p>

                        <p class="newline">
                            <label>職場の雰囲気について：</label><span><?php echo htmlspecialchars($Atmosphere); ?></span>
                        </p>

                        <p class="newline">
                            <label>総合的な満足度：</label><span><?php echo htmlspecialchars($Comprehensive); ?></span>
                        </p>

                        <p class="newline">
                            <label>良かった所、印象に残った所：</label>
                            <br>
                            <span><?php echo htmlspecialchars($good); ?></span>
                        </p>

                        <p class="newline">
                            <label>良くなかった所、期待外れだった所：</label>
                            <br>
                            <span><?php echo htmlspecialchars($bad); ?></span>
                        </p>

                        <p class="newline">
                            <label>困ったところ、よく分からなかった所：</label>
                            <br>
                            <span><?php echo htmlspecialchars($trouble); ?></span>
                        </p>

                        <p class="end">
                            <?php
                            $link;
                            $pattern = '/((?:https?|ftp):\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+)/';
                            $replace = '<a href="$1">$1</a>';
                            $link = preg_replace($pattern, $replace, $link);
                            ?>
                            <label>応募したページのリンク：</label><span><?php echo $link; ?></span>
                        </p>

                        <div class="time">
                            <small><?php echo htmlspecialchars($created); ?></small>
                        </div>
                    </li>
                </div>
            <?php endif; ?>
        <?php endwhile; ?>
    </div>
</body>

</html>