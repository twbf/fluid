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
                $query = 'SELECT post_title, post_content, post_date FROM post_word';
                $sql = mysql_query($query, $db) or die(mysql_error($db));
                while ($row = mysql_fetch_assoc($sql)) {
                    echo '<h2>'. $row['post_title'] . '</h2>';
                    echo '<p>'. $row['post_content'] . '</p>';
                    echo '<p>'. $row['post_date'] . '</p>';
                }
                echo $posts;
                echo '<br>';
                echo '<a href="blog.php?action=post">Post</a>';
                break;
            case 'post':
                ?>
                <form action="transaction.php?action=post" method="post">
                  <p>Title:</p>
                  <input type="text" name="title">
                  <p>Body:</p>
                  <textarea rows="4" cols="50" name="content">
                    
                  </textarea>
                  <input type="submit" value="post">
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
