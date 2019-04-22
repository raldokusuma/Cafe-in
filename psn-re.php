<?php 
	include("_con2.php");
	$queryc = "select * from v_pemesanan";
    $pemesanan = mysqli_query($con, $queryc);  
    $pemesananq = [];  

    foreach ($pemesanan as $key => $value) {
    	array_push($pemesananq, $value);
    }

 	echo json_encode($pemesananq);

 ?>