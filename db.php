<?php
/* DBへの接続 */
function dbconnection()
{
    $db = new mysqli('localhost', 'root', 'root', 'user_db');
    if (!$db) {
        die($db->error);
    }

    return $db;
}
