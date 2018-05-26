<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="stylesheet" type="text/css" href="css/pesan.css">
	<link href="https://fonts.googleapis.com/css?family=Oxygen:400,300,700" rel="stylesheet" type="text/css"/>
    <link href="https://code.ionicframework.com/ionicons/1.4.1/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
	<title>Makan</title>
</head>
<body>
    <div id="shopping-cart" style="width: 45%; float: left; padding: 20px;">
        <table cellpadding="10" cellspacing="1">
            <tbody>
                <tr>
                    <th style="text-align:right;color: black"><strong>Order ID</strong></th>
                	<th style="text-align:right;color: black"><strong>Meja</strong></th>
                    <th style="text-align:left; color: black"><strong>Name</strong></th>
                    <th style="text-align:right;color: black"><strong>Order Date</strong></th>
                    <th style="text-align:right;color: black"><strong>Action</strong></th>
                </tr>   
                <?php
                	include("_con2.php");
                	$queryc = "select * from v_pemesanan";
    				$pemesanan = mysqli_query($con, $queryc);       
                    foreach ($pemesanan as $item){
                ?>
                <tr>
                    <td style="text-align:right;border-bottom:#F0F0F0 1px solid; color: black"><?php echo $item["order_id"]; ?></td>
                	<td style="text-align:right;border-bottom:#F0F0F0 1px solid; color: black"><?php echo $item["person_id"]; ?></td>
                    <td style="text-align:left;border-bottom:#F0F0F0 1px solid; color: black"><strong><?php echo $item["Nama"]; ?></strong></td>
                	<td style="text-align:right;border-bottom:#F0F0F0 1px solid; color: black"><?php echo $item["order_date"]; ?></td>
                    <td style="text-align:center;border-bottom:#F0F0F0 1px solid;"><a id="btnEmpty" href="masak.php?order_id=<?php echo $item["order_id"]; ?>&product_id=<?php echo $item["product_id"]; ?>" class="btnRemoveAction">Masak</a></td>
                </tr>
                    <?php
                        }
                    ?>
            </tbody>
        </table> 
    </div>
</body>
</html> 