<?php

    include_once 'dbh-inc.php';
    include_once 'functions-inc.php';

    $depCity = $_POST["departureCity"];
    $depTime = $_POST["departure_time"];
    $arrCity = $_POST["arrivalCity"];
    $arrTime = $_POST["arrival_time"];
    $date_start = $_POST["start_date"];
    $date_end = $_POST["end_date"];
    $schedule = $_POST["week_schedule"];
    $flight_schedule = "";
    $airplane = $_POST["airplane"];
    $first_class_price = $_POST["first_class_price"];
    $economy_class_price = $_POST["economy_class_price"];
    

    if($depCity == NULL ||  $depTime == NULL || $arrCity == NULL || $arrTime == NULL || $date_start == NULL || $date_end == NULL || $schedule == NULL || $airplane == NULL || $first_class_price == NULL || $economy_class_price == NULL){ 
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


    insertFlight($connect, $depCity, $arrCity, $depTime, $arrTime, $date_start, $date_end, $flight_schedule, $airplane, $first_class_price, $economy_class_price);
    


?>