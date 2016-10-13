<?php
session_start();
    //page with non-security transfers
    //Connect To Server
    $db = mysql_connect('localhost','root', 'abcdef')or die('fail');
    mysql_select_db('admin', $db) or die(mysql_error($db));
?>
<html>
    <head>
        <title>Changing Users</title>
        <link rel="stylesheet" type="text/css" href="home-css.css">
    </head>
    <body>
<?php
    
?>
