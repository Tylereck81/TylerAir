<?php 
    include_once 'header.php';
    include_once 'includes/dbh-inc.php';
    include_once 'includes/functions-inc.php';
?>


<div class="page-title">Add Flights</div>
    <form id = "form" style = "height:125%;" action="includes/addflights-inc.php" method="post">

        <label>Flight ID: <?php 
           $f = getMax($connect,1) +1;
           if($f>100){ 
            echo 'TA'.$f;
           }
           elseif($f>10){ 
            echo 'TA0'.$f;
           }
           else{ 
            echo 'TA00'.$f;
           }
        ?>
        </label>

        <div class="page-subtitle-title"><hr>Departure<hr></div>
        
       
        <br>
        <br>
       
        <label>Departure City:</label> <select name="departureCity" id = "departureCity" required> 
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
        <label>Departure Time</label>
        <input type="time" name="departure_time" id = "departure_time" required > 
        <br><br>

        <div class="page-subtitle-title"><hr>Arrival<hr></div>
        <label>Arrival City:</label> <select name="arrivalCity" id = "arrivalCity" required> 
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
        <label>Arrival Time: </label>
        <input type="time" name="arrival_time" id = "arrival_time" required > 
        <br><br>
        <div class="page-subtitle-title"><hr>Schedule<hr></div>
        <label>Date Start:</label>
        <input type="date" name="start_date" id = "start_date" required />
        <br>

        <label>Date End:</label>
        <input type="date" name="end_date" id = "end_date" required />
        <br> 

        <label>Week Schedule: <br>
        <input type="checkbox" name="week_schedule[]" value="mon">Monday<br>
        <input type="checkbox" name="week_schedule[]" value="tue">Tuesday<br>
        <input type="checkbox" name="week_schedule[]" value="wed">Wednesday<br>
        <input type="checkbox" name="week_schedule[]" value="thu">Thursday<br>
        <input type="checkbox" name="week_schedule[]" value="fri">Friday<br>
        <input type="checkbox" name="week_schedule[]" value="sat">Saturday<br>
        <input type="checkbox" name="week_schedule[]" value="sun">Sunday<br>
        </label>

        <br>
        <div class="page-subtitle-title"><hr>Airplane<hr></div>
        <label>Airplane Name:</label>
        <select name="airplane" id = "airplane" required> 
            <option value="">..Select...</option> 
            <?php

            $query_city = "SELECT * FROM airplanes;";
            $result = $connect->query($query_city);
            
            while($row = $result->fetch_array()){
                ?> 
                <option value="<?php echo $row['airplane_name']; ?>"> <?php echo $row['airplane_name']; ?></option>
           <?php 
           }
           ?>
        </select> <br>

        <label>First Class Price: $<label>
        <input type="number" name="first_class_price" id = "first_class_price" min="1" step="any" value="0" required />
        <br>
        
        <label>Economy Class Price: $</label>
        <input type="number" name="economy_class_price" id = "economy_class_price" min="1" step="any" value="0" required />
        <br>

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
            var airplane = document.getElementById("airplane").value;
            var first_class_price  = document.getElementById("first_class_price").value;
            var economy_class_price = document.getElementById("economy_class_price").value;

            const checkbox_check = document.querySelectorAll('input[type="checkbox"]:checked').length > 0;
            
            if(depCity=="" || arrCity=="" || dep_time == "" || arr_time == "" || start_date == "" || end_date == ""){
                Error +="Please enter required data\n";
            }
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

            if(!checkbox_check){
                Error += "Please schedule of flight\n";
            }

            if(first_class_price <=0){ 
                Error += "First Class Price should be more than 0\n";
            }

            if(economy_class_price <=0){ 
                Error += "Economy Class Price should be more than 0\n";
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