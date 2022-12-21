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
        if($depCity=="" || $arrCity=="" || $depart_date=="" || $return_date== ""|| $seat_class=""){ 
            header("location: index.php?error=noinformation");
            exit();
        }
    }
    else{ 
        if($depCity=="" || $arrCity=="" || $depart_date=="" | $seat_class=""){ 
            header("location: index.php?error=noinformation");
            exit();
        }

    }

   
    $result = queryFlight($connect, $depCity, $arrCity, $depart_date, $return_date, $ticket_type,$seat_class);

    echo "<h2>".$depCity." to ".$arrCity."</h2>";
    if(isset($_SESSION["userid"])){ //if logged in 

        if($result){ //if there is any flights 
            
            echo "<table>";
            echo "<tr><th>Flight #</th><th>Date</th><th>Departure Time</th><th>Arrival Time</th><th>Price</th><th>Buy</th></tr>";
            if($seat_class == "first"){
                while($row = $result->fetch_array()){  
                    echo "<tr><td>" .($row['flight_ID']) . "</td><td>" . ($row['flight_date']) . "</td><td>" . ($row['departure_time']) . "</td><td>" . ($row['arrival_time']) . "</td><td>" . ($row['firstclass_price']) . "</td><td><a href='bookflight.php'>Continue</a></td></tr>";   
                }
            }
            else{ 
                while($row = $result->fetch_array()){  
                    echo "<tr><td>" .($row['flight_ID']) . "</td><td>" . ($row['flight_date']) . "</td><td>" . ($row['departure_time']) . "</td><td>" . ($row['arrival_time']) . "</td><td>" . ($row['economyclass_price']) . "</td><td><a href='bookflight.php'>Continue</a></td></tr>";   
                }
            }

        }
        else{
            echo "<h2>".$depCity." to ".$arrCity."</h2>";
            echo "<h3> NO FLIGHTS FOUND </h3>";
        }
        
    }
    else{ 
        if($result){ //if there is any flights 

            echo "<table>";
            echo "<tr><th>Flight #</th><th>Date</th><th>Departure Time</th><th>Arrival Time</th><th>Price</th><th>Buy</th></tr>";
            if($seat_class == "first"){
                while($row = $result->fetch_array()){  
                    echo "<tr><td>" .($row['flight_ID']) . "</td><td>" . ($row['flight_date']) . "</td><td>" . ($row['departure_time']) . "</td><td>" . ($row['arrival_time']) . "</td><td>" . ($row['firstclass_price']) . "</td><td>Login to Buy</td></tr>";   
                }
            }
            else{ 
                while($row = $result->fetch_array()){  
                    echo "<tr><td>" .($row['flight_ID']) . "</td><td>" . ($row['flight_date']) . "</td><td>" . ($row['departure_time']) . "</td><td>" . ($row['arrival_time']) . "</td><td>" . ($row['economyclass_price']) . "</td><td>Login to Buy</td></tr>";   
                }
            }

        }
        else{
            echo "<h2>".$depCity." to ".$arrCity."</h2>";
            echo "<h3> NO FLIGHTS FOUND </h3>"; 
        }

    }

    
    
    
    

    

    echo "</table>"; 

?>

<?php
    include_once 'footer.php'
?> 