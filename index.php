<?php
session_start();
    require 'mysql-connect.inc.php';
    $db = mysqli_connect(mysql_host,mysql_user,mysql_pass)or die('fail');
    mysqli_select_db(mysql_database, $db)
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css.css">
    </head>
    <body>
    <div class="header">
        <h1>Bueler-Faudree Blog</h1>
        <nav>
            <ul>
                <li><a href="?action=view">Home</a></li>
                <li><a href="?action=post">Post</a></li>
                <li><a href="index.php">Sign Out</a></li>
                <?php if($_SESSION['user_auth']==5){echo '<li><a href="?action=admin">Admin</a></li>';} ?>
            </ul>
        </nav>
    </div>
    <?php
        if(isset($_POST['username'])){
        //getting variable's
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['pass'] = $_POST['password'];
            $_SESSION['mysql_name']= '"'.$_SESSION['name'].'"';
            $_SESSION['mysql_pass'] = '"'.$_SESSION['pass'].'"';
            $query = 'SELECT user_auth, user_id FROM users WHERE user_name = ' . $_SESSION['mysql_name'] . 'AND user_pass ="' . md5($_SESSION['pass']) . '"';
            $auth = mysqli_query($query, $db);
            while ($row = mysqli_fetch_assoc($auth)) {
                $_SESSION['user_auth'] = $row['user_auth'];
                $_SESSION['user_id'] = $row['user_id'];
            }
            $query = 'SELECT first, last, email FROM user_info WHERE user_id=' . $_SESSION['user_id'];
            $mysql = mysqli_query($query, $db);
            while ($row = mysqli_fetch_assoc($mysql)) {
                $_SESSION['fullName'] = $row['first'] .' '. $row['last'];
                $_SESSION['email'] = $row['email'];
            }
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
