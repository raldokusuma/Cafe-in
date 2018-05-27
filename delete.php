<?php
include("_con2.php");
// cek apakah tombol simpan sudah diklik atau blum?
if(isset($_GET['product_id'])){

    // ambil data dari formulir
    $id = $_GET['product_id'];
    // buat query update
    echo $id;
    $sql = "DELETE FROM tbl_product WHERE product_id=$id";
    $query = mysqli_query($con, $sql);

    // apakah query update berhasil?
    if( $query ) {
        // kalau berhasil alihkan ke halaman list-siswa.php
        header('Location: user.php');
    } else {
        // kalau gagal tampilkan pesan
        die("Gagal menyimpan perubahan...");
    }


} else {
    die("Akses dilarang...");
}

?>