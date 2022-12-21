<?php
    include_once 'header.php';
    include_once 'includes/dbh-inc.php';
    include_once 'includes/functions-inc.php';


    $results = $_SESSION["results"];
    $tickets = $_POST["tickets"];
    $ticket_num = $_POST["ticket"];

    echo '<h2> CHOSEN FLIGHT </h2>';
    $data = $results[$ticket_num];
    echo 'Flight: ' .$data['flight_ID'];


?>


<?php
    include_once 'footer.php'
?> 