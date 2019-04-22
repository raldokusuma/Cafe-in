<?php
   include('_con.php');
   session_start();
   
   $user_check = $_SESSION['login_user'];
   
   
   $login_session = $user_check;
   
   if(!isset($_SESSION['login_user'])){
      header("location:login.php");
   }
?>
<html>
   <head>
      <title>Welcome </title>
   </head>
   
   <body>
      <h1>Welcome <?php echo $login_session; ?></h1> 
      <h2><a href = "logout.php">Sign Out</a></h2>
   </body>
   
</html>