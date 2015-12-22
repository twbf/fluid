<?php
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
        <a href="sign-in.php">No</a>
        <a href="commit.php?action=delete&id=' . $_GET['id'] . '">Yes</a>';
        break;
    case 'edit';
?>
        <form action="commit.php?action=edit" method="post">
            Username:
            <input type="text" name="username">
            Password:
            <input type="password" name="password">
            Security Level
            <select name="security_level">
<?php
        break;
    }
?>
           
    </body>
</html>
