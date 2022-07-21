<?php
try {
    //DBに接続
    $dsn = 'mysql:dbname=user_db; host=localhost';
    $username = 'root';
    $password = 'root';
    $pdo = new PDO($dsn, $username, $password);

    //SQL文を実行して、結果を$stmtに代入する。
    $stmt = $pdo->prepare(" SELECT * FROM posts WHERE message LIKE '%" . $_POST["search_name"] . "%' order by id desc");
    //実行する
    $stmt->execute();
} catch (PDOException $e) {
    echo "接続エラー:" . $e->getMessage() . "\n";
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/search.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

    <title>キーワード検索</title>
</head>

<body>

    <div class="header">
        <div class="header-nav">
            <img src="../img/名称未設定-3.png" alt="" width="80" height="80">
            <a href="../Home-index/home.php">
                <h1>Real intentioN</h1>
            </a>
        </div>

        <ul>
            <li><a href="../Home-index/home.php"><i class="fa-solid fa-house"></i><span>Home</span></a></li>
            <li><a href="../Home-index/myprofile.php?id=<?php echo htmlspecialchars($id); ?>"><i class=" fa fa-user"></i><span>Profile</span></a></li>
            <li><a href="#"><i class="fa fa-briefcase"></i><span>Service</span></a></li>
            <li><a href="#"><i class="fa-solid fa-file-signature"></i><span>Contact</span></a></li>

        </ul>
    </div>
    <!--　ヘッダーエリア　-->


    <div class="home">
        <a href="../Home-index/home.php">ホームへ</a>
    </div>





    <!-- ここでPHPのforeachを使って結果をループさせる -->


    <?php foreach ($stmt as $row) : ?>


        <div class="result">


            <h3>
                <a href="./myprofile.php?id=<?php echo htmlspecialchars($row[2]); ?>">
                    <?php echo '@user' . $row[2]; ?>
                </a>
            </h3>
            <h3>
                <?php echo $row[1]; ?>
            </h3>
            <div class="img">
                <?php if ($row[3]) : ?>
                    <img src="../picture/<?php echo htmlspecialchars($row[3]); ?>" alt="">
                <?php endif; ?>
            </div>

            <small>
                <?php echo $row[4]; ?>
            </small>

        </div>






    <?php endforeach; ?>



    <!-- フッターエリア -->
    <footer>
        サイト管理者　竹田　颯<br>
        ご意見、ご要望をお待ちしています。
    </footer>
</body>

</html>