<?php
session_start();
$db = mysql_connect('localhost','root', 'abcdef')or die('fail');
    mysql_select_db('voting', $db) or die(mysql_error($db));
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css.css">
    </head>
    <body>
        <h1>2016 Bueler-Faudree Presidential Voting</h1>
        <?php
            $_SESSION['name'] = $_POST['name'];
            $_SESSION['birth-year'] = $_POST['birth-year'];

            $name = '"'.$_SESSION['name'].'"';
            $birthYear = '"'.$_SESSION['birth-year'].'"';
            $query = 'SELECT security_level FROM elect WHERE voter_name = ' . $name . 'AND voter_birth = ' . $birthYear;
            $auth = mysql_query($query, $db) or die(mysql_error($db));
            while ($row = mysql_fetch_assoc($auth)) {
               foreach ($row as $value) {
                   $securityLevel .= $value;
               }
            }
            if(isset($_SESSION['name'])){
                $_SESSION['securityLevel'] = $securityLevel;
                echo '<p>Thank you for signing in '. $_SESSION['name'] . '.</a><br>';
                ?>
                <form action="change.php?action=vote" method="post">
                    <input type="radio" name="cand" value="Vera Bueler">Vera Bueler
                    <input type="radio" name="cand" value="Micah Faudree">Micah Faudree
                    <input type="radio" name="cand" value="Dahlia Woodward">Dahlia Woodward
                    <input type="hidden" name="id" value="<?php echo $_SESSION['name']; ?>">
                    <input type="submit" name="vote" value="Vote">
                </form>
                <?php
                if($_SESSION['securityLevel']==1){
                    echo '<br>
                    <a href="command-mysql.php">Command MySQL</a>
                    <br>
                    <a href="change.php?action=add">Add Voter</a>
                    <br>
                    <a href="change.php?action=result">Election Results</a>
                    <br>';
                    $query = 'SELECT voter_name,voter_birth
                        FROM
                            elect';
                    $result = mysql_query($query, $db) or die(mysql_error($db));
                    echo '<table class="admin">';
                    while ($row = mysql_fetch_assoc($result)) {
                        echo '<tr>';
                        foreach ($row as $value) {
                            echo '<td>' . $value . '</td>';
                        }
                    }
                    echo '</table>';
                }
            }
        ?>
    </body>
</html>
