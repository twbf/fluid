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
    <h1>2016 Bueler-Faudree Presidential Voting</h1>
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
    case 'vote':
        $id = $_GET['id'];
        
        echo '<p>Thank you for voting.</p>
              <p>Have a great day!</p>
              <a href="index.php">Back Sign-In</a>';
        break;
    case 'result':
        $query = 'SELECT voter_vote
                        FROM
                            elect ORDER BY voter_birth DESC';
        $result = mysql_query($query, $db) or die(mysql_error($db));
        echo '<table class="admin">';
        while ($row = mysql_fetch_assoc($result)) {
            echo '<tr>';
            foreach ($row as $value) {
                echo '<td>' . $value . '</td>';
            }
        }
        break;
    }
    
    }else{
    echo 'You do not have permission to veiw this site'; 
    }
?>
        
    </body>
</html>
