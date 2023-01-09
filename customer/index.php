<?php
    include_once 'header.php';
    include_once 'includes/dbh-inc.php';
    include_once 'includes/functions-inc.php';
?> 
<?php 
    if(isset($_SESSION["userid"])){ 
        echo 'Welcome '.$_SESSION["useruid"]."!";
    }
    if(isset($_GET["error"])){ 
        if($_GET["error"] == "none"){ 
            echo "<p>Booking Successful! Go to My Flights to see booked tickets!</p>";
        }
    }

?> 


<div class="page-title">Flight Inquiry</div>
    <form id = "form" action="queryflights-inc.php" method="post">
        
        <label id = "radio_titles">Round Trip</label><input type="radio" name="ticket_type" value="round_trip" checked = "checked" >
        <label id = "radio_titles">One Way</label><input type="radio" name="ticket_type" value="one_way">
        <br>
        <br>



        <label style="margin-left:25px;">From:</label> <select style="margin-right:49px" name="departureCity" id = "departureCity" required> 
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
        </select>


        <label >To:</label> <select name="arrivalCity" id = "arrivalCity" required> 
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
        </select>

        <label>Class:</label> <select name="seat_class" id = "seat_class" required> 
            <option value="">..Select...</option> 
            <option value="first">First Class</option> 
            <option value="econ">Economy</option> 
        </select> <br>
       
        <label style="margin-right:8px;">Depart:</label>
        <input type="date" name="depart_date" id = "depart_date" required />

        <label>Return:</label>
        <input type="date" name="return_date" id = "return_date" required />
        <br> 
        <br>
        

        <label>Number of Tickets:</label>
        <button type="button" onclick="onMinusClick()">-</button>
        <a id="clicks">1</a>
        <button type="button" onclick="onAddClick()">+</button>

        <input type="hidden" id="tickets" name="tickets" value="">

        <input type='button' onclick="check()" value="Search">
    </form>

    <script>
        var tickets = 1;

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
            document.getElementById("tickets").value= tickets; 


            
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
                if (tickets<=0){ 
                    Error += "Tickets needs to be more than 0\n";
                }
                if(tickets>10){ 
                    Error += "Max ticket amount per user is 10\n";
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
                if (tickets<=0){ 
                    Error += "Tickets needs to be more than 0\n";
                }
                if(tickets>10){ 
                    Error += "Max ticket amount per user is 10\n";
                }
                 
            }


            if(Error == ""){
               document.getElementById("form").submit();
               
            }
            else{ 
                alert(Error);
            }

        }


        function onAddClick(){
            if(tickets+1 <=10){
                tickets+=1;
                document.getElementById("clicks").innerHTML = tickets;
            } 
            
        }

        function onMinusClick(){
            if(tickets-1>=0){ 
                tickets-=1;
                document.getElementById("clicks").innerHTML = tickets;
            }
        }
    </script>


<?php
    include_once 'footer.php'
?> 