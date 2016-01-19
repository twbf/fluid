<?php
session_start();
    require 'mysql-connect.inc.php';
    $db = mysql_connect(mysql_host,mysql_user,mysql_pass)or die('fail');
    mysql_select_db(mysql_database, $db) or die(mysql_error($db));
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
    <h1>Bueler-Faudree Blog</h1>
<?php
    if($_SESSION['user_auth']>=1){
        switch($_GET['action']) {
            case 'view':
                echo 'Their are currently no posts';
                echo '<a href="blog.php?action=post">Post</a>';
                break;
            case 'post':
                ?>
                <form action="blog.php" method="post">
                  Title:
                  <input type="text" name="username">
                  Body:
                  <textarea rows="4" cols="50">
                    
                  </textarea>
                  <input type="submit" value="Sign In">
                </form>
                <?php
                break;
        }
    }elseif($_SESSION['user_auth']=0){
        echo'You are signed in, but you don\'t have the privilages to view the blog';
    }else{
        header("Location: index.php");
    }
?>

