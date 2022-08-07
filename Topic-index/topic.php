<?php
// sessionスタート
session_start();

// requireでfunctionを呼び込む
require('../db.php');

//--------------------------------------------------------------------------------------------------------------------------

// ログインしている場合
if (isset($_SESSION['id'])) {
    $id = $_SESSION['user_id'];
    $name = $_SESSION['user_name'];
} else {
    // ログインしていない場合index.phpを経由して、ログインページへ戻す
    header('Location: ../Home-index/index.php');
    exit();
}




//---------------------------------------------------------------------------------------------------------------------------

// functionの呼びだし、DBとの接続
$db = dbconnection();




?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/topic.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <title>Document</title>
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
            <li><a href="../Topic-index/topic.php"><i class="fa-solid fa-star"></i><span>topic</span></a></li>
            <li><a href="../Home-index/myprofile.php?id=<?php echo htmlspecialchars($id); ?>"><i class=" fa fa-user"></i><span>Profile</span></a></li>
            <li><a href="../Service-index/home.php"><i class="fa fa-briefcase"></i><span>Service</span></a></li>
            <li><a href="#"><i class="fa-solid fa-file-signature"></i><span>Contact</span></a></li>

        </ul>
    </div>




    <div class="container">


        <div class="main-contents">
            <h2>Small Talk Topics</h2>



            <?php
            $stmt1 = $db->prepare('SELECT p.id, p.member_id, p.message, p.picture, p.created, p.iine, m.name, m.picture, m.status, m.course, m.School_year from posts p, members m where m.id=p.member_id order by iine desc limit 3');
            $stmt1->execute();
            $stmt1->bind_result($id, $member_id, $message, $img, $created, $iine, $name, $picture, $status, $course, $School_year);
            ?>



            <?php while ($stmt1->fetch()) : ?>

                <div class="post">


                    <div class="picture">
                        <!-- 写真の表示 -->
                        <?php if ($picture) : ?>

                            <a href="./myprofile.php?id=<?php echo htmlspecialchars($member_id); ?>">
                                <img src="../member_picture/<?php echo htmlspecialchars($picture); ?>" alt="" width="100" height="100">
                            </a>
                        <?php endif; ?>

                        <!-- ユーザーが写真を登録していない場合はデフォルトの画像を表示 -->
                        <?php if (!$picture) : ?>
                            <a href="./myprofile.php?id=<?php echo htmlspecialchars($member_id); ?>">
                                <img src="../img/default.png" alt="" width="100" height="100">
                            </a>
                        <?php endif; ?>
                    </div>
                    <li>


                        <p>
                            <!-- ユーザー情報の表示 -->
                            <span class="user_name"><?php echo htmlspecialchars($name); ?></span>
                            <span class="user_number"><?php echo ('@user' . $member_id); ?></span>

                        </p>

                        <p class="koube">
                            <span class="a"><?php echo $status; ?></span>
                            <span class="b"><?php echo $course; ?></span>
                            <span class="c"><?php echo $School_year; ?></span>
                        </p>

                        <!-- メッセージの表示 -->
                        <div class="newline">
                            <?php
                            $message;
                            $pattern = '/((?:https?|ftp):\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+)/';
                            $replace = '<a href="$1">$1</a>';
                            $message = preg_replace($pattern, $replace, $message);
                            ?>
                            <?php echo ($message); ?>

                            <p class="img">
                                <?php if ($img) : ?>
                                    <img src="../picture/<?php echo htmlspecialchars($img); ?>" alt="">
                                <?php endif; ?>
                            </p>
                        </div>



                        <!-- 投稿時間の表示 -->
                        <div class="time">



                            <small class="post_time"><?php echo htmlspecialchars($created); ?></small>
                            <!-- 自分の投稿であれば削除できる -->
                            <?php if ($_SESSION['user_id'] === $member_id) : ?>
                                <a href="../Delete-home-index/delete.php?id=<?php echo htmlspecialchars($id); ?>" class="a" style="color: #696969;"><i class="fa-solid fa-trash"></i></a>
                            <?php endif; ?>

                            <!-- 自分の投稿であれば編集ができる -->
                            <?php if ($_SESSION['user_id'] === $member_id) : ?>
                                <a href="../Update-home-index/update.php?id=<?php echo htmlspecialchars($id); ?>" class="a" style="color: #4C8DCB;"><i class="fa-solid fa-pen-to-square"></i></a>
                            <?php endif; ?>


                            <a href="reply.php?id=<?php echo htmlspecialchars($id); ?>" class="a" style="color: #EF810F;"><i class="fa-solid fa-reply"></i></a>




                            <a href="like.php?id=<?php echo htmlspecialchars($id); ?>" class="a" style="color: #ff69b4;"><i class="fa-solid fa-thumbs-up"></i></a><span class="iine"><?php echo $iine ?></span>

                        </div>
                    </li>
                </div>
            <?php endwhile; ?>




            <h2>Service Topics</h2>
            <?php
            $stmt2 = $db->prepare('select p.id, p.member_id, p.message, p.field, p.course, p.days, p.Expectation, p.Understanding, p.Communication, p.atmosphere, p.good, p.bad, p.trouble, p.Comprehensive, p.link, p.created, p.iine, m.name, m.picture, m.status, m.course, m.School_year from keizi p, members m where m.id=p.member_id order by iine desc limit 3');

            $stmt2->execute();

            //　結果を変数におく
            $stmt2->bind_result($id, $member_id, $message, $field, $course1, $days,  $Expectation, $Understanding, $Communication, $Atmosphere, $good, $bad, $trouble, $Comprehensive, $link, $created, $iine, $name, $picture, $status, $course, $School_year);

            ?>

            <?php
            while ($stmt2->fetch()) :
            ?>
                <div class="post2">

                    <!-- 写真の表示 -->
                    <?php if ($picture) : ?>

                        <a href="../Home-index/myprofile.php?id=<?php echo htmlspecialchars($member_id); ?>">
                            <img src="../member_picture/<?php echo htmlspecialchars($picture); ?>" alt="" width="100" height="100">
                        </a>
                    <?php endif; ?>

                    <!-- ユーザーが写真を登録していない場合はデフォルトの画像を表示 -->
                    <?php if (!$picture) : ?>
                        <a href="../Home-index/myprofile.php?id=<?php echo htmlspecialchars($member_id); ?>">
                            <img src="../img/default.png" alt="" width="100" height="100">
                        </a>
                    <?php endif; ?>


                    <li>

                        <p>
                            <!-- ユーザー情報の表示 -->
                            <span class="user_name2"><?php echo htmlspecialchars($name); ?></span>
                            <span class="user_number2"><?php echo ('@user' . $member_id); ?></span>
                        </p>

                        <p class="koube2">
                            <span class="a"><?php echo $status; ?></span>
                            <span class="b"><?php echo $course; ?></span>
                            <span class="c"><?php echo $School_year; ?></span>
                        </p>


                        <!-- メッセージの表示 -->
                        <p class="start2">
                            <label>企業名：</label><span><?php echo htmlspecialchars($message); ?></span>

                        </p>

                        <p class="newline2">
                            <label>参加した分野：</label><span><?php echo htmlspecialchars($field); ?></span>
                        </p>

                        <p class="newline2">
                            <label>参加したカリキュラム：</label><span><?php echo htmlspecialchars($course1); ?></span>
                        </p>

                        <p class="newline2">
                            <label>参加した日数：</label><span><?php echo htmlspecialchars($days); ?></span>
                        </p>

                        <p class="newline2">
                            <label>体験内容について：</label><span><?php echo htmlspecialchars($Expectation); ?></span>
                        </p>

                        <p class="newline2">
                            <label>企業、業界理解について：</label><span><?php echo htmlspecialchars($Understanding); ?></span>
                        </p>

                        <p class="newline2">
                            <label>社員サポートについて：</label><span><?php echo htmlspecialchars($Communication); ?></span>
                        </p>

                        <p class="newline2">
                            <label>職場の雰囲気について：</label><span><?php echo htmlspecialchars($Atmosphere); ?></span>
                        </p>

                        <p class="newline2">
                            <label>総合的な満足度：</label><span><?php echo htmlspecialchars($Comprehensive); ?></span>
                        </p>



                        <p class="newline2">
                            <label>良かった所、印象に残った所：</label>
                            <br>
                            <span><?php echo htmlspecialchars($good); ?></span>
                        </p>




                        <p class="end2">
                            <?php
                            $link;
                            $pattern = '/((?:https?|ftp):\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+)/';
                            $replace = '<a href="$1">$1</a>';
                            $link = preg_replace($pattern, $replace, $link);
                            ?>
                            <label>応募したページのリンク：</label><span><?php echo $link; ?></span>
                        </p>



                        <div class="time2">



                            <small><?php echo htmlspecialchars($created); ?></small>
                            <!-- 自分の投稿であれば削除できる -->
                            <?php if ($_SESSION['user_id'] === $member_id) : ?>
                                <a href="../Delete-Service-index/delete.php?id=<?php echo htmlspecialchars($id); ?>" class="a" style="color:  #696969;"><i class="fa-solid fa-trash"></i></a>
                            <?php endif; ?>

                            <!-- 自分の投稿であれば編集ができる -->
                            <?php if ($_SESSION['user_id'] === $member_id) : ?>
                                <a href="../Update-Service-index/update.php?id=<?php echo htmlspecialchars($id); ?>" class="a" style="color: #4C8DCB;;"><i class="fa-solid fa-pen-to-square"></i></a>
                            <?php endif; ?>


                            <a href="reply.php?id=<?php echo htmlspecialchars($id); ?>" class="a" style="color: #EF810F;"><i class="fa-solid fa-reply"></i></a>

                            <a href="like.php?id=<?php echo htmlspecialchars($id); ?>" class="a" style="color: #ff69b4;"><i class="fa-solid fa-thumbs-up"></i></a><span class="iine"><?php echo $iine ?></span>


                        </div>




                    </li>

                </div>
            <?php endwhile; ?>



            <!-------------------------------------------------------------------------------------------------------------->


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