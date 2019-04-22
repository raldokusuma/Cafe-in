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
        <div id="product-grid" style="width: 50%; float: left; padding: 20px;">
            <ul><li class="allmenu"><a href="pesan.php">All Menu</a></li></ul>
            <ul>
                <li class="menu"><a class="active" href="pesan.php?view=v_acai">Acai</a></li>
                <li class="menu"><a href="pesan.php?view=v_blended">Blended</a></li>
                <li class="menu"><a href="pesan.php?view=v_coffee">Coffee</a></li>
                <li class="menu"><a href="pesan.php?view=v_others">Others</a></li>
                <li class="menu"><a href="pesan.php?view=v_pasta">Pasta</a></li>
                <li class="menu"><a href="pesan.php?view=v_rice">Rice</a></li>
                <li class="menu"><a href="pesan.php?view=v_sharedbites">Shared Bites</a></li>
                <li class="menu"><a href="pesan.php?view=v_sweet">Sweet</a></li>
                <li class="menu"><a href="pesan.php?view=v_tea">Tea</a></li>
                <li class="menu"><a href="pesan.php?view=v_topdrinks">Topping for Drinks</a></li>
                <li class="menu"><a href="pesan.php?view=v_topfood">Topping for Foods</a></li>
                <li class="menu"><a href="pesan.php?view=v_western">Western</a></li>
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
            <div class="product-item" style="position: relative;">
                <form method="post" action="pesan.php?action=add&product_id=<?php echo $product_array[$key]["product_id"]; ?>">
                <!-- <div class="product-image"><img src="img/<?php echo $product_array[$key]["Nama"];?>.jpg"></div> -->
                <div><strong style="color: black"><?php echo $product_array[$key]["Nama"]; ?></strong></div>
                <div class="product-price"><?php echo "Rp ".$product_array[$key]["price"];?>rb</div>
                <div style="bottom: 5px; margin-left: 30px; position: absolute; "><input type="text" name="quantity" value="1" size="2" /><input type="submit" value="Add to cart" class="btnAddAction" /></div>
                </form>
            </div>
            <?php
                }
            }
            ?>
        </div>
        <div id="shopping-cart" style="width: 40%; float: right; padding: 20px;">
            <div class="txt-heading">Shopping Cart <a id="btnEmpty" href="sp_order.php">Pesan</a><a id="btnEmpty" href="pesan.php?action=empty">Empty Cart</a></div>
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
                        <td style="text-align:center;border-bottom:#F0F0F0 1px solid;"><a href="pesan.php?action=remove&product_id=<?php echo $item["product_id"]; ?>" class="btnRemoveAction">Remove Item</a></td>
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