<?php
// セッションスタート
session_start();

// エラー回避のため配列を初期化
$form = [
    'nickname' => '',
    'email' => '',
    'message' => '',
    'form' => '',
];

// エラー回避のため配列を初期化
$error = [];

//---------------------------------------------------------------------------------------------------------------------------

// 送信テェック
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form['nickname'] = filter_input(INPUT_POST, 'nickname', FILTER_SANITIZE_STRING);

    //もしnameが空白(blank)であればという条件を追加する
    if ($form['nickname'] === '') {
        $error['nickname'] = 'blank';
    }

    $form['form'] = filter_input(INPUT_POST, 'form', FILTER_SANITIZE_STRING);

    $form['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    //もしnameが空白(blank)であればという条件を追加する
    if ($form['email'] === '') {
        $error['email'] = 'blank';
    }

    $form['message'] = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
    //もしnameが空白(blank)であればという条件を追加する
    if ($form['message'] === '') {
        $error['message'] = 'blank';
    }

    if (empty($error)) {
        $_SESSION['form'] = $form;

        //すべてにエラーがない場合確認画面に移動する
        header('Location: contactcheck.php');
        exit();
    }
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
    <title>お問い合わせ</title>
</head>

<body>
    <div class="card">
        <div class="content">
            <h2>contact</h2>
            <form action="" method="post">
                <dl>

                    <!------------------------------------------------------------------------------------------------------>

                    <!-- ニックネームの入力欄 -->
                    <dt>お名前<span class="error">[必須]</span></dt>
                    <dd>
                        <input type="text" name="nickname" maxlength="200" placeholder="山田　太郎" value="<?php echo htmlspecialchars($form['nickname']); ?>">

                        <!-- ニックネームの欄が未記入の場合エラーを表示する -->
                        <?php if (isset($error['nickname']) && $error['nickname'] === 'blank') : ?>
                            <h5 class="error">*ニックネームが未入力です。入力してください!</h5>
                        <?php endif; ?>
                    </dd>

                    <!----------------------------------------------------------------------------------------------------->

                    <dt>選択してください　必須</dt>
                    <dd>
                        <select name="form" required>
                            <option value="">選択して下さい</option>
                            <option value="1、パスワード関連">1、パスワード関連</option>
                            <option value="2、ご意見">2、ご意見</option>
                        </select>
                    </dd>

                    <!------------------------------------------------------------------------------------------------------>

                    <!-- メールアドレスの入力欄 -->
                    <dt>メールアドレス<span class="error">[必須]</span></dt>
                    <dd>
                        <!-- patternで形式を指定 -->
                        <input type="email" name="email" placeholder="info@co.jp" pattern="\d{30]@\d{30}" value="<?php echo htmlspecialchars($form['email']); ?>">
                        <!-- メールアドレスが未入力の場合エラーを表示する -->
                        <?php if (isset($error['email']) && $error['email'] === 'blank') : ?>
                            <h5 class="error">*ニックネームが未入力です。入力してください!</h5>
                        <?php endif; ?>
                    </dd>

                    <!------------------------------------------------------------------------------------------------------>

                    <dt>お問い合わせ内容<span class="error">[必須]</span></dt>
                    <dd>
                        <!-- <input class="message" type="text" name="message" placeholder="お問い合わせ内容を記入して下さい。" value="<?php echo htmlspecialchars($form['message']); ?>"> -->

                        <textarea name="message" cols="60" rows="15"></textarea>

                        <?php if (isset($error['message']) && $error['message'] === 'blank') : ?>
                            <h5 class="error">*お問いわせ内容を記入して下さい。</h5>
                        <?php endif; ?>
                    </dd>

                    <!------------------------------------------------------------------------------------------------------>

                    <!-- 送信ボタン -->
                    <button class="btn btn-radius-solid btn--shadow">確認</button>
            </form>
        </div>
    </div>
</body>

</html>