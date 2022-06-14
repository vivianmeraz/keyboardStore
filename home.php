<?php

$stmt = $pdo->prepare('SELECT * FROM PRODUCT_TABLE ORDER BY date_Added DESC LIMIT 6');
$stmt->execute();
$newreleases = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare('SELECT * FROM PRODUCT_TABLE ORDER BY total_Sold DESC LIMIT 6');
$stmt->execute();
$bestsellers = $stmt->fetchAll(PDO::FETCH_ASSOC);

#pdo=NULL
?>
<?=template_header('home') ?>

<div class="flat-imagebox">
    <!--determine sortby by var-->
    <div class="container pt-5">
        <div class="row pt-5">
            <a href="index.php?page=products&sortby=releasedate" class="products">
                <h2>New Releases</h2>
            </a>
        </div>
        <div class="row pt-2">
            <?php foreach ($newreleases as $product): ?>
		<div class="col-lg-4 col-sm-6 pt-2">
            <a href="index.php?page=item&id=<?=$product['product_ID']?>" class="item">
                <div class="row">
                    <img src="assets/img/<?=$product['image_Link']?>" width="200" height="200" alt="<?=$product['product_Title']?>">
                </div>
                <div class="row">
                    <span class="name"><?=$product['product_BrandName']?> <?=$product['product_Title']?></span>
                    <?php if ($product['product_Discount'] > 0): ?>
                        <span style="text-decoration:line-through" class="name">&dollar;<?=$product['product_BasePrice']?></span><span style="font-weight:bold" class="name">&dollar;<?=$product['product_Discount']?></span>
                    <?php endif; ?>
                    <?php if ($product['product_Discount'] == 0): ?>
                        <span class="name">&dollar;<?=$product['product_BasePrice']?></span>
                    <?php endif; ?>
                </div>
            </a>			
		</div>
            <?php endforeach; ?>
        </div>
        <div class="row pt-5">
            <a href="index.php?page=item&id=KBKCK1212" class="item">
                <img class='img-fluid w-100' src="assets/img/KBKCK1212.jpg" alt="Apex 5">
            </a>
        </div>
        <div class="row pt-5">
            <a href="index.php?page=products&sortby=bestsellers" class="products">
                <h2>Best Sellers</h2>
            </a>
	</div>
        <div class="row pt-2">
            <?php foreach ($bestsellers as $product): ?>
                <div class="col-lg-4 col-sm-6 pt-2">
                    <a href="index.php?page=item&id=<?=$product['product_ID']?>" class="item">
                        <div class="row">
                            <img src="assets/img/<?=$product['image_Link']?>" width="200" height="200" alt="<?=$product['product_Title']?>">
                        </div>
                        <div class="row">
                            <span class="name"><?=$product['product_BrandName']?> <?=$product['product_Title']?></span>
                            <?php if ($product['product_Discount'] > 0): ?>
                                <span style="text-decoration:line-through" class="name">&dollar;<?=$product['product_BasePrice']?></span><span style="font-weight:bold" class="name">&dollar;<?=$product['product_Discount']?></span>
                            <?php endif; ?>
                            <?php if ($product['product_Discount'] == 0): ?>
                                <span class="name">&dollar;<?=$product['product_BasePrice']?></span>
                            <?php endif; ?>
                        </div>
                    </a>		
                </div>
            <?php endforeach; ?>
        </div>
        <div class="row pt-5">
            <a href="index.php?page=item&id=KBSSApex501" class="item">
                <img class='img-fluid w-100' src="assets/img/KBSSApex501.jpg" alt="DeathAdder V217">
            </a>
	</div>
    </div>
</div>

<?=template_footer()?>
