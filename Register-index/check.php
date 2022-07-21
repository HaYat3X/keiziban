<?php
//---------------------------------------------------------------------------------------------------------------------------

// セッションスタート
session_start();

// function呼び出し
require('../db.php');

// データを受け取る
if (isset($_SESSION['form'])) {
    $form = $_SESSION['form'];
} else {
    header('Location: welcome.php');
    exit();
}

//---------------------------------------------------------------------------------------------------------------------------

// データベースとの連携
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = dbconnection();

    // インサート文でテーブルにデータを登録する
    $stmt = $db->prepare('insert into members (name, email, birth, tel, password, picture, status, course, School_year, comment, uuid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    // 値を代入できなかったときエラーを表示
    if (!$stmt) {
        die($db->error);
    }


    // 所属学科の初期値を指定する
    $Department = '未設定';

    // 所属コースの初期値を指定する
    $course = '未設定';

    // 学年の初期値を設定する
    $School_year = '未設定';

    // 自己紹介の初期値を設定する
    $comment = '自己紹介を記入してください';

    // セキュリティー対策のためのランダム文字列作成
    $str2 = substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz0123456789"), 0, 16);


    // パスワードの暗号化
    $password = password_hash($form['password'], PASSWORD_DEFAULT);
    $stmt->bind_param('sssssssssss', $form['nickname'], $form['email'], $form['birth'], $form['tel'], $password, $form['image'], $Department, $course, $School_year, $comment, $str2);
    $success = $stmt->execute();



    header('Location: thank.php');
}
?>

<!-------------------------------------------------------------------------------------------------------------------------->

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/check.css">
    <title>登録内容確認 / Real intentioN</title>
    <link rel="icon" href="../img/名称未設定-3.png">
</head>

<body>
    <main>
        <div class="card">
            <div class="content">

                <!---------------------------------------------------------------------------------------------------------->



                <!---------------------------------------------------------------------------------------------------------->

                <!-- タイトル文字 -->
                <h2>登録内容を確認する</h2>
                <form action="" method="post">

                    <div class="user-box">



                        <p>
                            <?php echo htmlspecialchars($form['nickname']); ?>
                        </p>
                    </div>

                    <div class="user-box">


                        <p>
                            <?php echo htmlspecialchars($form['birth']); ?>
                        </p>
                    </div>


                    <div class="user-box">


                        <p>
                            <?php echo htmlspecialchars($form['email']); ?>
                        </p>
                    </div>




                    <div class="user-box">


                        <p>
                            <?php echo htmlspecialchars($form['tel']); ?>
                        </p>
                    </div>


                    <div class="user-box">



                        <p>
                            <?php echo htmlspecialchars($form['password']); ?>
                        </p>
                    </div>


                    <div class="user-box">


                        <p>
                            <?php if ($form['image']) : ?>
                                <img src="../member_picture/<?php echo htmlspecialchars($form['image']); ?>" height="80" width="80">
                            <?php endif; ?>

                            <?php if (!$form['image']) : ?>
                                <img src="../img/default.png" height="80" width="80">
                            <?php endif; ?>
                        </p>
                    </div>


                    <!------------------------------------------------------------------------------------------------------>



                    <button>

                        登録する
                    </button>
                </form>
                <!--書き直しができるように値(Tofix)を設定しておく-->
                <div class="guidance">
                    <a href="welcome.php?action=Tofix">書き直す&gt;&gt;</a>
                </div>
            </div>
        </div>
    </main>
</body>

</html>