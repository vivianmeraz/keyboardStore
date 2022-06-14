<?php

if ($_SESSION['admin_flag'] != '1' && $_SESSION['signedin'] != 'true'){
    header("Location: index.php");
    exit();
}

$productid_error_msg = '';
$product_Discount_error_msg = '';
$createstatus = '';
$filldata = '';
$pid = '';
$pti = '';
$pty = '';
$pbn = '';
$pbp = '';
$pdi = '';



if (isset($_POST['querysubmit'])){
    $filldata = "true";
    $productID = $_POST['product_id'];

    $stmt = $pdo->prepare('SELECT * FROM PRODUCT_TABLE WHERE product_ID = ?');
    $stmt->bindValue(1, $productID, PDO::PARAM_STR);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    $pid = $product['product_ID'];
    $pti = $product['product_Title'];
    $pty = $product['product_Type'];
    $pbn = $product['product_BrandName'];
    $pbp = $product['product_BasePrice'];
    $pdi = $product['product_Discount'];

}

if (isset($_POST['submit'])){
    try{
        if (empty($_POST['product_id'])){
            $productid_error_msg = 'product_id field is required!';
        }
        if (empty($_POST['product_Discount'])){
            $product_Discount_error_msg = 'product_Discount field is required!';
        }
        if (empty($productid_error_msg) &&
                empty($product_Discount_error_msg)
                )
        {
            $product_id = $_POST['product_id'];
            $product_Discount = $_POST['product_Discount'];

            $stmt = $pdo->prepare('UPDATE PRODUCT_TABLE SET product_Discount = ? WHERE product_ID = ?');
            $stmt->bindValue(1, $product_Discount, PDO::PARAM_STR);
            $stmt->bindValue(2, $product_id, PDO::PARAM_STR);
            $stmt->execute();

            $createstatus = 'Successfully created product discount.';

            $filldata = '';

        }

    }
    catch (PDOException $e) {
        // $error = "Error : " . $e->getMessage();
        $error = "Error modifying product. Please try again.";
        echo '<script type="text/javascript">alert("'.$error.'");</script>';
    }
}



?>

<?=template_header('admincreatediscount');?>

<div class="container">
    <div class="row pt-5">
        <div class="col-sm-4">
            <a class="dropdown-item" href="index.php?page=admin">Create Products</a>
            <a class="dropdown-item" href="index.php?page=adminmodifyproduct">Modify Products</a>
            <a class="dropdown-item" href="index.php?page=adminmodifyuser">Modify Users</a>
            <a class="dropdown-item" href="index.php?page=admintransaction">Transactions</a>
            <a class="dropdown-item" href="index.php?page=admincoupon">Coupons</a>
            <a class="dropdown-item" href="index.php?page=admincreatediscount">Product Discounts</a>
        </div>
        <div class="col-sm-8">
            <?php if ($createstatus != ''): ?>
                <div class="h5"><?php echo $createstatus ?></div>
            <?php endif; ?>
            <form action="index.php?page=admincreatediscount" method='post'>
                <div class="mb-3 mt-3">
                    <label for="product_id" class="form-label">Enter a product ID:</label>
                    <input type="text" class="form-control" id="product_id" placeholder="Enter product ID" name="product_id">
                    <br>
                    <button type="submit" name="querysubmit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            <?php if ($filldata != ""): ?>
                <div class="row pt-5">
                    <div class="row">
                        <div class="h5">Product ID: <?php echo $pid ?></div>
                        <div class="h5">Product Brand Name: <?php echo $pbn ?></div>
                        <div class="h5">Product Name: <?php echo $pti ?></div>
                        <div class="h5">Product Type: <?php echo $pty ?></div>
                        <div class="h5">Product Base Price: <?php echo "$" . $pbp ?></div>
                        <?php if($product['product_Discount'] > 0): ?>
                            <div class="h5">Current Product Base Price: <?php echo "$" . $pdi ?></div>
                        <?php endif; ?>
                    </div>
                    <form action="index.php?page=admincreatediscount" method='post'>
                        <div class="mb-3 mt-3">
                            <label for="product_id" class="form-label">Product ID:</label>
                            <input type="text" class="form-control" id="product_id" value="<?=$pid?>" name="product_id">
                        </div>
                        <?php if ($productid_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$productid_error_msg?></div>
                        <?php endif; ?>
                        <div class="mb-3 mt-3">
                            <label for="product_Discount" class="form-label">Product Discount:</label>
                            <input type="text" class="form-control" id="product_Discount" value="<?=$pdi?>" name="product_Discount">
                        </div>
                        <?php if ($product_Discount_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$product_Discount_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="row pt-5"></div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?=template_footer()?>