<?php
    include_once 'header.php'
?> 

<div class="page-title">Sign Up</div>
    <form style = "height:70%;" action="includes/signup-inc.php" method="post">
        <label style="display: inline-block; margin-right: 20px;">Full Name: </label><br>
        <br>
        <label style="display: inline-block; margin-right: 10px; ">First Name </label><input style ="width:30%;" type= "text" name="fname" placeholder="First Name"> 
        <label style="display: inline-block; margin-right: 10px; ">Middle Name(s) </label><input style ="width:30%;" type= "text" name="mname" placeholder="Middle Name"><br><br>
        <label style="display: inline-block; margin-right: 12px;">Last Name </label><input style ="width:30%;" type= "text" name="lname" placeholder="Last Name"> 
        <br>
        <br>
        <br>

        <label style="display: inline-block; margin-right: 20px;">Personal Information: </label><br><br>
        <label>Telephone Number</label>
        <input style ="width:24.5%;" type= "tel" name="phone_num" placeholder="123-456-789" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}">
        <label>Email </label>
        <input style ="width:38%;" type= "text" name="email" placeholder="Email"><br><br>
        <label>Passport Number </label>
        <input style ="width:25.5%;" type= "text" name="passport" placeholder="Passport Number">
        <br>
        <br>
        <br>
        <label style="display: inline-block; margin-right: 20px;">Account Details: </label><br><br>

        <label>Username </label>
        <input style ="width:30.5%;" type= "text" name="uid" placeholder="Username"> 
        <br>
        <br>
        <label>Password </label>
        <input style ="width:31%;" type= "password" name="pwd" placeholder="Password">
        <label>Password Repeat</label>
        <input style ="width:31%;" type= "password" name="pwdrepeat" placeholder="Repeat Password">
        <br>
        <br>
        <input type="submit" name = "submit" value="Sign Up">
    </form>

    <?php
        if(isset($_GET["error"])){ 
            if($_GET["error"] == "inputempty"){ 
                echo "<p>Input Empty: Please fill in all required fields.</p>";
            }
            else if($_GET["error"] == "invaliduid"){ 
                echo "<p>Invalid UID: Please refer to format instructions.</p>";
            }
            else if($_GET["error"] =="invalidemail"){ 
                echo "<p>Invalid Email: Please input correct email format.</p>";
            }
            else if($_GET["error"] =="passwordmismatch"){ 
                echo "<p>Passport Mismatch: Please input matching passwords.</p>";
            }
            else if($_GET["error"] =="uidexists"){ 
                echo "<p>UID Exists: The username, email, or passport associated with the account already exists.</p>";
            }
            else if($_GET["error"] == "stmtpreparefailure" || $_GET["error"] == "stmtbindfailure" || $_GET["error"] == "stmtexecutefailure" || $_GET["error"] == "stmtresultfailure"){ 
                echo "<p>Something went wrong! Try Again.</p>";
            }
            else if($_GET["error"] == "none"){ 
                echo "<p>You have signed up! Go to Login page to log in.</p>";
            }
        }

    ?>
    

<?php
    include_once 'footer.php'
?> 