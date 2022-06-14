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



if(isset($_POST["imagesubmit"])) {
    $file = $_FILES['image'];

    $fileName = $_FILES['image']['name'];
    $fileTmpName = $_FILES['image']['tmp_name'];
    $fileSize = $_FILES['image']['size'];
    $fileError = $_FILES['image']['error'];
    $fileType = $_FILES['image']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($fileActualExt, $allowed)){
        if ($fileError === 0){
            if ($fileSize < 1000000){
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                $fileDestination = 'assets/img/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                header("Location: index.php?page=admin");
            }
            else{
                $msg = "Your file is too big.";
            }
        }
        else{
            $msg = "Error uploading file.";
        }
    }
    else{
        $msg = "You cannot upload files of this type.";
    }
}

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

            $sql = "INSERT INTO PRODUCT_TABLE VALUES ('$product_id', '$product_title', '$product_type', '0', '$quantity', '$product_desc', '$product_bn', '$product_baseprice', '0', '$date', '$imagename', '$product_tags')";

            $insertstmt = $pdo->prepare($sql);
            $insertstmt->execute();

            $createstatus = 'Successfully created new product.';

        }

    }
    catch (PDOException $e) {
        // $error = "Error : " . $e->getMessage();
        $error = "Error creating item. Please try again.";
        echo '<script type="text/javascript">alert("'.$error.'");</script>';
    }
}


?>

<?=template_header('admin');?>

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
                <form action = "index.php?page=admin" method = "post" enctype = "multipart/form-data">
                    <input type = "file" name = "image" id = "image"/>
                    <button type="imagesubmit" class="btn btn-primary">Submit</button>
                </form>
                <?php if ($msg != ""): ?>
                    <div class="text-danger mb3"><?=$msg?></div>
                <?php endif; ?>
            </div>
            <div class="row pt-5">
                <?php if ($createstatus != ''): ?>
                    <div class="h5"><?php echo $createstatus ?></div>
                <?php endif; ?>
                <form action="index.php?page=admin" method='post'>
                    <div class="mb-3 mt-3">
                        <label for="product_id" class="form-label">Product ID:</label>
                        <input type="text" class="form-control" id="product_id" placeholder="Enter product ID" name="product_id">
                    </div>
                    <?php if ($productid_error_msg != ""): ?>
                        <div class="text-danger mb3"><?=$productid_error_msg?></div>
                    <?php endif; ?>
                    <br>
                    <div class="mb-3">
                        <label for="product_Title" class="form-label">Product Title:</label>
                        <input type="text" class="form-control" id="product_Title" placeholder="Enter product title" name="product_Title">
                    </div>
                    <?php if ($producttitle_error_msg != ""): ?>
                        <div class="text-danger mb3"><?=$producttitle_error_msg?></div>
                    <?php endif; ?>
                    <br>
                    <div class="mb-3">
                        <label for="product_Type" class="form-label">Product Type:</label>
                        <input type="text" class="form-control" id="product_Type" placeholder="Enter product type" name="product_Type">
                    </div>
                    <?php if ($producttype_error_msg != ""): ?>
                        <div class="text-danger mb3"><?=$producttype_error_msg?></div>
                    <?php endif; ?>
                    <br>
                    <div class="mb-3">
                        <label for="product_Quantity" class="form-label">Product Quantity:</label>
                        <input type="text" class="form-control" id="product_Quantity" placeholder="Enter product quantity" name="product_Quantity">
                    </div>
                    <?php if ($productquantity_error_msg != ""): ?>
                        <div class="text-danger mb3"><?=$productquantity_error_msg?></div>
                    <?php endif; ?>
                    <br>
                    <div class="mb-3">
                        <label for="product_Description" class="form-label">Product Description:</label>
                        <input type="text" class="form-control" id="product_Description" placeholder="Enter product description" name="product_Description">
                    </div>
                    <?php if ($description_error_msg != ""): ?>
                        <div class="text-danger mb3"><?=$description_error_msg?></div>
                    <?php endif; ?>
                    <br>
                    <div class="mb-3">
                        <label for="product_BrandName" class="form-label">Product Brand Name:</label>
                        <input type="text" class="form-control" id="product_BrandName" placeholder="Enter product brand name" name="product_BrandName">
                    </div>
                    <?php if ($brandname_error_msg != ""): ?>
                        <div class="text-danger mb3"><?=$brandname_error_msg?></div>
                    <?php endif; ?>
                    <br>
                    <div class="mb-3">
                        <label for="product_BasePrice" class="form-label">Product Base Price:</label>
                        <input type="text" class="form-control" id="product_BasePrice" placeholder="Enter product price" name="product_BasePrice">
                    </div>
                    <?php if ($productbaseprice_error_msg != ""): ?>
                        <div class="text-danger mb3"><?=$productbaseprice_error_msg?></div>
                    <?php endif; ?>
                    <br>
                    <div class="mb-3">
                        <label for="image_Link" class="form-label">Image Link:</label>
                        <input type="text" class="form-control" id="image_Link" placeholder="Enter Image Link" name="image_Link">
                    </div>
                    <?php if ($imagename_error_msg != ""): ?>
                        <div class="text-danger mb3"><?=$imagename_error_msg?></div>
                    <?php endif; ?>
                    <br>
                    <div class="mb-3">
                        <label for="product_Tags" class="form-label">Product Tags:</label>
                        <input type="text" class="form-control" id="product_Tags" placeholder="Enter product tags" name="product_Tags">
                    </div>
                    <?php if ($producttags_error_msg != ""): ?>
                        <div class="text-danger mb3"><?=$producttags_error_msg?></div>
                    <?php endif; ?>
                    <br>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="row pt-5"></div>
        </div>
    </div>
</div>

<?=template_footer()?>