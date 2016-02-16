<?php
session_start();
    if(gethostname() == 'bueler-gazelle'){
        require 'local-mysql-connect.inc.php';
    }else{
        require 'mysql-connect.inc.php';
    }
    $db = mysqli_connect(mysql_host,mysql_user,mysql_pass);
    $mysqli = new mysqli("localhost", "root", "abcdef", "bf-blog");
    mysqli_select_db($db, mysql_database);
    
    if($_SESSION['user_auth']>=1 or $_GET['action']=='add'){
        function delete($database, $databaseid){
            global $_GET, $db;
            $id = $_GET['id'];
            $query = 'DELETE FROM ' . $database . ' WHERE ' . $id . '=' . $databaseid . '_id';
            mysqli_query($db, $query);
        }
        function email($to, $subject, $html){
            require 'class.SimpleMail.php';
            $message = new SimpleMail();
            $message->setSendText(false);
            $message->setToAddress('"' . $to . '"');
            $message->setFromAddress('twbf.public@gmail.com');
            $message->setSubject($subject);
            $message->setHTMLBody($html);
            $message->send();
            return $message;
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
                $auth = mysqli_query($db, $query);
                $last_word_id = mysqli_insert_id($db);
                if($_FILES['image']['error']==0){
                    $dest ='images/' . $_FILES['picture']['name'];
                    $tmp =  $_FILES['picture']['tmp_name'];
                    move_uploaded_file($tmp,$dest);
                    $query = 'INSERT INTO post_picture (post_picture_id, picture_location, picture_user_id) VALUES (NULL,"'. $_FILES['picture']['name'] .'",'. $user_id .')';
                    $auth = mysqli_query($db, $query);
                    $last_picture_id = mysqli_insert_id($db);
                    if($last_word_id==0){
                        $last_word_id==$_GET['id'];
                    }
                    $query = 'INSERT INTO post (post_id, post_word_id, post_picture_id) VALUES (NULL,'.$last_word_id.','.$last_picture_id.')';
                    $auth = mysqli_query($db, $query);
                }
                $cont = '<h1>Bueler-Faudree Blog</h1><h2>' .$_POST['title']. '</h2><p>' . $_POST['content'] . '</p>';
                if (email($_SESSION['email'], $_POST['title'], $cont) == true){
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
                 mysqli_multi_query($db, $query);
                 if($_SESSION['user_auth']==5){
                    header("Location: blog.php?action=admin");
                 }else{
                    header("Location: index.php?warning=" . urlencode('Please Sign In Again'));
                 }
                 break;
             case 'signout':
                session_destroy();
                header("Location: index.php");
                break;
            case 'email':
                if (email($_POST['to'], $_POST['subject'], $_POST['html']) == ''){
                }
                header("Location: blog.php?action=admin");
                break;
        }
    }
?>
