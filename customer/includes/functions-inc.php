<?php
function check_NotEmpty($fname, $lname, $phone_num, $email, $passport, $uid, $password, $passwordRepeat){ 
    $result;
    if(empty($fname) || empty($lname) || empty($phone_num) || empty($email) ||  empty($passport) ||  empty($uid) ||  empty($password) ||  empty($passwordRepeat)){ 
        $result =  false;
    }
    else{ 
        $result =  true;
    }
    return $result;
}

function check_validUid($uid){
    $result;
    if(preg_match('/^[a-zA-Z][0-9a-zA-Z_]{5,20}[0-9a-zA-Z]$/',$uid)){ 
        $result = true;
    }
    else{ 
        $result = false;
    }
    return $result;

}

function check_validEmail($email){ 
    $result;
    if(filter_var($email,FILTER_VALIDATE_EMAIL)){ 
        $result = true;
    }
    else{ 
        $result = false;
    }
    return $result;
}

function check_passwordMatch($password, $passwordRepeat){
    $result;
    if($password == $passwordRepeat){ 
        $result= true;
    }
    else{ 
        $result= false;
    }
    return $result;
}

function uid_ifExists($uid,$email,$passport,$adminLogin,$connect){
    if($adminLogin){
         $query_uid = "SELECT * FROM users WHERE (user_username = ? OR user_email = ?) AND user_privlege = 1;";
         //prepared statements to pass in that SQL statement (prevents code injections) 
         
         if(!($stmt = $connect->prepare($query_uid))){ 
             header("location: ../adminlogin.php?error=stmtpreparefailure");
             exit();
         }
 
         //binds the statement with the actual data
         
         if(!($stmt ->bind_param("ss",$uid,$email))){ 
             header("location: ../adminlogin.php?error=stmtbindfailure");
             exit();
         }
 
         if(!($stmt ->execute())){ 
             header("location: ../adminlogin.php?error=stmtexecutefailure");
             exit();
         }
 
         if(!($result = $stmt->get_result())){ 
             header("location: ../adminlogin.php?error=stmtresultfailure");
             exit();
         }
 
         //checks if result has some data in it and return it
         $data = $result ->fetch_array(MYSQLI_ASSOC);
 
         if($data){
             return $data; 
         }
         else{
             $result = false;
             return $result;
         }
 
         $stmt->close(); 

    }
    else{ 
        //SQL query to get if the users already exist
        $query_uid = "SELECT * FROM users WHERE user_username = ? OR user_email = ? OR user_passport_number = ?;";
        //prepared statements to pass in that SQL statement (prevents code injections) 
        
        if(!($stmt = $connect->prepare($query_uid))){ 
            header("location: ../signup.php?error=stmtpreparefailure");
            exit();
        }

        //binds the statement with the actual data
        
        if(!($stmt ->bind_param("sss",$uid,$email,$passport))){ 
            header("location: ../signup.php?error=stmtbindfailure");
            exit();
        }

        if(!($stmt ->execute())){ 
            header("location: ../signup.php?error=stmtexecutefailure");
            exit();
        }

        if(!($result = $stmt->get_result())){ 
            header("location: ../signup.php?error=stmtresultfailure");
            exit();
        }

        //checks if result has some data in it and return it
        $data = $result ->fetch_array(MYSQLI_ASSOC);

        if($data){
            return $data; 
        }
        else{ 
            $result = false;
            return $result;
        }

        $stmt->close();

    }   
}

function createUser($connect, $fname, $mname, $lname, $phone_num, $email, $passport, $user_priv, $uid, $password){ 
    //SQL query to get if the users already exist
    $query_insert = "INSERT INTO users(user_fname, user_mname, user_lname, user_phone_number, user_email, user_passport_number, user_privlege, user_username, user_password) VALUES (?,?,?,?,?,?,?,?,?);";
    
    if(!($stmt = $connect->prepare($query_insert))){ 
        header("location: ../signup.php?error=stmtpreparefailure");
        exit();
    }

    $hash_pwd = password_hash($password,PASSWORD_DEFAULT);
    //$hash_pwd = $password;

    //binds the statement with the actual data
    if(!($stmt ->bind_param("sssssssss",$fname, $mname, $lname, $phone_num, $email, $passport, $user_priv, $uid, $hash_pwd))){ 
        header("location: ../signup.php?error=stmtbindfailure");
        exit();
    }

    if(!($stmt ->execute())){ 
        header("location: ../signup.php?error=stmtexecutefailure");
        exit();
    } 

    header("location: ../signup.php?error=none");

    $stmt->close();
}

function logincheck_NotEmpty($username, $password){ 
    $result;
    if(empty($username) ||  empty($password)){ 
        $result =  false;
    }
    else{ 
        $result =  true;
    }
    return $result;
}

function logIn($connect, $uid, $password, $adminLogin){ 
    //if customer is loginning in 
    if($adminLogin){
        $result  = uid_ifExists($uid,$uid,-1,$adminLogin,$connect);
        if($result){
            $p = $result["user_password"];

            // $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
            // $txt = password_hash("password",PASSWORD_DEFAULT);
            // fwrite($myfile, $txt);
            // fclose($myfile);

            //$p = substr($p,0,60);
            $check_p = password_verify($password,$p);

            if($check_p){
                session_start();
                $_SESSION["userid"] = $result["user_ID"]; 
                $_SESSION["useruid"] = $result["user_username"];
                $_SESSION["userfname"] = $result["user_fname"];
                header("location: ../adminindex.php");
                exit();
            }
            else{
                header("location: ../adminlogin.php?error=passwordIncorrect");
                exit();
            }

        }
        else {
            header("location: ../adminlogin.php?error=doesNotExist");
            exit();
        }

    }
    //admin login
    else{ 
        $result  = uid_ifExists($uid,$uid,-1,$adminLogin,$connect);
        if($result){
            $p = $result["user_password"];
            //$p = substr($p,0,60);
            $check_p = password_verify($password,$p);

            if($check_p){
                session_start();
                $_SESSION["userid"] = $result["user_ID"]; 
                $_SESSION["useruid"] = $result["user_username"];
                $_SESSION["userfname"] = $result["user_fname"];
                header("location: ../index.php");
                exit();
            }
            else{
                header("location: ../login.php?error=passwordIncorrect");
                exit();
            }

        }
        else {
            header("location: ../login.php?error=doesNotExist");
            exit();
        }     
    }

}

function queryFlight($connect, $depCity, $arrCity, $depart_date, $return_date, $ticket_type){ 
    header("location: ../adminlogin.php?error=doesNotExist");
    exit();
}




?>