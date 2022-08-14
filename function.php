<?php
/* DBへの接続 */
function db_connection()
{
    $db = new mysqli('localhost', 'root', 'root', 'user_db');

    // エラー表示
    if (!$db) {
        die($db->error);
    }

    return $db;
}
