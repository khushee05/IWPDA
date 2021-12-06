<?php 
    session_start();
    include("config.php");
    echo "</br><h2> ".$_SESSION['name']."'s Cart</h2></br>";
   
    if(isset($_POST['pid'])){
        $pid=$_POST['pid'];
        $uid=$_POST['uid'];
        $sql = "DELETE FROM billdetails WHERE pid= $pid AND uid=$uid";
 
        if (mysqli_query($db, $sql)) {
     
            echo "Item deleted successfully";
     
        } else {
         
            echo "Error deleting Item: " . mysqli_error($db);
        }
        mysqli_close($db);
     

    }
?>
<html>
    <head>
        <title>Result Page</title>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
        <style>
          *{
            font-family:'Poppins';
          }
            .row {
                    display: flex;
            }
                  .column1 {
                    padding-top:30px;
                    flex: 50%;
                 
                    height: 150px; 
                    
                  }
                  .column2 {
                    flex: 50%;
                    padding-top: 0px;
                    padding-right:20px;
                    padding-left:200px;
                    height: 300px; 
                    width:200px;
                    
                  }
                  body{
  background-color:#ECFFDC;
}


table,tr,td.th{
  border-collapse: collapse;
  text-align:center;

}
td,th{
  padding-left: 10px;
  padding-right: 10px;
  padding-top: 10px;
  padding-bottom: 10px;
  border: 1px solid #000;
  
}
th{
  background: #9A03C2;
  color: #FFFFFF;
  
}
td{
  background-color:	#F3CFC6;
}
.browse{
  position:absolute;
  top:30px;
  right:120px;
  background-color: #9A03C2;
  color:white;
  padding: 10px 17px;
  border: none;
  border-radius: 6px;
} 

a{
  color:#ffffff;
  text-decoration:none;
  font-size:17px;

}

.logoutBtn{
background-color: #9A03C2;

  
    padding: 10px 17px;
    border: none;
    /* background-color: purple; */
    color: white;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
    top: 30px;
    position: absolute; 
  right: 10px; 
 

}
.sendFeedback{
  background-color:#9A03C2;
  color: white;
  border:none;
  border-radius: 4px;
  padding:8px;

}
.amount{
  position:absolute;
  top:400px;
  left:410px;
}
#removeBtn{
  background-color:red;
  border:none;
  border-radius: 5px;
  padding-top:4px;
  padding-right:6px;
  padding-left:6px;
  padding-bottom:4px;
  color:white;
}
.order{
background-color: #9A03C2;

  
    padding: 10px 17px;
    border: none;
    /* background-color: purple; */
    color: white;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
    top: 460px;
    position: absolute; 
  left: 580px; 
 

}
          </style>

    </head>
    <body>
   
    <button class="browse"> <a href ="items.php" >Browse</a></button>
    <form action="result.php" method="post">
        <input type="submit" name="order" class="order" value="Order">
    </form>
    
    <form action="logout.php" method="post">
        <input type="submit" name="logoutBtn" class="logoutBtn" value="Log out">
    </form>
    <div class="row">
          
        <?php
            
            include("config.php");
            $fetchData= fetch_data($db);
            //echo print_r($fetchData);
            show_data($fetchData);
            function fetch_data($db){
                $id = $_SESSION["userid"];
                //echo $id;
                $query="SELECT * from billdetails where uid = '$id'";
                $exec=mysqli_query($db, $query);
                if(mysqli_num_rows($exec)>0){
                  $row= mysqli_fetch_all($exec, MYSQLI_ASSOC);
                  return $row;  
                      
                }else{
                  return $row=[];
                }
            }
            function show_data($fetchData){
                
                if(count($fetchData)>0){
            
                    echo '<table cell-padding="1" class="column1">
                       <tr>
                           <th>S.No.</th>
                           <th>Product ID</th>
                           <th>Product Name</th>
                           <th>Product Description</th>
                           <th>Price</th>
                           <th></th>
                       </tr>';
                     $sn=1;
                     $total=0;
                     foreach($fetchData as $data){ 
                        echo "<tr>
                         <td>".$sn."</td>
                         <td>".$data['pid']."</td>
                         <td>".$data['pname']."</td>
                         <td>".$data['pdesc']."</td>
                         <td>".$data['price']."</td>
                         <td><button id='removeBtn' onclick='removeFun(".$data['pid'].",".$_SESSION['userid'].")'>Remove</button></td></tr>";
                         $total+=$data['price'];
                         $sn++; 
                    }
             echo "<h3 class='amount'>Total Bill Amount = Rs. ".$total."</h3>";

                   
               }else{
                    
                 echo "<h2>Cart is Empty</h2>"; 
               }
                 echo "</table>";
               }

               if($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['SendFeedback'])){
                $targetFilePath="./upload/".$_FILES['file']['name'];
                $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg');
                $isUploaded=0;
                if(($_FILES['file']['size']<1000000))
                {
                    if(move_uploaded_file($_FILES['file']['tmp_name'],$targetFilePath))
                    $isUploaded=1;
                    
                }
                if($isUploaded==1){
                    $toEmail = "jain.khushee05@gmail.com";
                    $fromEmail="jain.khushee05@gmail.com";
                    $name=$_POST['name'];
                    $subject = $_POST['subject'];
                    $message = $_POST['feedback'];
                    $fo=fopen($targetFilePath,"rb");
                    $data=fread($fo,filesize($fn));
                    fclose($fo);
                    $data1=chunk_split(base64_encode($data));
                    $header="Content-Type:multipart/mixed\r\n";
                    $header.="Content-Disposition:attachment;filename=".$_FILES['file']['name']."\r\n";
                    $header.="Content-Transfer-Encoding:base64".$data1."\r\n";
                    $retval = mail ($to,$subject,$message,$header);
                    if( $retval == true ) {
                        echo "<h1>Message sent successfully...</h1>";
                    }else {
                        echo "<h1>Message could not be sent...</h1>";
                    }
                }
            }
        ?>

          <div class="column2">
            <h3>&emsp;&emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &ensp;  Send Feedback</h3>
            <form action="result.php" method="POST" class="column2">
              <label>Enter Name: </label>
              <input type="text" placeholder="Enter name" value="" name="name"></br></br>
              <label>Enter Subject: </label>
              <input type="text" placeholder="Enter subject" value="" name="subject"></br></br>
              <label>Feedback: </label>
                  </br></br><textarea rows = "10" cols="40"placeholder="Few words you want us to know..." value="" name="feedback"></textarea></br></br>
                  <input type="file">
                  <br/><br/>
              <input type="submit" value="Send Feedback" name="SendFeedback" class="sendFeedback">
              
            </form>
              </div>
              </div>

        <script>
  function removeFun(pid, uid){
        $.ajax({
          type: "POST",
          url: "result.php",
          data: {
            pid: pid,
            uid: uid
          },
          success: function(html){
         
              $("body").html(html). show();
      
          }

        })
    }

</script>
              
    </body>
    
</html>
<?php 


if($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['SendFeedback'])){
  $to = "panshuljindal@gmail.com";
      $subject = $_POST['subject'];
      $message = $_POST['feedback'];
      $header = "From:panshuljindal@gmail.com \r\n";
      $header .= "Content-type: text/html\r\n";
      
      $retval = mail ($to,$subject,$message,$header);
      if( $retval == true ) {
          echo "Message sent successfully...";
      }else {
          echo "Message could not be sent...";
      }
  }
?>