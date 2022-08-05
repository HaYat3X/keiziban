<?php
session_start();

// ログインしている場合
if (isset($_SESSION['id'])) {
    $id = $_SESSION['user_id'];
    $name = $_SESSION['user_name'];
} else {
    // ログインしていない場合index.phpを経由して、ログインページへ戻す
    header('Location: ../Home-index/index.php');
    exit();
}
require('../db.php');
$db = new mysqli('localhost', 'root', 'root', 'user_db');
$stmt = $db->prepare('select * from posts where id=?');
if (!$stmt) {
    die($db->error);
}
$update_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$stmt->bind_param('i', $update_id);
$stmt->execute();

$stmt->bind_result($id, $message, $member_id, $img, $created, $modifile, $iine);
$result = $stmt->fetch();

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/update-home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <title>編集画面</title>
</head>

<body>

    <!--　ヘッダーエリア　-->
    <div class="header">
        <div class="header-nav">
            <img src="..//img/favicon.png" alt="" width="80" height="80">
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

    <div class="content">
        <div class="edit">
            <form action="../Update-home-index/update_do.php" method="post" enctype="multipart/form-data">
                <div class="text">
                    <input type="hidden" name="id" value="<?php echo $update_id; ?>">
                    <textarea name="memo" placeholder=" 編集内容を記述してください"><?php echo htmlspecialchars($message); ?></textarea>
                    <div>
                        <input type="file" name="image" size="30" value="">
                    </div>


                </div>


                <div class="btn">
                    <button>更新する</button>
                </div>
            </form>
        </div>



        <div class="side-contents">





            <!-- カレンダーの表示 -->
            <div class="calendar">
                <iframe src="https://calendar.google.com/calendar/embed?src=ja.japanese%23holiday%40group.v.calendar.google.com&ctz=Asia%2FTokyo" style="border: 0" frameborder="0" scrolling="no"></iframe>
            </div>

            <!-------------------------------------------------------------------------------------------------------------->



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


    <div class="footer">
        <div class="SNS">
            <a href="https://github.com/Hayate12345"><i class="fa-brands fa-github"></i>Hayate12345</a>
            <a href="https://twitter.com/hayate_KIC"><i class="fa-brands fa-twitter"></i>hayate_KIC</a>
        </div>

        <p>2022-08/01 Hayate-studio</p>
    </div>
</body>

</html>