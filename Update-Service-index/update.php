<?php
require('../db.php');
$db = new mysqli('localhost', 'root', 'root', 'user_db');
$stmt = $db->prepare('select * from keizi where id=?');
if (!$stmt) {
    die($db->error);
}
$update_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$stmt->bind_param('i', $update_id);
$stmt->execute();

$stmt->bind_result($id, $message, $field, $course, $days, $Expectation, $Understanding, $Communication, $good, $bad, $trouble, $Comprehensive, $link, $member_id, $created, $modifile);
$result = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="../Css/Service-update.css">
    <title>Document</title>
</head>

<body>

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
                <li><a href="../Service-index/home.php"><i class="fa fa-briefcase"></i><span>Service</span></a></li>
                <li><a href="#"><i class="fa-solid fa-file-signature"></i><span>Contact</span></a></li>

            </ul>
        </div>

        <div class="content">
            <form action="./update_do.php" method="post">

                <input type="hidden" name="id" value="<?php echo $update_id; ?>">

                <div class="user-box">
                    <label>企業名</label>
                    <input type="text" name="message" required value="<?php echo $message; ?>">
                </div>

                <div class="user-check">
                    <label>参加した業種</label>
                    <input type="radio" name="field" required value="メーカー"> メーカー
                    <input type="radio" name="field" value="商社"> 商社
                    <input type="radio" name="field" value="流通、小売"> 流通、小売
                    <input type="radio" name="field" value="金融"> 金融
                    <input type="radio" name="field" value="サービス、インフラ"> サービス、インフラ
                    <br>
                    <input class="tag" type="radio" name="field" value="ソフトウェア、通信"> ソフトウェア、通信
                    <input type="radio" name="field" value="広告、出版、マスコミ"> 広告、出版、マスコミ
                    <input type="radio" name="field" value="官公庁、公社、団体"> 官公庁、公社、団体

                </div>

                <div class="user-box">
                    <label>参加したカリキュラム、コース</label>
                    <input type="text" name="course" required value="<?php echo $course; ?>">
                </div>



                <div class="user-check">
                    <label>参加した日数</label>
                    <input type="radio" name="day" required value="1日"> 1日
                    <input type="radio" name="day" value="2日〜5日程度"> 2日〜5日程度
                    <input type="radio" name="day" value="1週間程度"> 1週間程度
                    <input type="radio" name="day" value="2週間程度"> 2週間程度
                    <input type="radio" name="day" value="1ヶ月程度"> 1ヶ月程度
                    <input class="tag" type="radio" name="day" value="1ヶ月以上"> 1ヶ月以上
                </div>

                <div class="user-check">
                    <label class="only">※各項目を5段階で評価してください</label>
                    <br>
                    <p>
                        1、満足していない
                        2、どちらかといえば満足していない
                        3、どちらともいえない
                        <br>
                        4、どちらかといえば満足している
                        5、満足している
                    </p>
                </div>

                <div class="user-check">
                    <label>体験内容は満足できる内容でしたか？</label>
                    <input type="radio" name="Expectation" required value="満足していない"> 1
                    <input type="radio" name="Expectation" value="どちらかといえば満足していない"> 2
                    <input type="radio" name="Expectation" value="どちらともいえない"> 3
                    <input type="radio" name="Expectation" value="どちらかといえば満足している"> 4
                    <input type="radio" name="Expectation" value="満足している"> 5
                </div>

                <div class="user-check">
                    <label>業種や職種、企業について理解できましたか？</label>
                    <input type="radio" name="Understanding" required value="満足していない"> 1
                    <input type="radio" name="Understanding" value="どちらかといえば満足していない"> 2
                    <input type="radio" name="Understanding" value="どちらともいえない"> 3
                    <input type="radio" name="Understanding" value="どちらかといえば満足している"> 4
                    <input type="radio" name="Understanding" value="満足している"> 5
                </div>

                <!-- <div class="user-check">
                <label>社員とのコミュニケーションはどうでしたか？</label>
                <input type="radio" name="Communication" required value="満足している"> 1
                <input type="radio" name="Communication" value="どちらかといえば満足している"> 2
                <input type="radio" name="Communication" value="どちらともいえない"> 3
                <input type="radio" name="Communication" value="どちらかといえば満足していない"> 4
                <input type="radio" name="Communication" value="満足していない"> 5
            </div> -->

                <div class="user-check">
                    <label>社員、講師のサポートはどうでしたか？</label>
                    <input type="radio" name="Communication" required value="満足していない"> 1
                    <input type="radio" name="Communication" value="どちらかといえば満足していない"> 2
                    <input type="radio" name="Communication" value="どちらともいえない"> 3
                    <input type="radio" name="Communication" value="どちらかといえば満足している"> 4
                    <input type="radio" name="Communication" value="満足している"> 5
                </div>

                <div class="user-text">
                    <label>インターンシップの良かった所、印象に残っている所、参考になった所を教えてください</label>
                    <textarea name="good" required><?php echo $good ?></textarea>
                </div>

                <div class="user-text">
                    <label>インターンシップの良くなかった所、期待はずれだった所があれば教えてください</label>
                    <textarea name="bad" placeholder="空白でも投稿できます"><?php echo $bad ?></textarea>
                </div>

                <div class="user-text">
                    <label>インターンシップの困った所、よく分からなかった所があれば教えてください</label>
                    <textarea name="trouble" placeholder="空白でも投稿できます"><?php echo $trouble;  ?></textarea>
                </div>

                <div class="user-check">
                    <label>今回参加した企業のインターンシップを総合的に判断してください</label>
                    <br>
                    <input type="radio" name="Comprehensive" required value="満足していない"> 1
                    <input type="radio" name="Comprehensive" value="どちらかといえば満足していない"> 2
                    <input type="radio" name="Comprehensive" value="どちらともいえない"> 3
                    <input type="radio" name="Comprehensive" value="どちらかといえば満足している"> 4
                    <input type="radio" name="Comprehensive" value="満足している"> 5
                </div>

                <div class="user-text">
                    <label>応募したページのリンクを貼り付けてください</label>
                    <textarea required name="link"><?php echo $link ?></textarea>
                </div>


                <button><i class="fa-solid fa-pen"></i>投稿する</button>
            </form>
        </div>
    </body>

</html>
</body>

</html>