<?php

if ($_SESSION['admin_flag'] != '1' && $_SESSION['signedin'] != 'true'){
    header("Location: index.php");
    exit();
}

$productid_error_msg = '';
$producttitle_error_msg = '';
$producttype_error_msg = '';
$productquantity_error_msg = '';
$description_error_msg = '';
$brandname_error_msg = '';
$productbaseprice_error_msg = '';
$imagename_error_msg = '';
$producttags_error_msg = '';
$createstatus = '';
$date = date("Y-m-d");
$msg = '';
$filldata = '';
$pid = '';
$pti = '';
$pty = '';
$pq = '';
$pdc = '';
$pbn = '';
$pbp = '';
$pil = '';
$ptg = '';

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
    $pq = $product['product_Quantity'];
    $pdc = $product['product_Description'];
    $pbn = $product['product_BrandName'];
    $pbp = $product['product_BasePrice'];
    $pil = $product['image_Link'];
    $ptg = $product['product_Tags'];
}

/*
if (isset($_POST['imagesubmit'])) {
  
    $filename = $_FILES["image"]["name"];
    $tempname = $_FILES["image"]["tmp_name"];    
    $folder = "assets/img/".$filename;

    if (move_uploaded_file($tempname, $folder))  {
        $msg = "";
    }else{
        $msg = "Failed to upload image";
    }
}
*/

if (isset($_POST['submit'])){
    try{
        if (empty($_POST['product_id'])){
            $productid_error_msg = 'product_id field is required!';
        }
        if (empty($_POST['product_Title'])){
            $producttitle_error_msg = 'product_Title field is required!';
        }
        if (empty($_POST['product_Type'])){
            $producttype_error_msg = 'product_Type field is required!';
        }
        if (empty($_POST['product_Quantity'])){
            $productquantity_error_msg = 'product_Quantity Date field is required!';
        }
        if (empty($_POST['product_Description'])){
            $description_error_msg = 'product_Description field is required!';
        }
        if (empty($_POST['product_BrandName'])){
            $brandname_error_msg = 'product_BrandName field is required!';
        }
        if (empty($_POST['product_BasePrice'])){
            $productbaseprice_error_msg = 'product_BasePrice field is required!';
        }
        if (empty($_POST['image_Link'])){
            $imagename_error_msg = 'image_Link field is required!';
        }
        if (empty($_POST['product_Tags'])){
            $producttags_error_msg = 'product_Tags field is required!';
        }
        if (empty($productid_error_msg) &&
                empty($producttitle_error_msg) &&
                empty($producttype_error_msg ) &&
                empty($productquantity_error_msg) &&
                empty($description_error_msg) &&
                empty($brandname_error_msg) &&
                empty($productbaseprice_error_msg) &&
                empty($imagename_error_msg) &&
                empty($producttags_error_msg)
                )
        {
            $product_id = $_POST['product_id'];
            $product_title = $_POST['product_Title'];
            $product_type = $_POST['product_Type'];
            $quantity = $_POST['product_Quantity'];
            $product_desc = $_POST['product_Description'];
            $product_bn = $_POST['product_BrandName'];
            $product_baseprice = $_POST['product_BasePrice'];
            $imagename = $_POST['image_Link'];
            $product_tags = $_POST['product_Tags'];

            $stmt = $pdo->prepare('UPDATE PRODUCT_TABLE SET product_Title = ?, product_Type = ?, product_Quantity = ?, product_Description = ?, product_BrandName = ?, product_BasePrice = ?, image_Link = ?, product_Tags = ? WHERE product_ID = ?');
            $stmt->bindValue(1, $product_title, PDO::PARAM_STR);
            $stmt->bindValue(2, $product_type, PDO::PARAM_STR);
            $stmt->bindValue(3, $quantity, PDO::PARAM_STR);
            $stmt->bindValue(4, $product_desc, PDO::PARAM_STR);
            $stmt->bindValue(5, $product_bn, PDO::PARAM_STR);
            $stmt->bindValue(6, $product_baseprice, PDO::PARAM_STR);
            $stmt->bindValue(7, $imagename, PDO::PARAM_STR);
            $stmt->bindValue(8, $product_tags, PDO::PARAM_STR);
            $stmt->bindValue(9, $product_id, PDO::PARAM_STR);
            $stmt->execute();

            $createstatus = 'Successfully updated product.';

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

<?=template_header('adminmodifyproduct');?>

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
            <form action="index.php?page=adminmodifyproduct" method='post'>
                <div class="mb-3 mt-3">
                    <label for="product_id" class="form-label">Enter a product ID to change it's values</label>
                    <input type="text" class="form-control" id="product_id" placeholder="Enter product ID" name="product_id">
                    <br>
                    <button type="submit" name="querysubmit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            <?php if ($filldata == ""): ?>
                <div class="row">
                    <?php if ($createstatus != ''): ?>
                        <div class="h5"><?php echo $createstatus ?></div>
                    <?php endif; ?>
                    <form action="index.php?page=adminmodifyproduct" method='post'>
                        <div class="mb-3 mt-3">
                            <label for="product_id" class="form-label">Product ID:</label>
                            <input type="text" class="form-control" id="product_id" placeholder="Enter product ID" name="product_id" disabled>
                        </div>
                        <?php if ($productid_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$productid_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="product_Title" class="form-label">Product Title:</label>
                            <input type="text" class="form-control" id="product_Title" placeholder="Enter product title" name="product_Title" disabled>
                        </div>
                        <?php if ($producttitle_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$producttitle_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="product_Type" class="form-label">Product Type:</label>
                            <input type="text" class="form-control" id="product_Type" placeholder="Enter product type" name="product_Type" disabled>
                        </div>
                        <?php if ($producttype_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$producttype_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="product_Quantity" class="form-label">Product Quantity:</label>
                            <input type="text" class="form-control" id="product_Quantity" placeholder="Enter product quantity" name="product_Quantity" disabled>
                        </div>
                        <?php if ($productquantity_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$productquantity_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="product_Description" class="form-label">Product Description:</label>
                            <input type="text" class="form-control" id="product_Description" placeholder="Enter product description" name="product_Description" disabled>
                        </div>
                        <?php if ($description_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$description_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="product_BrandName" class="form-label">Product Brand Name:</label>
                            <input type="text" class="form-control" id="product_BrandName" placeholder="Enter product brand name" name="product_BrandName" disabled>
                        </div>
                        <?php if ($brandname_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$brandname_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="product_BasePrice" class="form-label">Product Base Price:</label>
                            <input type="text" class="form-control" id="product_BasePrice" placeholder="Enter product price" name="product_BasePrice" disabled>
                        </div>
                        <?php if ($productbaseprice_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$productbaseprice_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="image_Link" class="form-label">Image Link:</label>
                            <input type="text" class="form-control" id="image_Link" placeholder="Enter Image Link" name="image_Link" disabled>
                        </div>
                        <?php if ($imagename_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$imagename_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="product_Tags" class="form-label">Product Tags:</label>
                            <input type="text" class="form-control" id="product_Tags" placeholder="Enter product tags" name="product_Tags" disabled>
                        </div>
                        <?php if ($producttags_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$producttags_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <button type="submit" name="submit" class="btn btn-primary" disabled>Submit</button>
                    </form>
                </div>
                <div class="row pt-5"></div>
            <?php endif; ?>
            <?php if ($filldata != ""): ?>
                <div class="row">
                    <?php if ($createstatus != ''): ?>
                        <div class="h5"><?php $createstatus ?></div>
                    <?php endif; ?>
                    <form action="index.php?page=adminmodifyproduct" method='post'>
                        <div class="mb-3 mt-3">
                            <label for="product_id" class="form-label">Product ID:</label>
                            <input type="text" class="form-control" id="product_id" value="<?=$pid?>" name="product_id">
                        </div>
                        <?php if ($productid_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$productid_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="product_Title" class="form-label">Product Title:</label>
                            <input type="text" class="form-control" id="product_Title" value="<?=$pti?>" name="product_Title">
                        </div>
                        <?php if ($producttitle_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$producttitle_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="product_Type" class="form-label">Product Type:</label>
                            <input type="text" class="form-control" id="product_Type" value="<?=$pty?>" name="product_Type">
                        </div>
                        <?php if ($producttype_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$producttype_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="product_Quantity" class="form-label">Product Quantity:</label>
                            <input type="text" class="form-control" id="product_Quantity" value="<?=$pq?>" name="product_Quantity">
                        </div>
                        <?php if ($productquantity_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$productquantity_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="product_Description" class="form-label">Product Description:</label>
                            <input type="text" class="form-control" id="product_Description" value="<?=$pdc?>" name="product_Description">
                        </div>
                        <?php if ($description_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$description_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="product_BrandName" class="form-label">Product Brand Name:</label>
                            <input type="text" class="form-control" id="product_BrandName" value="<?=$pbn?>" name="product_BrandName">
                        </div>
                        <?php if ($brandname_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$brandname_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="product_BasePrice" class="form-label">Product Base Price:</label>
                            <input type="text" class="form-control" id="product_BasePrice" value="<?=$pbp?>" name="product_BasePrice">
                        </div>
                        <?php if ($productbaseprice_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$productbaseprice_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="image_Link" class="form-label">Image Link:</label>
                            <input type="text" class="form-control" id="image_Link" value="<?=$pil?>" name="image_Link">
                        </div>
                        <?php if ($imagename_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$imagename_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="product_Tags" class="form-label">Product Tags:</label>
                            <input type="text" class="form-control" id="product_Tags" value="<?=$ptg?>" name="product_Tags">
                        </div>
                        <?php if ($producttags_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$producttags_error_msg?></div>
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