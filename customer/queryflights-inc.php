<?php
    include_once 'header.php';
    include_once 'includes/dbh-inc.php';
    include_once 'includes/functions-inc.php';

    $depCity = $_POST["departureCity"];
    $arrCity = $_POST["arrivalCity"];
    $depart_date = $_POST["depart_date"];
    $return_date = $_POST["return_date"];
    $ticket_type = $_POST["ticket_type"];
    $seat_class = $_POST["seat_class"];
    $tickets = $_POST["tickets"];
    $ticket_num = 0;

    if($ticket_type=="round_trip"){

        if($depCity=="" || $arrCity=="" || $depart_date=="" || $return_date== ""|| $seat_class==""){ 
            header("location: index.php?error=noinformation");
            exit();
        }
    }
    else{ 

        if($depCity=="" || $arrCity=="" || $depart_date=="" | $seat_class==""){ 
            header("location: index.php?error=noinformation");
            exit();
        }

        $result = queryFlight($connect, $depCity, $arrCity, $depart_date, $return_date, $ticket_type,$seat_class,$tickets);

        echo "<h2>".$depCity." to ".$arrCity."</h2>";
        echo "<h3> Departure Date: ".$depart_date."</h3>";

        if(mysqli_num_rows($result)){ //if there is any flights
            
            //data array stores the results data in session
            $data = array();

            echo "<form id='form' action='bookflight.php' method='post'>";
            
            echo "<table>";
            echo "<tr><th>Flight #</th><th>Departure Time</th><th>Arrival Time</th><th>Price</th><th>Buy</th></tr>";
            while($row = $result->fetch_array(MYSQLI_ASSOC)){
                $seat_disp = ($seat_class == "first")? ($row['firstclass_price']) : ($row['economyclass_price']);
                $log_disp = (isset($_SESSION["userid"]))? " <input type='radio' name='ticket' value='".$ticket_num."'>" : "Login to Continue";
                
                echo "<tr><td>" .($row['flight_ID']) . "</td><td>" . ($row['departure_time']) . "</td><td>" . ($row['arrival_time']) . "</td><td>". $seat_disp ."</td><td>". $log_disp ."</td></tr>";  
                
                $data[] = $row;
                $ticket_num+=1;  
            }
            echo "</table>"; 

            echo "<input type='hidden' id='tickets' name='tickets' value='".$tickets."'>";

            $_SESSION['results'] = $data;

            echo "<input type='button' onclick='check()' value='Book Ticket'>";
            
        }
        else{
            echo "<h2>".$depCity." to ".$arrCity."</h2>";
            echo "<h3> NO FLIGHTS FOUND </h3>";
        }

        /*
        UPDATE flight_schedule
        SET economyclass_seats=6
        WHERE flight_ID="TA038" AND flight_date="2022-12-26";
        */
    }
        
?>

<script>
    function check(){ 
        var ticket="";
        const radioButtons = document.querySelectorAll('input[name="ticket"]');
        for (const radioButton of radioButtons) {
            if (radioButton.checked) {
                ticket = radioButton.value;
                break;
            }
        }

        if (ticket!=""){ 
            document.getElementById("form").submit();
        }
        else{ 
            alert("Select a ticket to book");
        }

    }
</script> 
    
            

<?php
    include_once 'footer.php'
?> 