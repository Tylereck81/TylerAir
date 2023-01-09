<?php
    session_start(); 

?> 

<html>
    <head>
        <link rel="stylesheet" type = "text/css" href="style.css"> 
        <meta charset="utf-8"> 
        <title>Tyler Air</title>
    </head>
    <body>
        <a href="adminindex.php"><img style = "display: inline-block; margin-right: 20px;"src="TA_logo.png" alt="Tyler Air" height = "150px" width = " 300px"></a>
        <?php 
            if(isset($_SESSION["useruid"])){
                echo '<div style = "float:right;">Logged In: '.$_SESSION["useruid"].'</div>';
            }
        ?>
        <nav>
        <ul>   
            <?php 
            //need to check if admin is logged in
            if($_SESSION["useruid"] == "admin"){
                echo '<li><a href="adminindex.php">Home</a></li>';
                echo '<li><a href="addflights.php">Add Flight</a></li>';
                echo "<li><a href='manageflights.php'>Manage Flights</a></li>";
                echo "<li><a href='includes/adminlogout-inc.php'>Logout</a></li>";
            }
            else{
                header("location: adminlogin.php");
            }
            ?> 
        </ul> 
        </nav>
