<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items</title>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="index.css"> -->
    <!-- Including jQuery is required. -->
   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
   <!-- Including our scripting file. -->
   <script type="text/javascript" src="script.js"></script>
   <!-- Including CSS file. -->
    <style>
* {
  box-sizing: border-box;
  font-family: 'Poppins';
}
body{
  background-color:#ECFFDC;
}


table,tr,td.th{
  border-collapse: collapse;
}
tr,td,th{
  padding-left: 30px;
  padding-right: 30px;
  padding-top: 18px;
  padding-bottom: 18px;
  border: 1px solid #000;
  
}
th{
  background: #9A03C2;
  color: #FFFFFF;
  
}
td{
  background-color:	#F3CFC6;
}
.cartIcon{
  position: absolute; 
  right: 150px; 
  top: 30px; 
  height: 80px;
  width: auto;
}
.logoutBtn{
  padding-left: 40px;
  padding-right: 40px;
  padding-top: 15px;
  padding-bottom: 15px;
  font-size: 15px;
}

.searchTerm {
  width: 15%;
  border: 3px solid #9867C5;
  
  padding: 15px;
  height: 30px;
  border-radius: 5px 5px 5px 5px;
  outline: none;
  color: black;
}

.searchTerm:focus{
  color: black;
}

.logoutBtn{
background-color: #9A03C2;
display:block;
    margin-left: auto;
    padding: 12px 20px;
    border: none;
    /* background-color: purple; */
    color: white;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
    margin-top: 30px;
    position: absolute; 
  right: 20px; 
  top: 0px; 

}

.addCart{
  background-color: #9A03C2;
  /* display: inline; */
  color: white;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    font-family: Arial, Helvetica, sans-serif;
    padding: 10px 15px;
    border: none;

}
#ad{
  margin-left:10px;
}
#bynw{
  background-color:	#AAFF00;
  color:black;
}
</style>
</head>
<body style="margin-left: 30px;">
<a class="cartIcon" href="result.php"><img height="48px" width="auto" src="cart.png" ></a></br>
    <div>
    <h1>Hi <?php echo $_SESSION["name"]; ?> </h1>
    </div>
    <div class="search">
    <input type="text" id="search" placeholder="Search" class="searchTerm"/></br></br>
    <div id="display"></div>

    </div>
            <?php
                include("config.php");
                $fetchData= fetch_data($db);
                show_data($fetchData);
                // fetch query
                function fetch_data($db){
                    $query="SELECT * from products ORDER BY id";
                    $exec=mysqli_query($db, $query);
                    if(mysqli_num_rows($exec)>0){
                        $row= mysqli_fetch_all($exec, MYSQLI_ASSOC);
                        return $row;  
        
                    }else{
                        return $row=[];
                    }
                }
                function show_data($fetchData){
                echo '<table id="table" class="divTable">
                        <tr>
                            <th>ID</th>
                            <th> Product Name</th>
                            <th>Product Description</th>
                            <th>Price</th>
                            <th> Add the Cart</th>
                        </tr>';
                if(count($fetchData)>0){
                      foreach($fetchData as $data){ 
                  echo "<tr>
                          <td>".$data['id']."</td>
                          <td>".$data['pname']."</td>
                          <td>".$data['pdesc']."</td>
                          <td>".$data['price']."</td>
                          <td><button class='addCart' id='bynw' onclick='clickCart(".$_SESSION['userid'].",".$data['id'].",1)'>Buy Now</button><button id='ad' class='addCart' onclick='clickCart(".$_SESSION['userid'].",".$data['id'].",2)'>Add to Cart</Button>";
                    }
                }else{
                    
                  echo "<center><h2>No Data found</h2></center>"; 
                }
                  echo "</table>";
                }
?>
     <br/>
     <div class="addC"></div>     
    <form action="logout.php" method="post">
        <input type="submit" name="logoutBtn" class="logoutBtn" value="Log out">
    </form>
</body>
<script>
  function clickCart(uid, id,type){
        $.ajax({
          type: "POST",
          url: "search.php",
          data: {
            pid: id,
            uid: uid
          },
          success: function(html){
            console.log(type);
            if(type==2){
              $(".addC").html(html). show();
            setTimeout(function() {
              $(".addC").hide();
            }, 2000);
            }
           else{
             document.location="result.php";
           }
          }

        })
    }

</script>
</html>


