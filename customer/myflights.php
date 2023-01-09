<?php
    include_once 'header.php';
    include_once 'includes/dbh-inc.php';
    include_once 'includes/functions-inc.php';

?>
<div class="page-title">My Flights</div>
<?php
    $data = array();
    if(isset($_SESSION["useruid"])){
        $userid = $_SESSION["userid"];
        $bid = 0;
        $result = getUserFlights($connect, $userid,1);
        #MY TICKETS
        echo "<form id='form' method='post'>";
        echo '<div class="page-subtitle-title"><hr>My Tickets<hr></div><br><br>';
        if(mysqli_num_rows($result)){

            while($row = $result->fetch_array(MYSQLI_ASSOC)){
                echo '<div class="ticket_details">';
                echo "Ticket ID: " .($row['ticket_ID'])."<br>";
                echo "Flight ID: " .($row['flight_ID'])."<br>";
                echo "Flight Date: " . ($row['flight_date'])."<br>";
                $flight_result = getFlightInfo($connect,$row['flight_ID']);
                while($row2 = $flight_result->fetch_array(MYSQLI_ASSOC)){
                    
                    $depAirp = getAirportInfo($connect, $row2['departure_airport']);
                    $arrAirp = getAirportInfo($connect, $row2['destination_airport']);
                    echo '('.$depAirp["city"].' -> '.$arrAirp["city"].')<br>';
                    
                    echo $depAirp["airport_name"] ." (". $depAirp["airport_ID"].") to " . $arrAirp["airport_name"] ." (". $arrAirp["airport_ID"].")<br>";
                }

                if ($row['section'] == "first")
                    echo "Section: First Class <br>";
                else 
                echo "Section: Economy <br>";
                echo "Bag Number: " . ($row['bag_number'])."<br>";
                echo "Number of Tickets ".($row['number_tickets'])."<br>";
                echo "Ticket Price: " .($row['ticket_price'])."<br>";
                // echo '<button id = '.$bid.' onClick="check(this.id)">Cancel</button><br>';
                echo '<button type ="submit" name="id" value='.$bid.'>Cancel</button>';
                echo "<br>";
                echo "<br>";
                echo '</div>';
                $bid+=1;
                $data[] = $row;
            }
        }
        else{
            echo "<h3> NO FLIGHTS FOUND </h3>";
        }


        $result1 = getUserFlights($connect, $userid,0);
        #CANCELLED TICKETS
        echo '<div class="page-subtitle-title"><hr>My Cancelled Tickets<hr></div><br><br>';
        if(mysqli_num_rows($result1)){
            while($row = $result1->fetch_array(MYSQLI_ASSOC)){
                echo '<div class="ticket_details">';
                echo "Ticket ID: " .($row['ticket_ID'])."<br>";
                echo "Flight ID: " .($row['flight_ID'])."<br>";
                echo "Flight Date: " . ($row['flight_date'])."<br>";
                $flight_result = getFlightInfo($connect,$row['flight_ID']);
                while($row2 = $flight_result->fetch_array(MYSQLI_ASSOC)){
                    
                    $depAirp = getAirportInfo($connect, $row2['departure_airport']);
                    $arrAirp = getAirportInfo($connect, $row2['destination_airport']);
                    echo '('.$depAirp["city"].' -> '.$arrAirp["city"].')<br>';
                    
                    echo $depAirp["airport_name"] ." (". $depAirp["airport_ID"].") to " . $arrAirp["airport_name"] ." (". $arrAirp["airport_ID"].")<br>";
                }

                if ($row['section'] == "first")
                    echo "Section: First Class <br>";
                else 
                echo "Section: Economy <br>";
                echo "Bag Number: " . ($row['bag_number'])."<br>";
                echo "Number of Tickets ".($row['number_tickets'])."<br>";
                echo "Ticket Price: " .($row['ticket_price'])."<br>";
                echo "<br>";
                echo "<br>";

                echo '</div>';
            }
        }
        else{
            echo "<h3> NO FLIGHTS FOUND </h3>";
        }

        $result2 = getUserFlights($connect, $userid,2);
        #Cancelled Flights
        echo '<div class="page-subtitle-title"><hr>Cancelled Flights<hr></div><br><br>';
        if(mysqli_num_rows($result2)){
            while($row = $result2->fetch_array(MYSQLI_ASSOC)){
                echo '<div class="ticket_details">';
                echo "Ticket ID: " .($row['ticket_ID'])."<br>";
                echo "Flight ID: " .($row['flight_ID'])."<br>";
                echo "Flight Date: " . ($row['flight_date'])."<br>";
                $flight_result = getFlightInfo($connect,$row['flight_ID']);
                while($row2 = $flight_result->fetch_array(MYSQLI_ASSOC)){
                    
                    $depAirp = getAirportInfo($connect, $row2['departure_airport']);
                    $arrAirp = getAirportInfo($connect, $row2['destination_airport']);
                    echo '('.$depAirp["city"].' -> '.$arrAirp["city"].')<br>';
                    
                    echo $depAirp["airport_name"] ." (". $depAirp["airport_ID"].") to " . $arrAirp["airport_name"] ." (". $arrAirp["airport_ID"].")<br>";
                }

                if ($row['section'] == "first")
                    echo "Section: First Class <br>";
                else 
                echo "Section: Economy <br>";
                echo "Bag Number: " . ($row['bag_number'])."<br>";
                echo "Number of Tickets ".($row['number_tickets'])."<br>";
                echo "Ticket Price: " .($row['ticket_price'])."<br>";
                echo "<br>";
                echo "<br>";
                echo '</div>';
            }
        }
        else{
            echo "<h3> NO FLIGHTS FOUND </h3>";
        }


    }
    else{ 
        header("location: index.php");
        exit();
    }

    if(isset($_POST['id'])){ 
        $index = $_POST['id'];
        $r = $data[$index];
        userCancelFlight($connect,$r["ticket_ID"],$_SESSION["userid"], $r["flight_ID"], $r["flight_date"], $r["number_tickets"],$r["section"]);
        unset($_POST['id']);
        header("Refresh:0");
    }

    

?>

<?php
    include_once 'footer.php'
?> 