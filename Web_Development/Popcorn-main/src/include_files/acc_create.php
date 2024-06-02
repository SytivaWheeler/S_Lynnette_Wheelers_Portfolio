<?php
require("DBConn.php");

if (isset($_POST['user']) && isset($_POST['pwd']) && isset($_POST['email'])) {

    # User entered data
    $username = $_POST['user'];
    $pass_word = $_POST['pwd'];
    $email = $_POST['email'];

    try {
        #SQL Query to Database
        $sth = $dbh->prepare('INSERT INTO user_info (username,pass_word,email) VALUES (?,?,?)');
        $sth->execute(array($username, $pass_word, $email));

        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['profilebool'] = false;

        header("Location:../pages/profile_gen.php");

    } catch (PDOException $e) {

        $usercheck = $sth->fetchAll(\PDO::FETCH_ASSOC);

        #Check specific error code. If 23000, sign in matches other existing user
        if($e->getCode() == '23000'){

            #SQL Query to Database
            $sth2 = $dbh->prepare('SELECT * FROM user_info WHERE username = ?');
            $sth2->execute(array($username));

            #SQL Query result
            $usercheck = $sth2->fetchAll(\PDO::FETCH_ASSOC);

            #If username matches, that was the source of the 23000 error, 
            #otherwise it was the email.

            if ($usercheck[0]['username'] == $username) {
                $em = "This username is in use already! Please try different one..";
            }else{
                $em = "A user with this email already exists! Try signing in..";
            }

        }else{
            $em = 'Error has occured. Please try again later.';
        }

        header("Location:../pages/create_account.php?error=" . $em);
    }
}
?>
