<?php
session_start();

    if ($_SESSION['securityLevel']==1){
    
    //Connect To Server
    $db = mysql_connect('localhost','root', 'abcdef')or die('fail');
    mysql_select_db('voting', $db) or die(mysql_error($db));
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
        $name = '"' . $_POST['name'] . '"';
        $birth = '"' . $_POST['birth-year'] . '"';
        //Query
        $query = 'INSERT INTO elect (voter_name, voter_birth)
            VALUES (' . $name . ',
                ' . $birth . ')';
         mysql_query($query, $db) or die(mysql_error($db));
         echo '<p>New User Successfully Added</p>
               <a href="vote.php">Back To Administrator Console</a>';
         break;
     case 'delete':
        $id = $_GET['id'];
        $query = 'DELETE FROM users WHERE ' . $id . '=user_id';
        mysql_query($query, $db) or die(mysql_error($db));
        echo '<p>User with the id ' . $id . ' succesfully deleted</p>
              <a href="admin.php">Back To Administrator Console</a>';
        break;
    case 'vote':
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
