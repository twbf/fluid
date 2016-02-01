<?php
session_start();
    require 'mysql-connect.inc.php';
    $db = mysql_connect(mysql_host,mysql_user,mysql_pass)or die('fail');
    mysql_select_db(mysql_database, $db) or die(mysql_error($db));
    
    if($_SESSION['user_auth']>=1){
        switch($_GET['action']) {
            case 'post':
                $user_id = $_SESSION['user_id'];
                $query = 'INSERT INTO post_word (post_word_id, post_title, post_content, post_date, post_user_id) VALUES (NULL,"'. $_POST['title'] .'","'. $_POST['content'] .'",NULL,'. $user_id .')';
                if($_GET['edit-post']=='edit'){
                    $query = 'UPDATE post_word SET
                    post_title="' .$_POST['title']. '", 
                    post_content="' .$_POST['content']. '", 
                    post_date= NULL
                    WHERE post_word_id=' .$_GET['id'];
                }
                $auth = mysql_query($query, $db) or die(mysql_error($db));
                $_FILE['picture']['tmp_name'] == "none";
                if(!$_FILE['picture']['tmp_name']=="none"){
                    echo'gsdhfsj';
                    $dest ='/var/www/html/fluid/bf-blog/images/' . $_FILE['picture']['name'];
                    $tmp =  $_FILE['picture']['tmp_name'];
                    move_uploaded_file($tmp,$dest);
                }
                echo $_FILE['picture']['tmp_name'];
                echo $_FILE['picture']['name'];
                echo 'fsdhsjk';
                //header("Location: blog.php?action=view");
                break;
            case 'delete':
                switch($_GET['what']) {
                    case 'user':
                        $database = 'users';
                        $databaseid = 'user';
                        break;
                        
                    case 'post':
                        $database = 'post_word';
                        $databaseid = 'post_word';
                        break;
                }
                $id = $_GET['id'];
                $query = 'DELETE FROM ' . $database . ' WHERE ' . $id . '=' . $databaseid . '_id';
                mysql_query($query, $db) or die(mysql_error($db));
                header("Location: blog.php?action=admin");
                break;
            case 'add':
                $username = '"' . $_POST['name'] . '"';
                $password = '"' . md5($_POST['pass']) . '"';
                $auth = '"' . $_POST['auth'] . '"';
                $query = 'INSERT INTO users (user_id, user_name, user_pass, user_auth)
                    VALUES (NULL,' . $username . ',' . $password . ',' . $auth . ')';
                if($_GET['edit-user']=='edit'){
                    $query = 'UPDATE users SET
                    user_name=' .$username. ',';
                    if ($_POST['pass']==true){
                        $query .= 'user_pass=' . $password . ',';
                    }
                    $query .= 'user_auth =' . $auth . 'WHERE user_id=' . $_GET['id'];
                 }
                 mysql_query($query, $db) or die(mysql_error($db));
                 header("Location: blog.php?action=admin");
                 break;
        }
    }
?>
