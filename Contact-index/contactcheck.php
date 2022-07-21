<?php
// セッションスタート
session_start();

// 関数読み込み
require('../db.php');

//データを受け取る
$form = $_SESSION['form'];

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

    //重複登録を防ぐためにデータを消去しておく
    unset($_SESSION['form']);
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
    <link rel="stylesheet" href="../css/style1.css">
    <title>お問い合わせ内容確認</title>
</head>

<body>
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