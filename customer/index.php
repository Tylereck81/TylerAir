<?php
    include_once 'header.php';
    include_once 'includes/dbh-inc.php';
    include_once 'includes/functions-inc.php';
?> 
 

<h2>Query Flights</h2>
    <form id = "form" action="queryflights-inc.php" method="post">
        
        <input type="radio" name="ticket_type" value="round_trip" checked = "checked" >Round Trip
        <input type="radio" name="ticket_type" value="one_way">One Way
        <br>
        <br>


        From: <select name="departureCity" id = "departureCity" required> 
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


        To: <select name="arrivalCity" id = "arrivalCity" required> 
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

        Class: <select name="seat_class" id = "seat_class" required> 
            <option value="">..Select...</option> 
            <option value="first">First Class</option> 
            <option value="econ">Economy</option> 
        </select> <br>
       
        <br><br>
        Depart:
        <input type="date" name="depart_date" id = "depart_date" required />
        <br>

        Return:
        <input type="date" name="return_date" id = "return_date" required />
        <br> 


        <input type='button' onclick="check()" value="Search">
    </form>

    <script>
        function check(){
            var Error = "";
            var trip_type="";
            
            
            
            const radioButtons = document.querySelectorAll('input[name="ticket_type"]');
            for (const radioButton of radioButtons) {
                if (radioButton.checked) {
                    trip_type = radioButton.value;
                    break;
                }
            }

            
            
            var depCity = document.getElementById("departureCity").value;
            var arrCity = document.getElementById("arrivalCity").value;
            var depart_date = document.getElementById("depart_date").value;
            var return_date = document.getElementById("return_date").value;
            
            
            var seat_class = document.getElementById("seat_class").value; 


            
            if(trip_type == "round_trip"){ 
                if(depCity=="" || arrCity=="" || depart_date=="" || return_date== "" || seat_class==""){
                    Error +="Please enter required data\n";
                }

                if(depCity == arrCity){
                    Error += "Departure City and Arrival City cannot be the same\n";
                }

                let currentDate = new Date().toJSON().slice(0, 10);
                if(depart_date<=currentDate){ 
                    Error += "Depart date should be after today\n";
                }
                if(depart_date>return_date){ 
                    Error += "Depart date should be after return date\n";
                }
                
            }
            else{ 

                if(depCity=="" || arrCity=="" || depart_date=="" || seat_class==""){
                    Error +="Please enter required data\n";
                }

                if(depCity == arrCity){
                    Error += "Departure City and Arrival City cannot be the same\n";
                }

                let currentDate = new Date().toJSON().slice(0, 10);
                if(depart_date<=currentDate){ 
                    Error += "Depart date should be after today\n";
                }
                 
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
    include_once 'footer.php'
?> 