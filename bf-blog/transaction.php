<?php
session_start();
    require 'mysql-connect.inc.php';
    $db = mysql_connect(mysql_host,mysql_user,mysql_pass)or die('fail');
    mysql_select_db(mysql_database, $db) or die(mysql_error($db));
    $query = 'INSERT INTO users (user_id, user_name,user_pass,user_auth) VALUES (NULL,"Thomas","'. md5('T547mile').'",5)';
    $auth = mysql_query($query, $db) or die(mysql_error($db));
    echo 'success';
?>
