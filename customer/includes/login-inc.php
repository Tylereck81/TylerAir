<?php
    //checks if the submit button was pressed so that we
    //cannot access this page by URL
    if(isset($_POST["submit"])){

        $username = $_POST["uid"];
        $password = $_POST["pwd"];

        require_once 'dbh-inc.php'; 
        require_once 'functions-inc.php';

        //checks if the entered all NEEDED values 
        if(!logincheck_NotEmpty($username,$password)){ 
            header("location: ../login.php?error=inputempty");
            exit();
        }

        logIn($connect,$username,$password);
    }
    else{ 
        header("location: ../login.php");
    }

?> 