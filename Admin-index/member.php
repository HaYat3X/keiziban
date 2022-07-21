<?php
session_start();
// ログインしている場合
if (isset($_SESSION['hayate'])) {
} else {
    // ログインしていない場合index.phpを経由して、ログインページへ戻す
    header('Location: ../Admin-index/index.php');
    exit();
}

$db = new mysqli('localhost', 'root', 'root', 'user_db');

$stmt = $db->prepare("SELECT * FROM members order by id desc");

$stmt->execute();
$stmt->bind_result($a, $b, $c, $d, $e, $f, $g, $h, $i, $j, $k, $l, $m, $n);





?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./member.css">
    <title>会員情報管理</title>
</head>

<body>
    <div class="content">
        <?php while ($stmt->fetch()) : ?>
            <div class="A">
                <ul>
                    <?php if ($g) : ?>
                        <img src="../member_picture/<?php echo htmlspecialchars($g); ?>" width="100" height="100" alt="">
                    <?php endif; ?>
                    <?php if (!$g) : ?>
                        <img src="../img/default.png" alt="" width="100" height="100">
                    <?php endif; ?>
                    <li>会員の番号：<?php echo $a; ?></li>
                    <li>会員の名前：<?php echo $b; ?></li>
                    <li>会員のメールアドレス：<?php echo $c; ?></li>
                    <li>会員の誕生日：<?php echo $d; ?></li>
                    <li>会員の電話番号：<?php echo $e; ?></li>
                    <li>会員の学科：<?php echo $h; ?></li>
                    <li>会員のコース：<?php echo $i; ?></li>
                    <li>会員の学年：<?php echo $j; ?></li>
                    <li>会員の自己紹介：<?php echo $k; ?></li>
                    <li>会員のUUID：<?php echo $l; ?></li>
                    <li>サービス開始時間：<?php echo $m; ?></li>

                </ul>
            </div>
        <?php endwhile; ?>
    </div>
</body>

</html>