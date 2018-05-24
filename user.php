

<!DOCTYPE html>
<html>
<head>
    <title>User Web</title>
</head>

<body>
    <header>
        <h3>data user</h3>
    </header>

    <nav>
        <a href="login.html">registrasi</a>
    </nav>

    <br>

    <table border="1">
    <thead>
        <tr>
            <th>product_id</th>
            <th>Nama</th>
            <th>price</th>
            <th>Jenis</th>
        </tr>
    </thead>
    <tbody>

        <?php
         include("_con.php");
        $sql = "SELECT * FROM tbl_product";
        $query = mysqli_query($con, $sql);

        while($user = mysqli_fetch_array($query)){
            echo "<tr>";

            echo "<td>".$user['product_id']."</td>";
            echo "<td>".$user['Nama']."</td>";
            echo "<td>".$user['price']."</td>";
            echo "<td>".$user['Jenis']."</td>";
            echo "<td>";
            echo "<a href='edit.php?product_id=".$user['product_id']."'>Edit</a> | ";
            echo "<a href='delete.php?product_id=".$user['product_id']."'>Delete</a>";
            echo "</td>";
            echo "</tr>";
        }
        ?>

    </tbody>
    </table>

    <p>Total: <?php echo mysqli_num_rows($query) ?></p>

    </body>
</html>
