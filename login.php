<?php

 //session_start();
 

// if(isset($_SESSION["userid"]) && $_SESSION["userid"] === true){
//     header("location: items.php");
//     exit;
// }
    require_once "session.php";
    require_once "config.php";

    $error= '';
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['loginBtn'])){
        $email = trim($_POST['email']);
        $pswd= trim($_POST['pswd']);
       // $pswhas = password_hash($pswd, PASSWORD_BCRYPT);

        if(empty($email)){
            $error.='<p> Please enter email. </p>';
        }
        if(empty($pswd)){
            $error.='<p> Please enter password. </p>';
        }

        if(empty($error)){
            $query = "select * from users where email = '$email'";
            $result = mysqli_query($db,$query);
            if($result){
                if (mysqli_num_rows($result) > 0) {
               
                $row = mysqli_fetch_assoc($result);
                    if($row['password'] == $pswd ){
                        session_start();
                        $_SESSION["userid"] = $row['id'];
                        $_SESSION["name"] = $row['name'];
                        $_SESSION["email"] = $row['email'];
                        echo "Login Successful";
                        header("location: items.php");
                        exit;
                    }
                    else{
                        $error.= '<p> The password is incorrect!<p/>';
                        
                    }
                       
                }
                else{
                    $error .= '<p> No user exists with this email address. </p>';
                   echo $error;
                   }
               }
       }
       echo $error;
       mysqli_close($db);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="index2.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body style= "background-color:wheat;">
    <div class="signUpBody">
    <div class="signupForm">
        <form action='login.php' method='post' class ="sgform">

            <div id="signup">
                Login
            </div>        
            <p id ="loginstart">
                Enter the Login Credentials.
            </p>
            
            <div class="FormContainer">
                <label for="email" class="label">Email ID:</label>
                <input type="email" name="email"  id = "email" class="inputField"><br/>
            </div>

            <div class="FormContainer">
                <label for="pswd" class="label">Password:</label>
                <input type="password" name="pswd" id = "pswd" class="inputField"><br/>
            </div>

            <input type="submit" name="loginBtn" class="loginBtn">

        </form>

   
    </div>
<p id="basetwo"><a href="signup.php">Register</a></p>   
<p id="basethree"><a href="adminLogin.php">Admin Login</a></p>
</div>
<!-- <a href="adminLogin.php" id="adminlogin">Admin Login</a> -->
</body>

</html>