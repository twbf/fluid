<?php
session_start();

    if ($_SESSION['securityLevel']==5){
    
    //Connect To Server
    $db = mysql_connect('localhost','root', 'abcdef')or die('fail');
    mysql_select_db('admin', $db) or die(mysql_error($db));
?>
<html>
    <head>
        <title>Committ Changes</title>
    </head>
    <body>
<?php
    switch($_GET['action']) {
    case 'add':
        //Making Form Information MYSQL friendly
        $username = '"' . $_POST['username'] . '"';
        $password = '"' . $_POST['password'] . '"';
        $security_level = '"' . $_POST['security_level'] . '"';
        //Query
        $query = 'INSERT INTO users (user_name, user_pass, security_level)
            VALUES (' . $username . ',
                ' . $password . ',
                ' . $security_level . ')';
         mysql_query($query, $db) or die(mysql_error($db));
         echo '<p>New User Successfully Added</p>
               <a href="admin.php">Back To Administrator Console</a>';
         break;
     case 'delete':
        $id = $_GET['id'];
        $query = 'DELETE FROM users WHERE ' . $id . '=user_id';
        mysql_query($query, $db) or die(mysql_error($db));
        echo '<p>User with the id ' . $id . ' succesfully deleted</p>
              <a href="admin.php">Back To Administrator Console</a>';
        break;
    case 'edit':
        $id = $_GET['id'];
        $query = 'UPDATE users SET 
            user_name ="' . $_POST['username'] . '",
            user_pass =' . $_POST['password'] . ',
            security_level =' . $_POST['security_level'] . '
            WHERE user_id = ' . $id;
        mysql_query($query, $db) or die(mysql_error($db));
        echo '<p>User with the id ' . $id . ' succesfully edited</p>
              <a href="admin.php">Back To Administrator Console</a>';
     }
     }else{
       echo 'You do not have permission to veiw this site'; 
    }
?>
        
    </body>
</html>
