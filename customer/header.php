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
            <li><a href="index.php">Home</a></li>
            <?php 
            //need to check if the user is logged in
            if(isset($_SESSION["useruid"])){
                $name = $_SESSION["useruid"];
                echo '<li><a href="myflights.php">My Flights</a></li>';
                echo "<li><a href='profile.php'>Profile</a></li>";
                echo "<li><a href='includes/logout-inc.php'>Logout</a></li>";
            }
            else{
                echo"<li><a href='signup.php'>Sign Up</a></li>";
                echo"<li><a href='login.php'>Login</a></li>";

            }
            ?> 
        </ul> 
        </nav>
