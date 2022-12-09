<?php
    session_start(); 

?> 

<html>
    <head> 
        <meta charset="utf-8"> 
        <title>Tyler Air</title>
    </head>
    <body>
        <nav>
        <ul>   
            <?php 
            //need to check if admin is logged in
            if($_SESSION["useruid"] == "admin"){
                echo '<li><a href="adminindex.php">Home</a></li>';
                echo '<li><a href="addflights.php">Add Flight</a></li>';
                echo "<li><a href='schedule.php'>Flight Schedule</a></li>";
                echo "<li><a href='includes/adminlogout-inc.php'>Logout</a></li>";
            }
            else{
                header("location: adminlogin.php");
            }
            ?> 
        </ul> 
        </nav>
