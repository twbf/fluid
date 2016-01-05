<link rel="stylesheet" type="text/css" href="home-css.css">
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
    $query2 = 'SELECT security_level FROM users WHERE user_name = ' . $name . 'AND user_pass = ' . $pass;
    $auth = mysql_query($query2, $db) or die(mysql_error($db));
    while ($row = mysql_fetch_assoc($auth)) {
       foreach ($row as $value) {
           $securityLevel .= $value;
       }
    }
    $_SESSION['securityLevel'] = $securityLevel;
    if(isset($_SESSION['securityLevel'])){
        echo '<p>Thank you for signing in '. $_SESSION['username'] . '.</a>';
        
        if($_SESSION['securityLevel']==5){
            echo '<a href="admin.php">Administration Page</a>';
        }
    } elseif(isset($_SESSION['username'])){
        echo 'You either supplied the wrong credintials or you are not a user and need to registar';
    } 
    else {
?>
<form action="index.php" method="post">
  Username:
  <input type="text" name="username">
  Password:
  <input type="password" name="password">
  <input type="submit" value="Sign In">
</form>
<form action="index.php" method="post">
  <input type="submit" value="Registar">
</form>
<?php
}
?>
