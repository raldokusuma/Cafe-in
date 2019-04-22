<?php 
	include("_con2.php");
    $queryp = "select * from v_sajikan";
    $pemesanan = mysqli_query($con, $queryp);   
    $pemesananq = [];  

    foreach ($pemesanan as $key => $value) {
    	array_push($pemesananq, $value);
    }

 	echo json_encode($pemesananq);

 ?>