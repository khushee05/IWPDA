<?php

require_once "config.php";
 
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signUpBtn'])){
 
    $name = trim($_POST['name']);
    $phno = trim($_POST['phno']);
    $email = trim($_POST['email']);
    $pswd = trim($_POST['pswd']);
    $con_pswd = trim($_POST['con_pswd']);
   // $password_has = password_hash($pswd, PASSWORD_BCRYPT);
    

    if($query = $db->prepare("SELECT * FROM users WHERE email =?")){
        $error = '';
        $query->bind_param('s', $email);
        $query->execute();
        $query->store_result();
        if($query->num_rows>0){
            $error .= '<p class="state"> Email address is already registered! </p>';

        }
        else{
            if(strlen($pswd)<6){
                $error.='<p> Password must have atleast 6 characters. </p>';
            }
            if(empty($con_pswd)){
                $error.='<p> Please enter confirm password. <p>';
            }
            else{
                if(empty($error) && ($pswd != $con_pswd)){
                        $error.='<p> Password did not match. </p>';
                }
            }

            if(empty($error)){
                $insetquery = $db->prepare("INSERT into users (name, email, password, contact) VALUES (?,?,?,?);");
                $insetquery->bind_param("ssss",$name,$email,$pswd,$phno);
                $result =$insetquery->execute();
                if($result){
                    $error.='<p class="state"> Registration Successful! </p>';
                }
                else{
                    $error.='<p> Something went wrong </p>';
                }
                $insetquery->close();
            }
        }
        echo $error;
    }


    $query->close();
    
    mysqli_close($db);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="index.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
</head>
<body class="signUpBody">
    
    <div class="signupForm">
        <form action='signup.php' method="post" class ="sgform">
        <div id="signup">
        Sign Up
    </div>
    <div id="title">
        Please fill the details to create an account.
    </div>
            <div class="FormContainer">
                <label for="name" class="label">Full name:</label>
                <input type="text" id = "name" name="name" class="inputField" required><br/>
            </div>
          
            

            <div class="FormContainer">
                <label for="phno" class="label">Contact Number:</label>
                <input type="number" id = "phno" name="phno" class="inputField" required><br/>
            </div>

            <div class="FormContainer">
                <label for="email" class="label">Email ID:</label>
                <input type="email" id = "email" name="email" class="inputField" required><br/>
            </div>

            <div class="FormContainer">
                <label for="pswd" class="label">Password:</label>
                <input type="password" id = "pswd" name="pswd" class="inputField" required><br/>
            </div>

            <div class="FormContainer">
                <label for="con_pswd" class="label">Confirm password:</label>
                <input type="password" id = "con_pswd" name="con_pswd" class="inputField" required><br/>
            </div>

                <input type="submit" name="signUpBtn" id="signUpBtn" value="Submit">
        </form>
    </div>

    <div id="base">
        Already have an account? <span><a href="login.php">Login here</a></span>
    </div>
</body>
</html>