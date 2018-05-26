<?php
    include("_con2.php");
    $idd=$_GET['order_id'];
    $queryb = "SELECT fn_cekstatus('$idd')";
    $pemesanan = mysqli_query($con, $queryb);
    $bayar = mysqli_fetch_array($pemesanan);
    if ($bayar[0]!=0) {
        header("location: pemesanan.php?order_id=$idd");
    }
    else{
        $queryc = "CALL sp_bayar('$idd')";
        $pemesanan = mysqli_query($con, $queryc);  
        header("location: pesan.php");
    }
?>