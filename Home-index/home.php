<?php

// sessionスタート
session_start();

// requireでfunctionを呼び込む
require('../function.php');

// DB接続
$db = db_connection();

// ログインしている場合
if (isset($_SESSION['id'])) {
    $id = $_SESSION['user_id'];
    $name = $_SESSION['user_name'];
} else {
    // ログインしていない場合
    header('Location: ../Home-index/index.php');
    exit();
}

// メッセージの投稿
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
    $image = $_FILES['image'];

    if (
        $image['name'] !== '' && $image['error'] === 0
    ) {
        $type = mime_content_type($image['tmp_name']);
        // 写真の形式がjpegまたはpngでない場合という条件を追加する
        if ($type !== 'image/jpeg' && $type !== 'image/png' && $type !== 'image/jpg' && $type !== 'image/webp') {
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

        // SQL発行
        $stmt = $db->prepare('INSERT INTO posts (message, member_id, picture) VALUES (?, ?, ?)');
        $stmt->bind_param('sis', $message, $id, $filename);
        $stmt->execute();
        header('Location: ../Home-index/home.php');
    }
}

// 最大ページ数を求める 
$counts = $db->query('SELECT COUNT(*) AS cnt FROM posts');
$count = $counts->fetch_assoc();
$max_page = floor(($count['cnt'] + 1) / 5 + 1);

// Dbからデータの呼び出す
$stmt = $db->prepare('SELECT p.id, p.member_id, p.message, p.picture, p.created, p.iine, m.name, m.picture, m.status, m.course, m.School_year FROM posts p, members m WHERE m.id=p.member_id ORDER BY id DESC LIMIT ?, 5');

// 最大ページ数を求める
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
$page = ($page ?: 1);
$start = ($page - 1) * 5;
$stmt->bind_param('i', $start);
$stmt->execute();

//　結果を変数におく
$stmt->bind_result($id, $member_id, $message, $img, $created, $iine, $name, $picture, $status, $course, $School_year);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- cssのインポート -->
    <link rel="stylesheet" href="../Css/Home-home.css">

    <!-- ファビコンのインポート -->
    <link rel="icon" href="../img/favicon.png">

    <!-- font-awesomeのインポート -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

    <!-- タイトルの指定 -->
    <title>Real intention トップ / Real intentioN</title>
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
            <li>
                <a href="../Topic-index/topic.php"><i class="fa-solid fa-star"></i><span>topic</span></a>
            </li>

            <li>
                <a href="../Home-index/myprofile.php?id=<?php echo htmlspecialchars($id); ?>"><i class=" fa fa-user"></i><span>Profile</span></a>
            </li>

            <li>
                <a href="../Service-index/home.php"><i class="fa fa-briefcase"></i><span>Intern</span></a>
            </li>

            <li>
                <a href="../Contact-index/contact.php"><i class="fa-solid fa-file-signature"></i><span>Contact</span></a>
            </li>
        </ul>
    </div>

    <div class="container">
        <div class="main-contents">

            <div class="search-box">
                <label class="open" for="pop-up"><i class="fa-solid fa-pen-clip"></i>投稿する</label>
                <input type="checkbox" id="pop-up">

                <div class="overlay">
                    <div class="window">

                        <label class="close" for="pop-up"><i class="fa-solid fa-circle-xmark"></i></label>

                        <form action="" method="post" enctype="multipart/form-data">
                            <textarea name="message" placeholder=" 　　Real intentioNへようこそ" cols="60" rows="18" required></textarea>

                            <div class="user-box">
                                <input type="file" name="image" size="30" accept=".jpg, .jpeg, .png, .webp">
                            </div>

                            <button><i class="fa-solid fa-pen"></i>投稿する</button>
                        </form>
                    </div>
                </div>
            </div>

            <?php while ($stmt->fetch()) : ?>
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
                            <span class="user_number"><?php echo htmlspecialchars('@user' . $member_id); ?></span>
                        </p>

                        <p class="koube">
                            <span class="a"><?php echo htmlspecialchars($status); ?></span>
                            <span class="b"><?php echo htmlspecialchars($course); ?></span>
                            <span class="c"><?php echo htmlspecialchars($School_year); ?></span>
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
                            <br>
                        </div>

                        <p class="img">
                            <?php if ($img) : ?>
                                <img src="../picture/<?php echo htmlspecialchars($img); ?>" alt="">
                            <?php endif; ?>
                        </p>

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

            <div class="btn1">
                <?php if ($page > 1) : ?>
                    <a href="?page=<?php echo $page - 1; ?>">&lt;&lt;<?php echo $page - 1; ?></a>
                <?php endif; ?>

                <?php if ($page < $max_page) : ?>
                    <a href="?page=<?php echo $page + 1; ?>"><?php echo $page + 1; ?>&gt;&gt;</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="side-contents">
            <div class="search">
                <form method="post" action="search.php" class="search">
                    <input type="text" size="25" placeholder="　　メッセージを検索" name="search_name" required>
                    <button><i class="fa fa-search"></i></button>
                </form>
            </div>
            
            <div class="search">
                <form method="post" action="./Department.php" class="search">
                    <input type="text" size="25" placeholder="　　学科で検索" name="search_name" required>
                    <button><i class="fa fa-search"></i></button>
                </form>
            </div>

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

    <div class="footer">
        <div class="SNS">
            <a href="https://github.com/Hayate12345"><i class="fa-brands fa-github"></i>Hayate12345</a>
            <a href="https://twitter.com/hayate_KIC"><i class="fa-brands fa-twitter"></i>hayate_KIC</a>
        </div>

        <p>2022-08/01 Hayate-studio</p>
    </div>
</body>

</html>