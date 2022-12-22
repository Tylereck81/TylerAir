<?php
    include_once 'header.php';
    include_once 'includes/dbh-inc.php';
    include_once 'includes/functions-inc.php';

    if (isset($_POST['submitted'])){ 
        $ticket_type = $_SESSION["ticket_type"];
        if($ticket_type == "round_trip"){

        }
        else{ 


        }



    }
    else{ 
        $ticket_type = $_SESSION["ticket_type"];

        if($ticket_type == "round_trip"){

            $results1 = $_SESSION["results1"];
            $results2 = $_SESSION["results2"];
            $ticket_index1 = $_POST["ticket1"];
            $ticket_index2 = $_POST["ticket2"];
            $tickets = $_POST["tickets"];
            $user_ID = $_SESSION["useruid"];

            echo "<form id='form' action='' method='post'>";

            //data1 used as result data from user selection (from table)
            $data1 = $results1[$ticket_index1];
            $data2 = $results2[$ticket_index2];
            $depAirp = getAirportInfo($connect, $data1['departure_airport']); 
            $retAirp = getAirportInfo($connect, $data2['departure_airport']);

            echo '<h2>CONFIRMATION:</h2>';

            echo '<h3>User Information</h3>';
            echo '* CONFIRM THAT INFORMATION IS CORRECT *<br>'; 
            echo '* IF CHANGES NEED TO BE MADE, GO TO PROFILE *<br><br>'; 

            $userinfo = uid_ifExists($user_ID,$user_ID,$user_ID,0,$connect);
            echo "Full Name: ";
            echo $userinfo["user_fname"]." ".$userinfo["user_mname"]." ".$userinfo["user_lname"]."<br>";
            echo "Email: ".$userinfo["user_email"]."<br>";
            echo "Passport: ".$userinfo["user_passport_number"]."<br><br>";


            echo '<h3>Flight Information</h3>';
            echo '<h4>Outbound ('.$depAirp["city"].' -> '.$retAirp["city"].')</h4>';
            
            echo 'Flight: ' .$data1['flight_ID'];
            echo '<br><br>';
            
            echo $depAirp["airport_name"] ."(". $depAirp["airport_ID"].")<br>";
            echo $data1["flight_date"]."(".$data1["departure_time"].")";
            echo '<br><br>';

            echo $retAirp["airport_name"] ."(". $retAirp["airport_ID"].")<br>";
            echo $data1["flight_date"]."(".$data1["arrival_time"].")";

            echo '<br><br>';
            echo 'Bags per person: <select name="bags1" id = "bags1" required>';
            echo '<option value="">..Select...</option>';
            echo '<option value="1">1</option>';
            echo '<option value="2">2</option>';
            echo '<option value="3">3</option>';
            echo '</select> <br>';
            echo '* Each Ticket includes 1 baggage for free. Additional bags are 500NT each * ';


            echo '<h4>Inbound ('.$retAirp["city"].' -> '.$depAirp["city"].')</h4>';
            
            echo 'Flight: ' .$data2['flight_ID'];
            echo '<br><br>';
            
            echo $retAirp["airport_name"] ."(". $retAirp["airport_ID"].")<br>";
            echo $data2["flight_date"]."(".$data2["departure_time"].")";
            echo '<br><br>';

            echo $depAirp["airport_name"] ."(". $depAirp["airport_ID"].")<br>";
            echo $data2["flight_date"]."(".$data2["arrival_time"].")";

            echo '<br><br>';
            echo 'Bags per person: <select name="bags2" id = "bags2" required>';
            echo '<option value="">..Select...</option>';
            echo '<option value="1">1</option>';
            echo '<option value="2">2</option>';
            echo '<option value="3">3</option>';
            echo '</select> <br>';
            echo '* Each Ticket includes 1 baggage for free. Additional bags are 500NT each * ';

            echo '<br><br>';


            echo '<input type="button" onclick="check2()" value="Confirm Booking">';
            echo '<input type="hidden" name="submitted" value="1" />';

            echo '</form>';

        }
        else{

            $results = $_SESSION["results"];
            $tickets = $_POST["tickets"];
            $ticket_index = $_POST["ticket"];
            $user_ID = $_SESSION["useruid"];

            echo "<form id='form' action='' method='post'>";

            //data1 used as result data from user selection (from table)
            $data = $results[$ticket_index];
            $depAirp = getAirportInfo($connect, $data['departure_airport']);
            $retAirp = getAirportInfo($connect, $data['destination_airport']); 

            echo '<h2>CONFIRMATION:</h2>';

            echo '<h3>User Information</h3>';
            echo '* CONFIRM THAT INFORMATION IS CORRECT *<br>'; 
            echo '* IF CHANGES NEED TO BE MADE, GO TO PROFILE *<br><br>'; 

            $userinfo = uid_ifExists($user_ID,$user_ID,$user_ID,0,$connect);
            echo "Full Name: ";
            echo $userinfo["user_fname"]." ".$userinfo["user_mname"]." ".$userinfo["user_lname"]."<br>";
            echo "Email: ".$userinfo["user_email"]."<br>";
            echo "Passport: ".$userinfo["user_passport_number"]."<br><br>";


            echo '<h3>Flight Information</h3>';
            echo '<h4>Outbound ('.$depAirp["city"].' -> '.$retAirp["city"].')</h4>';
            
            echo 'Flight: ' .$data['flight_ID'];
            echo '<br><br>';
            
            echo $depAirp["airport_name"] ."(". $depAirp["airport_ID"].")<br>";
            echo $data["flight_date"]."(".$data["departure_time"].")";
            echo '<br><br>';

            echo $retAirp["airport_name"] ."(". $retAirp["airport_ID"].")<br>";
            echo $data["flight_date"]."(".$data["arrival_time"].")";

            echo '<br><br>';
            echo 'Bags per person: <select name="bags" id = "bags" required>';
            echo '<option value="">..Select...</option>';
            echo '<option value="1">1</option>';
            echo '<option value="2">2</option>';
            echo '<option value="3">3</option>';
            echo '</select> <br>';
            echo '* Each Ticket includes 1 baggage for free. Additional bags are 500NT each * ';
            echo '<br>';

            echo '<input type="button" onclick="check1()" value="Confirm Booking">';
            echo '<input type="hidden" name="submitted" value="1" />';

            echo '</form>'; 
            echo '<br>';

        }

    }



?>

<script> 
    function check1(){
        var Error = "";
        var bags = document.getElementById("bags").value; 
    
        if(bags == ""){ 
            Error += "Please enter in bag amount for flight";
        }

        if(Error==""){
            const response = confirm("Are you sure?"); 
            if(response){
                document.getElementById("form").submit();
            } 
            
        }
        else{ 
            alert(Error);
        }

    }

    function check2(){
        var Error = "";
        var bags1 = document.getElementById("bags1").value; 
        var bags2 = document.getElementById("bags2").value; 

        if(bags1 == "" || bags2 == ""){ 
            Error += "Please enter in bag amount for each flight";
        }

        if(Error==""){
            const response = confirm("Are you sure?"); 
            if(response){ 
                document.getElementById("form").submit();
            } 
            
        }
        else{ 
            alert(Error);
        }
        
    }
</script> 

<?php
    include_once 'footer.php'
?> 