<?php
    include_once 'header.php'
?> 

<h2>Sign Up</h2>
    <form action="includes/signup-inc.php" method="post">
        <input type= "text" name="fname" placeholder="First Name"> 
        <input type= "text" name="mname" placeholder="Middle Name"> 
        <input type= "text" name="lname" placeholder="Last Name"> 
        <input type= "tel" name="phone_num" placeholder="123-456-789" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}">
        <input type= "text" name="email" placeholder="Email">
        <input type= "text" name="passport" placeholder="Passport Number">
        <input type= "text" name="uid" placeholder="Username"> 
        <input type= "password" name="pwd" placeholder="Password">
        <input type= "password" name="pwdrepeat" placeholder="Repeat Password">
        <button type="submit" name="submit">Sign Up</button>

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