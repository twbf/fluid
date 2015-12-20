<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="home-css.css">
  </head>
  <body>
      <?php include 'home-same.php';?>
      <div class="content">
      </div>
      <?php
        mysql_connect('localhost','root', 'abcdef')or die('fail');
        //mail('twbueler@gmail.com','success','Perfect');
      ?>
  </body>
</html>
