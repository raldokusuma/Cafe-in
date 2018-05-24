<html>
<head>

    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link href="https://fonts.googleapis.com/css?family=Oxygen:400,300,700" rel="stylesheet" type="text/css"/>
    <link href="https://code.ionicframework.com/ionicons/1.4.1/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
    <title>Makan</title>
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
            echo "<a href='pesan.php?product_id=".$user['product_id']."'>Pesan</a>";
            echo "</td>";   
            echo "</tr>";

        }
        ?>

    </tbody>
    <?php
        include("_con.php"); 
        $array = $_GET['product_id'];

    ?>
    </table>

    <p>Total: <?php echo mysqli_num_rows($query) ?></p>

    </body>
</html>
