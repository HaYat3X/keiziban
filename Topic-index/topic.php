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

                        </div>
                    </li>
                </div>
            <?php endwhile; ?>




            <h2>Service Topics</h2>

        </div>






        <div class="side-contents">







            <div class="search">
                <form method="post" action="search.php" class="search">
                    <input type="text" size="25" placeholder="　　メッセージを検索" name="search_name" required>
                    <button><i class="fa fa-search"></i></button>
                </form>
            </div>






            <!-- カレンダーの表示 -->
            <div class="calendar">
                <iframe src="https://calendar.google.com/calendar/embed?src=ja.japanese%23holiday%40group.v.calendar.google.com&ctz=Asia%2FTokyo" style="border: 0" frameborder="0" scrolling="no"></iframe>
            </div>


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