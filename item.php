<?php

if(isset($_GET['id'])){
    $itemID = $_GET['id'];
    $stmt = $pdo->prepare('SELECT * FROM PRODUCT_TABLE WHERE product_ID = ?');
    $stmt->bindValue(1, $itemID, PDO::PARAM_STR);
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!$product){
        header("Location: ", true, 301);
        exit();
    }
}
else{
    header("Location: ", true, 301);
    exit();
}
$stmt = $pdo->prepare('SELECT * FROM PRODUCT_TABLE WHERE product_Type = ? ORDER BY date_Added DESC LIMIT 4');
#$stmt = $pdo->prepare('SELECT * FROM PRODUCT_TABLE WHERE product_BrandName = ? AND product_Type = ? AND NOT product_ID = ? ORDER BY product_Added DESC LIMIT 6');
$stmt->bindValue(1, $product['product_Type'], PDO::PARAM_STR);
#$stmt->bindValue(2, $product['product_ID'], PDO::PARAM_STR);
$stmt->execute();
$similaritems = $stmt->fetchAll(PDO::FETCH_ASSOC);


$stmt = $pdo->prepare('SELECT * FROM PRODUCT_TABLE WHERE product_BrandName = ? ORDER BY date_Added DESC LIMIT 4');
$stmt->bindValue(1, $product['product_BrandName'], PDO::PARAM_STR);
$stmt->execute();
$similaritems2 = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?=template_header('item');?>

<div class="container pt-5">
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <img class="img" src="assets/img/<?=$product['image_Link']?>" alt="Image"> 
            </div>
        </div>
        <div class="col-md-4">
            <div class="row">
                <h5 class="brandName"><?=$product['product_BrandName']?></h5>
                <h2 class="name"><?=$product['product_Title']?></h2>
                <span class="price">
                    <?php if ($product['product_Discount'] > 0): ?>
                        <span style="text-decoration:line-through" class="name">&dollar;<?=$product['product_BasePrice']?></span><span style="font-weight:bold" class="name"><?="   $" . $product['product_Discount']?></span>
                    <?php endif; ?>
                    <?php if ($product['product_Discount'] == 0): ?>
                        </span><span class="name">&dollar;<?=$product['product_BasePrice']?></span>
                    <?php endif; ?>
                </span>
                <form action="index.php?page=cart" method="post">
                    <input type="number" name="quantity" value="1" min="1" max="<?=$product['product_Quantity']?>"
                    placeholder="Quantity" required> 
                    <input type="hidden" name="product_id" value="<?=$product['product_ID']?>">
                    <input type="submit" value="Add To Cart">
                </form>
            </div>
            <br>
            <?php if ($product['product_Quantity'] <= 0): ?>
                <div class="row">
                    <h5 class="quantity_Remaining">OUT OF STOCK!</h5>
                </div>
            <?php endif; ?>
            <?php if ($product['product_Quantity'] > 0): ?>
                <div class="row">
                    <div class="h5"><?=$product['product_Quantity']?> left in stock.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="row pt-5">
        <div class="description">
            <?=$product['product_Description']?>
        </div>
    </div>
    <div class="row pt-5">
        <div class="h4">Similar Products</div>
    </div>
    <div class="row">
        <?php foreach ($similaritems as $prod): ?>
            <?php if ($prod['product_ID'] != $product['product_ID']): ?>
                <div class="col-lg-3 col-sm-6 pt-2">
                    <a href="index.php?page=item&id=<?=$prod['product_ID']?>" class="item">
                        <div class="row">
                            <img src="assets/img/<?=$prod['image_Link']?>" width="200" height="200" alt="<?=$prod['product_Title']?>">
                        </div>
                        <div class="row">
                            <span class="name"><?=$prod['product_BrandName']?></span>
                            <span class="name"><?=$prod['product_Title']?></span>
                            <?php if ($prod['product_Discount'] > 0): ?>
                                <span style="text-decoration:line-through" class="name">&dollar;<?=$prod['product_BasePrice']?></span><span style="font-weight:bold" class="name">&dollar;<?=$prod['product_Discount']?></span>
                            <?php endif; ?>
                            <?php if ($prod['product_Discount'] == 0): ?>
                                </span><span class="name">&dollar;<?=$prod['product_BasePrice']?></span>
                            <?php endif; ?>
                        </div>
                    </a>		
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php foreach ($similaritems2 as $prod): ?>
            <?php if ($prod['product_ID'] != $product['product_ID']): ?>
                <?php if ($prod['product_Type'] != $product['product_Type']): ?>
                    <div class="col-lg-3 col-sm-6 pt-2">
                        <a href="index.php?page=item&id=<?=$prod['product_ID']?>" class="item">
                            <div class="row">
                                <img src="assets/img/<?=$prod['image_Link']?>" width="200" height="200" alt="<?=$prod['product_Title']?>">
                            </div>
                            <div class="row">
                                <span class="name"><?=$prod['product_BrandName']?></span>
                                <span class="name"><?=$prod['product_Title']?></span>
                                <?php if ($prod['product_Discount'] > 0): ?>
                                    <span style="text-decoration:line-through" class="name">&dollar;<?=$prod['product_BasePrice']?></span><span style="font-weight:bold" class="name">&dollar;<?=$prod['product_Discount']?></span>
                                <?php endif; ?>
                                <?php if ($prod['product_Discount'] == 0): ?>
                                    </span><span class="name">&dollar;<?=$prod['product_BasePrice']?></span>
                                <?php endif; ?>
                            </div>
                        </a>		
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>



<?=template_footer()?>