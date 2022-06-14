<?php

$tagurl = 'index.php?page=products';

if (isset($_GET['category'])){
	$category = $_GET['category'];
    $tagurl .= '&category=' . $category;
}
if (isset($_GET['brand'])){
	$brand = $_GET['brand'];
    $tagurl .= '&brand=' . $brand;
}

/*
$sortby = isset($_GET['sortby']) ? $_GET['sortby'] : 'releasedate';

if ($sortby == 'availability'){
    $order = 'product_Quantity > 0 AND total_Sold DESC';
}
else if($sortby == 'bestsellers'){
    $order = 'total_Sold DESC';
}
else if($sortby == 'price:asc'){
    $order = 'product_BasePrice DESC';
}
else if($sortby == 'price:desc'){
    $order = 'product_BasePrice DESC';
}
else{
    $order = 'date_Added DESC';
}

$direction = 'DESC';

if ($sortby == 'price:asc'){
    $direction = 'ASC';
}
*/

if (isset($_GET['pr'])){
    $pricerange = $_GET['pr'];
    $tagprice = 'product_BasePrice';
    if ($pricerange == 1){
        $low = 0;
        $high = 25;
    }
    if ($pricerange == 2){
        $low = 26;
        $high = 50;
    }
    if ($pricerange == 3){
        $low = 51;
        $high = 75;
    }
    if ($pricerange == 4){
        $low = 76;
        $high = 100;
    }
    if ($pricerange == 5){
        $low = 101;
        $high = 500;
    }
}

if (isset($_GET['sortby'])){
    $sortby = $_GET['sortby'];
}
/*
if (isset($_GET['category'], $_GET['brand'], $_GET['pr'], $_GET['sortby'])){
    $stmt = $pdo->prepare('SELECT * FROM PRODUCT_TABLE WHERE product_Type = ? AND product_BrandName = ? AND ? > 0 AND ? >= ? AND ? <= ? ORDER BY date_Added DESC');
	$stmt->bindValue(1, $category, PDO::PARAM_STR);
	$stmt->bindValue(2, $brand, PDO::PARAM_STR);
    $stmt->bindValue(3, $tag, PDO::PARAM_STR);
    $stmt->bindValue(4, $tagprice, PDO::PARAM_STR);
    $stmt->bindValue(5, $low, PDO::PARAM_INT);
    $stmt->bindValue(6, $tagprice, PDO::PARAM_STR);
    $stmt->bindValue(7, $high, PDO::PARAM_INT);
}
else if (isset($_GET['category'], $_GET['brand'], $_GET['pr'])){
    $stmt = $pdo->prepare('SELECT * FROM PRODUCT_TABLE WHERE product_Type = ? AND product_BrandName = ? AND ? >= ? AND ? <= ? ORDER BY date_Added DESC');
	$stmt->bindValue(1, $category, PDO::PARAM_STR);
	$stmt->bindValue(2, $brand, PDO::PARAM_STR);
    $stmt->bindValue(3, $tagprice, PDO::PARAM_STR);
    $stmt->bindValue(4, $low, PDO::PARAM_INT);
    $stmt->bindValue(5, $tagprice, PDO::PARAM_STR);
    $stmt->bindValue(6, $high, PDO::PARAM_INT);
}
else if (isset($_GET['category'], $_GET['brand'], $_GET['sortby'])){
    $stmt = $pdo->prepare('SELECT * FROM PRODUCT_TABLE WHERE product_Type = ? AND product_BrandName = ? AND ? > 0 ORDER BY date_Added DESC');
	$stmt->bindValue(1, $category, PDO::PARAM_STR);
	$stmt->bindValue(2, $brand, PDO::PARAM_STR);
    $stmt->bindValue(3, $tag, PDO::PARAM_STR);
    $stmt->bindValue(4, $tagprice, PDO::PARAM_STR);
    $stmt->bindValue(5, $low, PDO::PARAM_INT);
    $stmt->bindValue(6, $high, PDO::PARAM_INT);
}
else if (isset($_GET['category'], $_GET['pr'], $_GET['sortby'])){
    $stmt = $pdo->prepare('SELECT * FROM PRODUCT_TABLE WHERE product_Type = ? AND ? > 0 AND ? >= ? AND ? <= ? ORDER BY date_Added DESC');
	$stmt->bindValue(1, $category, PDO::PARAM_STR);
    $stmt->bindValue(2, $tag, PDO::PARAM_STR);
    $stmt->bindValue(3, $tagprice, PDO::PARAM_STR);
    $stmt->bindValue(4, $low, PDO::PARAM_INT);
    $stmt->bindValue(5, $tagprice, PDO::PARAM_STR);
    $stmt->bindValue(6, $high, PDO::PARAM_INT);
}
else if (isset($_GET['brand'], $_GET['pr'], $_GET['sortby'])){
    $stmt = $pdo->prepare('SELECT * FROM PRODUCT_TABLE WHERE product_BrandName = ? AND ? > 0 AND ? >= ? AND ? <= ? ORDER BY date_Added DESC');
	$stmt->bindValue(1, $brand, PDO::PARAM_STR);
    $stmt->bindValue(2, $tag, PDO::PARAM_STR);
    $stmt->bindValue(3, $tagprice, PDO::PARAM_STR);
    $stmt->bindValue(4, $low, PDO::PARAM_INT);
    $stmt->bindValue(5, $tagprice, PDO::PARAM_STR);
    $stmt->bindValue(6, $high, PDO::PARAM_INT);
}
else if (isset($_GET['category'], $_GET['brand'])){
    $stmt = $pdo->prepare('SELECT * FROM PRODUCT_TABLE WHERE product_Type = ? AND product_BrandName = ? ORDER BY date_Added DESC');
	$stmt->bindValue(1, $category, PDO::PARAM_STR);
	$stmt->bindValue(2, $brand, PDO::PARAM_STR);
}
else if (isset($_GET['category'], $_GET['pr'])){
    $stmt = $pdo->prepare('SELECT * FROM PRODUCT_TABLE WHERE product_Type = ? AND ? >= ? AND ? <= ? ORDER BY date_Added DESC');
	$stmt->bindValue(1, $category, PDO::PARAM_STR);
    $stmt->bindValue(2, $tagprice, PDO::PARAM_STR);
    $stmt->bindValue(3, $low, PDO::PARAM_INT);
    $stmt->bindValue(4, $tagprice, PDO::PARAM_STR);
    $stmt->bindValue(5, $high, PDO::PARAM_INT);
}
else if (isset($_GET['category'], $_GET['sortby'])){
    $stmt = $pdo->prepare('SELECT * FROM PRODUCT_TABLE WHERE product_Type = ? AND ? > 0 ORDER BY date_Added DESC');
	$stmt->bindValue(1, $category, PDO::PARAM_STR);
    $stmt->bindValue(2, $tag, PDO::PARAM_STR);
}
else if (isset($_GET['brand'], $_GET['pr'])){
    $stmt = $pdo->prepare('SELECT * FROM PRODUCT_TABLE WHERE product_BrandName = ? AND ? >= ? AND ? <= ? ORDER BY date_Added DESC');
	$stmt->bindValue(1, $brand, PDO::PARAM_STR);
    $stmt->bindValue(2, $tagprice, PDO::PARAM_STR);
    $stmt->bindValue(3, $low, PDO::PARAM_INT);
    $stmt->bindValue(4, $tagprice, PDO::PARAM_STR);
    $stmt->bindValue(5, $high, PDO::PARAM_INT);
}
else if (isset($_GET['brand'], $_GET['sortby'])){
    $stmt = $pdo->prepare('SELECT * FROM PRODUCT_TABLE WHERE product_BrandName = ? AND ? > 0 ORDER BY date_Added DESC ');
	$stmt->bindValue(1, $brand, PDO::PARAM_STR);
    $stmt->bindValue(2, $tag, PDO::PARAM_STR);
}
else if (isset($_GET['pr'], $_GET['sortby'])){
    $stmt = $pdo->prepare('SELECT * FROM PRODUCT_TABLE WHERE  ? > 0 AND ? >= ? AND ? <= ? ORDER BY date_Added DESC');
    $stmt->bindValue(1, $tag, PDO::PARAM_STR);
    $stmt->bindValue(2, $tagprice, PDO::PARAM_STR);
    $stmt->bindValue(3, $low, PDO::PARAM_INT);
    $stmt->bindValue(4, $tagprice, PDO::PARAM_STR);
    $stmt->bindValue(5, $high, PDO::PARAM_INT);
}
*/
if (isset($_GET['category'])){
    $stmt = $pdo->prepare('SELECT * FROM PRODUCT_TABLE WHERE product_Type = ?');
	$stmt->bindValue(1, $category, PDO::PARAM_STR);
}
else if (isset($_GET['brand'])){
    $stmt = $pdo->prepare('SELECT * FROM PRODUCT_TABLE WHERE product_BrandName = ?');
	$stmt->bindValue(1, $brand, PDO::PARAM_STR);

}
else if (isset($_GET['pr'])){
    $stmt = $pdo->prepare('SELECT * FROM PRODUCT_TABLE WHERE product_BasePrice >= ? AND product_BasePrice <= ? ORDER BY product_BasePrice DESC');
    #$stmt->bindValue(1, $tagprice, PDO::PARAM_STR);
    $stmt->bindValue(1, $low, PDO::PARAM_INT);
    #$stmt->bindValue(3, $tagprice, PDO::PARAM_STR);
    $stmt->bindValue(2, $high, PDO::PARAM_INT);
}
else if (isset($_GET['sortby']) && $sortby == 'instock'){
    $stmt = $pdo->prepare('SELECT * FROM PRODUCT_TABLE WHERE product_Quantity > 0 ORDER BY date_Added DESC');
}
else if (isset($_GET['sortby']) && $sortby == 'bestsellers'){
    $stmt = $pdo->prepare('SELECT * FROM PRODUCT_TABLE ORDER BY total_Sold DESC');
}
else{
    $stmt = $pdo->prepare('SELECT * FROM PRODUCT_TABLE ORDER BY date_Added DESC');
}
/*if (isset($_GET['category']) && isset($_GET['brand'])){
	$stmt = $pdo->prepare('SELECT * FROM PRODUCT_TABLE WHERE product_Type = ? AND product_BrandName = ? ORDER BY ?');
	$stmt->bindValue(1, $category, PDO::PARAM_STR);
	$stmt->bindValue(2, $brand, PDO::PARAM_STR);
	$stmt->bindValue(3, $order, PDO::PARAM_STR);
	#$stmt->bindValue(4, $direction, PDO::PARAM_STR);
}
else if(isset($_GET['category'])){
	$stmt = $pdo->prepare('SELECT * FROM PRODUCT_TABLE WHERE product_Type = ? ORDER BY ?');
	$stmt->bindValue(1, $category, PDO::PARAM_STR);
	$stmt->bindValue(2, $order, PDO::PARAM_STR);
	#$stmt->bindValue(3, $direction, PDO::PARAM_STR);
}
else if(isset($_GET['brand'])){
	$stmt = $pdo->prepare('SELECT * FROM PRODUCT_TABLE WHERE product_BrandName = ? ORDER BY ?');
	$stmt->bindValue(1, $brand, PDO::PARAM_STR);
	$stmt->bindValue(2, $order, PDO::PARAM_STR);
	#$stmt->bindValue(3, $direction, PDO::PARAM_STR);
}
else{
	$stmt = $pdo->prepare('SELECT * FROM PRODUCT_TABLE ORDER BY ?');
	$stmt->bindValue(1, $order, PDO::PARAM_STR);
	#$stmt->bindValue(2, $direction, PDO::PARAM_STR);
}
*/

$stmt->execute();

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?=template_header('products');?>

<div class="container pt-5">
	<div class="row pt-2">
	    <div class="col-sm-4">
            <div class="accordion" id="productsAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Brands
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#productsAccordion">
                        <div class="accordion-body">
                            <a class="dropdown-item" href="index.php?page=products&brand=Acer">Acer</a>
                            <a class="dropdown-item" href="index.php?page=products&brand=Keychron">Keychron</a>
                            <a class="dropdown-item" href="index.php?page=products&brand=Logitech">Logitech</a>
                            <a class="dropdown-item" href="index.php?page=products&brand=Perixx">Perixx</a>
                            <a class="dropdown-item" href="index.php?page=products&brand=Razer">Razer</a>
                            <a class="dropdown-item" href="index.php?page=products&brand=Redragon">Redragon</a>
                            <a class="dropdown-item" href="index.php?page=products&brand=Steelseries">Steelseries</a>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                            Type
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#productsAccordion">
                        <div class="accordion-body">
                            <a class="dropdown-item" href="index.php?page=products&category=keyboard">Keyboards</a>
                            <a class="dropdown-item" href="index.php?page=products&category=mouse">Mice</a>
                            <a class="dropdown-item" href="index.php?page=products&category=switch">Switches</a>
                            <a class="dropdown-item" href="index.php?page=products&category=keycap">Keycaps</a>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                            Price
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#productsAccordion">
                        <div class="accordion-body">
                            <!-- range= 1 - 5 -->
                            <a class="dropdown-item" href="index.php?page=products&pr=1">$0 - $25</a>
                            <a class="dropdown-item" href="index.php?page=products&pr=2">$26 - $50</a>
                            <a class="dropdown-item" href="index.php?page=products&pr=3">$51 - $75</a>
                            <a class="dropdown-item" href="index.php?page=products&pr=4">$76 - $100</a>
                            <a class="dropdown-item" href="index.php?page=products&pr=5">$100+</a>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                Featured Items
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse show" aria-labelledby="headingFour" data-bs-parent="#productsAccordion">
                            <div class="accordion-body">
                                <a class="dropdown-item" href="index.php?page=products&sortby=instock">In Stock</a>
                                <a class="dropdown-item" href="index.php?page=products&sortby=releasedate">Release Date</a>
                                <a class="dropdown-item" href="index.php?page=products&sortby=bestsellers">Best Sellers</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
	    </div>
	    <div class="col-sm-8">
            <div class="row gx-5 gy-5">
                <?php foreach ($products as $product): ?>
                    <div class="col-sm-4">
                        <a href="index.php?page=item&id=<?=$product['product_ID']?>" class="item">
                            <div class="row">
                                <img src="assets/img/<?=$product['image_Link']?>" width="250" height="250" alt="<?=$product['product_BrandName'].$product['product_Title']?>">
                            </div>
                            <div class="row">
                                <span class="name"><?=$product['product_BrandName']?></span>
                                <span class="name"><?=$product['product_Title']?></span>
                                <?php if ($product['product_Discount'] > 0): ?>
                                    <span style="text-decoration:line-through" class="name">&dollar;<?=$product['product_BasePrice']?></span><span style="font-weight:bold" class="name">&dollar;<?=$product['product_Discount']?></span>
                                <?php endif; ?>
                                <?php if ($product['product_Discount'] == 0): ?>
                                    </span><span class="name">&dollar;<?=$product['product_BasePrice']?></span>
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
	</div>
</div>
<?=template_footer()?>
