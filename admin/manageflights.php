<?php 
    include_once 'header.php';
    include_once 'includes/dbh-inc.php';
    include_once 'includes/functions-inc.php';
?>


<div class = "page-title">Manage Flights</div>
    <form id = "form1" style = "height:20%;" method="post">

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
    //first does query 
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
            
            echo "<form id='form2' method='post'>";
            echo "<input type='button' onclick='check2()' value='Cancel Flights(s)'>";

            $results = queryFlight1($connect, $flight, $flight_date);
            $index = 0;
            if(mysqli_num_rows($results)){
                $data = array();
                echo'<div class = "page-subtitle-title">Select Checkbox(es) and Press Cancel Flight Button</div>';
                
                echo "<table>";
                echo "<tr><th>Flight #</th><th>Flight Date</th><th>First Class Seats</th><th>Economy Class Seats</th><th>Cancel</th></tr>";
                while($row = $results->fetch_array(MYSQLI_ASSOC)){

                    $cancel_checkbox = '<input type="checkbox" name="selected_rows[]" value='.$index.'><br>';
                    
                    echo "<tr><td>" .($row['flight_ID']) . "</td><td>" . ($row['flight_date']) . "</td><td>" . ($row['firstclass_seats']) . "</td><td>". ($row['firstclass_seats']) ."</td><td>".$cancel_checkbox."</td></tr>";  
                    
                    $data[] = $row;
                    $index+=1;  
                }
                echo "</table>"; 
                echo "<input type='hidden' name='size' value=".$index.">";
                echo '<input type="hidden" name="submitted2" value="1">';
                
                $_SESSION['results'] = $data;
            }
            else{ 
                echo'<div class = "page-subtitle-title">No Flights Found</div>';
            }

        }
        else if($flight!=""){ //query just flight 

            echo "<form id='form2' method='post'>";
            echo "<input type='button' onclick='check2()' value='Cancel Flights(s)'>";

            $results = queryFlight2($connect, $flight);
            $index = 0;
            
            if(mysqli_num_rows($results)){
                $data = array();
                echo'<div class = "page-subtitle-title">Select Checkbox(es) and Press Cancel Flight Button</div>';
            
                echo "<table>";
                echo "<tr><th>Flight #</th><th>Flight Date</th><th>First Class Seats</th><th>Economy Class Seats</th><th>Cancel</th></tr>";
                while($row = $results->fetch_array(MYSQLI_ASSOC)){

                    $cancel_checkbox = '<input type="checkbox" name="selected_rows[]" value='.$index.'><br>';
                    
                    echo "<tr><td>" .($row['flight_ID']) . "</td><td>" . ($row['flight_date']) . "</td><td>" . ($row['firstclass_seats']) . "</td><td>". ($row['firstclass_seats']) ."</td><td>".$cancel_checkbox."</td></tr>";  
                    
                    $data[] = $row;
                    $index+=1;  
                }
                echo "</table>"; 
                echo "<input type='hidden' name='size' value=".$index.">";
                echo '<input type="hidden" name="submitted2" value="1">';
                $_SESSION['results'] = $data;

            }
            else{ 
                echo'<div class = "page-subtitle-title">No Flights Found</div>';
            }
        }
        else{  //querry just date
            echo "<form id='form2' method='post'>";
            echo "<input type='button' onclick='check2()' value='Cancel Flights(s)'>";

            $results = queryFlight3($connect, $flight_date);
            $index = 0;

            if(mysqli_num_rows($results)){
                $data = array();
                echo'<div class="page-subtitle-title">Select Checkbox(es) and Press Cancel Flight Button</div>';

                echo "<table>";
                echo "<tr><th>Flight #</th><th>Flight Date</th><th>First Class Seats</th><th>Economy Class Seats</th><th>Cancel</th></tr>";
                while($row = $results->fetch_array(MYSQLI_ASSOC)){

                    $cancel_checkbox = '<input type="checkbox" name="selected_rows[]" value='.$index.'><br>';
                    
                    echo "<tr><td>" .($row['flight_ID']) . "</td><td>" . ($row['flight_date']) . "</td><td>" . ($row['firstclass_seats']) . "</td><td>". ($row['firstclass_seats']) ."</td><td>".$cancel_checkbox."</td></tr>";  
                    
                    $data[] = $row;
                    $index+=1;  
                }
                echo "</table>";
                echo "<input type='hidden' name='size' value=".$index.">";
                echo '<input type="hidden" name="submitted2" value="1">';
                $_SESSION['results'] = $data;

            }
            else{ 
                echo'<div class = "page-subtitle-title">No Flights Found</div>';
            }
        }
    }

    if(isset($_POST["submitted2"])){
        $selected_rows = $_POST["selected_rows"]; 
        $size = $_POST["size"];
        $results = $_SESSION['results'];
        

        for($i = 0; $i<$size; $i++){ 
            if (IsChecked('selected_rows',$i)){ 
                $d = $results[$i];
                adminCancelFlight($connect, $d["flight_ID"],$d["flight_date"]);
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
                document.getElementById("form1").submit();
            }
            else{ 
                alert(Error);
            }

        }

        function check2(){ 
            const checkbox_check = document.querySelectorAll('input[type="checkbox"]:checked').length > 0;
            if(checkbox_check){
                document.getElementById("form2").submit();
            }
            else{ 
                alert("Please select one or more flights to cancel");
            }
        }

</script>


<?php 
    include_once 'footer.php'
?>
