<?php

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


function uid_ifExists($connect,$uid,$email){
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


function logIn($connect, $uid, $password){
     
    $result  = uid_ifExists($connect,$uid,$uid);
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

function IsChecked($chkname,$value)
{
    if(!empty($_POST[$chkname]))
    {
        foreach($_POST[$chkname] as $chkval)
        {
            if($chkval == $value)
            {
                return true;
            }
        }
    }
    return false;
}


function make_schedule(){ 
    $result="";
    $days = array('mon','tue','wed','thu','fri','sat','sun');

    foreach($days as $d){ 
        if (IsChecked('week_schedule',$d)){ 
            $result.='1';
        }
        else{ 
            $result.='0';
        }
    }

    return $result;
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

function getMax($connect,$m){ 
    if ($m){ 
        $query_maxID = "SELECT MAX(flight_id) FROM flights_seq;";
        $result = $connect -> query($query_maxID);
        $row = $result ->fetch_array(MYSQLI_NUM);
        return $row[0];
    }
    else{ 
        $query_maxID = "SELECT MAX(flight_id) FROM flights;";
        $result = $connect -> query($query_maxID);
        $row = $result ->fetch_array(MYSQLI_NUM);
        return $row[0];
    }
    
}

function getAirplaneID($connect, $airplane){ 
    $query_airplane = "SELECT * FROM airplanes WHERE airplane_name=?";
    
    if(!($stmt = $connect->prepare($query_airplane))){ 
        header("location: ../addflights.php?error=stmtpreparefailure");
        exit();
    }

    //binds the statement with the actual data
    
    if(!($stmt ->bind_param("s",$airplane))){ 
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

function insertFlight($connect, $depCity, $arrCity, $depTime, $arrTime, $date_start, $date_end, $flight_schedule, $airplane, $first_class_price, $economy_class_price){
    $depAirport = getAirportCode($connect, $depCity);
    $arrAirport = getAirportCode($connect, $arrCity);
    $airplane_ID = getAirplaneID($connect, $airplane);

    $flight_duration = round(abs(strtotime($arrTime) - strtotime($depTime)) / 60,2);

    $query_insertflight = "INSERT INTO flights(departure_airport,destination_airport,departure_time,arrival_time,flight_duration,date_start,date_end,week_schedule,airplane_ID,firstclass_price,economyclass_price) VALUES(?,?,?,?,?,?,?,?,?,?,?);";
    
    if(!($stmt = $connect->prepare($query_insertflight))){ 
        header("location: ../addflights.php?error=stmtpreparefailure1");
        exit();
    }

    //binds the statement with the actual data
    if(!($stmt ->bind_param("sssssssssss",$depAirport["airport_ID"],$arrAirport["airport_ID"],$depTime,$arrTime,$flight_duration,$date_start,$date_end,$flight_schedule,$airplane_ID["airplane_ID"],$first_class_price,$economy_class_price))){ 
        header("location: ../addflights.php?error=stmtbindfailure1");
        exit();
    }

    if(!($stmt ->execute())){ 
        header("location: ../addflights.php?error=stmtexecutefailure1");
        exit();
    }
    $stmt->close();
    header("location: ../adminindex.php?error=addedflight");

    $flight_ID = getMax($connect,0);

    populate_FlightSchedule($connect, $flight_ID, $date_start, $date_end, $flight_schedule, $airplane);

}

function populate_FlightSchedule($connect, $flight_ID, $date_start, $date_end, $flight_schedule, $airplane){
    $begin = new DateTime($date_start);
    $end = new DateTime($date_end);

    $interval = DateInterval::createFromDateString('1 day');
    $period = new DatePeriod($begin, $interval, $end);

    $airplaneinfo = getAirplaneInfo($connect, $airplane);

    $firstclassSeats = $airplaneinfo["first_class"];
    $economyclassSeats = $airplaneinfo["economy_class"];
    $status = 1;

    foreach ($period as $dt) {
        $date = $dt->format("Y-m-d");

        if(check_DateInSchedule($flight_schedule,$date)){

            $query_scheduleFlight = "INSERT INTO flight_schedule(flight_ID,flight_date,firstclass_seats,economyclass_seats,flight_status) VALUES(?,?,?,?,?);";

            if(!($stmt = $connect->prepare($query_scheduleFlight))){ 
                header("location: ../addflights.php?error=stmtpreparefailure2");
                exit();
            }
        
            //binds the statement with the actual data
            if(!($stmt ->bind_param("sssss",$flight_ID,$date,$firstclassSeats,$economyclassSeats,$status))){ 
                header("location: ../addflights.php?error=stmtbindfailure2");
                exit();
            }
        
            if(!($stmt ->execute())){ 
                header("location: ../addflights.php?error=stmtexecutefailure2");
                exit();
            }

            $stmt->close();
            header("location: ../adminindex.php?error=addedflight");
        }

    }


}

function getAirplaneInfo($connect, $airplane){ 
    $query_airplane = "SELECT * FROM airplanes WHERE airplane_name = ?;";
    
    if(!($stmt = $connect->prepare($query_airplane))){ 
        header("location: ../addflights.php?error=stmtpreparefailure");
        exit();
    }

    //binds the statement with the actual data
    
    if(!($stmt ->bind_param("s",$airplane))){ 
        header("location: ../addflights.php?error=stmtbindfailure");
        exit();
    }

    if(!($stmt ->execute())){ 
        header("location: ../addflights.php?error=stmtexecutefailure");
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

function check_DateInSchedule($flight_schedule,$date){ 
    $dayofweek = date('w', strtotime($date))-1;
    if($dayofweek == -1){ 
        $dayofweek = 6;
    }
    
    $result = 0;
    if($flight_schedule[$dayofweek]){ 
        $result = true; 
    }
    else{ 
        $result = false; 
    }
    return $result;
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

function queryFlight1($connect, $flight, $flight_date){ 
    $query_flight = "SELECT * FROM flight_schedule WHERE flight_ID = ? AND flight_date = ? AND flight_status = 1;";
    
    if(!($stmt = $connect->prepare($query_flight))){ 
        header("location: ../manageflights.php?error=stmtpreparefailure");
        exit();
    }

    //binds the statement with the actual data
    
    if(!($stmt ->bind_param("ss",$flight,$flight_date))){ 
        header("location: ../manageflights.php?error=stmtbindfailure");
        exit();
    }

    if(!($stmt ->execute())){ 
        header("location: ../manageflights.php?error=stmtexecutefailure");
        exit();
    }

    if(!($result = $stmt->get_result())){ 
        header("location: ../manageflights.php?error=stmtresultfailure");
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

function queryFlight2($connect, $flight){ 
    $query_flight = "SELECT * FROM flight_schedule WHERE flight_ID = ?  AND flight_status = 1;";

    if(!($stmt = $connect->prepare($query_flight))){ 
        header("location: ../manageflights.php?error=stmtpreparefailure");
        exit();
    }

    //binds the statement with the actual data
    
    if(!($stmt ->bind_param("s",$flight))){ 
        header("location: ../manageflights.php?error=stmtbindfailure");
        exit();
    }

    if(!($stmt ->execute())){ 
        header("location: ../manageflights.php?error=stmtexecutefailure");
        exit();
    }

    if(!($result = $stmt->get_result())){ 
        header("location: ../manageflights.php?error=stmtresultfailure");
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

function queryFlight3($connect, $flight_date){ 
    $query_flight = "SELECT * FROM flight_schedule WHERE flight_date = ?  AND flight_status = 1;";
    
    if(!($stmt = $connect->prepare($query_flight))){ 
        header("location: ../manageflights.php?error=stmtpreparefailure");
        exit();
    }

    //binds the statement with the actual data
    
    if(!($stmt ->bind_param("s",$flight_date))){ 
        header("location: ../manageflights.php?error=stmtbindfailure");
        exit();
    }

    if(!($stmt ->execute())){ 
        header("location: ../manageflights.php?error=stmtexecutefailure");
        exit();
    }

    if(!($result = $stmt->get_result())){ 
        header("location: ../manageflights.php?error=stmtresultfailure");
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

function adminCancelFlight($connect, $flight_ID, $flight_date){ 
    $query_cancel = " UPDATE flight_schedule SET flight_status = 0 WHERE flight_ID = ?  AND flight_date = ?;";
    
    if(!($stmt = $connect->prepare($query_cancel))){ 
        header("location: manageflights.php?error=stmtpreparefailure");
        exit();
    }

    //binds the statement with the actual data
    
    if(!($stmt ->bind_param("ss",$flight_ID,$flight_date))){ 
        header("location: manageflights.php?error=stmtbindfailure");
        exit();
    }

    if(!($stmt ->execute())){ 
        header("location: manageflights.php?error=stmtexecutefailure");
        exit();
    }

    $stmt->close();
}

function getCanceledFlights($connect,$flight_date){ 
    $query_flight = "SELECT * FROM flight_schedule WHERE flight_date >= ?  AND flight_status = 0;";
    
    if(!($stmt = $connect->prepare($query_flight))){ 
        header("location: ../manageflights.php?error=stmtpreparefailure");
        exit();
    }

    //binds the statement with the actual data
    
    if(!($stmt ->bind_param("s",$flight_date))){ 
        header("location: ../manageflights.php?error=stmtbindfailure");
        exit();
    }

    if(!($stmt ->execute())){ 
        header("location: ../manageflights.php?error=stmtexecutefailure");
        exit();
    }

    if(!($result = $stmt->get_result())){ 
        header("location: ../manageflights.php?error=stmtresultfailure");
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

?>