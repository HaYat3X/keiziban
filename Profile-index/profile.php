<?php

// セッションスタート
session_start();

// functionの呼び込む
require('../function.php');

// DB接続
$db = db_connection();

if (isset($_SESSION['id'])) {
    $id = $_SESSION['user_id'];
    $name = $_SESSION['user_name'];
} else {
    header('Location: ../Home-index/index.php');
    exit();
}

$stmt = $db->prepare('SELECT * FROM members WHERE id=?');
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

    <!-- タイトルの指定指定 -->
    <title>プロフィールを編集する / Real intentioN</title>

    <!-- ファビコンの読み込み -->
    <link rel="icon" href="../img/favicon.png">

    <!-- cssの読み込み -->
    <link rel="stylesheet" href="../Css/update-profile.css">

    <!-- font-awesomeのインポート -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
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
            <?php if ($_SESSION['user_id'] === $id) : ?>
                <div class="edit">
                    <form action="../Profile-index/profile_do.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">

                        <div class="user_box">
                            <label>アイコンを変更</label>
                            <br>
                            <input type="file" name="image" accept=".png, .jpg, .jpeg">
                        </div>

                        <div class="user_box">
                            <label>名前</label>
                            <br>
                            <input type="text" name="name" value="<?php echo $name; ?>">
                        </div>

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
                            <input type="radio" name="status" value="ゲームソフト学科"> ゲームソフト学科
                            <br>
                            <input type="radio" name="status" value="情報工学科"> 情報工学科
                            <br>
                            <input type="radio" name="status" value="情報ビジネス学科"> 情報ビズネス学科
                            <br>
                            <input type="radio" name="status" value="3DCGアニメーション学科"> 3DCGアニメーション学科
                            <br>
                            <input type="radio" name="status" value="デジタルアニメ学科"> デジタルアニメ学科
                            <br>
                            <input type="radio" name="status" value="グラフィックデザイン学科"> グラフィックデザイン学科
                            <br>
                            <input type="radio" name="status" value="サウンドクリエイト学科"> サウンドクリエイト学科
                            <br>
                            <input type="radio" name="status" value="声優タレント学科"> 声優タレント学科
                            <br>
                            <input type="radio" name="status" value="インダストリアルデザイン学科"> インダストリアルデザイン学科
                            <br>
                            <input type="radio" name="status" value="総合研究科（建築コース）"> 総合研究科（建築コース）
                            <br>
                            <input type="radio" name="status" value="総合研究科（CGコース）"> 総合研究科（CGコース）
                            <br>
                            <input type="radio" name="status" value="日本語学科"> 日本語学科
                            <br>
                            <input type="radio" name="status" value="国際コミュニケーション学科"> 国際コミュニケーション学科
                        </div>

                        <div class="course">
                            <label>コース</label>
                            <br>
                            <input type="radio" name="course" value="プログラミングコース"> プログラミングコース
                            <br>
                            <input type="radio" name="course" value="esportsコース"> esportsコース
                            <br>
                            <input type="radio" name="course" value="建築デザインコース"> 建築デザインコース
                            <br>
                            <input type="radio" name="course" value="建築インテリアコース"> 建築インテリアコース
                            <br>
                            <input type="radio" name="course" value="該当なし"> 該当なし
                        </div>

                        <div class="number">
                            <label>学年</label>
                            <br>
                            <input type="radio" name="School_year" value="1年生"> 1年生
                            <br>
                            <input type="radio" name="School_year" value="2年生"> 2年生
                            <br>
                            <input type="radio" name="School_year" value="3年生"> 3年生
                            <br>
                            <input type="radio" name="School_year" value="4年生"> 4年生

                        </div>

                        <div class="Introduction">
                            <label>自己紹介</label>
                            <br>
                            <textarea name="comment"><?php echo $comment; ?></textarea>
                        </div>

                        <button>更新する</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>

        <div class="side-contents">

            <!-- カレンダーの表示 -->
            <div class="calendar">
                <iframe src="https://calendar.google.com/calendar/embed?src=ja.japanese%23holiday%40group.v.calendar.google.com&ctz=Asia%2FTokyo" style="border: 0" frameborder="0" scrolling="no"></iframe>
            </div>

            <div class="site-content">
                <div class="site">
                    <a href="https://job.career-tasu.jp/2024/top/"><img src="../img/link1.png" alt=""></a>
                    <a href="https://job.mynavi.jp/24/pc/toppage/displayTopPage/index"><img src="../img/ogp.jpeg" alt=""></a>
                </div>

                <div class="site">
                    <a href="https://job.rikunabi.com/2024/?isc=r21rcnz02954"><img src="../img/link2.png" alt=""></a>
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