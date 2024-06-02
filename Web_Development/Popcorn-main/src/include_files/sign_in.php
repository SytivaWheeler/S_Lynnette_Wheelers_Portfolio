<?php
require("DBConn.php");
require("profile_check.php");

if (isset($_POST['user']) && isset($_POST['pwd'])) {

    # User entered data
    $username = $_POST['user'];
    $pass_word = $_POST['pwd'];    

    # Prep sql statments
    $sth = $dbh->prepare('SELECT * FROM user_info WHERE username = ?');
    $sth->execute(array($username));

    $usercheck = $sth->fetchAll(\PDO::FETCH_ASSOC);

    # Check if username exists in database
    if ($usercheck[0]['username'] == $username) {

        # Check if password is correct
        if ($usercheck[0]['pass_word'] == $pass_word) {

            # Sign in, setting all necessary session variables, then running the profile check and 
            # setting the return value to profilebool.
            session_start();
            $_SESSION['username'] = $usercheck[0]['username'];
            $_SESSION['email'] = $usercheck[0]['email'];
            $_SESSION['f-name'] = $usercheck[0]['f_name'];
            $_SESSION['l-name'] = $usercheck[0]['l_name'];
            $_SESSION['age'] = $usercheck[0]['age'];

            $_SESSION['profilebool'] = prof_check($_SESSION['username']);
            
            header("Location: ../pages/homepage.php");
        } else {
            $em = "Username or passsword is incorrect..";
            header("Location:../pages/sign_in_page.php?error=" . $em);   
        }
    } else {
        $em = "That username does not exist..";
        header("Location:../pages/sign_in_page.php?error=" . $em);    
    }
}
