<?php
session_start();
    if($_SESSION['user_auth']>=1){
    require 'mysql-connect.inc.php';
    $db = mysql_connect(mysql_host,mysql_user,mysql_pass)or die('fail');
    mysql_select_db(mysql_database, $db) or die(mysql_error($db));
    
    $query = 'SELECT first, last FROM user_info WHERE user_id=' . $_SESSION['user_id'];
    $mysql = mysql_query($query, $db) or die(mysql_error($db));
    while ($row = mysql_fetch_assoc($mysql)) {
        $fullName = $row['first'] .' '. $row['last'];
    }
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
                <li><a href="transaction.php?action=signout">Sign Out</a></li>
                <?php if($_SESSION['user_auth']==5){echo '<li><a href="?action=admin">Admin</a></li>';} ?>
                <li><?php echo $fullName; ?></li>
            </ul>
        </nav>
    </div>
    <div class="content">
<?php
        function getPicture($rowid){
            global $db;
            $query1 = 'SELECT post_picture_id FROM post WHERE post_word_id=' . $rowid;
            $mysql = mysql_query($query1, $db) or die(mysql_error($db));
            while ($row1 = mysql_fetch_assoc($mysql)) {
                $query = 'SELECT picture_location FROM post_picture WHERE post_picture_id=' . $row1['post_picture_id'];
                $mysql1 = mysql_query($query, $db) or die(mysql_error($db));
                while ($row2 = mysql_fetch_assoc($mysql1)) {
                    echo '<img src="images/' . $row2['picture_location'] . ' ">';
                    return;
                }
            }
        }
        switch($_GET['action']) {
            case 'view':
                echo '<div class="coll">';
                $query = 'SELECT * FROM post_word ORDER BY post_date DESC';
                $sql = mysql_query($query, $db) or die(mysql_error($db));
                while ($row = mysql_fetch_assoc($sql)) {
                    echo '<a href="?action=bigview&id=' .$row['post_word_id']. '"><div class="post">';
                    getPicture($row['post_word_id']);
                    echo '<h2>'. $row['post_title'] . '</h2>';
                    echo '<p>'. substr($row['post_content'], 0, 100) . '...</p>';
                    echo '<p class="small">'. $row['post_date'] . '</p>';
                    if($_SESSION['user_id']==$row['post_user_id']){
                        echo'<p><a href="?action=post&edit-post=edit&id=' . $row['post_word_id'] . '">Edit</a></p>'; 
                    }  
                    echo '</div></a>';
                }
                echo '</div>';
                break;
            case 'bigview':
                $query = 'SELECT * FROM post_word WHERE post_word_id=' . $_GET['id'];
                $sql = mysql_query($query, $db) or die(mysql_error($db));
                while ($row = mysql_fetch_assoc($sql)) {
                    echo '<div class="post">';
                    getPicture($row['post_word_id']);
                    echo '<h2>'. $row['post_title'] . '</h2>';
                    echo '<p>'. $row['post_content'] . '</p>';
                    echo '<p class="small">'. $row['post_date'] . '</p>';
                    if($_SESSION['user_id']==$row['post_user_id']){
                        echo'<p><a href="?action=post&edit-post=edit&id=' . $row['post_word_id'] . '">Edit</a></p>'; 
                    }  
                    echo '</div>';
                }
                break;
            case 'post':
                $edit = $_GET['edit-post'];
                $id = $_GET['id'];
                if($_SESSION['user_auth']==5 or $_SESSION['user_auth']){
                    if($edit=='edit'){
                        $query = 'SELECT post_title, post_content FROM post_word WHERE post_word_id =' . $id;
                        $sql = mysql_query($query, $db) or die(mysql_error($db));
                        while ($row = mysql_fetch_assoc($sql)) {
                            $title=$row['post_title'];
                            $content=$row['post_content'];
                        }
                    }
                }
                echo '<form action="transaction.php?action=post';
                if($edit=='edit'){
                    echo '&edit-post=edit&id='.$id;
                }
                echo '" method="POST" enctype= "multipart/form-data" ><p>Title:</p><input type="text" name="title" value="' . $title . '"><p>Body:</p><textarea rows="4" cols="50" name="content">' . $content . '</textarea><p>If you would like a picture to appear with your post please select one</p><input type="hidden" name="MAX_FILE_SIZE" value="2000000"/><input type="file" name="picture"><input type="submit" value="post"></form>';
                break;
            case 'admin':
                if($_SESSION['user_auth']==5){
                    $query = 'SELECT user_id, user_name, user_auth FROM users';
                    $sql = mysql_query($query, $db) or die(mysql_error($db));
                    echo '<br><a href="?action=add">Add User</a><h2>Users</h2><table>';
                    while ($row = mysql_fetch_assoc($sql)) {
                        echo '<tr>';
                        foreach ($row as $value) {
                            echo '<td>' . $value . '</td>';
                        }
                        $query = 'SELECT first, last, email FROM user_info WHERE user_id=' . $row['user_id'];
                        $mysql = mysql_query($query, $db) or die(mysql_error($db));
                        while ($row1 = mysql_fetch_assoc($mysql)) {
                            foreach ($row1 as $value) {
                                echo '<td>' . $value . '</td>';
                            }
                        }
                        echo'<td><a href="transaction.php?action=delete&what=user&id=' . $row['user_id'] . '">Delete</a></td><td><a href="?action=add&edit-user=edit&id='. $row['user_id'] . '">Edit</a></td>';
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
                        echo'<td><a href="transaction.php?action=delete&what=post&id=' . $row['post_word_id'] . '">Delete</a></td><td><a href="?action=post&edit-post=edit&id='. $row['post_word_id'] . '">Edit</a></td>';
                    }
                    echo '</table>';
                }
                break;
            case 'add':
                $edit = $_GET['edit-user'];
                $id = $_GET['id'];
                if($_SESSION['user_auth']==5){
                    if($edit=='edit'){
                        $query = 'SELECT * FROM users WHERE user_id =' . $id;
                        $sql = mysql_query($query, $db) or die(mysql_error($db));
                        while ($row = mysql_fetch_assoc($sql)) {
                            $name=$row['user_name'];
                            $auth=$row['user_auth'];
                        }
                        $query = 'SELECT * FROM user_info WHERE user_id =' . $id;
                        $sql = mysql_query($query, $db) or die(mysql_error($db));
                        while ($row = mysql_fetch_assoc($sql)) {
                            $first=$row['first'];
                            $last=$row['last'];
                            $email=$row['email'];
                        }
                    }
                }
                echo '<form action="transaction.php?action=add';
                if($edit=='edit'){
                    echo '&edit-user=edit&id='.$id;
                } 
                echo '" method="post"><p>Username:</p><input type="text" name="name" value="' . $name . '"><p>Password:';
                if($edit=='edit'){
                    echo '(please leave blank to not change password)';
                }
                echo '</p>';
                echo '<input type="password" name="pass">';
                if($_SESSION['user_auth']==5){
                    echo '<p>Security Level:</p><select name="auth">';
                    for($total=1;$total<=5;$total++){
                        echo '<option value="' . $total . '"';
                        if($total==$auth) {
                            echo ' selected';
                        }
                        echo '>' . $total . '</option>';
                    }
                    echo '</select>';
                }
                echo '
                <p>First Name:</p><input type="text" name="first" value="' .$first. '">
                <p>Last Name:</p><input type="text" name="last" value="' .$last. '">
                <p>Email:</p><input type="text" name="email" value="' .$email. '">';
                echo'
                <input type="submit" value="Add User">
                </form>';
                break;
            }
?>
            </div>
<?php
    }elseif($_SESSION['user_auth']=0){
        echo'You are signed in, but you don\'t have the privilages to view the blog';
    }else{
        header("Location: index.php");
    }
?>

