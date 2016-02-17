<?php
session_start();
    if(gethostname() == 'bueler-gazelle'){
        require 'local-mysql-connect.inc.php';
    }else{
        require 'mysql-connect.inc.php';
    }
    $db = mysqli_connect(mysql_host,mysql_user,mysql_pass);
    mysqli_select_db($db, mysql_database)
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css.css">
        <link rel="stylesheet" type="text/css" href="css.css">
        <link rel="apple-touch-icon" sizes="57x57" href="screen/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="screen/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="screen/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="screen/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="screen/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="screen/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="screen/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="screen/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="screen/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="screen/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="screen/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="screen/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="screen/favicon-16x16.png">
        <link rel="manifest" href="screen/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="screen/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="js.js"></script>
    </head>
    <body>
    <div class="header">
        <h1>Bueler-Faudree Blog</h1>
        <nav>
            <ul>
            <?php
                if(isset($_POST['username'])){
        
                $_SESSION['name'] = $_POST['username'];
                $_SESSION['pass'] = $_POST['password'];
                $_SESSION['mysql_name']= '"'.$_SESSION['name'].'"';
                $_SESSION['mysql_pass'] = '"'.$_SESSION['pass'].'"';
                $query = 'SELECT user_auth, user_id FROM users WHERE user_name = ' . $_SESSION['mysql_name'] . 'AND user_pass ="' . md5($_SESSION['pass']) . '"';
                $auth = mysqli_query($db, $query);
                while ($row = mysqli_fetch_assoc($auth)) {
                    $_SESSION['user_auth'] = $row['user_auth'];
                    $_SESSION['user_id'] = $row['user_id'];
                }
                $query = 'SELECT first, last, email FROM user_info WHERE user_id=' . $_SESSION['user_id'];
                $mysql = mysqli_query($db, $query);
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
                echo $_GET['warning'];
                ?>
                <form action="index.php" method="post">
                  Username:
                  <input type="text" name="username">
                  Password:
                  <input type="password" name="password">
                  <input type="submit" value="Log In">
                </form>
                
                <?php
            }
                ?>
            </ul>
        </nav>
    </div>
    <div class="content">
        <div class="post" id="p0">
            <h2>Please Registar</h2>
            <form action="blog.php?action=add" method="post">
              <input type="submit" value="Registar">
            </form>
            <p>Once you registar you will get an email when your account gets activated. It can take as much as 24 hours for that to happen.</p>
            <p>Until we have a better hosting plan and security system the blog users are limited to family and friends of Thomas Bueler</p>
        </div>
        <div class="post" id="p1">
            <h2>Support/
            Administrator</h2>
            <p>Thomas Bueler</p>
            <p>Email: <a href="mailto:twbf@bf-blog.esy.es">twbf@bf-blog.esy.es</a></p>
            <p>Website #1: <a href="http://twbf.github.io">twbf.github.io</a></p>
            <p>Wedsite #2: <a href="http://twbf.esy.es">twbf.esy.es</a></p>
        </div>
        <footer>
            Copyright &copy; 2016 TWBF All rights reserved.
        </footer>
    </div>
    </body>
</html>
