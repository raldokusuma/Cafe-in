<?php
session_start();
include("_con.php");
$db_edit = new DBController();
if(!empty($_GET["action"])) {
switch($_GET["action"]) {
    case "edit":
        if(!empty($_GET["product_id"])) {
            $productById = $db_edit->runQuery("SELECT * FROM tbl_product WHERE product_id='" . $_GET["product_id"] . "'");
            // echo json_encode($productById) ;
            // echo "\n";
            $itemArray = array($productById[0]["product_id"] =>array('product_id'=>$productById[0]["product_id"],'name'=>$productById[0]["Nama"], 'jenis'=>$productById[0]["Jenis"], 'price'=>$productById[0]["price"]));
            $_SESSION["editan"] = $itemArray;
        }
    break;
    case "update":
        unset($_SESSION["editan"]);
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
            <ul><li class="allmenu"><a href="admin.php">All Menu</a></li></ul>
            <ul>
                <li class="menu"><a class="active" href="admin.php?view=v_acai">Acai</a></li>
                <li class="menu"><a href="admin.php?view=v_blended">Blended</a></li>
                <li class="menu"><a href="admin.php?view=v_coffee">Coffee</a></li>
                <li class="menu"><a href="admin.php?view=v_others">Others</a></li>
                <li class="menu"><a href="admin.php?view=v_pasta">Pasta</a></li>
                <li class="menu"><a href="admin.php?view=v_rice">Rice</a></li>
                <li class="menu"><a href="admin.php?view=v_sharedbites">Shared Bites</a></li>
                <li class="menu"><a href="admin.php?view=v_sweet">Sweet</a></li>
                <li class="menu"><a href="admin.php?view=v_tea">Tea</a></li>
                <li class="menu"><a href="admin.php?view=v_topdrinks">Topping for Drinks</a></li>
                <li class="menu"><a href="admin.php?view=v_topfood">Topping for Foods</a></li>
                <li class="menu"><a href="admin.php?view=v_western">Western</a></li>
            </ul>
            <?php
                // include ("_con.php");
                // include '_con2.php';
                // $db_handle = new DBController();
                if (isset($_GET['view'])) {
                    $product_array = $db_edit->runQuery("SELECT * FROM `".$_GET['view']."`");
                    // $querya = "SELECT * FROM v_acai";
                    // $view = mysqli_query($con, $querya);
                    // $product_array = mysqli_fetch_array($view);
                }
                else {
                    $product_array = $db_edit->runQuery("SELECT * FROM tbl_product ORDER BY product_id ASC");
                }
                if (!empty($product_array)) { 
                foreach($product_array as $key=>$value){
            ?>
            <div class="product-item" style="position: relative;">
                <div><strong style="color: black"><?php echo $product_array[$key]["Nama"]; ?></strong></div>
                <div class="product-price"><?php echo "Rp ".$product_array[$key]["price"];?>rb</div>
                <div style="bottom: 5px; left: 20px; right: 20px; position: absolute; "><a style="margin: 20px" href="admin.php?action=edit&product_id=<?php echo $product_array[$key]["product_id"]; ?>" class="btnRemoveAction">Edit</a><a href="delete.php?product_id=<?php echo $product_array[$key]["product_id"]; ?>" class="btnRemoveAction">Delete</a></div>
            </div>
            <?php
                }
            }
            ?>
        </div>
        <div id="shopping-cart" style="width: 40%; float: right; padding: 20px;">
            <form method="post" action="update.php">
                <div class="txt-heading">Form Edit Menu <input style="float: right;" type="submit" value="Simpan" name="simpan" class="btnAddAction" /></div>
                <?php
                    if(isset($_SESSION["editan"])){
                ?>  
                <table cellpadding="10" cellspacing="1">
                    <tbody>
                        <tr>
                            <th style="text-align:right;color: black"><strong>Kolom</strong></th>
                            <th style="text-align:right;color: black"><strong>Input</strong></th>
                        </tr>
                        <?php 
                            foreach ($_SESSION["editan"] as $item) {
                        ?>
                        <tr>
                            <td style="text-align:right;border-bottom:#F0F0F0 1px solid; color: black">
                                <label for="id">ID: </label>
                            </td>
                            <td style="text-align:right;border-bottom:#F0F0F0 1px solid; color: black">
                                <input type="hidden" name="id" value="<?php echo $item['product_id'] ?>" />
                                <label name="id"><?php echo $item['product_id'] ?></label>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:right;border-bottom:#F0F0F0 1px solid; color: black">
                                <label for="nama">Nama: </label>
                            </td>
                            <td style="text-align:right;border-bottom:#F0F0F0 1px solid; color: black">
                                <input type="text" name="name" value="<?php echo $item['name'] ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:right;border-bottom:#F0F0F0 1px solid; color: black">
                                <label for="price">Price: </label>
                            </td>
                            <td style="text-align:right;border-bottom:#F0F0F0 1px solid; color: black">
                                <input type=text name="price" value="<?php echo $item['price'] ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:right;border-bottom:#F0F0F0 1px solid; color: black">
                                <label for="jenis">Jenis: </label>
                            </td>
                            <td style="text-align:right;border-bottom:#F0F0F0 1px solid; color: black">
                                <input type=text name="jenis" value="<?php echo $item['jenis'] ?>" />
                            </td>
                        </tr>    
                    </tbody>
                </table>        
                <?php
            }
                    }
                ?>
            </div>
        </form>
    </div>    
</body>
</html>