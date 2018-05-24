<?php

$con = mysqli_connect('localhost','root','');
mysqli_select_db($con,'fp_mbd');

// kalau tidak ada id di query string
if( !isset($_GET['product_id']) ){
    header('Location: user.php');
}

//ambil id dari query string
$id = $_GET['product_id'];

// buat query untuk ambil data dari database
$sql = "SELECT * FROM tbl_product WHERE product_id=$id";
$query = mysqli_query($con, $sql);
$user = mysqli_fetch_assoc($query);

// jika data yang di-edit tidak ditemukan
if( mysqli_num_rows($query) < 1 ){
    die("data tidak ditemukan...");
}

?>


<!DOCTYPE html>
<html>
<head>
    <title>Edit user</title>
</head>

<body>
    <header>
        <h3>User</h3>
    </header>

    <form action="edit.php" method="POST">

        <fieldset>

            <input type="hidden" name="id" value="<?php echo $user['product_id'] ?>" />

        <p>
            <label for="nama">Nama: </label>
            <input type="text" name="username" value="<?php echo $user['Nama'] ?>" />
        </p>
        <p>
            <label for="price">Price: </label>
            <input type=text name="price" value="<?php echo $user['price'] ?>" />
        </p>

        <p>
            <label for="jenis">Jenis: </label>
            <input type=text name="jenis" value="<?php echo $user['Jenis'] ?>" />
        </p>

        <p>
            <input type="submit" value="Simpan" name="simpan" />
        </p>

        </fieldset>


    </form>

    </body>
</html>
