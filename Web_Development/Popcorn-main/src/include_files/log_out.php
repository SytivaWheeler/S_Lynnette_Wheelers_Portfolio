<?php
    session_start();
    $_SESSION = array();
    session_destroy();

    header("Location:../pages/sign_in_page.php");
?>