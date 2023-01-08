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

function uid_ifExists($connect,$uid,$email,$passport){
    
    //SQL query to get if the users already exist
    $query_uid = "SELECT * FROM users WHERE user_username = ? OR user_email = ? OR user_passport_number = ? AND user_privlege = 0;";
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

function logIn($connect, $uid, $password){ 

    $result  = uid_ifExists($connect,$uid,$uid,$uid);
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

function getAirportCode($connect, $city){
    
    $query_city = "SELECT airport_ID FROM airports WHERE city = ?;";
    
    if(!($stmt = $connect->prepare($query_city))){ 
        header("location: ../addflights.php?error=stmtpreparefailure");
        exit();
    }

    //binds the statement with the actual data
    
    if(!($stmt ->bind_param("s",$city))){ 
        header("location: ../addflights.php?error=stmtbindfailure");
        exit();
    }

    if(!($stmt ->execute())){ 
        header("location: ../addflights.php?error=stmtexecutefailure1");
        exit();
    }

    if(!($result = $stmt->get_result())){ 
        header("location: ../addflights.php?error=stmtresultfailure");
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

function queryFlight($connect, $depCity, $arrCity, $depart_date,$class,$tickets){ 
    $depAirportID = getAirportCode($connect, $depCity);
    $arrAirportID = getAirportCode($connect, $arrCity);
    
    if($class == "econ"){ 
        $queryflight = 'SELECT * FROM flights NATURAL JOIN flight_schedule 
        WHERE flights.departure_airport = ? AND 
        flights.destination_airport = ? AND 
        flight_date = ? AND 
        flight_schedule.flight_status = 1 AND  
        flight_schedule.economyclass_seats>=?'; 
    }
    else{ 
        $queryflight = 'SELECT * FROM flights NATURAL JOIN flight_schedule 
        WHERE flights.departure_airport = ? AND 
        flights.destination_airport = ? AND 
        flight_date = ? AND 
        flight_schedule.flight_status = 1 AND  
        flight_schedule.firstclass_seats>=?'; 
    }

    if(!($stmt = $connect->prepare($queryflight))){ 
        header("location: index.php?error=stmtpreparefailure");
        exit();
    }

    //binds the statement with the actual data
    if(!($stmt ->bind_param("ssss",$depAirportID["airport_ID"],$arrAirportID["airport_ID"],$depart_date,$tickets))){ 
        header("location: index.php?error=stmtbindfailure");
        exit();
    }

    if(!($stmt ->execute())){ 
        header("location: index.php?error=stmtexecutefailure");
        exit();
    }

    if(!($result = $stmt->get_result())){ 
        header("location: index.php?error=stmtresultfailure");
        exit();
    }

    if($result){
        return $result; 
    }
    else{ 
        $result = false;
        return $result;
    }
}

function getAirportInfo($connect, $airportID){ 
    $query_airport = "SELECT * FROM airports WHERE airport_ID = ?;";
    
    if(!($stmt = $connect->prepare($query_airport))){ 
        header("location: bookflight.php?error=stmtpreparefailure");
        exit();
    }

    //binds the statement with the actual data
    
    if(!($stmt ->bind_param("s",$airportID))){ 
        header("location: bookflight.php?error=stmtbindfailure");
        exit();
    }

    if(!($stmt ->execute())){ 
        header("location: bookflight.php?error=stmtexecutefailure1");
        exit();
    }

    if(!($result = $stmt->get_result())){ 
        header("location: bookflight.php?error=stmtresultfailure");
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

function bookFlight($connect,$user_ID,$flight_ID,$flight_date,$section_class,$number_tickets,$bags,$TOTALPRICE,$ticket_status){ 
    $query_insert = "INSERT INTO booking(user_ID, flight_ID, flight_date, section, number_tickets, bag_number, ticket_price, ticket_status) VALUES (?,?,?,?,?,?,?,?);";
            
    if(!($stmt = $connect->prepare($query_insert))){ 
        header("location: bookflight.php?error=stmtpreparefailure");
        exit();
    }

    //binds the statement with the actual data
    if(!($stmt ->bind_param("ssssssss",$user_ID,$flight_ID,$flight_date,$section_class,$number_tickets,$bags,$TOTALPRICE,$ticket_status))){ 
        header("location: bookflight.php?error=stmtbindfailure");
        exit();
    }

    if(!($stmt ->execute())){ 
        header("location: bookflight.php?error=stmtexecutefailure1");
        exit();
    }

    changeTicketAmount($connect,$flight_ID,$flight_date,$number_tickets,$section_class);

    header("location: index.php?error=none");
    $stmt->close();

}

function changeTicketAmount($connect,$flight_ID,$flight_date,$number_tickets,$section_class){
    if($section_class == "first"){ 
        $query_update = "UPDATE flight_schedule SET firstclass_seats = firstclass_seats - ? WHERE flight_ID = ? AND flight_date = ?;";
            
        if(!($stmt = $connect->prepare($query_update))){ 
            header("location: bookflight.php?error=stmtpreparefailure");
            exit();
        }

        //binds the statement with the actual data
        if(!($stmt ->bind_param("sss",$number_tickets,$flight_ID,$flight_date))){ 
            header("location: bookflight.php?error=stmtbindfailure");
            exit();
        }

        if(!($stmt ->execute())){ 
            header("location: bookflight.php?error=stmtexecutefailure1");
            exit();
        }

        $stmt->close();
    }
    else {
        $query_update = "UPDATE flight_schedule SET economyclass_seats = economyclass_seats - ? WHERE flight_ID = ? AND flight_date = ?;";
            
        if(!($stmt = $connect->prepare($query_update))){ 
            header("location: bookflight.php?error=stmtpreparefailure");
            exit();
        }

        //binds the statement with the actual data
        if(!($stmt ->bind_param("sss",$number_tickets,$flight_ID,$flight_date))){ 
            header("location: bookflight.php?error=stmtbindfailure");
            exit();
        }

        if(!($stmt ->execute())){ 
            header("location: bookflight.php?error=stmtexecutefailure1");
            exit();
        }

        $stmt->close();

    }
    

}

function getUserFlights($connect, $userid,$ticket_status){
    
    $query_flights = "SELECT * FROM booking WHERE user_ID = ? AND ticket_status = ?";
    
    if(!($stmt = $connect->prepare($query_flights))){ 
        header("location: ../myflights.php?error=stmtpreparefailure");
        exit();
    }

    //binds the statement with the actual data
    if(!($stmt ->bind_param("ss",$userid,$ticket_status))){ 
        header("location: ../myflights.php?error=stmtbindfailure");
        exit();
    }

    if(!($stmt ->execute())){ 
        header("location: ../myflights.php?error=stmtexecutefailure1");
        exit();
    }

    if(!($result = $stmt->get_result())){ 
        header("location: ../myflights.php?error=stmtresultfailure");
        exit();
    }

    if($result){
        return $result; 
    }
    else{ 
        $result = false;
        return $result;
    }
    $stmt->close();
} 

function getFlightInfo($connect, $flight_ID){
    $query_flights = "SELECT * FROM flights WHERE flight_ID = ?;";
    
    if(!($stmt = $connect->prepare($query_flights))){ 
        header("location: ../myflights.php?error=stmtpreparefailure");
        exit();
    }

    //binds the statement with the actual data
    if(!($stmt ->bind_param("s",$flight_ID))){ 
        header("location: ../myflights.php?error=stmtbindfailure");
        exit();
    }

    if(!($stmt ->execute())){ 
        header("location: ../myflights.php?error=stmtexecutefailure1");
        exit();
    }

    if(!($result = $stmt->get_result())){ 
        header("location: ../myflights.php?error=stmtresultfailure");
        exit();
    }

    if($result){
        return $result; 
    }
    else{ 
        $result = false;
        return $result;
    }
    $stmt->close();
} 

function userCancelFlight($connect,$ticket_ID,$user_ID, $flight_ID, $flight_date, $number_tickets,$section_class){ 
    $query_cancel = "UPDATE booking SET ticket_status = 0 WHERE ticket_ID = ? AND user_ID = ? AND flight_ID = ? AND flight_date = ?; ";
    
    if(!($stmt = $connect->prepare($query_cancel))){ 
        header("location: ../myflights.php?error=stmtpreparefailure");
        exit();
    }

    //binds the statement with the actual data
    if(!($stmt ->bind_param("ssss",$ticket_ID,$user_ID,$flight_ID,$flight_date))){ 
        header("location: ../myflights.php?error=stmtbindfailure");
        exit();
    }

    if(!($stmt ->execute())){ 
        header("location: ../myflights.php?error=stmtexecutefailure1");
        exit();
    }

    updateScheduleUserCancel($connect, $flight_ID, $flight_date, $number_tickets,$section_class);
}

function updateScheduleUserCancel($connect, $flight_ID, $flight_date, $number_tickets,$section_class){
    if ($section_class == "first"){
        $query_cancel = "UPDATE flight_schedule SET firstclass_seats = firstclass_seats + ? WHERE flight_ID = ? AND flight_date = ?;";
        if(!($stmt = $connect->prepare($query_cancel))){ 
            header("location: ../myflights.php?error=stmtpreparefailure");
            exit();
        }

        //binds the statement with the actual data
        if(!($stmt ->bind_param("sss",$number_tickets,$flight_ID,$flight_date))){ 
            header("location: ../myflights.php?error=stmtbindfailure");
            exit();
        }

        if(!($stmt ->execute())){ 
            header("location: ../myflights.php?error=stmtexecutefailure1");
            exit();
        }
    }
    else{
        $query_cancel = "UPDATE flight_schedule SET economyclass_seats = economyclass_seats + ? WHERE flight_ID = ? AND flight_date = ?;";
        if(!($stmt = $connect->prepare($query_cancel))){ 
            header("location: ../myflights.php?error=stmtpreparefailure");
            exit();
        }

        //binds the statement with the actual data
        if(!($stmt ->bind_param("sss",$number_tickets,$flight_ID,$flight_date))){ 
            header("location: ../myflights.php?error=stmtbindfailure");
            exit();
        }

        if(!($stmt ->execute())){ 
            header("location: ../myflights.php?error=stmtexecutefailure1");
            exit();
        } 

    }

}

function updatePhoneNum($connect, $newPhoneNum, $user_ID){ 
    $query_edit = "UPDATE users SET user_phone_number = ? WHERE user_username = ?;";

    if(!($stmt = $connect->prepare($query_edit))){ 
        header("location: ../profile.php?error=stmtpreparefailure");
        exit();
    }

    //binds the statement with the actual data
    if(!($stmt ->bind_param("ss",$newPhoneNum,$user_ID))){ 
        header("location: ../profile.php?error=stmtbindfailure");
        exit();
    }

    if(!($stmt ->execute())){ 
        header("location:../profile.php?error=stmtexecutefailure1");
        exit();
    }
}

function updatePassword($connect, $newPassword, $user_ID){
    $query_edit = "UPDATE users SET user_password = ? WHERE user_username = ?;";

    $hash_pwd = password_hash($newPassword,PASSWORD_DEFAULT);
    
    if(!($stmt = $connect->prepare($query_edit))){ 
        header("location:../profile.php?error=stmtpreparefailure");
        exit();
    }

    //binds the statement with the actual data
    if(!($stmt ->bind_param("ss",$hash_pwd,$user_ID))){ 
        header("location:../profile.php?error=stmtbindfailure");
        exit();
    }

    if(!($stmt ->execute())){ 
        header("location:../profile.php?error=stmtexecutefailure1");
        exit();
    }
}






?>