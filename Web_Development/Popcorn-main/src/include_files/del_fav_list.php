<?php
require("DBConn.php");

session_start();

if(isset($_SESSION['username'])){

    $username = $_SESSION['username'];

    if(isset($_POST['del_button'])){

        $imdb_id = $_POST['del_button'];

        try {
            #SQL Query to Database
            $sth = $dbh->prepare('DELETE FROM fav_list WHERE username=(?) AND movie_id=(?)');
            $sth->execute(array($username, $imdb_id));

            header("Location:../pages/user/fav_list.php");

        } catch (PDOException $e) {

            $em = 'An error has occured. Please try again later';
            header("Location:../pages/user/fav_list.php?error=" . $em);
        }
    }
    
}else{
    header("Location:../pages/sign_in_page.php");
}
?>