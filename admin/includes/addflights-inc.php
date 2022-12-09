<?php

    include_once 'dbh-inc.php';
    include_once 'functions-inc.php';

    $depCity = $_POST["departureCity"];
    $depTime = $_POST["departure_time"];
    $arrCity = $_POST["arrivalCity"];
    $arrTime = $_POST["arrival_time"];
    $date_start = $_POST["start_date"];
    $date_end = $_POST["end_date"];
    $flight_price = $_POST["flight_price"];
    $schedule = $_POST["week_schedule"];
    $flight_schedule = "";

    if($depCity == NULL ||  $depTime == NULL || $arrCity == NULL || $arrTime == NULL || $date_start == NULL || $date_end == NULL || $flight_price == NULL || $schedule == NULL){ 
        header("location:../addflights.php?error=noinformation");
        exit();
    }
    
    //checks that they at least clicked one day for flight 
    if(empty($schedule)){  
        header("location:../addflights.php?error=noschedule");
        exit();
    }
    else{ 
        $flight_schedule = make_schedule();
    }


    insertFlight($connect,$depCity,$arrCity,$depTime,$arrTime,$flight_schedule,$date_start,$date_end,$flight_price);
    


?>