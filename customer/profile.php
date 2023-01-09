<?php
    include_once 'header.php';
    include_once 'includes/dbh-inc.php';
    include_once 'includes/functions-inc.php';
?>
<div class="page-title">Profile Information</div>
<?php 

if(isset($_SESSION["useruid"])){
    $useruid = $_SESSION["useruid"];
    $info = uid_ifExists($connect,$useruid,$useruid,$useruid); 
    if($info){
        
        echo '<form style="width:50%; height:42%;" id = "form" method="post">';
        echo '<label>Name</label><br><br>';
        echo 'First Name ';
        echo '<input style="color:#fff;" type= "text" name="fname" value='.$info["user_fname"].' disabled="disable">';
        echo 'Middle Name ';
        echo '<input style="color:#fff;" type= "text" name="mname" value='.$info["user_mname"].' disabled="disable">';
        echo 'Last Name ';
        echo '<input style="color:#fff;" type= "text" name="lname" value='.$info["user_lname"].' disabled="disable"><br><br>';

        echo '<label>Personal Information</label><br><br>';

        echo 'Email ';
        echo '<input style="color:#fff;" type= "text" name="email" value='.$info["user_email"].' disabled="disable">';
        echo 'Passport ';
        echo '<input style="color:#fff;" type= "text" name="passport" value='.$info["user_passport_number"].' disabled="disable">';
        echo 'Phone Number ';
        echo '<input type= "tel" id = "editpn" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" name="phone_num" value='.$info["user_phone_number"].' disabled="disable" >';
        echo '<input type="button" onclick="enable_edit_phone_number()" value="Edit"><br><br>';

        echo '<label>Login Credentials</label><br><br>';
        
        echo 'Username ';
        echo '<input style="color:#fff;" type= "text" name="uid" value='.$useruid.' disabled="disable">';
        echo 'Password ';
        echo '<input type="button" onclick="enable_edit_password()" value="Edit">';
        echo '<input type= "password" id = "editp1" name="pwd" placeholder="Password"  disabled="disable">';
        echo 'Password ';
        echo '<input type= "password" id = "editp2" name="pwdrepeat" placeholder="Repeat Password"  disabled="disable"><br><br>';
        echo '<input type="hidden" name="submitted" value="1" />';
        echo '<input type="button" id = "sub" onclick="check()" value="Make Changes" disabled="disable">';
        
    }

    if(isset($_POST["submitted"])){
        if(isset($_POST["phone_num"])){ 
            $newPhoneNum = $_POST["phone_num"];
            updatePhoneNum($connect, $newPhoneNum, $useruid);
            header("Refresh:0");
        }
        if(isset($_POST["pwd"]) && isset($_POST["pwdrepeat"])){ 
            $pwd = $_POST["pwd"];
            updatePassword($connect, $pwd, $useruid);
            header("location: includes/logout-inc.php");
        }
    }

}
else{ 
    header("location: index.php");
    exit();
}

?>

<script>
    function enable_edit_phone_number(){ 
        document.getElementById("editpn").disabled = false;
        document.getElementById("sub").disabled = false;
    }

    function enable_edit_password(){ 
        document.getElementById("editp1").disabled = false;
        document.getElementById("editp2").disabled = false;
        document.getElementById("sub").disabled = false;
    }

    function check(){

        if(document.getElementById("editp1").disabled == false &&  document.getElementById("editp2").disabled == false && document.getElementById("editpn").disabled == false){ 
            //change all
            var Error = "";
            var phone_num = document.getElementById("editpn").value;
            var password1 = document.getElementById("editp1").value;
            var password2 = document.getElementById("editp2").value;

            if(phone_num == ""){ 
                Error += "Please enter phone number\n";
            }
            if(password1 == "" || password2 == ""){ 
                Error += "Please enter in passwords\n";
            }
            if(password1!=password2){ 
                Error += "Please enter in same password\n";
            }
            if(Error==""){
                const response = confirm("Are you sure you want to change?"); 
                if(response){
                    document.getElementById("form").submit();
                }
            }
            else{ 
                alert(Error);
            }
        }
        else if(document.getElementById("editpn").disabled == false){ 
            //change JUST phone number
            var Error = "";
            var phone_num = document.getElementById("editpn").value;

            if(phone_num == ""){ 
                Error += "Please enter phone number\n";
            }

            if(Error==""){
                const response = confirm("Are you sure you want to change?"); 
                if(response){
                    document.getElementById("form").submit();
                }
            }
            else{ 
                alert(Error);
            }
        }
        else{ 
            //change JUST password
            var Error = "";
            var password1 = document.getElementById("editp1").value;
            var password2 = document.getElementById("editp2").value;

            if(password1 == "" || password2 == ""){ 
                Error += "Please enter in passwords\n";
            }
            if(password1!=password2){ 
                Error += "Please enter in same password\n";
            }
            if(Error==""){
                const response = confirm("Are you sure you want to change? Changing password will result in automatic sign out."); 
                if(response){
                    document.getElementById("form").submit();
                }
            }
            else{ 
                alert(Error);
            }
        }
        
    
        
    }

</script>

<?php
    include_once 'footer.php'
?> 