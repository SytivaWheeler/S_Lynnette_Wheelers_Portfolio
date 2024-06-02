<?php

require ("DBConn.php");

# Resume session and retrieve username
session_start();
$username = $_SESSION['username'];

if(isset($_GET['check'])){
    # Get check boxes filled by user
    $selections = $_GET['check'];

    try {
        foreach($selections as $genre){
            # SQL Query to Database for each checkbox filled by user
            $sth = $dbh->prepare('INSERT INTO user_profiles (username,genre_id) VALUES (?,?)');
            $sth->execute(array($username, $genre));   
        }

        # Change profilebool to true so user cant return to profilegen.php
        $_SESSION['profilebool'] = true;
        header("Location:../pages/homepage.php");
    } catch (PDOException $e) {

        $em = 'An error has occured. Please try again later';
        header("Location:../pages/profile_gen.php?error=" . $em);
    }
}else{
    $em = 'An error has occured. Make sure you select some genres!';
    header("Location:../pages/profile_gen.php?error=" . $em);
}



?>