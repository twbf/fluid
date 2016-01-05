<?php
    $db = mysql_connect('localhost','root', 'abcdef')or die('fail');
    $query = 'CREATE DATABASE IF NOT EXISTS voting';
    mysql_query($query, $db) or die(mysql_error($db));
    mysql_select_db('voting', $db) or die(mysql_error($db));
#    $query = 'UPDATE elect SET security_level=1 WHERE voter_birth=2002
#        voter_id         INTEGER UNSIGNED                                    NOT NULL   AUTO_INCREMENT,
#        voter_name       VARCHAR(255)                                        NOT NULL   DEFAULT "",
#        voter_birth      INT(4)                                              NOT NULL   DEFAULT 0,
#        voter_vote       ENUM("No Vote", "Vera Bueler", "Micah Faudree")     NOT NULL   DEFAULT "No Vote",
#        
#        PRIMARY KEY (voter_id)
#        )
#        ENGINE=MyISAM';
    $query = 'ALTER TABLE elect 
       MODIFY COLUMN voter_vote ENUM("No Vote", "Vera Bueler", "Micah Faudree", "Dahlia Woodward")     NOT NULL   DEFAULT "No Vote"';
        
    mysql_query($query, $db) or die(mysql_error($db)); 
    echo 'dahlia';
?>
