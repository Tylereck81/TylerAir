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
        
        $result = queryFlight($connect, $depCity, $arrCity, $depart_date, $return_date, $ticket_type,$seat_class);

        echo "<h2>".$depCity." to ".$arrCity."</h2>";
        echo "<h3> Departure Date: ".$depart_date."</h3>";
        
        if(mysqli_num_rows($result)){ //if there is any flights 
           
            echo "<table>";
            echo "<tr><th>Flight #</th><th>Departure Time</th><th>Arrival Time</th><th>Price</th><th>Buy</th></tr>";
            while($row = $result->fetch_array()){
                $seat_disp = ($seat_class == "first")? ($row['firstclass_price']) : ($row['economyclass_price']);
                $log_disp = (isset($_SESSION["userid"]))? "<a href='bookflight.php'>Buy</a>" : "Login to Continue";
                
                echo "<tr><td>" .($row['flight_ID']) . "</td><td>" . ($row['departure_time']) . "</td><td>" . ($row['arrival_time']) . "</td><td>". $seat_disp ."</td><td>". $log_disp ."</td></tr>";   
            }
            echo "</table>"; 
        }
        else{
            echo "<h2>".$depCity." to ".$arrCity."</h2>";
            echo "<h3> NO FLIGHTS FOUND </h3>";
        }
        

    }
        
?>

<?php
    include_once 'footer.php'
?> 