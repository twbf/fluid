<?php
    //Connect To Server
    $db = mysql_connect('localhost','root', 'abcdef')or die('fail');
    $query = 'CREATE DATABASE IF NOT EXISTS admin';
    mysql_query($query, $db) or die(mysql_error($db));
    mysql_select_db('admin', $db) or die(mysql_error($db));
#    $query = 'CREATE TABLE users (
#        user_id         INTEGER UNSIGNED   NOT NULL    AUTO_INCREMENT,
#        user_name       VARCHAR(255)        NOT NULL,
#        user_pass       VARCHAR(30)         NOT NULL,
#        security_level  TINYINT(1)          NOT NULL   DEFAULT 0,
#        
#        PRIMARY KEY (user_id)
#        )
#        ENGINE=MyISAM';
#    mysql_query($query, $db) or die(mysql_error($db)); 
    
    //Inserting Users
    $query = 'INSERT INTO users 
        (user_id, user_name, user_pass, security_level)
        VALUES
        (1, "Thomas Bueler", "qwerty", 5),
        (2, "Vera Bueler", "123456", 5)';
    mysql_query($query, $db) or die(mysql_error($db));
    
?>
