

<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<link href="https://fonts.googleapis.com/css?family=Oxygen:400,300,700" rel="stylesheet" type="text/css"/>
    <link href="https://code.ionicframework.com/ionicons/1.4.1/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
	<title>Makan</title>
</head>
<body>

        <table cellpadding="10" cellspacing="1">
            <tbody>
                <tr>
                    <th style="text-align:left; color: black"><strong>Name</strong></th>
                    <th style="text-align:right;color: black"><strong>Order Date</strong></th>
                    <th style="text-align:center;color: black"><strong>Status</strong></th>
                </tr>   
                <?php
                	$queryc = "CALL sp_lihatpesan($oid[0])";
    				$pemesanan = mysqli_query($con, $queryc);       
                    foreach ($pemesanan as $item){
                ?>
                <tr>
                    <td style="text-align:left;border-bottom:#F0F0F0 1px solid; color: black"><strong><?php echo $item["Nama"]; ?></strong></td>
                    <td style="text-align:right;border-bottom:#F0F0F0 1px solid; color: black"><?php echo $item["order_date"]; ?></td>
                    <td style="text-align:right;border-bottom:#F0F0F0 1px solid; color: black"><?php echo $item["status"]; ?></td>
                </tr>
                    <?php
                        }
                    ?>
            </tbody>
        </table> 
        <?php 

    } 
    else {
        die("gagal bre");
    }

}
		
?>

  
</body>
</html>
  