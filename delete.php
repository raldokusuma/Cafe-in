<?php

$con = mysqli_connect('localhost','root','');
mysqli_select_db($con,'fp_mbd');

if( isset($_GET['product_id']) ){

    // ambil id dari query string
    $id = $_GET['product_id'];

    // buat query hapus
    $sql = "DELETE FROM tbl_product WHERE product_id=$id";
    $query = mysqli_query($con, $sql);

    // apakah query hapus berhasil?
    if( $query ){
        header('Location: user.php');
    } else {
        die("gagal menghapus...");
    }

} else {
    die("akses dilarang...");
}

?>
