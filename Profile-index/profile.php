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
$GET_ID = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$stmt->bind_param('i', $GET_ID);
$stmt->execute();

$stmt->bind_result($id, $name, $email, $birth, $tel, $password, $picture, $status, $course, $School_year, $comment, $uuid, $created, $modifild);
$result = $stmt->fetch();




?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../Css/update-profile.css">
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
        <?php if ($_SESSION['user_id'] === $id) : ?>

            <div class="edit">
                <form action="../Profile-index/profile_do.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">



                    <div class="user_box">
                        <label>アイコン</label>
                        <br>
                        <input type="file" name="image" size="30" value="">

                    </div>


                    <div class="user_box">
                        <label>名前</label>
                        <br>
                        <input type="text" name="name" value="<?php echo $name; ?>">
                    </div>


                    <div class="koube">
                        <div class="status">
                            <label>学科</label>
                            <br>
                            <input type="radio" name="status" value="ITエキスパート学科"> ITエキスパート学科
                            <br>
                            <input type="radio" name="status" value="ITスペシャリスト学科"> ITスペシャリスト学科
                            <br>
                            <input type="radio" name="status" value="情報処理学科"> 情報処理学科
                            <br>
                            <input type="radio" name="status" value="AIシステム開発学科"> AIシステム開発学科
                            <br>
                            <input type="radio" name="status" value="ゲーム開発研究学科"> ゲーム開発研究学科
                            <br>
                            <input type="radio" name="status" value="エンターテインメントソフト学科"> エンターテインメントソフト学科
                            <br>
                            <input type="radio" name="status" value="エンターテインメントソフト学科"> エンターテインメントソフト学科
                            <br>
                            <input type="radio" name="status" value="エンターテインメントソフト学科"> エンターテインメントソフト学科
                            <br>
                            <input type="radio" name="status" value="エンターテインメントソフト学科"> エンターテインメントソフト学科
                            <br>
                            <input type="radio" name="status" value="エンターテインメントソフト学科"> エンターテインメントソフト学科
                            <br>
                            <input type="radio" name="status" value="留年"> 留年
                            <br>
                        </div>


                        <div class="course">
                            <label>コース</label>
                            <br>
                            <input type="radio" name="course" value="AIテクノロジーコース"> AIテクノロジーコース
                            <br>
                            <input type="radio" name="course" value="該当なし"> 該当なし
                            <br>
                            <input type="radio" name="course" value="留年"> 留年
                            <br>

                        </div>
                    </div>

                    ・学年
                    <input type="radio" name="School_year" value="1年生">1年生
                    <input type="radio" name="School_year" value="2年生">2年生
                    <br>
                    ・自己紹介
                    <textarea name="comment" cols="30" rows="10"><?php echo $comment; ?></textarea>
            </div>

            <button class="btn_arrow1">更新する</button>
            </form>
    </div>
<?php endif; ?>
</div>

<footer>
    サイト管理者　竹田　颯<br>
    ご意見、ご要望をお待ちしています。
</footer>

</body>

</html>