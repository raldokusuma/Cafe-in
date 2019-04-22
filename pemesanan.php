
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
            <thead>
                <tr>
                	<th style="text-align:right;color: black"><strong>Order Date</strong></th>
                	<th style="text-align:right;color: black"><strong>Meja</strong></th>
                    <th style="text-align:left; color: black"><strong>Nama</strong></th>
                    <th style="text-align:left; color: black"><strong>Jumlah</strong></th>
                    <th style="text-align:center;color: black"><strong>Status</strong></th>
                </tr>
            </thead> 
                <tbody id="theb">  
                <?php
                $check_stat=array();
                	include("_con2.php");
                	$idd=$_GET['order_id'];
                ?>
                	<div class="txt-heading">Pesanan Anda</div>
                <?php
                	$queryc = "CALL sp_lihatpesan('$idd')";
    				$pemesanan = mysqli_query($con, $queryc);       
 					 
                    foreach($pemesanan as $item){
                ?>
                <tr>	
                	<meta http-equiv="refresh" content="5">
                	<td style="text-align:right;border-bottom:#F0F0F0 1px solid; color: black"><?php echo $item["order_date"]; ?></td>
                	<td style="text-align:right;border-bottom:#F0F0F0 1px solid; color: black"><?php echo $item["person_id"]; ?></td>
                    <td style="text-align:left;border-bottom:#F0F0F0 1px solid; color: black"><strong><?php echo $item["Nama"]; ?></strong></td>
                    <td style="text-align:left;border-bottom:#F0F0F0 1px solid; color: black"><strong><?php echo $item["quantity"]; ?></strong></td>
                    <td style="text-align:right;border-bottom:#F0F0F0 1px solid; color: black"><?php echo $item["status"]; ?></td>
                </tr>
                    <?php
                    array_push($check_stat, $item["status"]);

                    }
                    if (!in_array("dipesan", $check_stat) && !in_array("dimasak", $check_stat) && !in_array("disajikan", $check_stat)) {
                     	
                     ?>

                     <tr>
                        <td></td><td></td><td></td><td></td>
                        <td style="text-align:right;border-bottom:#F0F0F0 1px solid; color: black; "><a id="btnEmpty" href="pesan.php" class="btnRemoveAction">Pesan Lagi</a></td>
                    </tr>
                     
                     

                     <?php  
						}
                     ?>
                      
                    
            </tbody>
        </table>
    </div>
</body>
</html> 