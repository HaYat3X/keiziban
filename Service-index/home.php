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
    // ログインしていない場合、ログインページへ戻す
    header('Location: ../Login/login.php');
    exit();
}

//---------------------------------------------------------------------------------------------------------------------------

// functionの呼びだし
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
$stmt->bind_result($id, $member_id, $message, $field, $course1, $days,  $Expectation, $Understanding, $Communication, $Atmosphere, $good, $bad, $trouble, $Comprehensive, $link, $created, $iine, $name, $picture, $status, $course, $School_year);


?>
<!-------------------------------------------------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/service-home.css">

    <link rel="icon" href="../img/名称未設定-3.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

    <title>Real intention</title>
</head>

<body>
    <!--　ヘッダーエリア　-->
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
            <li><a href="../Service-index/home.php"><i class="fa fa-briefcase"></i><span>Intern</span></a></li>
            <li><a href="#"><i class="fa-solid fa-file-signature"></i><span>Contact</span></a></li>

        </ul>
    </div>




    <!---------------------------------------------------------------------------------------------------------------------->

    <!-- メインエリア -->
    <div class="container">


        <div class="main-contents">

            <div class="search-box">
                <label class="open" for="pop-up"><i class="fa-solid fa-pen-clip"></i><a href="./post.php">投稿する</a></label>


            </div>



            <?php
            while ($stmt->fetch()) :
            ?>
                <div class="post">

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
                            <span class="user_name"><?php echo htmlspecialchars($name); ?></span>
                            <span class="user_number"><?php echo ('@user' . $member_id); ?></span>
                        </p>

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

            <div class="btn1">
                <?php if ($page > 1) : ?>
                    <button><a href="?page=<?php echo $page - 1; ?>">&lt;&lt;<?php echo $page - 1; ?></a></button>
                <?php endif; ?>

                <?php if ($page < $max_page) : ?>
                    <button><a href="?page=<?php echo $page + 1; ?>"><?php echo $page + 1; ?>&gt;&gt;</a></button>
                <?php endif; ?>
            </div>

        </div>

        <!------------------------------------------------------------------------------------------------------------------>


        <div class="side-contents">
            <div class="search">
                <form method="post" action="search.php" class="search">
                    <input type="text" size="25" placeholder="　　キーワードで検索" name="search_service" required>
                    <button><i class="fa fa-search"></i></button>
                </form>
            </div>




            <!-- カレンダーの表示 -->
            <div class="calendar">
                <iframe src="https://calendar.google.com/calendar/embed?src=ja.japanese%23holiday%40group.v.calendar.google.com&ctz=Asia%2FTokyo" style="border: 0" frameborder="0" scrolling="no"></iframe>
            </div>


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


    <!---------------------------------------------------------------------------------------------------------------------->

    <!-- フッターエリア -->
    <footer>
        <p>ご意見ご要望お待ちしています。気軽にお問い合わせください!</p>
        <p>&copy;hayate-studio</p>
    </footer>



</body>

</html>