<html> 
    <head> 
        <meta charset="utf-8"> 
        <title>Tyler Air</title>
    </head>
    <body>

    <h2>Admin Login</h2>
    <form action="includes/adminlogin-inc.php" method="post">
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
                echo "<p>Admin Username does not exist.</p>";
            }
            else if($_GET["error"] =="passwordIncorrect"){ 
                echo "<p>Password is incorrect.</p>";
            }
        }

    ?> 

    </body>
</html>