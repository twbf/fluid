<?php
session_start();
    //geting variables from form
    $name = $_POST['username'];
    $pass = $_POST['password'];
    
    //starting session
    
    $_SESSION['username'] = $name;
    //$_SESSION['password'] = $pass
    
    //making variables mysql friendly
    $name = '"'.$name.'"';
    $pass = '"'.$pass.'"';
    
    $db = mysql_connect('localhost','root', 'abcdef')or die('fail');
    mysql_select_db('admin', $db) or die(mysql_error($db));
    $query = 'SELECT *
        FROM
            users';
    $result = mysql_query($query, $db) or die(mysql_error($db));
    
   $query2 = 'SELECT security_level FROM users WHERE user_name = ' . $name . 'AND user_pass = ' . $pass;
    
   $auth = mysql_query($query2, $db) or die(mysql_error($db));
    
    //Results 
    
    echo '<br>';
    
    while ($row = mysql_fetch_assoc($auth)) {
       foreach ($row as $value) {
           $securityLevel .= $value;
       }
    }
    
    $_SESSION['securityLevel'] = $securityLevel;
    
    if ($securityLevel==5){
        //What Employees can see
        echo "Thank you for signing in ". $name . '.';
        echo '
        <br>
        <a href="command-mysql.php">Command Mysql</a>
        <br>
        <a href="update-users.php?action=add">ADD USER</add>
        <table>';
        while ($row = mysql_fetch_assoc($result)) {
            echo '<tr>';
            foreach ($row as $value) {
                echo '<td>' . $value . '</td>';
            }
            echo'
            <td><a href="update-users.php?action=delete&id=' . $row['user_id'] . '">Delete</a></td>';
            echo'
            <td><a href="update-users.php?action=edit&id=' . $row['user_id'] . '">Edit</a></td>
            </tr>';
        }
        echo '</table>';
    }else{
        echo "Sorry but you don't have permission to view this page.";
    }
?>
