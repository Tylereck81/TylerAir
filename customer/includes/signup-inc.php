<?php
    //checks if the submit button was pressed so that we
    //cannot access this page by URL
    if(isset($_POST["submit"])){ 
        $fname = $_POST["fname"];
        $mname = $_POST["mname"];
        $lname = $_POST["lname"];
        $phone_num = $_POST["phone_num"];
        $email = $_POST["email"];
        $passport = $_POST["passport"];
        $user_priv = 0;
        $uid = $_POST["uid"];
        $password = $_POST["pwd"];
        $passwordRepeat = $_POST["pwdrepeat"];

        require_once 'dbh-inc.php'; 
        require_once 'functions-inc.php';
        
        //checks if the entered all NEEDED values 
        if(!check_NotEmpty($fname, $lname, $phone_num, $email, $passport, $uid, $password, $passwordRepeat)){ 
            header("location: ../signup.php?error=inputempty");
            exit();
        }

        //checks if it is a valid username
        if(!check_validUid($uid)){ 
            header("location: ../signup.php?error=invaliduid");
            exit();
        }

        //checks if the email is valid
        if(!check_validEmail($email)){ 
            header("location: ../signup.php?error=invalidemail");
            exit();
        }

        //checks if the passwords that were entered match
        if(!check_passwordMatch($password,$passwordRepeat)){ 
            header("location: ../signup.php?error=passwordmismatch");
            exit();
        }

        //checks if the username exists
        if(uid_ifExists($uid,$email,$passport,0,$connect)){ 
            header("location: ../signup.php?error=uidexists");
            exit();
        }

        createUser($connect, $fname, $mname, $lname, $phone_num, $email, $passport, $user_priv, $uid, $password);



    }
    else{ 
        header("location:../signup.php");
    }

?>