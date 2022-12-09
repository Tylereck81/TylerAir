 <?php 
    $serverName = "localhost"; 
    $dbUserName = "root"; 
    $dbPassword = "password";
    $dbName = "TylerAir";

    $connect = mysqli_connect($serverName, $dbUserName, $dbPassword,$dbName);

    if($connect->connect_error){ 
        die("Connect Failed: ".$connect->connect_error);
    }
   
 ?>