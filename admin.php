<?php
    session_start();

    require_once "config.php";
    

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insertBtn'])){

        echo '<div class="update"><div class="updateForm"><form method="post" action="admin.php" class="upform"><p>Enter the Product Details.</p><b>Product Id:  </b><input type="number" name ="pid" id="pid"class="inputField"><br/><br/><b>Product name:  </b><input type="text" name ="pname" id="pname" class="inputField"><br/><br/><b>Product description: </b> <input type="text" name ="pd" id="pd" class="inputField"><br/><br/><b>Product price: </b><input type="number" name ="pp" id="pp" class="inputField"><br/><br/><input type="submit" name ="addbtn" id="addbtn" value = "Add Product in database" class="b"><br/></form></div></div>';
    }

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addbtn'])){

    $pid = $_POST['pid'];
    $pname = $_POST['pname'];
    $pdesc = $_POST['pd'];
    $price = $_POST['pp'];
    
    $sql = "INSERT INTO products (id,pname,pdesc,price) VALUES ('$pid','$pname','$pdesc','$price')";
 
     if (mysqli_query($db, $sql)) {
        echo "<div class='state'>New record has been added successfully !</div>";
     } else {
        echo "Error: " . $sql . ":-" . mysqli_error($db);
     }
     mysqli_close($db);
    }

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteBtn'])){
        echo '<div class="update"><div class="updateForm"> <form method ="post" action = "admin.php" class="upform"><p> Enter the product ID of the product to be deleted.<p> <input type ="number" name="pidd" id="pidd"><br/><br/><input type="submit" name = "delBtn" id = "delBtn" value="Delete" class="b"> </form></div></div>';
    }

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delBtn'])){
        $pidd = $_POST['pidd'];
        $sql = "DELETE FROM products WHERE id= $pidd";
 
        if (mysqli_query($db, $sql)) {
     
            echo "<div class='state'>Record deleted successfully </div>";
     
        } else {
         
            echo "<div class='state'>Error deleting record: </div>" . mysqli_error($db);
        }
        mysqli_close($db);
    }

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateBtn'])){
        echo '<div class="update"><div class="updateForm">
        <form method ="post" action = "admin.php" class="upform"> 
        <p> Enter the product ID of the product to be Updated.<p>
        <input type ="number" name="upid" id="upid"><br/><br/>
        <input type="submit" name = "takeId" id = "takeId" value="Update" class="b"></form></div></div>';
    }

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['takeId'])){
        $id = $_POST['upid'];
        $query = "SELECT * FROM products WHERE id = $id";
        $result = mysqli_query($db,$query);
            if($result){
                if (mysqli_num_rows($result) > 0) {
               
                $row = mysqli_fetch_assoc($result);
                echo "<div class='updateForm'><form method='post' action='admin.php' class='upform'>
                        <div class='container'>
                        <label for='piddddd'>Product ID: </label> <b>".$row['id']."</b><input type='hidden' name ='piddddd' id='piddddd' value='".$row['id']."' ><br/><br/>
                        </div>
                        <div class='container'>
                        <label for='pname'>Product Name:</label><br/><br/> <input type='text' name ='pname' id='pname' value='".$row['pname']."'class='inputField'><br/><br/>
                        </div>
                        <div class='container'>
                        <label for='pd'>Product description: </label><br/><br/><input type='text' name ='pd' id='pd'value='".$row['pdesc']."'class='inputField'><br/><br/>
                        </div>
                        <div class='container'>
                        <label for='pp'>Product Price: </label><br/><br/><input type='number' name ='pp' id='pp'value='".$row['price']."'class='inputField'><br/></br>
                        </div>
                        <div class='container'>
                        <input type='submit' name ='updateFormBtn' id='updateFormBtn' value = 'Update Product in database' class='b'><br/>
                        </div>
                        </form></div>";
                }
                else{
                    $error = '<p <div class="state">No product exists with this product id</p>';
                   echo $error;
                   }
               }
               else{
                   echo "no";
               }
    	
    
	mysqli_close($db);

    }



    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateFormBtn'])){
            $productId=$_POST['piddddd'];
            $pname = $_POST['pname'];
            $pdesc=$_POST['pd'];
            $price=$_POST['pp'];
            
            $sql = "UPDATE products SET pname ='".$pname."',pdesc='".$pdesc."',price=".$price." WHERE id=".$productId."";
            if (mysqli_query($db, $sql)) {
                echo "<div class='state'>Record Updated Successfully!</div>";
            } 
            else {
                echo json_encode(array("statusCode"=>201));
            }
	mysqli_close($db);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>

    <style>
        .logoutBtn{
            background-color: #9A03C2;

  
    padding: 10px 17px;
    border: none;
    /* background-color: purple; */
    color: white;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
    top: 18px;
    position: absolute; 
  right: 12px; 
        }
        body{
            background: #ECFFDC;
        }
        ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  
}

li {
  float: left;
}

#one{
    margin-top:18px;
    margin-left:10px;


}

#two{
    margin-top:18px;
    margin-left:30px;


}

#three{
    margin-top:18px;
    margin-left:30px;


}

#updateBtn{
    padding: 10px 17px;
    border: none;
    background-color: #006400 ;
    border-radius: 6px;
    color: white;
 
}

#insertBtn{
    padding: 10px 17px;
    border: none;
    background-color: #006400 ;
    border-radius: 6px;
    color: white;
 
}

#deleteBtn{
    padding: 10px 17px;
    border: none;
    background-color: #006400 ;
    border-radius: 6px;
    color: white;
}

/* .update{
    box-sizing: border-box;
    margin-left: 100;px
    padding: 0;
    background-color: wheat;
    font-family: "lato", sans-serif;
} */
 .updateForm {
    display: flex;
    justify-content: center;
    align-items: center;
   
  }
 .upform{
    background-color: white;
    width: 400px;
    border-radius: 8px;
    padding: 20px 40px;
    box-shadow: 0 10px 25px rgba(92, 99, 105, .2);
  }
  .inputField {
    /* position: absolute; */
    top: 0px;
    left: 0px;
    height: 80%;
    width: 100%;
    border: 3px solid #006400;
    border-radius: 4px;
    border-color: #006400;
    font-size: 16px;
    padding: 5px 20px;
    outline: none;
    background: none;
  }
/* 
  .container {
    position: relative;
    height: 60px;
    width: 90%;
    margin-bottom: 17px;
  } */

  
  
label {
    top: 27px;
    left: 15px;
    padding: 0 4px;
    background-color: white;
    color: #006400;
    font-size: 16px;
    transition: 0.5s;
    z-index: 1;
    font-family: Sans-Serif, Helvetica;
  }
  .state{
      color:  black;
      font-size: 20px;


  }
  .b{
    background-color: #32CD32;
    border:none;
    padding-top:7px;
    padding-bottom:7px;
    padding-right:9px;
    padding-left:9px;
    border-radius:5px;
    color:white;
  }
  
        </style>
</head>
<body>

   <div >
   <ul id='horizontal-list'>
    <li id="one">
        <form action="admin.php" method='post'>
            <input type="submit" name="updateBtn" id="updateBtn" value="Update Product Details">
        </form>
    </li>
    <li id="two">
    <form action="admin.php" method='post'>
            <input type="submit" name="insertBtn" id="insertBtn" value="Add Product">
        </form>
    </li >
    <li id="three"><form action="admin.php" method='post'>
            <input type="submit" name="deleteBtn" id="deleteBtn" value="Delete Product">
        </form></li>
</ul>
</div>

<form action="logout.php" method="post">
        <input type="submit" name="logoutBtn" class="logoutBtn"value="Log out">
    </form>

</body>
</html>