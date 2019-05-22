<?php
   
   session_start();
   include("_con2.php");
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      $myusername = mysqli_real_escape_string($con,$_POST['namaq']);
      $mypassword = mysqli_real_escape_string($con,$_POST['passq']); 
      	
      $sql = "CALL sp_login('$myusername','$mypassword')";
      $result = mysqli_query($con,$sql);
      $row = mysqli_fetch_array($result);
      
      if($row[0] == 1) {
        	$_SESSION['login_user'] = $myusername;
          $_SESSION['login_user'] = $myusername;
        	header("location: rumahmakan.php");
      }
      else if ($row[0] == 5) {
          $_SESSION['login_user'] = $myusername;
          $_SESSION['login_user'] = $myusername;
          header("location: listsajikan.php");
      }
      else if ($row[0] == 6) {
          $_SESSION['login_user'] = $myusername;
          $_SESSION['login_user'] = $myusername;
          header("location: listpesan.php");
      }
      else if ($row[0] == 7) {
          $_SESSION['login_user'] = $myusername;
          $_SESSION['login_user'] = $myusername;
          header("location: listpembayaran.php");
      }
      else if ($row[0] == 8) {
          $_SESSION['login_user'] = $myusername;
          $_SESSION['login_user'] = $myusername;
          header("location: admin.php");
      }
      else {
         	$error = "Your Login Name or Password is invalid";
      }
   }
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/login.css">
  <link rel="stylesheet" type="text/css" href="css/tutorial.css">
	<link href="https://fonts.googleapis.com/css?family=Oxygen:400,300,700" rel="stylesheet" type="text/css"/>
  <link href="https://code.ionicframework.com/ionicons/1.4.1/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <title>Makan</title>
</head>
<body>
  <div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">

    <span class="close">&times;</span>
    <p style="color: black; text-align: center;"><strong style="font-size: 30px">Tahfaz</strong></p>
    <br>
    <div class="row">
      <div class="col-sm-6">
          <p style="color: black"><strong>Pembeli</strong></p>
          <p>Sebagai pembeli gunakan user meja1 - meja7 dan password sama dengan usernya</p>
      </div>
      <div class="col-sm-6">
          <p style="color: black"><strong>Pelayan</strong></p>
          <p>Untuk Pelayan gunakan username: pelayan dan password : pelayan.</p>
          <p>User pelayan mampu memverifikasi bahwa pesanan telah disajikan</p>
      </div>
      <div class="col-sm-6">
          <p style="color: black"><strong>Koki</strong></p>
          <p>Untuk Koki gunakan username: koki dan password : koki</p>
          <p>User koki mampu memverivikasi bahwa pesanan telah dibuat</p>
      </div>
      <div class="col-sm-6">
          <p style="color: black"><strong>Kasir</strong></p>
          <p>Untuk kasir gunakan username: kasir dan password: kasir</p>
          <p>User kasir mampu memverivikasi bahwa pembeli telah membayar pesanannya</p>
      </div>
      <br>
      <div class="col-sm-12">
          <p style="color: black"><strong>Admin</strong></p>
          <p>Untuk admin gunakan username: admin dan password: admin</p>
          <p>User admin mampu mengubah menu dan harga</p>
      </div>
    </div>
  </div>

</div>
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
  <script type="text/javascript" src="js/tutorial.js" ></script>
</body>
</html>
  
