<?php
    include_once 'header.php'
?>

<?php
    if(isset($_GET["error"])){ 
        $ERRORS = ""; 
        if($_GET["error"] == "inputempty"){ 
            $ERRORS.="Input Empty: Please fill in all required fields";
        }
        else if($_GET["error"] == "doesNotExist"){ 
            $ERRORS.= "Username does not exist. Sign up and try again";
        }
        else if($_GET["error"] =="passwordIncorrect"){ 
            $ERRORS.= "Password is incorrect";
        }
        echo '<span class="error">'.$ERRORS.' </span>';
    }

?> 

<div class="page-title">Login</div>
    <form  style = "height:23%;" action="includes/login-inc.php" method="post">
        <div id = "parent" style="text-align:center; background-color: #333;" >
            <div id="child">
                <label>Username/Email</label>
                <br>
                <input type= "text" name="uid" placeholder="Username/Email"> 
            </div>
        
            <br>
            <div id="child">
                <label>Password</label>
                <br>
                <input type= "password" name="pwd" placeholder="Password">
                <br>
                <input type='submit' name="submit">
            </div>
        </div>
        

    </form>

<?php
    include_once 'footer.php'
?> 