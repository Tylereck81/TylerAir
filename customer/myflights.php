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
        echo "<form style='width:50%;' id='form' method='post'>";
        echo '<div class="page-subtitle-title"><hr>My Tickets<hr></div>';
        echo "<input type='button' onclick='check()' value='Cancel Ticket(s)'><br><br>";
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
                echo 'Cancel: <input type="checkbox" name="selected_rows[]" value='.$bid.'><br>';
                echo '<input type="hidden" name="submitted" value="1" />';
                echo "<br>";
                echo "<br>";
                echo '</div>';
                $bid+=1;
                $data[] = $row;
            }
            echo "<input type='hidden' name='size' value=".$bid.">";
            $_SESSION['results'] = $data;
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

        if(isset($_POST["submitted"])){
            $selected_rows = $_POST["selected_rows"]; 
            $size = $_POST["size"];
            $results = $_SESSION['results'];
    
            for($i = 0; $i<$size; $i++){ 
                if (IsChecked('selected_rows',$i)){ 
                    $d = $results[$i];
                    userCancelTicket($connect,$d["ticket_ID"],$_SESSION["userid"], $d["flight_ID"], $d["flight_date"], $d["number_tickets"],$d["section"]);
                }
            }
            echo "<script>window.location.href='index.php?error=cancelticket';</script>";
        }
    }
    else{ 
        header("location: index.php");
        exit();
    }
?>

<script> 
function check(){ 
    const checkbox_check = document.querySelectorAll('input[type="checkbox"]:checked').length > 0;
    if(checkbox_check){
        const response = confirm("Are you sure you want to cancel these tickets?"); 
        if(response){ 
            document.getElementById("form").submit();
        } 
    }
    else{ 
        alert("Please select one or more tickets to cancel");
    }
}
</script>

<?php
    include_once 'footer.php'
?>