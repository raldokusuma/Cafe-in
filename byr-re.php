<?php 
	include("_con2.php");
    $queryy = "select * from v_pembayaran";
     $pemesanan = mysqli_query($con, $queryy);   
    $pemesananq = [];  

    foreach ($pemesanan as $key => $value) {
    	array_push($pemesananq, $value);
    }

 	echo json_encode($pemesananq);

 ?>