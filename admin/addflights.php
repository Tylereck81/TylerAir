<?php 
    include_once 'header.php';
    include_once 'includes/dbh-inc.php';
    include_once 'includes/functions-inc.php';
?>


<h2>Add Flights</h2>
    <form id = "form" action="includes/addflights-inc.php" method="post">
        DEPARTURE:<br><br>
        
        Flight ID: <?php 
           $f = getMax($connect,1) +1;
           if($f>100){ 
            echo 'TA'.$f;
           }
           else{ 
            echo 'TA0'.$f;

           }
           
        ?>
        <br>
       
        Departure City: <select name="departureCity" id = "departureCity" required> 
            <option value="">..Select...</option> 
            <?php
            
            $query_city = "SELECT * FROM airports ORDER BY city asc ;";
            $result = $connect->query($query_city);
            
            while($row = $result->fetch_array()){
                ?> 
                <option value="<?php echo $row['city']; ?>"> <?php echo $row['city']; ?></option>
           <?php 
           }
           ?>
        </select> <br>
        Departure Time: 
        <input type="time" name="departure_time" id = "departure_time" required > 
        <br><br>

        ARRIVAL<br><br>
        Arrival City: <select name="arrivalCity" id = "arrivalCity" required> 
            <option value="">..Select...</option> 
            <?php

            $query_city = "SELECT * FROM airports ORDER BY city asc;";
            $result = $connect->query($query_city);
            
            while($row = $result->fetch_array()){
                ?> 
                <option value="<?php echo $row['city']; ?>"> <?php echo $row['city']; ?></option>
           <?php 
           }
           ?>
        </select> <br>
        Arrival Time: 
        <input type="time" name="arrival_time" id = "arrival_time" required > 

        <br><br>
        Date Start: 
        <input type="date" name="start_date" id = "start_date" required />
        <br>

        Date End: 
        <input type="date" name="end_date" id = "end_date" required />
        <br> 

        Flight Price: $
        <input type="number" name="flight_price" id = "flight_price" min="1" step="any" value="0" required />
        <br>

        Week Schedule: <br>
        <input type="checkbox" name="week_schedule[]" value="mon">Monday<br>
        <input type="checkbox" name="week_schedule[]" value="tue">Tuesday<br>
        <input type="checkbox" name="week_schedule[]" value="wed">Wednesday<br>
        <input type="checkbox" name="week_schedule[]" value="thu">Thursday<br>
        <input type="checkbox" name="week_schedule[]" value="fri">Friday<br>
        <input type="checkbox" name="week_schedule[]" value="sat">Saturday<br>
        <input type="checkbox" name="week_schedule[]" value="sun">Sunday<br>
        

        <input type='button' onclick="check()" value="Add Flight">
        
    </form>

    <script>
        function check(){
            
            var Error = "";
            var depCity = document.getElementById("departureCity").value;
            var arrCity = document.getElementById("arrivalCity").value;
            var dep_time = document.getElementById("departure_time").value;
            var arr_time = document.getElementById("arrival_time").value;
            var start_date = document.getElementById("start_date").value;
            var end_date = document.getElementById("end_date").value;
            var flight_price = document.getElementById("flight_price").value;

            const checkbox_check = document.querySelectorAll('input[type="checkbox"]:checked').length > 0;
            

            if(depCity == arrCity){
                Error += "Departure City and Arrival City cannot be the same\n";
            }
            
            if(dep_time>arr_time){
                Error += "Departure Time cannot be after Arrival Time\n";
            }
            
            let currentDate = new Date().toJSON().slice(0, 10);

            if(start_date<currentDate){ 
                Error += "Start date should be more than today\n";
            }

            if(start_date>end_date){ 
                Error += "Start date should be before end date!\n";
            }

            if(flight_price <= 0 ){ 
                Error += "Please enter valid price\n";
            }

            if(!checkbox_check){
                Error += "Please schedule of flight\n";
            }

            if(Error == ""){ 
               document.getElementById("form").submit();
            }
            else{ 
                alert(Error);
            }

        }

    </script>

<?php
//1.write out forms for submissions with drop down menus for airports and allow them to pick dates 
//2. write into the airports table 
//3. Write into sections table based on available seats for each 
//4. Write into schedule table based on what dates they picked

?>


<?php 
    include_once 'footer.php'
?>