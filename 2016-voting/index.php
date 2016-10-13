<?php
session_start();
$db = mysql_connect('localhost','root', 'abcdef')or die('fail');
    mysql_select_db('admin', $db) or die(mysql_error($db));
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css.css">
    </head>
    <body>
        <h1>2016 Bueler-Faudree Presidential Voting</h1>
        <h2>Please sign in to vote.</h2>
        <div class="content">
            <form action="vote.php" method="post">
                Name:
                <input type="text" name="name">
                Birth Year:
                <select name="birth-year">
                <?php
                for($total=2016;$total>1900;$total--){
                    echo '<option value="' . $total . '">' . $total . '</option>';
                }
                ?>
                <input type="submit" value="Sign In">
            </form>
        </div>
    </body>
</html>
