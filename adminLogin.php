<?php
    session_start();
    $adminId = 1234;
    $adminPswd= "1234";

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['adminLoginBtn'])){
        $ckid = $_POST['adId'];
        $ckpd = $_POST['adpd'];

        $error='';

        if(empty($ckid)){
            $error.='<p> Please enter email. </p>';
            
        }
        if(empty($ckpd)){
            $error.='<p> Please enter password. </p>';
        }

      
        
        if(empty($error)){
            if($adminId == $ckid){
                if($adminPswd == (string)$ckpd){
                    echo "Succes2";
                    header("location: admin.php");
                            exit;
                }
                else{
                    $error.= "Incorrect Paassword";
                }
                
            }
            else{
                $error.= "You are not Admin";
            }
        }
        echo $error;
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="index2.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body style= "background-color:wheat;">
    <div class="signUpBody">
    <div class="signupForm">
        <form action='adminLogin.php' method='post' class ="sgform">

            <div id="admintitle">
                Admin Login
            </div>        
            <p id ="loginstart">
                Enter the Login Credentials.
            </p>
            
            <div class="FormContainer">
                <label for="adId" class="label">Admin ID:</label>
                <input type="number" name="adId"  id = "adId" class="inputField"><br/>
            </div>

            <div class="FormContainer">
                <label for="adpd" class="label">Password:</label>
                <input type="password" name="adpd" id = "adpd" class="inputField"><br/>
            </div>

            <input type="submit" name="adminLoginBtn" class="loginBtn">

        </form>

   
    </div>
<p id="basetwo"><a href="signup.php">Register</a></p>   
<p id="basethree"><a href="login.php">User Login</a></p>
</div>
<!-- <a href="adminLogin.php" id="adminlogin">Admin Login</a> -->
</body>

</html>