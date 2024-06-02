<?php
    function prof_check($username){
        try{
            require "DBConn.php";
            
            $sth = $dbh->prepare('SELECT * FROM user_profiles WHERE username= ?');
            $sth->execute([$username]);
    
            $rownum = count($sth->fetchAll());
    
            if($rownum > 0){
                return true;
            }else{
                return false;
            }
    
        }catch(PDOException $e){
            $em = 'Error retrieving profile info. Please try again later.';
            header("../pages/sign_in_page.php?error=" . $em);
        }
    }
    
?>