<?php
include("_con.php");
$db_update = new DBController();
// cek apakah tombol simpan sudah diklik atau blum?
if(isset($_POST['simpan'])){

    // ambil data dari formulir
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $jenis = $_POST['jenis'];
    // buat query update
    $sql = "CALL sp_edit('$id','$name','$price','$jenis')";
    $query = $db_update->runQuery($sql);

    // apakah query update berhasil?
    if( $query ) {
        // kalau berhasil alihkan ke halaman list-siswa.php
        header('Location: admin.php?action=update');
    } else {
        // kalau gagal tampilkan pesan
        die("Gagal menyimpan perubahan...");
    }


} else {
    die("Akses dilarang...");
}

?>
