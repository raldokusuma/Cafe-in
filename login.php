<?php
   include("_con.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      $myusername = mysqli_real_escape_string($con,$_POST['namaq']);
      $mypassword = mysqli_real_escape_string($con,$_POST['passq']); 
      	
      $sql = "CALL sp_login('$myusername','$mypassword')";
      $result = mysqli_query($con,$sql);
      $row = mysqli_fetch_array($result);
      
      if($row[0] == 1) {
        	$_SESSION['login_user'] = $myusername;
        	header("location: welcome.php");
      }else {
         	$error = "Your Login Name or Password is invalid";
      }
   }
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<link href="https://fonts.googleapis.com/css?family=Oxygen:400,300,700" rel="stylesheet" type="text/css"/>
    <link href="https://code.ionicframework.com/ionicons/1.4.1/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
	<title>Makan</title>
</head>
<body>
<div class="signin cf">
  <div class="avatar"></div>
  <form method="POST" action="">
    <div class="inputrow">
      <input type="text" id="name" name="namaq" placeholder="Username"/>
      <label class="ion-person" for="name"></label>
    </div>
    <div class="inputrow">
      <input type="password" id="pass" name="passq" placeholder="Password"/>
      <label class="ion-locked" for="pass"></label>
    </div>
    <input type="submit" value="Login"/>
  </form>
</div>
</div>
  
</body>
</html>
  