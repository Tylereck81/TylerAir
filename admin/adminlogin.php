<html> 
    <head>
        <link rel="stylesheet" type = "text/css" href="style.css">
        <meta charset="utf-8"> 
        <title>Tyler Air</title>
    </head>
    <body>
    <a href="adminindex.php"><img style = "display: block; margin-left: auto; margin-right: auto; "src="TA_logo.png" alt="Tyler Air" height = "150px" width = " 300px"></a>
        <?php 
            if(isset($_SESSION["useruid"])){
                echo '<div style = "float:right;">Logged In: '.$_SESSION["useruid"].'</div>';
            }
        ?>
    <hr>

    <div class = "page-title">Admin Login</div>
    <form id = "form" style ="height:15%;" action="includes/adminlogin-inc.php" method="post">
    <div id = "parent" style="text-align:center; background-color: #333;" >
        <div id="child">
            <input type= "text" name="uid" placeholder="Username/Email">
        </div>
        <div id = "child">
            <input type= "password" name="pwd" placeholder="Password"><br>
            <input type="submit" name="submit">
        </div>
        
    </div>

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