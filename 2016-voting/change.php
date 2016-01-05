<?php
session_start();
    
    //Connect To Server
    $db = mysql_connect('localhost','root', 'abcdef')or die('fail');
    mysql_select_db('voting', $db) or die(mysql_error($db));
?>
<html>
    <head>
        <title>Changing Users</title>
        <link rel="stylesheet" type="text/css" href="css.css">
    </head>
    <body>
<?php

    switch($_GET['action']) {
    case 'add':
    if ($_SESSION['securityLevel']==1){
?>
        <form action="result.php?action=add" method="post">
            Full Name:
            <input type="text" name="name">
            Birth Year:
            <select name="birth-year">
<?php
        for($total=2016;$total>1900;$total--){
            echo '<option value="' . $total . '">' . $total . '</option>';
        }
        echo'
        <input type="submit" value="Add voter">
        </form>';
        }else{
           echo 'You do not have permission to veiw this site'; 
        }
        break;
    case 'vote':
        $query = 'UPDATE elect SET 
            voter_vote ="' . $_POST['cand'] . '"
            WHERE voter_name = "' . $_SESSION['name'] . '"';
        mysql_query($query, $db) or die(mysql_error($db));
        header("Location: result.php");
        break;
    case 'result':
        header("Location: result.php?action=result");
        break;
    }
?>
           
    </body>
</html>
