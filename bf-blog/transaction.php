<?php
session_start();
    require 'mysql-connect.inc.php';
    $db = mysql_connect(mysql_host,mysql_user,mysql_pass)or die('fail');
    $mysqli = new mysqli("localhost", "root", "abcdef", "bf-blog");
    mysql_select_db(mysql_database, $db) or die(mysql_error($db));
    
    if($_SESSION['user_auth']>=1 or $_GET['action']=='add'){
        function delete($database, $databaseid){
            global $_GET, $db;
            $id = $_GET['id'];
            $query = 'DELETE FROM ' . $database . ' WHERE ' . $id . '=' . $databaseid . '_id';
            mysql_query($query, $db) or die(mysql_error($db));
        }
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
                $query = 'SET @post_word_id = LAST_INSERT_ID()';
                $auth = mysql_query($query, $db) or die(mysql_error($db));
                if($_FILES['picture']['tmp_name']=="none"){
                } else {
                    $dest ='images/' . $_FILES['picture']['name'];
                    $tmp =  $_FILES['picture']['tmp_name'];
                    move_uploaded_file($tmp,$dest);
                    $query = 'INSERT INTO post_picture (post_picture_id, picture_location, picture_user_id) VALUES (NULL,"'. $_FILES['picture']['name'] .'",'. $user_id .')';
                    $auth = mysql_query($query, $db) or die(mysql_error($db));
                    $query = 'SET @post_picture_id = LAST_INSERT_ID()';
                    $auth = mysql_query($query, $db) or die(mysql_error($db));
                    
                    $query = 'INSERT INTO post (post_id, post_word_id, post_picture_id) VALUES (NULL,@post_word_id,@post_picture_id)';
                    $auth = mysql_query($query, $db) or die(mysql_error($db));
                    
                }
                header("Location: blog.php?action=view");
                break;
            case 'delete':
                switch($_GET['what']) {
                    case 'user':
                        delete('users', 'user');
                        delete('user_info' , 'user');
                        break;
                        
                    case 'post':
                        delete('post_word', 'post_word');
                        delete('post','post_word');
                        break;
                }
                header("Location: blog.php?action=admin");
                break;
            case 'add':
                $username = '"' . $_POST['name'] . '"';
                $password = '"' . md5($_POST['pass']) . '"';
                $auth = '"' . $_POST['auth'] . '"';
                $first = '"' . $_POST['first'] . '"';
                $last = '"' . $_POST['last'] . '"';
                $email = '"' . $_POST['email'] . '"';
                $query = 'INSERT INTO users (user_id, user_name, user_pass, user_auth)
                    VALUES (NULL,' . $username . ',' . $password . ',' . $auth . '); SET @user_id = LAST_INSERT_ID(); ';
                $query .= 'INSERT INTO user_info (user_id, first, last, email)
                    VALUES (@user_id,' . $first . ',' . $last . ',' . $email . ')';
                if($_GET['edit-user']=='edit'){
                    $query = 'UPDATE users SET
                    user_name=' .$username. ',';
                    if ($_POST['pass']==true){
                        $query .= 'user_pass=' . $password . ',';
                    }
                    $query .= 'user_auth =' . $auth . 'WHERE user_id=' . $_GET['id']  . '; ';
                    $query .= 'UPDATE user_info SET first=' .$first. ', last=' .$last. ', email=' .$email . 'WHERE user_id=' . $_GET['id'];
                 }
                 $mysqli->multi_query($query) or die(mysql_error($db));
                 header("Location: blog.php?action=admin");
                 break;
             case 'signout':
                session_destroy();
                header("Location: index.php");
                break;
            case 'email':
                require 'class.SimpleMail.php';
                $message = new SimpleMail();

                $message->setSendText($_POST['text']);
                $message->setToAddress('"' . $_POST['to'] . '"');
                $message->setFromAddress('twbf.public@gmail.com');
                $message->setSubject($_POST['subject']);
                $message->setHTMLBody($_POST['html']);
                $message->send();
                header("Location: blog.php?action=view");
                break;
        }
    }
?>
