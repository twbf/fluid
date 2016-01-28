<?php
session_start();
    require 'mysql-connect.inc.php';
    $db = mysql_connect(mysql_host,mysql_user,mysql_pass)or die('fail');
    mysql_select_db(mysql_database, $db) or die(mysql_error($db));
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="css.css">
        <meta charset="utf-8">
    </head>
    <body>
    <h1>Bueler-Faudree Blog</h1>
    <?php
        if(isset($_POST['username'])){
        //getting variable's
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['pass'] = $_POST['password'];
            $_SESSION['mysql_name']= '"'.$_SESSION['name'].'"';
            $_SESSION['mysql_pass'] = '"'.$_SESSION['pass'].'"';
            $query = 'SELECT user_auth FROM users WHERE user_name = ' . $_SESSION['mysql_name'] . 'AND user_pass ="' . md5($_SESSION['pass']) . '"';
            $auth = mysql_query($query, $db) or die(mysql_error($db));
            while ($row = mysql_fetch_assoc($auth)) {
               foreach ($row as $value) {
                   $user_auth .= $value;
               }
            }
            $_SESSION['user_auth'] = $user_auth; 
            if (isset($_SESSION['user_auth'])){
                header("Location: blog.php?action=view");
            }else{
                echo 'You either supplied the wrong credintials or you are not a user and need to <a href="blog.php?action=add">registar</a>';
            }
        }else{
    ?>
            <form action="index.php" method="post">
              Username:
              <input type="text" name="username">
              Password:
              <input type="password" name="password">
              <input type="submit" value="Sign In">
            </form>
            <form action="blog.php?action=add" method="post">
              <input type="submit" value="Registar">
            </form>
    <?php
        }
    ?>
    </body>
</html>
