<?php
    include("_con2.php");
    $idd=$_GET['order_id'];
    $pid=$_GET['product_id'];
    echo $pid;
    echo $idd;
    $queryc = "CALL sp_ubahstat('$idd','$pid','dimasak')";
    $pemesanan = mysqli_query($con, $queryc);
    $masak = mysqli_fetch_array($pemesanan); 
    if ($masak[0]=1) {
    	header("location: listpesan.php");
    }
    else {
    	echo $masak;
    }
?>