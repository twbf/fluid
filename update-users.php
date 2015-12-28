<?php
session_start();

    if ($_SESSION['securityLevel']==5){
    
    //Connect To Server
    $db = mysql_connect('localhost','root', 'abcdef')or die('fail');
    mysql_select_db('admin', $db) or die(mysql_error($db));
?>
<html>
    <head>
        <title>Changing Users</title>
    </head>
    <body>
<?php

    switch($_GET['action']) {
    case 'add':
?>
        <form action="commit.php?action=add" method="post">
            Username:
            <input type="text" name="username">
            Password:
            <input type="password" name="password">
            Security Level
            <select name="security_level">
<?php
        for($total=1;$total<=5;$total++){
            echo '<option value="' . $total . '">' . $total . '</option>';
        }
        echo'
        <input type="submit" value="Add User">
        </form>';
        break;
    case 'delete':
        echo '
        <p>Are you sure you want to delete this user?</p>
        <p>There is no going back<p>
        <a href="admin.php">No</a>
        <a href="commit.php?action=delete&id=' . $_GET['id'] . '">Yes</a>';
        break;
    case 'edit':
        $query = 'SELECT user_name,user_pass,security_level FROM users where user_id=' . $_GET['id'];
        $result = mysql_query($query, $db) or die(mysql_error($db));
        extract(mysql_fetch_assoc($result));
?>
        <form action="commit.php?action=edit&id=<?php echo $_GET['id']?>" method="post"> 
            <input type="text" name="username" value="<?php echo $user_name; ?>">
            Password:
            <input type="password" name="password" value="<?php echo $user_pass; ?>">
            Security Level
            <select name="security_level">
<?php
        for($total=1;$total<=5;$total++){
            echo '<option value="' . $total . '"'; 
            if($total==$security_level) {
                echo ' selected';
            }
           echo '>' . $total . '</option>';
        }
?>
            <input type="submit" name="submit" value="Edit User">
<?php
        break;
    }
    }else{
       echo 'You do not have permission to veiw this site'; 
    }
?>
           
    </body>
</html>
