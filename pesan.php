<?php
include("_con.php");
session_start();

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
        echo json_encode($_SESSION['sav_pid']);
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
    <div id="shopping-cart">
        <div class="txt-heading">Shopping Cart <a id="btnEmpty" href="pesan.php?action=empty">Empty Cart</a></div>
        <?php
            if(isset($_SESSION["cart_item"])){
            $item_total = 0;
        ?>  
        <table cellpadding="10" cellspacing="1">
            <tbody>
                <tr>
                    <th style="text-align:left;"><strong>Name</strong></th>
                    <th style="text-align:right;"><strong>Quantity</strong></th>
                    <th style="text-align:right;"><strong>Price</strong></th>
                    <th style="text-align:center;"><strong>Action</strong></th>
                </tr>   
                <?php       
                    foreach ($_SESSION["cart_item"] as $item){
                ?>
                <tr>
                    <td style="text-align:left;border-bottom:#F0F0F0 1px solid;"><strong><?php echo $item["name"]; ?></strong></td>
                    <td style="text-align:right;border-bottom:#F0F0F0 1px solid;"><?php echo $item["quantity"]; ?></td>
                    <td style="text-align:right;border-bottom:#F0F0F0 1px solid;"><?php echo "$".$item["price"]; ?></td>
                    <td style="text-align:center;border-bottom:#F0F0F0 1px solid;"><a href="pesan.php?action=remove&product_id=<?php echo $item["product_id"]; ?>" class="btnRemoveAction">Remove Item</a></td>
                </tr>
                    <?php
                        $item_total += ($item["price"]*$item["quantity"]);
                        }
                    ?>
                <tr>
                    <td colspan="5" align=right><strong>Total:</strong> <?php echo "$".$item_total; ?></td>
                </tr>
            </tbody>
        </table>        
        <?php
            }
        ?>
    </div>
    <br>
    <div id="product-grid">
        <div class="txt-heading">Products</div>
        <?php
            $product_array = $db_handle->runQuery("SELECT * FROM tbl_product ORDER BY product_id ASC");
            if (!empty($product_array)) { 
            foreach($product_array as $key=>$value){
        ?>
        <div class="product-item">
            <form method="post" action="pesan.php?action=add&product_id=<?php echo $product_array[$key]["product_id"]; ?>">
            <div><strong><?php echo $product_array[$key]["Nama"]; ?></strong></div>
            <div class="product-price"><?php echo "$".$product_array[$key]["price"]; ?></div>
            <div><input type="text" name="quantity" value="1" size="2" /><input type="submit" value="Add to cart" class="btnAddAction" /></div>
            </form>
        </div>
        <?php
            }
        }
        ?>
    </div>
    </body>
</html>