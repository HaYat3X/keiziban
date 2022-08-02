<?php

// セッションスタート
session_start();

// function呼び出し
require('../db.php');


// 書き直しのために指定した値(Tofix)を呼び出す
if (isset($_GET['action']) && $_GET['action'] === 'Tofix' && isset($_SESSION['form'])) {
    $form = $_SESSION['form'];
    // 何も書かれていない場合は初期画面へ
} else {
    // エラー回避のために配列を初期化しておく
    $form = [
        'nickname' => '',
        'birth' => '',
        'email' => '',
        'password' => '',
        'tel' => '',
    ];
}

$error = [];

//---------------------------------------------------------------------------------------------------------------------------

// フォームの入力内容をチェックする
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // nameの入力内容をチェックする
    $form['nickname'] = filter_input(INPUT_POST, 'nickname', FILTER_SANITIZE_STRING);
    // nameが空白(blank)であればという条件を追加する
    if ($form['nickname'] === '') {
        $error['nickname'] = 'blank';
    }

    // 生年月日の入力内容をチェックする
    $form['birth'] = filter_input(INPUT_POST, 'birth', FILTER_SANITIZE_STRING);
    // birthが空白(blank)であればという条件を追加する
    if ($form['birth'] === '') {
        $error['birth'] = 'blank';
    }

    // emailの入力内容をチェックする
    $form['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    // emailが空白(blank)であればという条件を追加する
    if ($form['email'] === '') {
        $error['email'] = 'blank';

        // emailが重複している場合という条件を追加する
    } else {
        // データベースとの接続
        $db = dbconnection();
        $stmt = $db->prepare('select count(*) from members where email=?');
        $stmt->bind_param('s', $form['email']);
        $success = $stmt->execute();

        // countの結果を変数(Result_is)に代入
        $stmt->bind_result($Result_is);

        // 0か1で重複を判断する
        $stmt->fetch();

        // 数字が0以上ならば重複だから　$Result_isが0以上の時エラーを表示するという条件を追加する
        if ($Result_is > 0) {
            $error['email'] = 'duplicate';
        }
    }

    // telの入力内容をチェックする
    $form['tel'] = filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_STRING);
    // telが空白(blank)であればという条件を追加する
    if ($form['tel'] === '') {
        $error['tel'] = 'blank';

        // 携帯電話番号が重複している場合エラーを表示する
    } else {
        $db = dbconnection();
        $stmt = $db->prepare('select count(*) from members where tel=?');
        $stmt->bind_param('s', $form['tel']);
        $success = $stmt->execute();

        // countの結果を変数(Result_is)に代入
        $stmt->bind_result($Result_is);

        // 0か1で重複を判断する
        $stmt->fetch();

        // 数字が0以上ならば重複だから　$Result_isが0以上の時エラーを表示するという条件を追加する
        if ($Result_is > 0) {
            $error['tel'] = 'duplicate';
        }
    }

    // passwordの入力内容をチェックする
    $form['password'] = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    // passwordが空白(blank)であればという条件を追加する
    if ($form['password'] === '') {
        $error['password'] = 'blank';
        // passwordが6文字以下(length)であればという条件を追加する
    } else if (strlen($form['password']) < 6) {
        $error['password'] = 'length';
    }

    // 画像をチェックする
    $image = $_FILES['image'];

    if ($image['name'] !== '' && $image['error'] === 0) {
        $type = mime_content_type($image['tmp_name']);
        // 写真の形式がjpegまたはpngでない場合という条件を追加する
        if ($type !== 'image/jpeg' && $type !== 'image/png') {
            $error['image'] = 'type';
        }
    }

    if (empty($error)) {
        $_SESSION['form'] = $form;

        // 画像のアップロード
        if ($image['name'] !== '') {
            $filename = date('YmdHis') . '_' . $image['name'];
            if (!move_uploaded_file($image['tmp_name'], '../member_picture/' . $filename)) {
                die('ファイルのアップロードに失敗しました');
            }
            $_SESSION['form']['image'] = $filename;
        } else {
            $_SESSION['form']['image'] = '';
        }

        // すべてにエラーがない場合確認画面に移動する
        header('Location: check.php');
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
    <link rel="stylesheet" href="../Css/welcome.css">
    <title>アカウント作成 / Real intentioN</title>
    <link rel="icon" href="../img/名称未設定-3.png">
    <!-- font-awesomeのインポート -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
</head>

<body>

    <div class="header">
        <img src="../img/favicon.png" alt="">
        <h1>Real intentioN</h1>
    </div>


    <div class="content">
        <div class="msg">
            <h1>
                Register<br>
                Real intentioN
            </h1>


        </div>

        <div class="Register">



            <form action="" method="post" enctype="multipart/form-data">

                <ul class="progressbar">
                    <li class="active">ご入力</li>
                    <li>ご確認</li>
                    <li>完了</li>
                </ul>

                <div class="user-box">
                    <input required type="text" name="nickname" maxlength="33" placeholder="　ユーザー名　例：User1" value="<?php echo htmlspecialchars($form['nickname']); ?>">
                </div>

                <div class="user-box">



                    <input required type="date" name="birth" placeholder="　生年月日　例：2004-02/21" value="<?php echo htmlentities($form['birth']); ?>">


                </div>

                <div class="user-box">



                    <input required type="email" name="email" placeholder="　メールアドレス　例：info@co.jp" maxlength="30" value="<?php echo htmlspecialchars($form['email']); ?>">



                    <!-- メールアドレスが重複している場合エラーを表示する -->
                    <?php if (isset($error['email']) && $error['email'] === 'duplicate') : ?>
                        <h5 class="error">*指定のメールアドレスは既に登録されています。ログインしてください。</h5>
                    <?php endif; ?>
                </div>



                <div class="user-box">



                    <input required type="tel" name="tel" placeholder="　携帯電話番号　例：012345678910" pattern="\d{11}" value="<?php echo htmlspecialchars($form['tel']); ?>">


                    <!-- 携帯電話番号が重複している場合エラーを表示する -->
                    <?php if (isset($error['tel']) && $error['tel'] === 'duplicate') : ?>
                        <h5 class="error">*指定の携帯電話番号は既に登録されています。ログインしてください。</h5>
                    <?php endif; ?>
                </div>

                <div class="user-box">



                    <input required type="password" name="password" placeholder="　パスワード　例：••••••" maxlength="200" value="">



                    <!-- パスワードが6文字以下の場合エラーを表示する -->
                    <?php if (isset($error['password']) && $error['password'] === 'length') : ?>
                        <h5 class="error">*パスワードは6文字以上で入力してください!</h5>
                    <?php endif; ?>
                </div>


                <div class="user-box">



                    <input type="file" name="image" size="30" value="">

                    <!-- 指定された画像が(JPG)形式でなければエラーを表示する -->
                    <?php if (isset($error['image']) && $error['image'] === 'type') : ?>
                        <h5 class="error">*画像はJPG形式またはPNG形式で指定してください!</h5>
                    <?php endif; ?>
                </div>





                <!------------------------------------------------------------------------------------------------------>

                <!-- 送信ボタン -->
                <button>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    入力内容を確認する
                </button>

            </form>
        </div>
    </div>

    <div class="footer">
        <div class="SNS">
            <a href="https://github.com/Hayate12345"><i class="fa-brands fa-github"></i>Hayate12345</a>
            <a href="https://twitter.com/hayate_KIC"><i class="fa-brands fa-twitter"></i>hayate_KIC</a>
        </div>

        <p>2022-08/01 Hayate-studio</p>
    </div>

    <main>
        <div class="card">
            <div class="content">

                <!---------------------------------------------------------------------------------------------------------->

                <!-- ステップバーの制御-->
                <div class="progressbar">

                </div>

                <!---------------------------------------------------------------------------------------------------------->

                <!-- タイトル文字 -->
                <h2>アカウントを作成</h2>
                <form action="" method="post" enctype="multipart/form-data">


                    <div class="user-box">
                        <input required type="text" name="nickname" maxlength="33" placeholder="　ユーザー名　例：User1" value="<?php echo htmlspecialchars($form['nickname']); ?>">
                    </div>

                    <div class="user-box">



                        <input required type="date" name="birth" placeholder="　生年月日　例：2004-02/21" value="<?php echo htmlentities($form['birth']); ?>">


                    </div>

                    <div class="user-box">



                        <input required type="email" name="email" placeholder="　メールアドレス　例：info@co.jp" maxlength="30" value="<?php echo htmlspecialchars($form['email']); ?>">



                        <!-- メールアドレスが重複している場合エラーを表示する -->
                        <?php if (isset($error['email']) && $error['email'] === 'duplicate') : ?>
                            <h5 class="error">*指定のメールアドレスは既に登録されています。ログインしてください。</h5>
                        <?php endif; ?>
                    </div>



                    <div class="user-box">



                        <input required type="tel" name="tel" placeholder="　携帯電話番号　例：012345678910" pattern="\d{11}" value="<?php echo htmlspecialchars($form['tel']); ?>">


                        <!-- 携帯電話番号が重複している場合エラーを表示する -->
                        <?php if (isset($error['tel']) && $error['tel'] === 'duplicate') : ?>
                            <h5 class="error">*指定の携帯電話番号は既に登録されています。ログインしてください。</h5>
                        <?php endif; ?>
                    </div>

                    <div class="user-box">



                        <input required type="password" name="password" placeholder="　パスワード　例：••••••" maxlength="200" value="">



                        <!-- パスワードが6文字以下の場合エラーを表示する -->
                        <?php if (isset($error['password']) && $error['password'] === 'length') : ?>
                            <h5 class="error">*パスワードは6文字以上で入力してください!</h5>
                        <?php endif; ?>
                    </div>


                    <div class="user-box">



                        <input type="file" name="image" size="30" value="">

                        <!-- 指定された画像が(JPG)形式でなければエラーを表示する -->
                        <?php if (isset($error['image']) && $error['image'] === 'type') : ?>
                            <h5 class="error">*画像はJPG形式またはPNG形式で指定してください!</h5>
                        <?php endif; ?>
                    </div>





                    <!------------------------------------------------------------------------------------------------------>

                    <!-- 送信ボタン -->
                    <button>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        入力内容を確認する
                    </button>

                </form>
            </div>
        </div>
    </main>
</body>

</html>