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
        <link rel="stylesheet" type="text/css" href="css.css">
    </head>
    <body>
    <h1>Bueler-Faudree Blog</h1>
<?php
    if($_SESSION['user_auth']>=1){
        switch($_GET['action']) {
            case 'view':
                echo '<br>';
                echo '<a href="blog.php?action=post">Post</a>';
                echo '<br>';
                echo '<a href="index.php">Sign Out</a>';
                if($_SESSION['user_auth']==5){
                    echo '<br>';
                    echo '<a href="blog.php?action=admin">Admin</a>';
                }
                $query = 'SELECT post_title, post_content, post_date FROM post_word';
                $sql = mysql_query($query, $db) or die(mysql_error($db));
                while ($row = mysql_fetch_assoc($sql)) {
                    echo '<div class="post"><h2>'. $row['post_title'] . '</h2>';
                    echo '<p>'. $row['post_content'] . '</p>';
                    echo '<p>'. $row['post_date'] . '</p></div>';
                }
                break;
            case 'post':
                $edit = $_GET['edit-post'];
                $id = $_GET['id'];
                if($_SESSION['user_auth']==5){
                    if($edit=='edit'){
                        $query = 'SELECT post_title, post_content FROM post_word WHERE post_word_id =' . $id;
                        $sql = mysql_query($query, $db) or die(mysql_error($db));
                        while ($row = mysql_fetch_assoc($sql)) {
                            $title=$row['post_title'];
                            $content=$row['post_content'];
                        }
                    }
                }
                ?>
                <form action="transaction.php?action=post<?php if($edit=='edit'){echo '&edit-post=edit&id='.$id;}?>" method="post">
                  <p>Title:</p>
                  <input type="text" name="title" value="<?php echo $title;?>">
                  <p>Body:</p>
                  <textarea rows="4" cols="50" name="content">
                    <?php echo $content;?>
                  </textarea>
                  <input type="submit" value="post">
                </form>
                <?php
                break;
            case 'admin':
                if($_SESSION['user_auth']==5){
                    echo '<br><a href="blog.php?action=view">Home</a>';
                    $query = 'SELECT user_id, user_name, user_auth FROM users';
                    $sql = mysql_query($query, $db) or die(mysql_error($db));
                    echo '<br><a href="blog.php?action=add">Add User</a><h2>Users</h2><table>';
                    while ($row = mysql_fetch_assoc($sql)) {
                        echo '<tr>';
                        foreach ($row as $value) {
                            echo '<td>' . $value . '</td>';
                        }
                        echo'<td><a href="transaction.php?action=delete&what=user&id=' . $row['user_id'] . '">Delete</a></td>';
                    }
                    echo '</table>';
                    $query = 'SELECT post_word_id, post_title, post_date, post_user_id FROM post_word';
                    $sql = mysql_query($query, $db) or die(mysql_error($db));
                    echo '<h2>Posts</h2>';
                    echo '<table>';
                    while ($row = mysql_fetch_assoc($sql)) {
                        echo '<tr>';
                        foreach ($row as $value) {
                            echo '<td>' . $value . '</td>';
                        }
                        echo'<td><a href="transaction.php?action=delete&what=post&id=' . $row['post_word_id'] . '">Delete</a></td><td><a href="blog.php?action=post&edit-post=edit&id='. $row['post_word_id'] . '">Edit</a></td>';
                    }
                    echo '</table>';
                }
                break;
            case 'add':
?>
                <form action="transaction.php?action=add" method="post">
                    Username:
                    <input type="text" name="name">
                    Password:
                    <input type="password" name="pass">
<?php
                if($_SESSION['user_auth']==5){
?>
                    Security Level
                    <select name="auth">
<?php
                    for($total=1;$total<=5;$total++){
                        echo '<option value="' . $total . '">' . $total . '</option>';
                    }
                }
                echo'
                <input type="submit" value="Add User">
                </form>';
                break;
        }
    }elseif($_SESSION['user_auth']=0){
        echo'You are signed in, but you don\'t have the privilages to view the blog';
    }else{
        header("Location: index.php");
    }
?>

