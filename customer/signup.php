<?php
    include_once 'header.php'
?> 


<?php  
        if(isset($_GET["error"])){
            $ERRORS = ""; 
            if($_GET["error"] == "inputempty"){ 
                $ERRORS.= 'Input Empty: Please fill in all required fields';
            }
            if($_GET["error"] == "invaliduid"){ 
                $ERRORS .= "Invalid UID: Please refer to format instructions";
            }
            if($_GET["error"] =="invalidemail"){ 
                $ERRORS .="Invalid Email: Please input correct email format";
            }
            if($_GET["error"] =="passwordmismatch"){ 
                $ERRORS .="Passport Mismatch: Please input matching passwords";
            }
            if($_GET["error"] =="uidexists"){ 
                $ERRORS .="UID Exists: The username, email, or passport associated with the account already exists";
            }
            if($_GET["error"] == "stmtpreparefailure" || $_GET["error"] == "stmtbindfailure" || $_GET["error"] == "stmtexecutefailure" || $_GET["error"] == "stmtresultfailure"){ 
                $ERRORS .="Something went wrong! Try Again";
            }
            if($_GET["error"] == "none"){ 
                echo '<h2>You have signed up! Go to Login page to log in</h2>';
            }

            echo '<span class="error">'.$ERRORS.' </span>';
        }

    ?>

<div class="page-title">Sign Up</div>
    <form style = "height:80%;" action="includes/signup-inc.php" method="post">
        <label style="display: inline-block; margin-right: 20px;">Full Name: </label><span class="error">* required field</span><br>
        <hr>
        <br>
        <label style="display: inline-block; margin-right: 10px; ">First Name </label><input style ="width:30%;" type= "text" name="fname" placeholder="First Name"><span class="error">*</span> 
        <label style="display: inline-block; margin-right: 10px; ">Middle Name(s) </label><input style ="width:30%;" type= "text" name="mname" placeholder="Middle Name"><br>
        <label style="display: inline-block; margin-right: 12px;">Last Name </label><input style ="width:30%;" type= "text" name="lname" placeholder="Last Name"><span class="error">*</span> 
        <br>
        <br>
        <br>

        <label style="display: inline-block; margin-right: 20px;">Personal Information: </label> <span class="error">* required field</span><br><br>
        <hr>
        <label>Telephone Number</label>
        <input style ="width:24.5%;" type= "tel" name="phone_num" placeholder="123-456-789" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}"><span class="error">*</span>
        <label>Email </label>
        <input style ="width:38%;" type= "text" name="email" placeholder="Email"><span class="error">*</span><br><br>
        <label>Passport Number </label>
        <input style ="width:25.5%;" type= "text" name="passport" placeholder="Passport Number"><span class="error">*</span>
        <br>
        <br>
        <br>
        <label style="display: inline-block; margin-right: 20px;">Account Details: </label><span class="error">* required field</span><br><br>
        <hr>

        <label>Username </label>
        <input style ="width:30.5%;" type= "text" name="uid" placeholder="Username"> <span class="error">*</span>
        <br>
        <br>
        <label>Password </label>
        <input style ="width:31%;" type= "password" name="pwd" placeholder="Password"><span class="error">*</span>
        <label>Password Repeat</label>
        <input style ="width:31%;" type= "password" name="pwdrepeat" placeholder="Repeat Password"><span class="error">*</span>
        <br>
        <br>
        <input type="submit" name = "submit" value="Sign Up">
    </form>
    

<?php
    include_once 'footer.php'
?> 