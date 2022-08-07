<?php

session_start();
// ログインしている場合
if (isset($_SESSION['hayate'])) {
} else {
    // ログインしていない場合index.phpを経由して、ログインページへ戻す
    header('Location: ../Admin-index/index.php');
    exit();
}

require('../db.php');
$db = dbconnection();

/* 最大ページ数を求める */
$counts = $db->query('select count(*) as cnt from keizi');
$count = $counts->fetch_assoc();
$max_page = floor(($count['cnt'] + 1) / 5 + 1);

//--------------------------------------------------------------------------------------------------------------------------

// データの呼び出し
$stmt = $db->prepare('select p.id, p.member_id, p.message, p.field, p.course, p.days, p.Expectation, p.Understanding, p.Communication, p.atmosphere, p.good, p.bad, p.trouble, p.Comprehensive, p.link, p.created, p.iine, m.name, m.picture, m.status, m.course, m.School_year from keizi p, members m where m.id=p.member_id order by id desc limit ?, 5');

// 最大ページ数を求める
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
$page = ($page ?: 1);
$start = ($page - 1) * 5;
$stmt->bind_param('i', $start);
$success = $stmt->execute();

//　結果を変数におく
$stmt->bind_result($id, $member_id, $message, $field, $course1, $days, $Expectation, $Understanding, $Communication, $Atmosphere, $good, $bad, $trouble, $Comprehensive, $link, $created, $iine, $name, $picture, $status, $course, $School_year);





?>











<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/hayate2.css">
    <title>総合ページ</title>
</head>

<body>

    <div class="content">
        <?php
        while ($stmt->fetch()) :
        ?>
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







                </li>

            </div>
        <?php endwhile; ?>



        <!-------------------------------------------------------------------------------------------------------------->

        <div class="btn1">
            <?php if ($page > 1) : ?>
                <button><a href="?page=<?php echo $page - 1; ?>">&lt;&lt;<?php echo $page - 1; ?></a></button>
            <?php endif; ?>

            <?php if ($page < $max_page) : ?>
                <button><a href="?page=<?php echo $page + 1; ?>"><?php echo $page + 1; ?>&gt;&gt;</a></button>
            <?php endif; ?>
        </div>
    </div>



</body>

</html>