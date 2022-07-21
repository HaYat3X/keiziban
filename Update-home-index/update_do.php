<?php
$db = new mysqli('localhost', 'root', 'root', 'user_db');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ユーザーの入力値を変数に代入
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $message = filter_input(INPUT_POST, 'memo', FILTER_SANITIZE_STRING);


    $image = $_FILES['image'];

    if (
        $image['name'] !== '' && $image['error'] === 0
    ) {
        $type = mime_content_type($image['tmp_name']);
        // 写真の形式がjpegまたはpngでない場合という条件を追加する
        if ($type !== 'image/jpeg' && $type !== 'image/png') {
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

        $stmt = $db->prepare('update posts set message=?, picture=? where id=?');
        if (!$stmt) {
            die($db->error);
        }

        $stmt->bind_param('ssi', $message, $filename, $id);
        $success = $stmt->execute();
        if (!$success) {
            die($db->error);
        }

        header('Location: ../Home-index/home.php?id=' . $id);
    }
}
