<?php
#COUPON?
if(isset($_SESSION['couponCode']) ) {
$couponSql = 'SELECT * FROM COUPON_TABLE WHERE ? = coupon_ID';
$couponQuery = $pdo->prepare( $couponSql );
$couponQuery->bindValue(1, $_SESSION['couponCode'], PDO::PARAM_STR);
$couponQuery->execute();
$result = $couponQuery->fetch( PDO::FETCH_ASSOC );

$coupon = array(
"amount" => htmlentities($result['discount_Amount']),
"couponId" => htmlentities($result['coupon_ID']),
"couponTarget" => htmlentities($result['coupon_Target']),
"couponExpiry" => htmlentities($result['coupon_Expiry']),
"couponDesc" => htmlentities($result['coupon_Description'])
);

}
template_header('Place Order');
#GET PRODUCT DATA FOR PRODUCTS IN CART
$items = array();
$item = array();
foreach (array_keys($_SESSION['cart']) as $product) {
$sql = 'SELECT * FROM PRODUCT_TABLE WHERE product_ID = ?';
$query = $pdo->prepare($sql);
$query->bindValue(1, $product, PDO::PARAM_STR);
$query -> execute();
$result = $query->fetch(PDO::FETCH_ASSOC);

$item = array("img" => htmlentities($result['image_Link']), "name" => htmlentities($result['product_Title']), "brand" => htmlentities($result['product_BrandName']), 
"price" => htmlentities($result['product_BasePrice']), "couponPrice" => htmlentities($result['product_BasePrice']), "id" => htmlentities($result['product_ID']),
"quantity" => htmlentities($_SESSION['cart'][$product]), "isTarget" => htmlentities("0"),"category" => htmlentities($result['product_Type']),
);
#COUPON?
if(isset($_SESSION['couponCode']) ) {
#adjust for coupon if criteria is met
#bool to see if the item matches any target for the coupon
$isTarget = 0;
#create array of all coupon targets
$couponTargetsArray = explode(" ", $coupon['couponTarget']);

#loop to check if the item matches any target
$isTarget = 0; #set initially each loop
foreach ($couponTargetsArray as $target) {
  if( strcmp($item['category'], $target ) == 0) {
    #set bool to true
    $isTarget = 1;
    #send target bool to JS so we can update the text of couponed items
$item['isTarget'] = "1";
break;
    }
  }
#adjust the price to the coupon price if necessary
if($isTarget == 1) {
$item['couponPrice'] = htmlentities($result['product_BasePrice'] * $coupon['amount']);
  }
}

array_push($items, $item);
}


?>
<script src="assets/js/placeorder.js"></script>
<!-- ORDER SUMMARY -->
	<div class="placeorder content-wrapper mx-auto mt-5 mb-5 row">
   <div class="col-10 offset-1">
	        <h1> Your order has been placed!</h1>
	        <p> Thank you for ordering with MiceAndKeyboards.com! We will email you when your order ships! (Usually within 24 hours) </p>
          <h1>Order summary</h1>
          <div class="border rounded-3 mb-5 border-3 bg-info">
          <div id="cartDiv" class="row g-0">
          </div>
          <!-- Display the Cart Info -->
          <div id="totalContainer">
          <span id="couponDiv"></span>
          <span id="taxDiv"></span>
          <span> $<?php echo $_POST['shippingRadio'];?> shipping</span>
          <span id="totalDiv"></span>
          </div>
          <script>
          const itemsJSON = JSON.parse( '<?php echo json_encode($items) ?>');
          const couponsJSON = JSON.parse( '<?php echo json_encode($coupon) ?>');
          showItems(itemsJSON, couponsJSON, '<?php echo $_POST['shippingRadio']; ?>', "cartDiv")
          </script>
          <!-- SHIPPING -->
          <u><h3>Shipping Information</h3></u>
          <p><b><?php echo $_POST['firstNameShipping'];?> <?php echo $_POST['lastNameShipping'];?></b><br>
          <?php echo $_POST['addressShipping'];?><br><?php echo $_POST['cityShipping'];?>, <?php echo $_POST['stateShipping'];?> <?php echo $_POST['zipCodeBilling'];?> </p>
          <!-- BILLING -->
          <u><h3>Billing Information</h3></u>
          <p><b><?php echo $_POST['firstNameBilling'];?> <?php echo $_POST['lastNameBilling'];?></b><br>
          <?php echo $_POST['addressBilling'];?><br><?php echo $_POST['cityBilling'];?>, <?php echo $_POST['stateBilling'];?> <?php echo $_POST['zipCodeBilling'];?> </p>
          </div>
   </div>
	</div>
 
 <!-- DELETE CART AND STORE INFORMATION IN DATABASE -->
 <script>

        console.log(<?= json_encode($_POST) ?>);
 </script>

<?php
#STORE INFO TO ORDER_TABLE IN DATABASE
#*TODO*


#UNSET COUPON CODE, CART 
if( isset($_SESSION['couponCode']) ) {
unset($_SESSION['couponCode']);
}

if( isset($_SESSION['cart']) ) {
unset($_SESSION['cart']);
}
template_footer();

 ?>