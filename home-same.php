<h1>Fluid</h1>
<nav>
    <ul>
        <li><a href="http://twbf.github.io/fluid">Home</a></l>
        <li><a href="services">Services</a></l>
        <li><a href="about-us">About-Us</a></l>
        <li><a href="portfolio">Portfolio</a></l>
    </ul>
</nav>
<?php
    
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['password'] = $_POST['password'];

    $name = '"'.$_SESSION['username'].'"';
    $pass = '"'.$_SESSION['password'].'"';
    echo 'hjhg';
    $query2 = 'SELECT security_level FROM users WHERE user_name = ' . $name . 'AND user_pass = ' . $pass;
    echo 'hjhg';
    $auth = mysql_query($query2, $db) or die(mysql_error($db));
    echo 'hjhg';
    while ($row = mysql_fetch_assoc($auth)) {
       foreach ($row as $value) {
           $securityLevel .= $value;
       }
    }
    echo 'hjhg';
    echo $securityLevel;
    if(isset($_SESSION['securityLevel'])){
        $_SESSION['securityLevel'] = $securityLevel;
        echo '<p>Thank you for signing in '. $_SESSION['username'] . '.</a>';
        
        if($_SESSION['securityLevel']==5){
            echo '<a href="sign-in.php">Administration Page</a>';
        }
    } else {
?>
<form action="index.php" method="post">
  Username:
  <input type="text" name="username">
  Password:
  <input type="password" name="password">
  <input type="submit" value="Sign In">
</form>
<?php
}
?>
