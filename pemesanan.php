<html>
<head>
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<link rel="stylesheet" type="text/css" href="css/pesan.css">
	<link href="https://fonts.googleapis.com/css?family=Oxygen:400,300,700" rel="stylesheet" type="text/css"/>
    <link href="https://code.ionicframework.com/ionicons/1.4.1/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
    <link href="css/star-rating.css" media="all" rel="stylesheet" type="text/css" />
    <link href="css/theme.css" media="all" rel="stylesheet" type="text/css" />
	<title>Makan</title>
</head>

<body>
	<div id="shopping-cart" style="width: 100%; float: left; padding: 20px;">
        <table cellpadding="10" cellspacing="1" >
            <thead>
                <tr>
                	<th style="text-align:center;color: black"><strong>Order Date</strong></th>
                	<th style="text-align:center;color: black"><strong>Meja</strong></th>
                    <th style="text-align:center;color: black"><strong>Nama</strong></th>
                    <th style="text-align:center;color: black"><strong>Jumlah</strong></th>
                    <th style="text-align:center;color: black"><strong>Status</strong></th>
                </tr>
            </thead> 
                <tbody id="theb">  
                <?php
                $check_stat=array();
            	include("_con2.php");
            	$idd=$_GET['order_id'];
                $stat=array();
                ?>
                	<div class="txt-heading"><a href="rumahmakan.php" id="btnBack">kembali</a><center>Pesanan Anda</center></div>
                <?php
                	$queryc = "CALL sp_lihatpesan('$idd')";
    				$pemesanan = mysqli_query($con, $queryc);
                    $flag=0;
                    if (!in_array("dipesan", $stat) && !in_array("dimasak", $stat) && !in_array("disajikan", $stat) && !empty($stat)) {
                        $flag=1;
                    }

                    foreach($pemesanan as $item){
                    $stat[$apa-1]=$item["status"];
                    $apa++;
                ?>
                <tr>
                    <?php  
                    if ($flag==0) {  

                    ?>

                	<meta http-equiv="refresh" content="5">
                    <?php  
                    }
                    ?>
                	<td style="text-align:center;border-bottom:#F0F0F0 1px solid; color: black"><?php echo $item["order_date"]; ?></td>
                	<td style="text-align:center;border-bottom:#F0F0F0 1px solid; color: black"><?php echo $item["person_id"]; ?></td>
                    <td style="text-align:center;border-bottom:#F0F0F0 1px solid; color: black"><strong><?php echo $item["Nama"]; ?></strong></td>
                    <td style="text-align:center;border-bottom:#F0F0F0 1px solid; color: black"><strong><?php echo $item["quantity"]; ?></strong></td>
                    <td style="text-align:center;border-bottom:#F0F0F0 1px solid; color: black"><?php echo $item["status"]; ?></td>
                </tr>
                    <?php
                    }
                    if (!in_array("dipesan", $stat) && !in_array("dimasak", $stat) && !in_array("disajikan", $stat)) {
                        $flag=1;
                     ?>

                     <tr>
                        <td></td><td></td><td></td><td>
                            <label for="input-2" class="control-label">Rate This</label>
                        <input id="input-2" name="input-2" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1">
                        </td>
                        <td style="text-align:center;border-bottom:#F0F0F0 1px solid; color: black; "><a id="btnEmpty" href="rumahmakan.php" class="btnRemoveAction">Pesan Lagi</a></td>
                    </tr>
                     
                     

                     <?php  
                    
						}
                    ?>
                      
                    
            </tbody>
        </table>
    </div>
</body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.js"></script>
<script src="js/star-rating.js" type="text/javascript"></script>
<script>
    // initialize with defaults
$("#input-id").rating();

// with plugin options (do not attach the CSS class "rating" to your input if using this approach)
$("#input-id").rating({'size':'lg'});
</script>
</html> 