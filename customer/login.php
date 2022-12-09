<?php
    include_once 'header.php'
?>

<h2>Login</h2>
    <form action="includes/login-inc.php" method="post">
        <input type= "text" name="uid" placeholder="Username/Email"> 
        <input type= "password" name="pwd" placeholder="Password">
        <button type="submit" name="submit">Login</button>

    </form>

    <?php
        if(isset($_GET["error"])){ 
            if($_GET["error"] == "inputempty"){ 
                echo "<p>Input Empty: Please fill in all required fields.</p>";
            }
            else if($_GET["error"] == "doesNotExist"){ 
                echo "<p>Username does not exist. Sign up and try again.</p>";
            }
            else if($_GET["error"] =="passwordIncorrect"){ 
                echo "<p>Password is incorrect.</p>";
            }
        }

    ?> 

<?php
    include_once 'footer.php'
?> 