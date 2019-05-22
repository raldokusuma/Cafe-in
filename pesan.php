<?php
session_start();
include("_con.php");
$db_handle = new DBController();
if(!empty($_GET["action"])) {
switch($_GET["action"]) {
    case "add":
        if(!empty($_POST["quantity"])) {
            $productById = $db_handle->runQuery("SELECT * FROM tbl_product WHERE product_id='" . $_GET["product_id"] . "'");
            // echo json_encode($productById) ;
            // echo "\n";
            $itemArray = array($productById[0]["product_id"] =>array('product_id'=>$productById[0]["product_id"],'name'=>$productById[0]["Nama"], 'quantity'=>$_POST["quantity"], 'price'=>$productById[0]["price"]));
            
            if(!empty($_SESSION["cart_item"])) {
                //echo json_encode($_SESSION['sav_pid']);
                if(in_array($productById[0]["product_id"],$_SESSION['sav_pid'])) 
                    
                    {
                    //echo json_encode(array_keys($_SESSION["cart_item"]));
                    foreach($_SESSION["cart_item"] as $k => $v) {
                            if($productById[0]["product_id"]  == $v["product_id"]) {
                                if(empty($_SESSION["cart_item"][$k]["quantity"])){
                                    $_SESSION["cart_item"][$k]["quantity"] = 0;
                                    }
                                $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                            }
                    }
                } else {
                    $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray); 
                    array_push($_SESSION['sav_pid'],$productById[0]["product_id"]);
                    //echo json_encode($_SESSION["cart_item"]) ;
                }
            } else {
                $_SESSION["cart_item"] = $itemArray;
                $_SESSION['sav_pid'] = array();
                array_push($_SESSION['sav_pid'],$productById[0]["product_id"]);
            }
            
        }
    break;
    case "remove":
        // echo json_encode($_SESSION['sav_pid']);
        if(!empty($_SESSION["cart_item"])) {
            foreach($_SESSION["cart_item"] as $k => $v) {
                    if($_GET["product_id"] == $v["product_id"])
                        unset($_SESSION["cart_item"][$k]);        
                    if(empty($_SESSION["cart_item"]))
                        unset($_SESSION["cart_item"]);
                        //unset($_SESSION["sav_pid"]);
            }
            foreach ($_SESSION['sav_pid'] as $key => $value) {
                if($_GET["product_id"]==$value)
                    unset($_SESSION['sav_pid'][$key]);
            }
        }
    break;
    case "empty":
        unset($_SESSION["cart_item"]);
        unset($_SESSION["sav_pid"]);
    break;  
}
}
?>
<html>
<head>

    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="stylesheet" type="text/css" href="css/pesan.css">
    <link href="https://fonts.googleapis.com/css?family=Oxygen:400,300,700" rel="stylesheet" type="text/css"/>
    <link href="https://code.ionicframework.com/ionicons/1.4.1/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
    <title>Makan</title>
    <title>User Web</title>
</head>
<body>
    <div style="width: 100%;">
        <div><ul class="back"><li class="back"><a id="btnBack" href="rumahmakan.php"><strong>Kembali</strong></a></li></ul></div>
        <div id="product-grid" style="width: 50%; float: left; padding: 20px;">
            <ul class="menu"><li class="allmenu"><a href="pesan.php"><strong>All Menu</strong></a></li></ul>
            <ul class="menu">
                <li class="menu"><a class="active" href="pesan.php?view=v_acai"><strong>Acai</strong></a></li>
                <li class="menu"><a href="pesan.php?view=v_blended"><strong>Blended</strong></a></li>
                <li class="menu"><a href="pesan.php?view=v_coffee"><strong>Coffee</strong></a></li>
                <li class="menu"><a href="pesan.php?view=v_others"><strong>Others</strong></a></li>
                <li class="menu"><a href="pesan.php?view=v_pasta"><strong>Pasta</strong></a></li>
                <li class="menu"><a href="pesan.php?view=v_rice"><strong>Rice</strong></a></li>
                <li class="menu"><a href="pesan.php?view=v_sharedbites"><strong>Shared Bites</strong></a></li>
                <li class="menu"><a href="pesan.php?view=v_sweet"><strong>Sweet</strong></a></li>
                <li class="menu"><a href="pesan.php?view=v_tea"><strong>Tea</strong></a></li>
                <li class="menu"><a href="pesan.php?view=v_topdrinks"><strong>Topping for Drinks</strong></a></li>
                <li class="menu"><a href="pesan.php?view=v_topfood"><strong>Topping for Foods</strong></a></li>
                <li class="menu"><a href="pesan.php?view=v_western"><strong>Western</strong></a></li>
            </ul>
            <?php
                include '_con2.php';
                if (isset($_GET['view'])) {
                    $product_array = $db_handle->runQuery("SELECT * FROM `".$_GET['view']."`");
                    // $querya = "SELECT * FROM v_acai";
                    // $view = mysqli_query($con, $querya);
                    // $product_array = mysqli_fetch_array($view);
                }
                else {
                    $product_array = $db_handle->runQuery("SELECT * FROM tbl_product ORDER BY product_id ASC");
                }
                if (!empty($product_array)) { 
                foreach($product_array as $key=>$value){
            ?>
            <div class="product-item" style="position: relative; height: 250px">
                <form method="post" action="pesan.php?action=add&product_id=<?php echo $product_array[$key]["product_id"]; ?>">
                <!-- <div class="product-image"><img src="img/<?php echo $product_array[$key]["Nama"];?>.jpg"></div> -->
                <div><strong style="color: black"><?php echo $product_array[$key]["Nama"]; ?></strong></div>
                <div class="product-price"><?php echo "Rp ".$product_array[$key]["price"];?>rb</div>
                <div><img src="/img/product/<?php echo $product_array[$key]["img_product"]; ?>" style="height: 150px; width: auto" alt=""></div>
                <div style="bottom: 5px; margin-left: 30px; position: absolute; "><input type="text" name="quantity" value="1" size="2" /><input type="submit" value="Add to cart" class="btnAddAction" /></div>
                </form>
            </div>
            <?php
                }
            }
            ?>
        </div>
        <div id="shopping-cart" style="width: 40%; float: right; padding: 20px;">
            <div class="txt-heading"><strong>Shopping Cart </strong><a id="btnPesan" href="sp_order.php"><strong>Pesan</a></strong><a id="btnEmpty" href="pesan.php?action=empty"><strong>Empty Cart</strong></a></div>
            <?php
                if(isset($_SESSION["cart_item"])){
                $item_total = 0;
            ?>  
            <table cellpadding="10" cellspacing="1">
                <tbody>
                    <tr>
                        <th style="text-align:left; color: black"><strong>Name</strong></th>
                        <th style="text-align:right;color: black"><strong>Quantity</strong></th>
                        <th style="text-align:right;color: black"><strong>Price</strong></th>
                        <th style="text-align:center;color: black"><strong>Action</strong></th>
                    </tr>   
                    <?php       
                        foreach ($_SESSION["cart_item"] as $item){
                    ?>
                    <tr>
                        <td style="text-align:left;border-bottom:#F0F0F0 1px solid; color: black"><strong><?php echo $item["name"]; ?></strong></td>
                        <td style="text-align:right;border-bottom:#F0F0F0 1px solid; color: black"><?php echo $item["quantity"]; ?></td>
                        <td style="text-align:right;border-bottom:#F0F0F0 1px solid; color: black"><?php echo "Rp".$item["price"]; ?>rb</td>
                        <td style="text-align:center;border-bottom:#F0F0F0 1px solid;"><a href="pesan.php?action=remove&product_id=<?php echo $item["product_id"]; ?>" class="btnRemoveAction"><strong>Remove Item</strong></a></td>
                    </tr>
                        <?php
                            $item_total += ($item["price"]*$item["quantity"]);
                            }
                        ?>
                    <tr>
                        <td colspan="5" align=right style="color: black"><strong style="color: black">Total:</strong> <?php echo "Rp ".$item_total; ?> rb</td>
                    </tr>

                </tbody>
            </table>        
            <?php
                }
            ?>
        </div>
     
    </div>
    
    </body>
</html>