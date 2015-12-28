<?php
session_start();
$db = mysql_connect('localhost','root', 'abcdef')or die('fail');
    mysql_select_db('admin', $db) or die(mysql_error($db));
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="home-css.css">
    </head>
    <body>
        <?php include 'home-same.php';?>
        <div class="content">
        </div>
    </body>
</html>
