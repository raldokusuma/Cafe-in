<?php
session_start();
include("_con2.php");

if( isset($_SESSION['login_user']) ){

    // ambil id dari query string
    $user_name = $_SESSION['login_user'];
    $querya = "SELECT person_id from tbl_person where name='$user_name'";
    $user_id = mysqli_query($con, $querya);
    $idq = mysqli_fetch_array($user_id);
    // echo json_encode($idq[0]);
    date_default_timezone_set("Asia/Jakarta");
    $date=date("Y-m-d H:i:s");
    // echo $date;
    // buat query hapus
    $sql = "CALL sp_order('$idq[0]','$date','dipesan')";
    $query = mysqli_query($con, $sql);

    $queryb = "SELECT order_id from tbl_order where order_date='$date'";
    $order_id = mysqli_query($con, $queryb);
    $oid = mysqli_fetch_array($order_id);
    $temp = array_values($_SESSION["cart_item"]);
    unset($_SESSION["cart_item"]);
    $_SESSION["cart_item"]= $temp;
    // apakah query hapus berhasil?
    if($query){
		// echo json_encode($_SESSION["cart_item"][]["name"]);
        $i=0;
        echo json_encode(array_values($_SESSION["cart_item"]));
        echo json_encode(empty($_SESSION["cart_item"][$i]));

        while(!empty($_SESSION["cart_item"][$i]) ) { 
        	// echo json_encode(empty($_SESSION["cart_item"][$i]));
        	$pid = $_SESSION["cart_item"][$i]["product_id"];
        	$jml = $_SESSION["cart_item"][$i]["quantity"];
        	$sp_order ="CALL sp_pesan('$oid[0]','$pid','$jml')";
        	$queryc = mysqli_query($con, $sp_order);
        	$i++;
        }

        unset($_SESSION["cart_item"]);
        unset($_SESSION["sav_pid"]);
        // header("location: sp_order.php");
        header("location: pemesanan.php?order_id=$oid[0]");
    }
}
?>