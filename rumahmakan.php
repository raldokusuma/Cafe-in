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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Makan</title>
    <title>User Web</title>
</head>
<body>
    <div style="width: 100%;">
        <div id="product-grid" style="width: 50%; float: left; padding: 20px;">
            <ul><li class="allmenu"><a href="">Tempat Makan</a></li></ul>
            <?php
                include '_con2.php';
                if (isset($_GET['view'])) {
                    // $product_array = $db_handle->runQuery("SELECT * FROM `".$_GET['view']."`");
                    // $querya = "SELECT * FROM v_acai";
                    // $view = mysqli_query($con, $querya);
                    // $product_array = mysqli_fetch_array($view);
                }
                else {
                    $product_array = $db_handle->runQuery("SELECT * FROM tbl_rumahmakan ORDER BY id_rumahmakan ASC");
                }
                if (!empty($product_array)) { 
                foreach($product_array as $key=>$value){
            ?>
            <div class="product-item" style="position: relative;">
                <form method="post" action="pesan.php?action=add&product_id=<?php echo $product_array[$key]["product_id"]; ?>">
                <!-- <div class="product-image"><img src="img/<?php echo $product_array[$key]["Nama"];?>.jpg"></div> -->
                <div><strong style="color: black"><?php echo $product_array[$key]["nama_rumahmakan"]; ?></strong></div>
                <div class="jarak"><?php echo "Jarak ".$product_array[$key]["jarak_rumahmakan"];?>km</div>
                <!-- <div style="bottom: 5px; margin-left: 30px; position: absolute; "><input type="text" name="quantity" value="1" size="2" /><input type="submit" value="Add to cart" class="btnAddAction" /></div> -->
                <div style="bottom: 5px; margin-left: 40%; position: absolute; ">
                    <button class="btn btn-primary">Pilih</button>
                </div>
                </form>
            </div>
            <?php
                }
            }
            ?>
        </div>
     
    </div>
    
    </body>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</html>