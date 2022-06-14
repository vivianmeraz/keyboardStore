<?php
    /** Tyler was here :D */ 
    include("handle-account.php");

    // making the checkout page account locked
    if ($_SESSION['signedin'] == false)
    {
        echo '<script type="text/javascript">alert("You must be logged in to place an order.")</script>';

        // redirect to sign in page
        echo '<script>window.location.replace("index.php?page=sign-in")</script>';
    }

    // create Account object to access functions from handle-account.php
    $accInfo = new Account($pdo);

    // create query to USER_TABLE
    $accQuery = $accInfo->getAccountDetails($_SESSION['user_ID']);
    $cardNo = $accQuery['user_PaymentCardNo'];
    $cardCVV = $accQuery['user_PaymentCardCVV'];

    /********** coupon query (see if coupon exists) *************** -------------------------------------------------------------------------- */
    $couponSql = 'SELECT * FROM COUPON_TABLE WHERE ? = coupon_ID';
    $couponQuery = $pdo->prepare( $couponSql );
    $couponQuery->bindValue(1, $_POST['couponCode'], PDO::PARAM_STR);
    $couponQuery->execute();
    #fetch one coupon only (one coupon per transaction only)
    $result = $couponQuery->fetch( PDO::FETCH_ASSOC );
    
    #echo $_POST['couponCode'];
    #echo $result['coupon_ID'];
    
    #array of coupon details
    $coupon = array(
    "amount" => htmlentities($result['discount_Amount']),
    "couponId" => htmlentities($result['coupon_ID']),
    "couponTarget" => htmlentities($result['coupon_Target']),
    "couponExpiry" => htmlentities($result['coupon_Expiry']),
    "couponDesc" => htmlentities($result['coupon_Description'])
    );
    #If coupon is expired, change the couponId to "" so no coupon will be matched
    $todaysDate = date("Y-m-d");
    if( strcmp($todaysDate, $coupon['couponExpiry']) > 0) {
      #expired
      $coupon['couponId'] = "";
    }
    
    #if result exists, display coupon success message. otherwise, error message.
    $couponExists = 0;
    if( !strcmp("", $result['coupon_ID']) == 0) {
      #coupon code exists
      $couponExists = 1;
      #set bool to true to use in JS to display a message
    }
    
    #echo $_POST['couponCode'];
    $isCouponCode = isset($_POST['couponCode']);
    #$isCouponCode = strcmp($_POST['couponCode'], "");
    #echo $isCouponCode;
    
    #PUT COUPON IN SESSION IF coupon exists and is valid
    if($couponExists == 1 && $isCouponCode == 1){
    $_SESSION['couponCode'] = $coupon['couponId'];
    }

 
    /**  GET PRODUCTS IN CART FROM DATABASE & CALCULATE SUBTOTAL --------------------------------------------------------------------------*/
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
            $item = array("img" => htmlentities($product['image_Link']), "price" => htmlentities($product['product_BasePrice']), 
        "couponPrice " => htmlentities($product['$product_BasePrice']), "quantity" => htmlentities( $_SESSION['cart'][$product['product_ID']] ), 
        "id" => htmlentities($product['product_ID']), "category" => htmlentities($product['product_Type']),
        "isTarget" => htmlentities("0") 
            );
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
            $item['couponPrice'] = htmlentities($product['product_BasePrice'] * $coupon['amount']);
        }
        #push items to item array to send to JS to load boxes
            array_push($items, $item);
        }
    }
?>

<?=template_header('Checkout & Review Order');?>

    <script src="assets/js/checkout.js"></script>
    <!-- MAIN CONTAINER -->
    <div class="container mt-5">
    <h4 class="text-center">Checkout & Review Order</h4>
   
    <form type="submit" action="index.php?page=placeorder" method="post" id="placeOrderForm">
        <div class="row"> <!-- Two columns: LEFT - Form, RIGHT - PLACE ORDER -->
            <div class="col-md-8">
                <h5 class="fw-bold show border-bottom">Shipping</h5>
                <div class="mb-3" id="add-shipping-div">
                    <div class="row m-2">
                        <div class="form-floating col-6">
                            <input value="<?php echo htmlentities($accQuery["user_FirstName"]) ?>" type="text" class="form-control" id="firstNameShipping" placeholder="FirstName" name="firstNameShipping">
                            <label for="FirstName">First Name</label>
                        </div>
                        <div class="form-floating col-6">
                            <input value="<?php echo htmlentities($accQuery["user_LastName"]) ?>" type="text" class="form-control" id="lastNameShipping" placeholder="LastName" name="lastNameShipping">
                            <label for="LastName">Last Name</label>
                        </div>
                    </div>
                    <div class="row m-2">
                        <div class="form-floating col-12">
                            <input value="<?php echo htmlentities($accQuery["user_ShippingAddress"]) ?>" type="text" class="form-control" id="addressShipping" placeholder="StreetAddress" name="addressShipping">
                            <label for="StreetAddress">Street Address</label>
                        </div>
                    </div>
                    <div class="row m-2">
                        <div class="form-floating col-5">
                            <input value="<?php echo htmlentities($accQuery["user_ShippingCity"]) ?>" type="text" class="form-control" id="cityShipping" placeholder="City" name="cityShipping">
                            <label for="City">City</label>
                        </div>
                        <div class="form-floating col-4">
                            <input value="<?php echo htmlentities($accQuery["user_ShippingState"]) ?>" type="text" class="form-control" id="stateShipping" placeholder="State" name="stateShipping">
                            <label for="State">State</label>
                        </div>
                        <div class="form-floating col-3">
                            <input value="<?php echo htmlentities($accQuery["user_ShippingZipcode"]) ?>" type="text" class="form-control" id="zipCodeShipping" placeholder="ZipCode" name="zipCodeShipping">
                            <label for="ZipCode">Zip Code</label>
                        </div>
                    </div>
                    <div class="form-check ms-4">
                        <input data-bs-toggle="collapse" data-bs-target="#billing-div" class="form-check-input" type="checkbox" id="savedBillingCheck" name="savedBillingCheck" value="something" checked> 
                        <label class="form-check-label">Use Saved Billing Address</label><br>
                    </div>
                    <div class="collapse" id="billing-div">
                        <div class="row m-2">
                            <h5 class="fw-bold border-bottom">Billing</h5>
                            <div class="form-floating col-6">
                                <input value="<?php echo htmlentities($accQuery["user_FirstName"]) ?>" type="text" class="form-control" id="firstNameBilling" placeholder="FirstName" name="firstNameBilling">
                                <label for="FirstName">First Name</label>
                            </div>
                            <div class="form-floating col-6">
                                <input value="<?php echo htmlentities($accQuery["user_LastName"]) ?>" type="text" class="form-control" id="lastNameBilling" placeholder="LastName" name="lastNameBilling">
                                <label for="LastName">Last Name</label>
                            </div>
                        </div>
                        <div class="row m-2">
                            <div class="form-floating col-12">
                                <input value="<?php echo htmlentities($accQuery["user_BillingAddress"]) ?>" type="text" class="form-control" id="addressBilling" placeholder="StreetAddress" name="addressBilling">
                                <label for="StreetAddress">Street Address</label>
                            </div>
                        </div>
                        <div class="row m-2">
                            <div class="form-floating col-5">
                                <input value="<?php echo htmlentities($accQuery["user_BillingCity"]) ?>" type="text" class="form-control" id="cityBilling" placeholder="City" name="cityBilling">
                                <label for="City">City</label>
                            </div>
                            <div class="form-floating col-4">
                                <input value="<?php echo htmlentities($accQuery["user_BillingState"]) ?>" type="text" class="form-control" id="stateBilling" placeholder="State" name="stateBilling">
                                <label for="State">State</label>
                            </div>
                            <div class="form-floating col-3">
                                <input value="<?php echo htmlentities($accQuery["user_BillingZipcode"]) ?>" type="text" class="form-control" id="zipCodeBilling" placeholder="ZipCode" name="zipCodeBilling">
                                <label for="ZipCode">Zip Code</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="shipping-div" class="row mb-2 show collapse-shipping">
                    <div class="col-sm-10 mb-2">
                        <div id="shipping-div" class="row align-items-start ms-2">
                            <div class="shipping-method-selection-div">
                                <div class="row border my-3 py-2 g-0 px-1">
                                    <div class="col-1">
                                        <input class="form-check-input" type="radio" name="shippingRadio" id="ship5" value="5" checked onchange="calcTotal(itemsJSON)">
                                    </div>
                                    <div class="col-9">
                                        <b>Arrives in 5 - 7 days</b>
                                    </div>
                                    <div class="col-2">
                                        $5.00
                                    </div>
                                </div>
                                <div class="row border py-2 g-0 px-1">
                                    <div class="col-1">
                                        <input class="form-check-input" type="radio" name="shippingRadio" id="ship20" value="20" onchange="calcTotal(itemsJSON)">
                                    </div>
                                    <div class="col-9">
                                        <b>Arrives in 2 - 3 days</b>
                                    </div>
                                    <div class="col-2">
                                        $20.00
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

              


                <!-- payment method -->
                <h5 class="fw-bold show border-bottom ms-4">Payment</h5>
                    <div class="form-check mb-3 ms-4">
                        <input data-bs-toggle="collapse" data-bs-target="#add-payment-div" class="form-check-input" type="checkbox" id="savedPaymentCheck" name="savedPaymentCheck" value="something" checked onclick="hidePaymentInfo(<?php echo htmlentities($cardNo) ?>, <?php echo htmlentities($cardCVV) ?>)">
                        <label class="form-check-label">Use Saved Payment Method</label><br>
                    </div>
                    <script>
                        function hidePaymentInfo(cardNo, cardCVV)
                        {
                            const useSavedPayment = document.getElementById("savedPaymentCheck");
                            const cardNumber = document.getElementById("cardNumber");
                            const CVV = document.getElementById("securityCode");

                            if (useSavedPayment.checked == false)
                            {
                                cardNumber.removeAttribute("value");
                                CVV.removeAttribute("value");
                            }
                            else if (useSavedPayment.checked == true)
                            {
                                cardNumber.setAttribute("value", cardNo);
                                CVV.setAttribute("value", cardCVV);
                            }
                        }
                    </script>
                
                <div class="mb-3 collapse" id="add-payment-div">
                    <div class="row m-2">
                        <div class="form-floating col-md-6">
                            <input value="<?php echo htmlentities($accQuery["user_PaymentCardholderName"]) ?>" type="text" class="form-control" id="namePayment" placeholder="Name" name="namePayment" required="required">
                            <label for="Name">Name As It Appears On Card</label>
                        </div>
                        <div class="form-floating col-md-6">
                            <input value="<?php echo htmlentities($accQuery['user_PaymentCardNo']) ?>" type="text" class="form-control" id="cardNumber" placeholder="CardNumber" name="cardNumber" required="required" pattern="[0-9]{13,16}" title="Must be 13-16 numeric characters">
                            <label for="CardNumber">Card Number</label>
                        </div>
                    </div>
                    <div class="row m-2">
                        <div class="form-floating col-md-2">
                            <input value="<?php echo htmlentities($accQuery["user_PaymentCardExpMM"]) ?>" type="text" class="form-control" id="expirationDateMM" placeholder="ExpirationDate" name="expirationDateMM" required="required">
                            <label for="ExpirationDateMM">Exp. Month</label>
                        </div>
                        <div class="form-floating col-md-2">
                            <input value="<?php echo htmlentities($accQuery["user_PaymentCardExpYY"]) ?>" type="text" class="form-control" id="expirationDateYY" placeholder="ExpirationDateYY" name="expirationDateYY" required="required">
                            <label for="ExpirationDateYY">Exp. Year</label>
                        </div>
                        <div class="form-floating col-md-2">
                            <input type="password" class="form-control" id="securityCode" placeholder="SecurityCode" name="securityCode" required="required" value="<?php echo htmlentities($accQuery["user_PaymentCardCVV"]) ?>">
                            <label for="CVV">CVV</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN - PLACE ORDER -->
            <div class="col-md-4 mt-4 mb-5">
                <div class=" border border-2">
                    <div class="m-3">
                        <p id = "subtotal">
                            Subtotal
                        </p>
                        <p id="shipping">
                            Shipping & Handling
                        </p>
                        <hr>
                        <p class="" id="tax">
                            Tax
                        </p>
                        <h4 id="total">Total: $123.45</h4>
                        <div class="mx-auto w-75">
                        
                            <input type="submit" class="btn btn-danger w-100 my-1 mb-3" id="placeOrderButton" onclick="" value="Place Order" name="placeOrderButton">
                            <!-- **Call setForm() to fill in the below fields, and send them to placeorder.php** -->
                            <!-- <input type="hidden" id="firstName-shipping" name="firstNameShipping" value="value">
                            <input type="hidden" id="lastName-shipping" name="lastNameShipping" value="value">
                            <input type="hidden" id="address-shipping" name="addressShipping" value="value">
                            <input type="hidden" id="zipCode-shipping" name="zipCodeShipping" value="value">
                            <input type="hidden" id="city-shipping" name="cityShipping" value="value">
                            <input type="hidden" id="state-shipping" name="stateShipping" value="value">
                            <input type="hidden" id="firstName-billing" name="firstNameBilling" value="value">
                            <input type="hidden" id="lastName-billing" name="lastNameBilling" value="value">
                            <input type="hidden" id="address-billing" name="addressBilling" value="value">
                            <input type="hidden" id="zipCode-billing" name="zipCodeBilling" value="value">
                            <input type="hidden" id="city-billing" name="cityBilling" value="value">
                            <input type="hidden" id="state-billing" name="stateBilling" value="value">
                            <input type="hidden" id="name-payment" name="namePayment" value="value">
                            <input type="hidden" id="cardNumber-payment" name="cardNumberPayment" value="">
                            <input type="hidden" id="expirationDateMM-payment" name="expirationDatePaymentMM" value="">
                            <input type="hidden" id="expirationDateYY-payment" name="expirationDatePaymentYY" value="">
                            <input type="hidden" id="securityCode-payment" name="securityCodePayment" value="">
                            <input type="hidden" id="shippingSelect" name="shippingSelect" value="value">
                            <input type="hidden" id="couponEntered" name="couponEntered" value="value"> -->

                        
                        </div>
                        <div id="couponIdDiv">
                        </div>
                        <div style="max-height:550px"; class="row overflow-auto" id="cart">
                        <!-- populate the cart -->
                        <script>
                        const itemsJSON = JSON.parse( '<?php echo json_encode($items) ?>' );
                        const couponsJSON = JSON.parse( '<?php echo json_encode($coupon) ?>' );
                        showCart(itemsJSON, couponsJSON, '<?php echo $couponExists; ?>', "cart");
                        </script>
                        </form>
                        
                        </div>
                        
                    </div>
                    
                </div>
                 
                 
            </div>
                <!-- coupon code box -->
   <!-- <div class="border border-2"> -->
        <form action="index.php?page=checkout" method="post">
            <div class="input-group mb-3 w-50 ms-4">
            <input type="text" class="form-control" placeholder="Enter coupon code" aria-label="Recipient's                       username" aria-describedby="button-addon2" name="couponCode" id="couponCode">
            <button class="btn btn-outline-secondary" type="submit" id="submitCouponButton">Submit</button>
            </div>
        </form>
        <!-- coupon notification div -->
        <div id="couponNotification" class="ms-4">
        </div>
          <script>
                //JS for notification message
                //see if coupon code is set (coupon button submitted)
                alert('<?php echo $couponExists; ?>', '<?php echo $_POST['couponCode']; ?>', '<?php echo $isCouponCode; ?>', '<?php echo $coupon['couponDesc']; ?>', '<?php echo $coupon['couponId'] ?>', "couponNotification")
                </script>
   <!-- </div> -->
           
        </div> <!-- TWO MAIN COLUMNS -->

    
    </div>  <!--- MAIN CONTAINER -->
    
   <?=template_footer()?>
