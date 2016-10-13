<?php
session_start();
    include 'home-same.php';
    $db = mysql_connect('localhost','root', 'abcdef')or die('fail');
    mysql_select_db('admin', $db) or die(mysql_error($db));
    $query = 'SELECT *
        FROM
            users';
   $result = mysql_query($query, $db) or die(mysql_error($db));
    if ($_SESSION['securityLevel']==5){
        //What Employees can see
        echo "Thank you for signing in ". $_SESSION['username'] . '.';
        echo '
        <br>
        <a href="update-users.php?action=add">Add User</a>
        <table class="admin">';
        while ($row = mysql_fetch_assoc($result)) {
            echo '<tr>';
            foreach ($row as $value) {
                echo '<td>' . $value . '</td>';
            }
            echo'
            <td><a href="update-users.php?action=delete&id=' . $row['user_id'] . '">Delete</a></td>';
            echo'
            <td><a href="update-users.php?action=edit&id=' . $row['user_id'] . '">Edit</a></td>';
        }
        echo '</table>';
    }else{
        echo "Sorry but you don't have permission to view this page.";
    }
?>
