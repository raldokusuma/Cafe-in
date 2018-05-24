<?php
$con = mysqli_connect('localhost','root','');
mysqli_select_db($con,'PWEB182_E_16088');

// cek apakah tombol simpan sudah diklik atau blum?
if(isset($_POST['simpan'])){

    // ambil data dari formulir
    $id = $_POST['id'];
    $username = $_POST['username'];
    $apassword = md5($_POST['password']);

    // buat query update
    $sql = "UPDATE login SET username='$username', password='$password' WHERE id=$id";
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
