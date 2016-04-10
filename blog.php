<?php
session_start();
    if($_SESSION['user_auth']>=1  or $_GET['action']=='add'){
    if(gethostname() == 'bueler-gazelle'){
        require 'local-mysql-connect.inc.php';
    }else{
        require 'mysql-connect.inc.php';
    }
    $db = mysqli_connect(mysql_host,mysql_user,mysql_pass);
    mysqli_select_db($db, mysql_database);
    include 'head.inc.html';
?>
    <body>
    <div class="header">
        <h1>BF BLOG</h1>
        <form action="?action=view" method="POST">
            <input type="text" name="search" value="<?php echo $_POST['search']; ?>" class="searchBox">
            <input type="submit" value="Search"  class="searchBut">
        </form>
        <div class="menu" id="menu">
            <ul>
                <li><a href="?action=view">Home</a></li>
                <li><a href="?action=view&action2=post">Post</a></li>
                <li><a href="transaction.php?action=signout">Sign Out</a></li>
                <?php if($_SESSION['user_auth']==5){echo '<li><a href="?action=admin">Admin</a></li>';} ?>
                <li><a href="?action=add&edit-user=edit&id=<?php echo $_SESSION['user_id']; ?>"><?php echo $_SESSION['fullName']; ?></a></li>
            </ul>
        </div>
        <div class="menu-btn" id="menuBut">
             <div></div>
             <span></span>
             <span></span>
             <span></span>
        </div>
    </div>
    <div class="content" id="content">
<?php
        function getPicture($rowid){
            global $db;
            $query1 = 'SELECT post_picture_id FROM post WHERE post_word_id=' . $rowid;
            $mysql = mysqli_query($db, $query1);
            while ($row1 = mysqli_fetch_assoc($mysql)) {
                $query = 'SELECT picture_location FROM post_picture WHERE post_picture_id=' . $row1['post_picture_id'];
                $mysql1 = mysqli_query($db, $query) or die(mysql_error($db));
                while ($row2 = mysqli_fetch_assoc($mysql1)) {
                    echo '<img src="images/' . $row2['picture_location'] . ' ">';
                    return;
                }
            }
        }
        switch($_GET['action']) {
            case 'view':
                $query = 'SELECT * FROM post_word ORDER BY post_date DESC';
                if($_POST['search']==true){
                    $query = 'SELECT * FROM post_word WHERE post_title LIKE "%' . $_POST['search'] . '%" OR post_content LIKE "%' . $_POST['search'] . '%" ORDER BY post_date DESC';
                }
                $sql = mysqli_query($db, $query);
                $counter=0;
                while ($row = mysqli_fetch_assoc($sql)) {
                    echo '<div class="post blur" id="p'. $counter .'" onclick = "bigView(this)">';
                    getPicture($row['post_word_id']);
                    echo '<h2>'. $row['post_title'] . '</h2>';
                    echo '<p class="nolink" id="shorten">' . $row['post_content'] . '</p>';
                    echo '<p class="none"></p><p class="small">'. $row['post_date'] . '</p>';
                    if($_SESSION['user_id']==$row['post_user_id']){
                        echo'<p><a href="?action=view&action2=post&edit-post=edit&id=' . $row['post_word_id'] . '">Edit  </a></p>'; 
                        echo'<p><a href="transaction.php?action=delete&what=post&id=' . $row['post_word_id'] . '">Delete  </a></p>'; 
                    }  
                    echo '</div>';
                    $counter++;
                }
                if($_GET['action2']=='post'){
                    echo '<link rel="stylesheet" type="text/css" href="middle.css">';
                    echo '<div class="middle"><div class="post"><a href="blog.php?action=view"><img src="Delete-50.png" class="deleteButton"></a>';
                    $edit = $_GET['edit-post'];
                    $id = $_GET['id'];
                    if($_SESSION['user_auth']==5 or $_SESSION['user_auth']){
                        if($edit=='edit'){
                            $query = 'SELECT post_title, post_content FROM post_word WHERE post_word_id =' . $id;
                            $sql = mysqli_query($db, $query);
                            while ($row = mysqli_fetch_assoc($sql)) {
                                $title=$row['post_title'];
                                $content=$row['post_content'];
                            }
                        }
                    }
                    echo '<form action="transaction.php?action=post';
                    if($edit=='edit'){
                        echo '&edit-post=edit&id='.$id;
                    }
                    echo '" method="POST" enctype= "multipart/form-data" ><p>Title:</p><input type="text" name="title" value="' . $title . '" class="searchBox"><p>Body:</p><textarea rows="4" cols="50" name="content"  class="searchBox">' . $content . '</textarea><p>If you would like a picture to appear with your post please select one</p><input type="hidden" name="MAX_FILE_SIZE" value="2000000"/><input type="file" name="picture"><input type="submit" value="Post" class="searchBut"></form></div></div>';
                }
                break;
            case 'admin':
                if($_SESSION['user_auth']==5){
                    $query = 'SELECT user_id, user_name, user_auth FROM users';
                    $sql = mysqli_query($db, $query);
                    echo '<br><a href="?action=add">Add User</a><h2>Users</h2><table>';
                    while ($row = mysqli_fetch_assoc($sql)) {
                        echo '<tr>';
                        foreach ($row as $value) {
                            echo '<td>' . $value . '</td>';
                        }
                        $query = 'SELECT first, last, email FROM user_info WHERE user_id=' . $row['user_id'];
                        $mysql = mysqli_query($db, $query);
                        while ($row1 = mysqli_fetch_assoc($mysql)) {
                            foreach ($row1 as $value) {
                                echo '<td>' . $value . '</td>';
                            }
                        }
                        echo'<td><a href="transaction.php?action=delete&what=user&id=' . $row['user_id'] . '">Delete</a></td><td><a href="?action=add&edit-user=edit&id='. $row['user_id'] . '">Edit</a></td>';
                    }
                    echo '</table>';
                    $query = 'SELECT post_word_id, post_title, post_date, post_user_id FROM post_word';
                    $sql = mysqli_query($db, $query);
                    echo '<h2>Posts</h2>';
                    echo '<table>';
                    while ($row = mysqli_fetch_assoc($sql)) {
                        echo '<tr>';
                        foreach ($row as $value) {
                            echo '<td>' . $value . '</td>';
                        }
                        echo'<td><a href="transaction.php?action=delete&what=post&id=' . $row['post_word_id'] . '">Delete</a></td><td><a href="?action=view&action2=post&edit-post=edit&id='. $row['post_word_id'] . '">Edit</a></td>';
                    }
                    echo '</table>';
                    ?>
                    <h2>Email</h2>
                    <form action="transaction.php?action=email" method="POST">
                        <p>To Address:</p>
                        <input type="text" name="to" value="">
                        <p>Subject:</p>
                        <input type="text" name="subject" value="">
                        <p>Text:</p>
                        <textarea rows="4" cols="50" name="text"></textarea>
                        <p>HTML:</p>
                        <textarea rows="4" cols="50" name="html"></textarea>
                        <input type="submit" value="Send">
                    </form>
                    <?php
                }
                break;
            case 'add':
                $edit = $_GET['edit-user'];
                $id = $_GET['id'];
                if($_SESSION['user_auth']==5 or $_SESSION['user_id']==$id){
                    if($edit=='edit'){
                        $query = 'SELECT * FROM users WHERE user_id =' . $id;
                        $sql = mysqli_query($db, $query);
                        while ($row = mysqli_fetch_assoc($sql)) {
                            $name=$row['user_name'];
                            $auth=$row['user_auth'];
                        }
                        $query = 'SELECT * FROM user_info WHERE user_id =' . $id;
                        $sql = mysqli_query($db, $query);
                        while ($row = mysqli_fetch_assoc($sql)) {
                            $first=$row['first'];
                            $last=$row['last'];
                            $email=$row['email'];
                        }
                    }
                }
                echo '<form action="transaction.php?action=add';
                if($edit=='edit'){
                    echo '&edit-user=edit&id='.$id;
                } 
                echo '" method="post"><p>Username:</p><input type="text" name="name" value="' . $name . '"><p>Password:';
                if($edit=='edit'){
                    echo '(please leave blank to not change password)';
                }
                echo '</p>';
                echo '<input type="password" name="pass">';
                if($_SESSION['user_auth']==5){
                    echo '<p>Security Level:</p><select name="auth">';
                    for($total=1;$total<=5;$total++){
                        echo '<option value="' . $total . '"';
                        if($total==$auth) {
                            echo ' selected';
                        }
                        echo '>' . $total . '</option>';
                    }
                    echo '</select>';
                } elseif ($_SESSION['user_auth']>=1){
                    echo '<p>Security Level:</p><select name="auth"><option value="1">1</option></select>';
                }
                echo '
                <p>First Name:</p><input type="text" name="first" value="' .$first. '">
                <p>Last Name:</p><input type="text" name="last" value="' .$last. '">
                <p>Email:</p><input type="text" name="email" value="' .$email. '">';
                echo'
                <input type="submit" value="Add/Update User">
                </form>';
                break;
            }
?>
                <div class="space"></div>
                <footer>
                    Copyright &copy; 2016 TWBF All rights reserved.
                </footer>
            </div>
<?php
    }elseif($_SESSION['user_auth']=0){
        echo'You are signed in, but you don\'t have the privilages to view the blog';
    }else{
        header("Location: index.php");
    }
?>

