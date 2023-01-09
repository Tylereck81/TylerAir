<?php 
    include_once 'header.php';
    include_once 'includes/dbh-inc.php';
    include_once 'includes/functions-inc.php';
?>

<?php 

if(isset($_GET["error"])){
    if($_GET["error"] == "addedflight"){ 
        echo "<h3>Successfully Added Flight</h3>";
    }
    else{ 
        echo "<h3>Something went wrong, try again</h3>";
    }
}

if(isset($_SESSION["userid"])){
    
    $today = date('Y-m-d');

    echo"<div class='page-title'>Today's Flights</div>";
    echo "<form id='form'>";
    $todays_flights = queryFlight3($connect, $today);
    if(mysqli_num_rows($todays_flights)){
        echo '<table>';
        echo '<tr><th>Flight ID</th><th>Flight Date</th><th>Departure Airport</th><th>Arrival Airport</th><th>FC Seats</th><th>EC Seats</th></tr>';
        while($row = $todays_flights->fetch_array(MYSQLI_ASSOC)){
            $flight_search = getFlightInfo($connect, $row['flight_ID']);
            
            if(mysqli_num_rows($flight_search)){
                while($row2 = $flight_search->fetch_array(MYSQLI_ASSOC)){
                    echo "<tr><td>" .($row['flight_ID']) . "</td><td>" . ($row['flight_date']) . "</td><td>" . ($row2['departure_airport']) . "</td><td>" . ($row2['destination_airport']) . "</td><td>" . ($row['firstclass_seats']) . "</td><td>". ($row['economyclass_seats']) ."</td></tr>";  
                }
            }

        }
        echo "</table>";
        
    }
    else{ 
        echo'<div class = "page-subtitle-title">No Flights Found</div>';
    }
    echo "</form>";


    echo"<div class='page-title'>Canceled Flights</div>";
    echo "<form id='form'>";
    $canceled = getCanceledFlights($connect,$today);
    if(mysqli_num_rows($canceled)){
        echo '<table>';
        echo '<tr><th>Flight ID</th><th>Flight Date</th><th>Departure Airport</th><th>Arrival Airport</th><th>FC Seats</th><th>EC Seats</th></tr>';
        while($row = $canceled->fetch_array(MYSQLI_ASSOC)){
            $flight_search = getFlightInfo($connect, $row['flight_ID']);
            if(mysqli_num_rows($flight_search)){
                while($row2 = $flight_search->fetch_array(MYSQLI_ASSOC)){
                    echo "<tr><td>" .($row['flight_ID']) . "</td><td>" . ($row['flight_date']) . "</td><td>" . ($row2['departure_airport']) . "</td><td>" . ($row2['destination_airport']) . "</td><td>" . ($row['firstclass_seats']) . "</td><td>". ($row['economyclass_seats']) ."</td></tr>";  
                }
            }

        }
        echo "</table>";
        echo "</form>";

    }
    else{ 
        echo'<div class = "page-subtitle-title">No Flights Found</div>';
    }



    
   
}
?>

<?php 
    include_once 'footer.php'
?>

