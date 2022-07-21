<?php
session_start();
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
} else {
    // ログインしていない場合、ログインページへ戻す
    header('Location: ../Login/login.php');
    exit();
}

require('../db.php');
$db = new mysqli('localhost', 'root', 'root', 'user_db');
$stmt = $db->prepare('select * from members where id=?');
if (!$stmt) {
    die($db->error);
}
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
    <link rel="stylesheet" href="../Css/myprofile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <title>プロフィール</title>
</head>

<body>

    <!--　ヘッダーエリア　-->
    <div class="header">
        <div class="header-nav">
            <img src="../img/名称未設定-3.png" alt="" width="80" height="80">
            <a href="../Home-index/home.php">
                <h1>Real intentioN</h1>
            </a>
        </div>

        <ul>
            <li><a href="../community_home/home.php"><i class="fa-solid fa-house"></i><span>Home</span></a></li>
            <li><a href="../community_home/myprofile.php?id=<?php echo htmlspecialchars($id); ?>"><i class=" fa fa-user"></i><span>Profile</span></a></li>
            <li><a href="#"><i class="fa fa-briefcase"></i><span>Service</span></a></li>
            <li><a href="#"><i class="fa-solid fa-file-signature"></i><span>Contact</span></a></li>

        </ul>
    </div>

    <div class="card">
        <div class="content">
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


                <div class="user_box">
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
    <footer>
        サイト管理者　竹田　颯<br>
        ご意見、ご要望をお待ちしています。
    </footer>

</body>

</html>