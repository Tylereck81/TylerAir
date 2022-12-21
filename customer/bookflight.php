<?php
    include_once 'header.php';
    include_once 'includes/dbh-inc.php';
    include_once 'includes/functions-inc.php';

    $ticket_type = $_POST["ticket_type"];

    if($ticket_type == "round_trip"){

        $results1 = $_SESSION["results1"];
        $results2 = $_SESSION["results2"];
        $ticket_index1 = $_POST["ticket1"];
        $ticket_index2 = $_POST["ticket2"];
        $tickets = $_POST["tickets"];

        echo '<h2> CHOSEN FLIGHTS </h2>';
        $data1 = $results1[$ticket_index1];
        echo 'Departure Flight: ' .$data1['flight_ID'];
        echo '<br>';
        $data2 = $results2[$ticket_index2];
        echo 'Departure Flight: ' .$data2['flight_ID'];

    }
    else{
        $results = $_SESSION["results"];
        $tickets = $_POST["tickets"];
        $ticket_index = $_POST["ticket"];



        echo '<h2> CHOSEN FLIGHT </h2>';
        $data = $results[$ticket_num];
        echo 'Flight: ' .$data['flight_ID'];
    }
    


?>


<?php
    include_once 'footer.php'
?> 