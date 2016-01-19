<?php
session_start();
$db = mysql_connect('127.0.0.1','root', 'abcdef')or die('fail');
    mysql_select_db('admin', $db) or die(mysql_error($db));
?>
<!DOCTYPE html>
        <?php include 'home-same.php';?>
        <div class="content">
        </div>
    </body>
</html>
