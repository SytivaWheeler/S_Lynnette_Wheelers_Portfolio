<?php
require("DBConn.php");

# Check if POST array is empty or not
if (!empty($_POST['email']) || !empty($_POST['f-name']) || !empty($_POST['l-name']) || !empty($_POST['age'])) {

    # Resume session and retrieve username
    session_start();
    $username = $_SESSION['username'];

    # Update any values the user set in the database
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $email = $_POST['email'];

        try {
            # SQL Query to Database, set correct variable to session variable and 
            # reroute back to profile page
            $sth = $dbh->prepare('UPDATE user_info SET email = ? WHERE username = ?');
            $sth->execute(array($email, $username));

            $_SESSION['email'] = $email;

            $sm = "Update successful!";
            header("Location:../pages/user/profile.php?succ=" . $sm);
        } catch (PDOException $e) {
            $em = "This email address is already in use. Try a different one.";
            header("Location:../pages/user/profile.php?error=" . $em);
        }
    }
    if (isset($_POST['f-name']) && !empty($_POST['f-name'])) {
        $f_name = $_POST['f-name'];
        try {
            # SQL Query to Database, set correct variable to session variable and 
            # reroute back to profile page
            $sth = $dbh->prepare('UPDATE user_info SET f_name = ? WHERE username = ?');
            $sth->execute(array($f_name, $username));

            $_SESSION['f-name'] = $f_name;

            $sm = "Update successful!";
            header("Location:../pages/user/profile.php?succ=" . $sm);
        } catch (PDOException $e) {
            $em = "Something went wrong. Try again later";
            header("Location:../pages/user/profile.php?error=" . $em);
        }
    }
    if (isset($_POST['l-name']) && !empty($_POST['l-name'])) {
        $l_name = $_POST['l-name'];
        try {
            # SQL Query to Database, set correct variable to session variable and 
            # reroute back to profile page
            $sth = $dbh->prepare('UPDATE user_info SET l_name = ? WHERE username = ?');
            $sth->execute(array($l_name, $username));

            $_SESSION['l-name'] = $l_name;

            $sm = "Update successful!";
            header("Location:../pages/user/profile.php?succ=" . $sm);
        } catch (PDOException $e) {
            $em = "Something went wrong. Try again later";
            header("Location:../pages/user/profile.php?error=" . $em);
        }
    }
    if (isset($_POST['age'])  && !empty($_POST['age'])) {
        $age = $_POST['age'];

        try {
            # SQL Query to Database, set correct variable to session variable and 
            # reroute back to profile page
            $sth = $dbh->prepare('UPDATE user_info SET age = ? WHERE username = ?');
            $sth->execute(array($age, $username));

            $_SESSION['age'] = $age;

            $sm = "Update successful!";
            header("Location:../pages/user/profile.php?succ=" . $sm);
        } catch (PDOException $e) {
            $em = "Something went wrong. Try again later";
            header("Location:../pages/user/profile.php?error=" . $em);
        }
    }
} else {
    $em = "You have to set something first!";
    header("Location:../pages/user/profile.php?error2=" . $em);
}
