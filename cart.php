<?php
// ADDING A PRODUCT TO THE CART----------------------------------------------------------------------------------

// If the user clicked the 'Add to Cart' form button (located in item.php), here we check the form data.
if (isset($_POST['product_id'], $_POST['quantity']) && (!isset($_POST['update']) ) && is_numeric($_POST['quantity'])) {                     // Still need to check product_id (not with is_numeric)
// Set post variables
	$product_id = $_POST['product_id'];
        $quantity = (int)$_POST['quantity'];        // Make sure quantity is an int
 
	// Check to see if the product exists in our database (PRODUCT_TABLE)
        $stmt = $pdo->prepare('SELECT * FROM PRODUCT_TABLE WHERE product_ID = ?');
        $stmt->execute([$_POST['product_id']]);

      	// Fetch product from database and return result as an array
        $productArr = $stmt->fetch(PDO::FETCH_ASSOC);
	
	// Check if product exists
	if ($productArr && $quantity > 0) {
		// Create/update session variable 'cart'
		if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
			// If product exists in cart already, then just update it
			if (array_key_exists($product_id, $_SESSION['cart'])) {
				$_SESSION['cart'][$product_id] += $quantity;
			} 
			// Product is not in the cart, so add it
			else {
				$_SESSION['cart'][$product_id] = $quantity;
			}
		}
		// There are no products in the cart, so insert the first one
		else {
			$_SESSION['cart'] = array($product_id => $quantity);
		}
	}

	header('location: index.php?page=cart');
	exit;
}

// REMOVING A PRODUCT FROM THE CART ---------------------------------------------------------------------------
// Still need a remove button in the shopping cart page

// Check for the URL param "remove"
if (isset($_POST['remove']) && isset($_SESSION['cart'])) { //&& isset($_SESSION['cart'][$_POST['remove']])) 
	foreach($_SESSION['cart'] as $k => $v) {
		if($_POST['product_id_remove'] == $k) {
			unset($_SESSION['cart'][$k]);
		}
		if (empty($_SESSION['cart'])) {
			unset($_SESSION['cart']);
		}

	}
}

// UPDATING PRODUCT QUANTITIES --------------------------------------------------------------------------------
// Update product quantities in cart if the user clicks the "Update" button on the shopping cart page
if (isset($_POST['update'])) { //&& isset($_SESSION['cart'])) {
#echo "IN UPDATE";

if($_POST['quantity'] == 0) {
#echo "zero";
#echo $_POST['quantity'];
unset($_SESSION['cart'][$_POST['product_id_update']]);
}                                           
else {
//TODO: **CHECK IF QUANTITY OF ITEMS IS IN STOCK**


#echo "not zero";
#echo $_SESSION['cart'][$_POST['product_id_update']];
#echo $_POST['quantity'];
$_SESSION['cart'][$_POST['product_id_update']] = $_POST['quantity'];
}

}


// PLACE ORDER ------------------------------------------------------------------------------------------------
if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
  	header('Location: index.php?page=placeorder');
        exit;
}


// GET PRODUCTS IN CART FROM DATABASE & CALCULATE SUBTOTAL --------------------------------------------------------------------------
// Check session variables for products in cart
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$productsArr = array();
$subtotal = 0.00;
 
// If there are products in the cart
if ($products_in_cart) {
	$question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
        $stmt = $pdo->prepare('SELECT * FROM PRODUCT_TABLE WHERE product_ID IN (' . $question_marks . ')');

        // Execute
	$stmt->execute(array_keys($products_in_cart));

	// Fetch and store in an array
	$productsArr = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$items = array();
	$item = array();

	// Calculate Subtotal
	foreach ($productsArr as $product) {
		$subtotal += (float)$product['price'] * (int)$products_in_cart[$product['product_ID']];
		$item = array("img" => htmlentities($product['image_Link']), "name" => htmlentities($product['product_Title']), "brand" => htmlentities($product['product_BrandName']), "price" => htmlentities($product['product_BasePrice']), 
    "quantity" => htmlentities($_SESSION['cart'][$product['product_ID']] ), "id" => htmlentities($product['product_ID']) );
    
		array_push($items, $item);
	}
}


?>


<?=template_header('Shopping Cart');?>

<script src="assets/js/cart.js"></script>


    <div class="ps-md-5 mt-5 row">

        <div class="col-md-8 col-11 mx-auto" id="colDiv">
        <h4 class="text-center mt-2" id="cartHeader">Shopping Cart</h4>
            <div class="mb-3 border row" style="border-top:none!important" id="cart">
            </div>
        </div>
        <div class="col-md-3 mx-md-4 col-11 mx-auto h-75 border" style="margin-top:2.8rem!important" id="summary-box">
        </div>
        <div class="text-center" id="emptyCartDiv">
        </div>
    </div>
   
<?php 
#if the cart is empty
if( count($_SESSION['cart']) <= 0) {
echo <<<EOT
 <script>
 const colDiv = document.getElementById("colDiv");
 const cart = document.getElementById("cart");
 const cartHeader = document.getElementById("cartHeader");
 const cartDiv = document.getElementById("emptyCartDiv");
 const summaryDiv = document.getElementById("summary-box");
 cartDiv.innerHTML += 'The cart is <span class="text-success">empty</span>. Add items to cart to start shopping!';
 cart.classList.remove("border")
 summaryDiv.classList.add("d-none")
 colDiv.classList.add("col-md-12", "col-12")
 
 </script>
EOT;
 }
?>

  <script>

        console.log(<?= json_encode($productsArr) ?>);
        console.log(<?= json_encode($items) ?>);
        console.log(<?= json_encode($_POST) ?>);
        const itemsJSON = JSON.parse( '<?php echo json_encode($items) ?>' );
        showCart(itemsJSON, "cart");
    </script>
    
<?=template_footer()?>
