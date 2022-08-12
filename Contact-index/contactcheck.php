<?php
// セッションスタート
session_start();

// if (isset($_SESSION['id'])) {
//     $id = $_SESSION['user_id'];
//     $name = $_SESSION['user_name'];
// } else {
//     // ログインしていない場合index.phpを経由して、ログインページへ戻す
//     header('Location: ../Home-index/index.php');
//     exit();
// }

if (isset($_SESSION['form'])) {
    $form = $_SESSION['form'];
} else {
    header('Location: contact.php');
    exit();
}


// 関数読み込み
require('../db.php');



//---------------------------------------------------------------------------------------------------------------------------

//データベースとの連携
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = dbconnection();

    //インサート文でテーブルにデータを登録する
    $stmt = $db->prepare('insert into contact (name, email, message) VALUES (?, ?, ?)');
    //値を代入できなかったときエラーを表示
    if (!$stmt) {
        die($db->error);
    }

    //データベースへデータを代入します
    $stmt->bind_param('sss', $form['nickname'], $form['email'], $form['message']);
    $success = $stmt->execute();
    //dbに値が代入できなかったときエラーを表示
    if (!$success) {
        die($db->error);
    }


    header('Location: success.php');
}
?>

<!-------------------------------------------------------------------------------------------------------------------------->

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/contact-check.css">
    <title>お問い合わせ内容確認</title>
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
            <li><a href="../Service-index/home.php"><i class="fa fa-briefcase"></i><span>Intern</span></a></li>
            <li><a href="../Contact-index/contact.php"><i class="fa-solid fa-file-signature"></i><span>Contact</span></a></li>

        </ul>
    </div>


    <div class="container">
        <div class="main-contents">
            <form action="" method="post">
                <div class="user-box">
                    <!-- ニックネームの入力欄 -->
                    <label>お名前</label>
                    <br>
                    <input type="text" name="nickname" maxlength="200" placeholder="山田　太郎" value="<?php echo htmlspecialchars($form['nickname']); ?>" required readonly>
                </div>

                <div class="user-box">
                    <label>メールアドレス</label>
                    <br>
                    <!-- patternで形式を指定 -->
                    <input type="email" name="email" placeholder="info@co.jp" value="<?php echo htmlspecialchars($form['email']); ?>" required readonly>
                </div>

                <div class="user-box">
                    <label>お問い合わせ内容</label>

                    <br>

                    <textarea name="message" required readonly><?php echo htmlspecialchars($form['message']); ?></textarea>


                </div>
                <!------------------------------------------------------------------------------------------------------>

                <!-- 送信ボタン -->
                <button class="btn btn-radius-solid btn--shadow">送信</button>
            </form>
        </div>

        <div class="side-contents">














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


        </div>
    </div>


    <div class="card">
        <div class="content">
            <h2>check</h2>
            <form action="" method="post">
                <table>

                    <!------------------------------------------------------------------------------------------------------>

                    <!-- 名前の確認欄 -->
                    <tr>
                        <th>お名前</th>
                        <td>
                            <?php echo htmlspecialchars($form['nickname']); ?>
                        </td>
                    </tr>

                    <!------------------------------------------------------------------------------------------------------>

                    <!-- メールアドレスの確認欄 -->
                    <tr>
                        <th>メールアドレス</th>
                        <td>
                            <?php echo htmlspecialchars($form['email']); ?>
                        </td>
                    </tr>

                    <!------------------------------------------------------------------------------------------------------>

                    <!-- 選択内容の確認欄 -->
                    <tr>
                        <th>選択内容</th>
                        <td>
                            <?php echo htmlspecialchars($form['form']); ?>
                        </td>
                    </tr>

                    <!------------------------------------------------------------------------------------------------------>

                    <!-- お問い合わせ内容の確認欄 -->
                    <tr>
                        <th>お問い合わせ内容</th>
                        <td>
                            <?php echo htmlspecialchars($form['message']); ?>
                        </td>
                    </tr>
                </table>

                <!---------------------------------------------------------------------------------------------------------->

                <!-- 送信ボタン -->
                <h5 class="message">
                    *お問い合わせ内容の返信は指定のメールアドレスに送りますので、<br>メールアドレスを今一度ご確認ください。
                </h5>

                <button>送信</button>
            </form>
        </div>
    </div>
</body>

</html>