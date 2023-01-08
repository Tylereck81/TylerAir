<?php 
    include_once 'header.php';
    include_once 'includes/dbh-inc.php';
    include_once 'includes/functions-inc.php';
?>


<h2>Manage Flights</h2>
    <form id = "form" method="post">

        Flights: <select name="flight" id = "flight"> 
            <option value="">..Select...</option> 
            <?php
            
            $query_city = "SELECT * FROM flights;";
            $result = $connect->query($query_city);
            
            while($row = $result->fetch_array()){
                ?> 
                <option value="<?php echo $row['flight_ID']; ?>"> <?php echo $row['flight_ID']; ?></option>
           <?php 
           }
           ?>
        </select> <br><br>
        

        Flight Date: 
        <input type="date" name="flight_date" id = "flight_date">
        <br><br>

        <input type="hidden" name="submitted" value="1">

    <input type='button' onclick="check()" value="Query">
        
    </form>

<?php
    if(isset($_POST["submitted"])){
        $flight="";
        $flight_date="";
        if(isset($_POST["flight"])){ 
            $flight = $_POST["flight"];
        }
        if(isset($_POST["flight_date"])){ 
            $flight_date = $_POST["flight_date"];
        }
        
        if($flight !="" && $flight_date!=""){  //query both
            

            $results = queryFlight1($connect, $flight, $flight_date);
            $index = 0;
            if(mysqli_num_rows($results)){

                echo "<table>";
                echo "<tr><th>Flight #</th><th>Flight Date</th><th>First Class Seats</th><th>Economy Class Seats</th><th>Cancel</th></tr>";
                while($row = $results->fetch_array(MYSQLI_ASSOC)){

                    $cancel_checkbox = '<input type="checkbox" name="selected_rows[]" value='.$index.'.><br>';
                    
                    echo "<tr><td>" .($row['flight_ID']) . "</td><td>" . ($row['flight_date']) . "</td><td>" . ($row['firstclass_seats']) . "</td><td>". ($row['firstclass_seats']) ."</td><td>".$cancel_checkbox."</td></tr>";  
                    
                    $index+=1;  
                }
                echo "</table>"; 
            }
            else{ 
                echo 'No Flights Found';
            }

        }
        else if($flight!=""){ //query just flight 
            $results = queryFlight2($connect, $flight);
            $index = 0;

            if(mysqli_num_rows($results)){

            echo "<table>";
            echo "<tr><th>Flight #</th><th>Flight Date</th><th>First Class Seats</th><th>Economy Class Seats</th><th>Cancel</th></tr>";
            while($row = $results->fetch_array(MYSQLI_ASSOC)){

                $cancel_checkbox = '<input type="checkbox" name="selected_rows[]" value='.$index.'.><br>';
                
                echo "<tr><td>" .($row['flight_ID']) . "</td><td>" . ($row['flight_date']) . "</td><td>" . ($row['firstclass_seats']) . "</td><td>". ($row['firstclass_seats']) ."</td><td>".$cancel_checkbox."</td></tr>";  
                
                $index+=1;  
            }
            echo "</table>"; 
            }
            else{ 
                echo 'No Flights Found';
            }
        }
        else{  //querry just date
            $results = queryFlight3($connect, $flight_date);
            $index = 0;

            if(mysqli_num_rows($results)){
                echo "<table>";
                echo "<tr><th>Flight #</th><th>Flight Date</th><th>First Class Seats</th><th>Economy Class Seats</th><th>Cancel</th></tr>";
                while($row = $results->fetch_array(MYSQLI_ASSOC)){

                    $cancel_checkbox = '<input type="checkbox" name="selected_rows[]" value='.$index.'.><br>';
                    
                    echo "<tr><td>" .($row['flight_ID']) . "</td><td>" . ($row['flight_date']) . "</td><td>" . ($row['firstclass_seats']) . "</td><td>". ($row['firstclass_seats']) ."</td><td>".$cancel_checkbox."</td></tr>";  
                    
                    $index+=1;  
                }
                echo "</table>"; 
            }
            else{ 
                echo 'No Flights Found';
            }
        }
    }


?>

<script>
        function check(){
            var Error = "";
            var flight = document.getElementById("flight").value;
            var flight_date = document.getElementById("flight_date").value;
            if (flight=="" && flight_date==""){ 
                Error="Please enter either flight or flight date or both";
            }
            if(Error==""){
                document.getElementById("form").submit();
            }
            else{ 
                alert(Error);
            }

        }

</script>


<?php 
    include_once 'footer.php'
?>
