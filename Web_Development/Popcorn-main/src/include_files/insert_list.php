<?php
require("DBConn.php");

session_start();
$username = $_SESSION['username'];

if (isset($_POST['favbtn'])) {

    $imdb_id = $_POST['favbtn'];

    try {
        # SQL Query to Database, insert movie to correct list. 
        $sth = $dbh->prepare('INSERT INTO fav_list (username, movie_id) VALUES (?,?)');
        $sth->execute(array($username, $imdb_id));

        # Message of success
        $sm = "Movie successfully added to favorites!";
        header("Location: ../pages/homepage.php?succ=" . $sm);
    } catch (PDOException $e) {
        # Message of dup movie
        $em = "This movie is in your favorites already!";
        header("Location: ../pages/homepage.php?error=" . $em);
    }
}elseif(isset($_POST['watchbtn'])){
    
    $imdb_id = $_POST['watchbtn'];
    
    try {
        # SQL Query to Database, insert movie to correct list. 
        $sth = $dbh->prepare('INSERT INTO watch_list (username, movie_id) VALUES (?,?)');
        $sth->execute(array($username, $imdb_id));

        # Message of success
        $sm = "Movie Successfully added to watch list!";
        header("Location: ../pages/homepage.php?succ=" . $sm);
    } catch (PDOException $e) {
        # Message of dup movie
        $em = "This movie is in your watch list already!";
        header("Location: ../pages/homepage.php?error=" . $em);
    }

}
