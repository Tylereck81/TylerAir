<?php

    include_once 'dbh-inc.php';
    include_once 'functions-inc.php';

    $depCity = $_POST["departureCity"];
    $arrCity = $_POST["arrivalCity"];
    $depart_date = $_POST["depart_date"];
    $return_date = $_POST["return_date"];
    $ticket_type = $_POST["ticket_type"]

    if($depCity=="" || $arrCity=="" || $depart_date=="" || $return_date== "" || $ticket_type==""){ 
        header("location:../addflights.php?error=noinformation");
        exit();
    }
    
    queryFlight($connect, $depCity, $arrCity, $depart_date, $return_date, $ticket_type);
    


?>