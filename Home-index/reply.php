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
$ID = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);


    $image = $_FILES['image'];

    if (
        $image['name'] !== '' && $image['error'] === 0
    ) {
        $type = mime_content_type($image['tmp_name']);
        // 写真の形式がjpegまたはpngでない場合という条件を追加する
        if ($type !== 'image/jpeg' && $type !== 'image/png') {
            $error['image'] = 'type';
        }
    }

    if (empty($error)) {

        // 画像のアップロード
        if ($image['name'] !== '') {
            $filename = date('YmdHis') . '_' . $image['name'];
            if (!move_uploaded_file($image['tmp_name'], '../picture/' . $filename)) {
                die('ファイルのアップロードに失敗しました');
            }
            $_SESSION['form']['image'] = $filename;
        } else {
            $_SESSION['form']['image'] = '';
        }

        $stmt = $db->prepare('INSERT INTO reply (message, member_id, post_id, picture) VALUES (?, ?, ?, ?)');
        if (!$stmt) {
            die($db->error);
        }




        $stmt->bind_param('siss', $message, $user_id, $ID, $filename);
        $success = $stmt->execute();


        // データベースの重複登録を防ぐ　POSTの内容を消す
        header('Location: reply.php?id=' . $ID);
    }
}


$stmt2 = $db->prepare('select p.id, p.message, p.member_id, p.post_id, p.picture, p.created, m.name, m.picture, m.status, m.course, m.School_year from reply p, members m where m.id=p.member_id order by id desc');


$stmt2->execute();

//　結果を変数におく
$stmt2->bind_result($r_id, $r_message, $r_member_id, $post_id, $img, $r_created, $name, $picture, $status, $course, $School_year);


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/reply.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <title>Document</title>
</head>

<body>

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

        <div class="search-box">
            <label class="open" for="pop-up"><i class="fa-solid fa-pen-clip"></i>返信する</label>
            <input type="checkbox" id="pop-up">
            <div class="overlay">
                <div class="window">
                    <label class="close" for="pop-up"><i class="fa-solid fa-circle-xmark"></i></label>
                    <form action="" method="post" enctype="multipart/form-data">

                        <textarea name="message" placeholder=" 　　Real intentioNへようこそ" required></textarea>
                        <div class="user-box">

                            <input type="file" name="image" size="30" value="">



                        </div>

                        <button><i class="fa-solid fa-pen"></i>返信する</button>
                    </form>

                </div>
            </div>


        </div>



        <?php
        while ($stmt2->fetch()) :
        ?>
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
                            <span><?php echo ('@user' . $r_member_id); ?></span>

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
                            <label><?php echo $r_message; ?></label>
                            <p class="img">
                                <?php if ($img) : ?>
                                    <img src="../picture/<?php echo htmlspecialchars($img); ?>" alt="">
                                <?php endif; ?>
                            </p>
                        </div>


                        <div class="time">

                            <small><?php echo htmlspecialchars($r_created); ?></small>



                            <?php if ($_SESSION['user_id'] === $r_member_id) : ?>
                                <a href="../Delete-home-reply-index/delete.php?id=<?php echo htmlspecialchars($r_id); ?>" class="a" style="color: red;"><i class="fa-solid fa-trash"></i></a>
                            <?php endif; ?>



                        </div>

                    </li>
                </div>
            <?php endif; ?>





        <?php endwhile; ?>

    </div>
    <footer>
        サイト管理者　竹田　颯<br>
        ご意見、ご要望をお待ちしています。
    </footer>

</body>

</html>