<?php 
    include_once 'header.php'
?>

<?php 
if(isset($_SESSION["userid"])){ 
    $name = $_SESSION["userfname"]; 
    echo "Hello ".$name. "";
}
?>

<?php 
    include_once 'footer.php'
?>

