<?php
require('../db.php');
$db = new mysqli('localhost', 'root', 'root', 'user_db');
$stmt = $db->prepare('select * from posts where id=?');
if (!$stmt) {
    die($db->error);
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$stmt->bind_param('i', $id);
$stmt->execute();

$stmt->bind_result($id, $message, $member_id, $img, $created, $modifile);
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

    <div class="content">
        <div class="edit">
            <form action="../Update-home-index/update_do.php" method="post" enctype="multipart/form-data">
                <div class="text">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
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



            <!-------------------------------------------------------------------------------------------------------------->
            <div class="site-content">
                <div class="site">
                    <a href="#"><img src="../img/ダウンロード.png" alt=""></a>
                    <a href="#"><img src="../img/log_main.png" alt=""></a>
                </div>

                <div class="site">
                    <a href="#"><img src="../img/ダウンロード.png" alt=""></a>
                    <a href="#"><img src="../img/log_main.png" alt=""></a>
                </div>
            </div>

            <div class="btn_arrow">
                <a href="../Login/logout1.php">ログアウト</a>
            </div>
        </div>


    </div>

    <footer>
        サイト管理者　竹田　颯<br>
        ご意見、ご要望をお待ちしています。
    </footer>
</body>

</html>