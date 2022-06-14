<?php

if ($_SESSION['admin_flag'] != '1' && $_SESSION['signedin'] != 'true'){
    header("Location: index.php");
    exit();
}

$couponname_error_msg = '';
$discount_error_msg = '';
$typelist_error_msg = '';
$expire_error_msg = '';
$description_error_msg = '';
$couponstatus = '';

if (isset($_POST['submit'])){
    try{
        if (empty($_POST['coupon_Name'])){
            $couponname_error_msg = 'Coupon Name field is required!';
        }
        if (empty($_POST['discount'])){
            $discount_error_msg = 'Discount field is required!';
        }
        if (empty($_POST['type_list'])){
            $typelist_error_msg = 'Type List field is required!';
        }
        if (empty($_POST['exp'])){
            $expire_error_msg = 'Expiration Date field is required!';
        }
        if (empty($_POST['description'])){
            $description_error_msg = 'Description field is required!';
        }
        if (empty($couponname_error_msg) &&
                empty($discount_error_msg) &&
                empty($typelist_error_msg ) &&
                empty($expire_error_msg) &&
                empty($description_error_msg)
                )
        {
            $couponid = $_POST['coupon_Name'];
            $disc = $_POST['discount'];
            $cTarg = $_POST['type_list'];
            $expire = $_POST['exp'];
            $descr = $_POST['description'];

            $sql = "INSERT INTO COUPON_TABLE (coupon_ID, discount_Amount, coupon_Target, coupon_Expiry, coupon_Description) VALUES ('$couponid', '$disc', '$cTarg', '$expire', '$descr')";
            $insertstmt = $pdo->prepare($sql);
            $insertstmt->execute();

            $couponstatus = 'Successfully created new coupon.';

        }

    }
    catch (PDOException $e) {
        // $error = "Error : " . $e->getMessage();
        $error = "Error creating coupon. Please try again.";
        echo '<script type="text/javascript">alert("'.$error.'");</script>';
    }
}

$stmt = $pdo->prepare('SELECT * FROM COUPON_TABLE');
$stmt->execute();
$coupons = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?=template_header('admincoupon');?>

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
            <div class="row">
                <?php if ($couponstatus != ''): ?>
                    <div class="h5"><?php echo $couponstatus?></div>
                <?php endif; ?>
                <form action="index.php?page=admincoupon" method='post'>
                    <div class="mb-3 mt-3">
                        <label for="coupon_Name" class="form-label">Coupon Name:</label>
                        <input type="text" class="form-control" id="coupon_Name" placeholder="Enter desired coupon name" name="coupon_Name">
                    </div>
                    <?php if ($couponname_error_msg != ""): ?>
                        <div class="text-danger mb3"><?=$couponname_error_msg?></div>
                    <?php endif; ?>
                    <br>
                    <div class="mb-3 mt-3">
                        <label for="discount" class="form-label">Discount Float Value:</label>
                        <input type="text" class="form-control" id="discount" placeholder="Enter a decimal value to be multiplied into item costs" name="discount">
                    </div>
                    <?php if ($discount_error_msg != ""): ?>
                        <div class="text-danger mb3"><?=$discount_error_msg?></div>
                    <?php endif; ?>
                    <br>
                    <div class="mb-3 mt-3">
                        <label for="type_list" class="form-label">List of brands or categories affected:</label>
                        <input type="text" class="form-control" id="type_list" placeholder="Enter a list of brands or categories which this coupon will affect" name="type_list">
                    </div>
                    <?php if ($typelist_error_msg != ""): ?>
                        <div class="text-danger mb3"><?=$typelist_error_msg?></div>
                    <?php endif; ?>
                    <br>
                    <div class="mb-3 mt-3">
                        <label for="exp" class="form-label">Expiration Date Y-m-d:</label>
                        <input type="text" class="form-control" id="exp" placeholder="Enter desired coupon name" name="exp">
                    </div>
                    <?php if ($expire_error_msg != ""): ?>
                        <div class="text-danger mb3"><?=$expire_error_msg?></div>
                    <?php endif; ?>
                    <br>
                    <div class="mb-3 mt-3">
                        <label for="description" class="form-label">Coupon Description:</label>
                        <input type="text" class="form-control" id="description" placeholder="Enter desired coupon name" name="description">
                    </div>
                    <?php if ($description_error_msg != ""): ?>
                        <div class="text-danger mb3"><?=$description_error_msg?></div>
                    <?php endif; ?>
                    <br>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="row pt-5">
                <div class="h5">Active Coupons:</div>
            </div>
            <div class="row">
                <?php foreach ($coupons as $coupon): ?>
                    <div class="row pt-5">
                        <span class="name">Coupon Name: <?=$coupon['coupon_ID']?></span>
                        <span class="name">Discount Amount as Percentage: <?=$coupon['discount_Amount']?></span>
                        <span class="name">Target Items: <?=$coupon['coupon_Target']?></span>
                        <span class="name">Expiration Date Y-m-d: <?=$coupon['coupon_Expiry']?></span>
                        <span class="name">Description: <?=$coupon['coupon_Description']?></span>
                    </div>
                    <br>
                <?php endforeach; ?>
            </div>
            <div class="row pt-5"></div>
        </div>  
    </div>
</div>

<?=template_footer()?>