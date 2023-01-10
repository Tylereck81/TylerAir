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

    echo '<div class="page-title">Query Results:</div>';
    

    //round trip searches two tickets
    if($ticket_type=="round_trip"){

        $ticket_index1 = 0;
        $ticket_index2 = 0;

        if($depCity=="" || $arrCity=="" || $depart_date=="" || $return_date== ""|| $seat_class==""){ 
            header("location: index.php?error=noinformation");
            exit();
        }
        
        
        $result1 = queryFlight($connect, $depCity, $arrCity, $depart_date,$seat_class,$tickets);
        $result2 = queryFlight($connect, $arrCity, $depCity, $return_date,$seat_class,$tickets);


        /************************ DEPARTURE FLIGHT *************************/

        echo "<form id='form' action='bookflight.php' method='post'>";
        echo "<input type='button' onclick='check2()' value='Book Ticket'>";

        echo "<h2>".$depCity." to ".$arrCity."</h2>";
        echo "<h3> Departure Date: ".$depart_date."</h3>";

        if(mysqli_num_rows($result1)){ //if there is any flights
            
            //data array stores the results data in session
            $data1 = array();
            
            echo "<table>";
            echo "<tr><th>Flight #</th><th>Departure Time</th><th>Arrival Time</th><th>Price</th><th>Buy</th></tr>";
            while($row = $result1->fetch_array(MYSQLI_ASSOC)){
                $seat_disp = ($seat_class == "first")? ($row['firstclass_price']) : ($row['economyclass_price']);
                $log_disp = (isset($_SESSION["userid"]))? " <input type='radio' name='ticket1' value='".$ticket_index1."'>" : "Login to Continue";
                
                echo "<tr><td>" .($row['flight_ID']) . "</td><td>" . ($row['departure_time']) . "</td><td>" . ($row['arrival_time']) . "</td><td>". $seat_disp ."</td><td>". $log_disp ."</td></tr>";  
                
                $data1[] = $row;
                $ticket_index1+=1;  
            }
            echo "</table>"; 
            
            //holds number of tickets they want to buy
            echo "<input type='hidden' id='tickets' name='tickets' value='".$tickets."'>";

            if(isset($_SESSION["userid"])){
                $_SESSION['ticket_type'] = $ticket_type; #ticket type
                $_SESSION['results1'] = $data1; #table results sent to other page
                $_SESSION['seat_class'] = $seat_class; #which class selection
            }
            
        }
        else{
            echo "<h3> NO FLIGHTS FOUND </h3>";
        }

        echo '<hr>';

        
        /************************ RETURN FLIGHT *************************/

        echo "<h2>".$arrCity." to ".$depCity."</h2>";
        echo "<h3> Return Date: ".$return_date."</h3>";

        if(mysqli_num_rows($result2)){ //if there is any flights
            
            //data array stores the results data in session
            $data2 = array();
            
            echo "<table>";
            echo "<tr><th>Flight #</th><th>Departure Time</th><th>Arrival Time</th><th>Price</th><th>Buy</th></tr>";
            while($row = $result2->fetch_array(MYSQLI_ASSOC)){
                $seat_disp = ($seat_class == "first")? ($row['firstclass_price']) : ($row['economyclass_price']);
                $log_disp = (isset($_SESSION["userid"]))? " <input type='radio' name='ticket2' value='".$ticket_index2."'>" : "Login to Continue";
                
                echo "<tr><td>" .($row['flight_ID']) . "</td><td>" . ($row['departure_time']) . "</td><td>" . ($row['arrival_time']) . "</td><td>". $seat_disp ."</td><td>". $log_disp ."</td></tr>";  
                
                $data2[] = $row;
                $ticket_index2+=1;  
            }
            echo "</table>"; 


            if(isset($_SESSION["userid"])){
                $_SESSION['results2'] = $data2;
            }
            
        }
        else{
            echo "<h3> NO FLIGHTS FOUND </h3>";
        }
    }
    else{ 
        $ticket_index = 0;

        if($depCity=="" || $arrCity=="" || $depart_date=="" | $seat_class==""){ 
            header("location: index.php?error=noinformation");
            exit();
        }


        $result = queryFlight($connect, $depCity, $arrCity, $depart_date,$seat_class,$tickets);

        echo "<form id='form' action='bookflight.php' method='post'>";
        echo "<input type='button' onclick='check()' value='Book Ticket'>";

        echo "<h2>".$depCity." to ".$arrCity."</h2>";
        echo "<h3> Departure Date: ".$depart_date."</h3>";


        if(mysqli_num_rows($result)){ //if there are any flights
            
            //data array stores the results data in session
            $data = array();
            
            echo "<table>";
            echo "<tr><th>Flight #</th><th>Departure Time</th><th>Arrival Time</th><th>Price</th><th>Buy</th></tr>";
            while($row = $result->fetch_array(MYSQLI_ASSOC)){
                $seat_disp = ($seat_class == "first")? ($row['firstclass_price']) : ($row['economyclass_price']);
                $log_disp = (isset($_SESSION["userid"]))? " <input type='radio' name='ticket' value='".$ticket_index."'>" : "Login to Continue";
                
                echo "<tr><td>" .($row['flight_ID']) . "</td><td>" . ($row['departure_time']) . "</td><td>" . ($row['arrival_time']) . "</td><td>". $seat_disp ."</td><td>". $log_disp ."</td></tr>";  
                
                $data[] = $row;
                $ticket_index+=1;  
            }
            echo "</table>"; 
            
            echo "<input type='hidden' id='tickets' name='tickets' value='".$tickets."'>";

            if(isset($_SESSION["userid"])){
                $_SESSION['ticket_type'] = $ticket_type;
                $_SESSION['results'] = $data;
                $_SESSION['seat_class'] = $seat_class;
            }
            
        }
        else{
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

    function check2(){ 
        var ticket1="";
        var ticket2="";
        const radioButtons1 = document.querySelectorAll('input[name="ticket1"]');
        for (const radioButton of radioButtons1) {
            if (radioButton.checked) {
                ticket1 = radioButton.value;
                break;
            }
        }

        const radioButtons2 = document.querySelectorAll('input[name="ticket2"]');
        for (const radioButton of radioButtons2) {
            if (radioButton.checked) {
                ticket2 = radioButton.value;
                break;
            }
        }

        if (ticket1!="" && ticket2!=""){ 
            document.getElementById("form").submit();
        }
        else{ 
            alert("Select a ticket to book");
        }

    }


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