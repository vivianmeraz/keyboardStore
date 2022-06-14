<?php
    require("handle-account.php");
    session_start();

    // if user tries to access this page via URL, they will be denied.
    if ($_SESSION['signedin'] == false)
    {
        echo '<script type="text/javascript">alert("Please log in first.")</script>';
        echo '<script>window.location.replace("index.php?page=home")</script>';
    }

    function displayAdminButton()
    {
        $adminLink = 'index.php?page=admin';
    
        // if user is logged in and has admin priviledges
        if ($_SESSION['signedin'] == true && $_SESSION['admin_flag'] == 1)
        {
            echo<<<EOT
            <h1 class="text-left">My Account <br> <button onclick="location.href = '$adminLink'" type="button" class="btn btn-info btn-lg">Admin Page</button></h1>
            EOT;
        }
        else 
        {
            echo<<<EOT
            <h1 class="text-left">My Account</h1>
            EOT;
        }
    }


    // create account object
    $accInfo = new Account($pdo);

    // create query to USER_TABLE
    $accQuery = $accInfo->getAccountDetails($_SESSION['user_ID']);

    // create query to TRANSACTION_TABLE
    $transactions = $accInfo->getTransactions($_SESSION['user_ID']);

    if(isset($_POST['accsave']) && !empty($_POST['fname_copy']) && !empty($_POST['lname_copy']) && !empty($_POST['email_copy']))
    {
        try {
            if ($accInfo->updateAccountInfo($_SESSION['user_ID'], $_POST['fname_copy'], $_POST['lname_copy'], $_POST['email_copy']))
            {
                // header("Refresh:5; url:index.php?page=my-account");
                // echo '<script> setTimeout(function(){
                //     window.location.reload();
                //  }, 2000); </script>';
                echo '<script> window.location.reload(); </script>';
            }   
            // else
            // {
            //     echo '<script type="text/javascript">alert("Error (1) saving account information. Please try again");</script>';
            // }
        } 
        catch (PDOException $e) {
            // $error = "Error : " . $e->getMessage();
            $error = "Error (2) saving account information. Please try again";
            echo '<script type="text/javascript">alert("'.$error.'");</script>';
        }
    }
    else if (isset($_POST['billingsave']) && !empty($_POST['billingaddress_copy']) && !empty($_POST['billingcity_copy']) && !empty($_POST['billingstate_copy']) && !empty($_POST['billingzipcode_copy']))
    {
        try {
            if ($accInfo->updateBillingAddress($_SESSION['user_ID'], $_POST['billingaddress_copy'], $_POST['billingcity_copy'], $_POST['billingstate_copy'], $_POST['billingzipcode_copy'])
            )
            {
                echo '<script> window.location.reload(); </script>';
            }
            // else
            // {
            //     echo '<script type="text/javascript">alert("Error (1) saving address information. Please try again");</script>';
            // }
        } 
        catch (PDOException $e) {
            // $error = "Error : " . $e->getMessage();
            $error = "Error (2) saving address information. Please try again";
            echo '<script type="text/javascript">alert("'.$error.'");</script>';
        }
    }

    else if(isset($_POST['shippingsave']) && !empty($_POST['shippingaddress_copy']) && !empty($_POST['shippingcity_copy']) && !empty($_POST['shippingstate_copy']) && !empty($_POST['shippingzipcode_copy']))
    {
        try {
            if ($accInfo->updateShippingAddress($_SESSION['user_ID'], $_POST['shippingaddress_copy'], $_POST['shippingcity_copy'], $_POST['shippingstate_copy'], $_POST['shippingzipcode_copy']))
            {
                echo '<script> window.location.reload(); </script>';
            }   
            // else
            // {
            //     echo '<script type="text/javascript">alert("Error (1) saving address information. Please try again");</script>';
            // }
        } 
        catch (PDOException $e) {
            // $error = "Error : " . $e->getMessage();
            $error = "Error (2) saving address information. Please try again";
            echo '<script type="text/javascript">alert("'.$error.'");</script>';
        }
    }

    else if(isset($_POST['paymentsave']) && !empty($_POST['cardno_copy']) && !empty($_POST['cardholdername_copy']) && !empty($_POST['cardmonth_copy']) && !empty($_POST['cardyear_copy']) && !empty($_POST['cardcvv_copy']))
    {
        try {
            if ($accInfo->updatePaymentInfo($_SESSION['user_ID'], $_POST['cardno_copy'], $_POST['cardholdername_copy'], $_POST['cardmonth_copy'], $_POST['cardyear_copy'], $_POST['cardcvv_copy']))
            {
                echo '<script> window.location.reload(); </script>';
            }   
            // else
            // {
            //     echo '<script type="text/javascript">alert("Error (1) saving payment information. Please try again");</script>';
            // }
        } 
        catch (PDOException $e) {
            // $error = "Error : " . $e->getMessage();
            $error = "Error (2) saving payment information. Please try again";
            echo '<script type="text/javascript">alert("'.$error.'");</script>';
        }
    }
?>

<?=template_header('My Account');?>
    
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/my-account.css">
    <script src="assets/js/my-account.js"></script>

    <div class="container" id="main-container">

  <!-- Content Goes Here -->
        <br>
        <?php displayAdminButton() ?>
        <div class="tab">
            <!-- hide everything until a tab is clicked -->
            <body onload="hideElementsInClass('tabcontent')"></body>

            <!-- create tabs -->
            <button class="tablinks" onclick="openMenu(event, 'Account Information', 'tabcontent'); cancelEdit()">Account Information</button>
            <button class="tablinks" onclick="openMenu(event, 'Addresses', 'tabcontent'); cancelEdit()">Addresses</button>
            <button class="tablinks" onclick="openMenu(event, 'Payment Information', 'tabcontent'); cancelEdit()">Payment Information</button>
            <button class="tablinks" onclick="openMenu(event, 'Transaction History', 'tabcontent'); cancelEdit()">Transaction History</button>
        </div>
        
        <!-- Account Information TAB -->
        <div id="Account Information" class="tabcontent container">
        <h4>Login and Security</h4>
        <form method="POST" class="form-control">
            <div name="account-info-form" id="account-info-form">
                <!-- first name -->
                <div class="mb-2">
                    <label class="form-label">First Name
                        <input disabled value="<?php echo htmlentities($accQuery["user_FirstName"]) ?>" type="text" class="form-control" id="fname" placeholder="Enter First Name" required="required">
                    </label>                
                </div>
                <!-- last name -->
                <div class="mb-2">
                    <label class="form-label">Last Name
                        <input disabled value="<?php echo htmlentities($accQuery["user_LastName"]) ?>" type="text" class="form-control" id="lname" placeholder="Enter Last Name" required="required">
                    </label>
                </div>
                <!-- email address -->
                <div class="mb-2">
                    <label class="form-label" for="email">Email
                        <input disabled value="<?php echo htmlentities($accQuery["user_Email"]) ?>" type="email" class="form-control" id="email" placeholder="Enter Email" pattern=".*@.*\..*" required="required">
                    </label>
                </div>
                <button type="button" id="acc-e" class="btn btn-primary mb-1 ms-1 mt-1" onclick="editAccountInfo()">Edit</button>
            </div>
                    <!--------------- Account Information COPY ----------------->
            <div name="account-info-form_copy" id="account-info-form_copy" hidden>
                <!-- first name -->
                <div class="mb-2">
                    <label class="form-label" id="accinfo" for="fname_copy">First Name
                        <input value="<?php echo htmlentities($accQuery["user_FirstName"]) ?>" type="text" class="form-control" id="fname_copy" name="fname_copy" placeholder="Enter First Name" required="required">
                    </label>                
                </div>
                <!-- last name -->
                <div class="mb-2">
                    <label class="form-label" for="lname">Last Name
                        <input value="<?php echo htmlentities($accQuery["user_LastName"]) ?>" type="text" class="form-control" id="lname_copy" name="lname_copy" placeholder="Enter Last Name" required="required">
                    </label>
                </div>
                <!-- email address -->
                <div class="mb-2">
                    <label class="form-label" for="email">Email
                        <input value="<?php echo htmlentities($accQuery["user_Email"]) ?>" type="email" class="form-control" id="email_copy" name="email_copy" placeholder="Enter Email" pattern=".*@.*\..*" required="required">
                    </label>
                </div>
                <div class="btn-group" id="accsavecancel">
                    <input type="submit" id="accsave" name="accsave" onclick="saveEdit()" value="Save" class="btn btn-primary m-1"></input>
                    <button type="button" id="acccancel" onclick="cancelEdit()" class="btn btn-secondary m-1">Cancel</button>
                </div>
            </div>
        </form>

        <p></p>
        <form class="form-control" id="form">
            <!-- password -->
            <div class="w-25 mb-3">
                <label for="password">Password</label>
                <div class="input-group-btn">
                    <button type="button" id="reset" name="reset" onclick="window.location.href = '/index.php?page=reset-password'" form="password" 
                    class="btn btn-outline-primary" style="border-color: black; text-decoration-color: black; color: black;">Reset Password
                    </button>
                </div>
            </div>
        </form>
        </div>
        
        <!-- Addresses TAB -->
        <div id="Addresses" class="tabcontent" overflow-auto>
        <h4>Billing Address</h4>
            <form method="POST" class="form-control">
                <div name="billing-address-form" id="billing-address-form">
                    <!-- Address -->
                    <div class="w-75 mb-3">
                        <label class="form-label" for="address">Address</label>
                        <input disabled value="<?php echo htmlentities($accQuery["user_BillingAddress"]) ?>" type="text" class="form-control" id="billingaddress" name="billingaddress" placeholder="Street address or P.O. Box" required="required">
                    </div>
                    <!-- City, State, Zip Code -->
                    <div class="row">
                        <!-- City -->
                        <div class="col-3 mb-3">
                            <div class="input-group">
                                <label class="form-label" for="billingcity">City
                                    <input disabled value="<?php echo htmlentities($accQuery["user_BillingCity"]) ?>" id="billingcity" name="billingcity" type="text" class="form-control" required="required">
                                </label>
                            </div> <!-- input-group -->
                        </div> <!-- col -->
                        <!-- State -->
                        <div class="col-3 mb-3">
                            <div class="input-group">
                                <label for="state"> State
                                    <input disabled value="<?php echo htmlentities($accQuery["user_BillingState"]) ?>" id="billingstate" name="billingstate" type="text" class="form-control" required="required">
                                </label>
                            </div> <!-- input-group -->
                        </div> <!-- col -->
                        <!-- Zip Code -->
                        <div class="col-3 mb-3">
                            <div class="input-group">
                                <label class="form-label" for="billingzipcode"> Zip Code 
                                    <input disabled value="<?php echo htmlentities($accQuery["user_BillingZipcode"]) ?>" id="billingzipcode" name="billingzipcode" type="text" pattern="[0-9]{5}" title="5 numeric characters only" class="form-control" required="required">
                                </label>
                            </div> <!-- input-group -->
                        </div> <!-- col -->
                    </div> <!-- row -->
                    <button type="button" id="billing-e" onclick="editBilling()" class="btn btn-primary mb-1 ms-1 mt-1">Edit</button>
                </div>
                <!----------------- Billing Address COPY -------------------------->
                <div name="billing-address-form_copy" id="billing-address-form_copy" hidden>
                    <!-- Address -->
                    <div class="w-75 mb-3">
                        <label class="form-label" for="address">Address</label>
                        <input value="<?php echo htmlentities($accQuery["user_BillingAddress"]) ?>" type="text" class="form-control" id="billingaddress_copy" name="billingaddress_copy" placeholder="Street address or P.O. Box" required="required">
                    </div>
                    <!-- City, State, Zip Code -->
                    <div class="row">
                        <!-- City -->
                        <div class="col-3 mb-3">
                            <div class="input-group">
                                <label class="form-label" for="billingcity_copy">City
                                    <input value="<?php echo htmlentities($accQuery["user_BillingCity"]) ?>" id="billingcity_copy" name="billingcity_copy" type="text" class="form-control" required="required">
                                </label>
                            </div> <!-- input-group -->
                        </div> <!-- col -->
                        <!-- State -->
                        <div class="col-3 mb-3">
                            <div class="input-group">
                                <label for="state"> State
                                    <input value="<?php echo htmlentities($accQuery["user_BillingState"]) ?>" id="billingstate_copy" name="billingstate_copy" type="text" class="form-control" required="required">
                                </label>
                            </div> <!-- input-group -->
                        </div> <!-- col -->
                        <!-- Zip Code -->
                        <div class="col-3 mb-3">
                            <div class="input-group">
                                <label class="form-label" for="billingzipcode_copy"> Zip Code 
                                    <input value="<?php echo htmlentities($accQuery["user_BillingZipcode"]) ?>" id="billingzipcode_copy" name="billingzipcode_copy" type="text" pattern="[0-9]{5}" title="5 numeric characters only" class="form-control" required="required">
                                </label>
                            </div> <!-- input-group -->
                        </div> <!-- col -->
                    </div> <!-- row -->
                    <div class="btn-group" id="billingsavecancel">
                        <input type="submit" id="billingsave" name="billingsave" onclick="saveEdit()" value="Save" class="btn btn-primary m-1"></input>
                        <button type="button" id="billingcancel" onclick="cancelEdit()" class="btn btn-secondary m-1">Cancel</button>
                    </div>
                </div>
            </form>
            
        <p></p>
        <h4>Shipping Address</h4>
        <form method="POST" class="form-control overflow-auto">
            <div name="shipping-address-form" id="shipping-address-form">
                <!-- Address -->
                <div class="w-75 mb-3">
                    <label class="form-label" for="shippingaddress">Address</label>
                    <input disabled value="<?php echo htmlentities($accQuery["user_ShippingAddress"]) ?>" type="text" class="form-control mb-3" id="shippingaddress" name="shippingaddress" placeholder="Street address or P.O. Box" required="required">
                </div>
                <!-- City, State, Zip Code -->
                <div class="row mb-3 citystatezipcode">
                    <!-- City -->
                    <div class="col-3">
                        <div class="input-group">
                            <label class="form-label" for="shippingcity">City
                                <input disabled value="<?php echo htmlentities($accQuery["user_ShippingCity"]) ?>" id="shippingcity" name="shippingcity" type="text" class="form-control" required="required">
                            </label>
                        </div> <!-- input-group -->
                    </div> <!-- col -->
                    <!-- State -->
                    <div class="col-3">
                        <div class="input-group">
                        <label class="form-label" for="state"> State
                                <input disabled value="<?php echo htmlentities($accQuery["user_ShippingState"]) ?>" id="shippingstate" name="shippingstate" class="form-control" required="required">
                        </label>
                        </div> <!-- input-group -->
                    </div> <!-- col -->
                    <!-- Zip Code -->
                    <div class="col-3">
                        <div class="input-group">
                            <label class="form-label" for="shippingzipcode">Zip Code
                                <input disabled value="<?php echo htmlentities($accQuery["user_ShippingZipcode"]) ?>" id="shippingzipcode" name="shippingzipcode" type="text" pattern="[0-9]{5}" title="5 numeric characters only" class="form-control" required="required">
                            </label>
                        </div> <!-- input-group -->
                    </div> <!-- col -->
                </div> <!-- row -->
                <!-- EDIT BUTTON -->
                <button type="button" id="shipping-e" onclick="editShipping()" class="btn btn-primary mb-1 ms-1 mt-1">Edit</button>
            </div>
                <!------------- Shipping Address COPY ------------->
            <div name="shipping-address-form_copy" id="shipping-address-form_copy" hidden>
                <!-- Address -->
                <div class="w-75 mb-3">
                    <label class="form-label" for="shippingaddress_copy">Address</label>
                    <input value="<?php echo htmlentities($accQuery["user_ShippingAddress"]) ?>" type="text" class="form-control mb-3" id="shippingaddress_copy" name="shippingaddress_copy" placeholder="Street address or P.O. Box" required="required">
                </div>
                <!-- City, State, Zip Code -->
                <div class="row mb-3 citystatezipcode">
                    <!-- City -->
                    <div class="col-3">
                        <div class="input-group">
                            <label class="form-label" for="shippingcity_copy">City
                                <input value="<?php echo htmlentities($accQuery["user_ShippingCity"]) ?>" id="shippingcity_copy" name="shippingcity_copy" type="text" class="form-control" required="required">
                            </label>
                        </div> <!-- input-group -->
                    </div> <!-- col -->
                    <!-- State -->
                    <div class="col-3">
                        <div class="input-group">
                        <label class="form-label" for="shippingstate"> State
                                <input value="<?php echo htmlentities($accQuery["user_ShippingState"]) ?>" id="shippingstate_copy" name="shippingstate_copy" class="form-control" required="required">
                        </label>
                        </div> <!-- input-group -->
                    </div> <!-- col -->
                    <!-- Zip Code -->
                    <div class="col-3">
                        <div class="input-group">
                            <label class="form-label" for="shippingzipcode_copy">Zip Code
                                <input value="<?php echo htmlentities($accQuery["user_ShippingZipcode"]) ?>" id="shippingzipcode_copy" name="shippingzipcode_copy" type="text" pattern="[0-9]{5}" title="5 numeric characters only" class="form-control" required="required">
                            </label>
                        </div> <!-- input-group -->
                    </div> <!-- col -->
                </div> <!-- row -->
                <div class="btn-group" id="shippingsavecancel">
                <input type="submit" id="shippingsave" name="shippingsave" onclick="saveEdit()" value="Save" class="btn btn-primary m-1"></input>
                    <button type="button" id="shippingcancel" onclick="cancelEdit()" class="btn btn-secondary m-1">Cancel</button>
                </div>
            </div>
        </form>
    </div>
        
        <!-- Payment Information TAB -->
        <div id="Payment Information" class="tabcontent">
        <h4>Credit/Debit</h4>
        <p></p>
            <form method="POST" class="form-control">
                <div name="payment-form" id="payment-form">
                    <div class="mb-3">
                        <label for="cardholder-name">Cardholder Name
                            <input disabled value="<?php echo htmlentities($accQuery["user_PaymentCardholderName"]) ?>" id="cardholdername" name="cardholdername" type="text" class="form-control" required="required">
                        </label>
                    </div>
                    <div class="col-sm-6 mb-3">
                            <label>Card Number
                                <input disabled value="<?php $accInfo->redactPaymentCardNo($accQuery['user_PaymentCardNo']) ?>" id="cardno" name="cardno" type="text" class="form-control" required="required">
                            </label>
                    </div>
                    <div class="row mb-3">
                        <div class="col-2">
                            <label hidden id="cardmonthlabel">Month
                                <input disabled value="<?php echo htmlentities($accQuery["user_PaymentCardExpMM"]) ?>" id="cardmonth" name="cardmonth" type="text" class="form-control" placeholder="MM" required="required">
                            </label>
                        </div>
                        <div class="col-2">
                            <label hidden id="cardyearlabel">Year
                                <input disabled value="<?php echo htmlentities($accQuery["user_PaymentCardExpYY"]) ?>" id="cardyear" name="cardyear" type="text" class="form-control" placeholder="YY" required="required">
                            </label>
                        </div>
                        <div class="col-2">
                            <label hidden id="cardcvvlabel">CVV
                                <input disabled value="" id="cardcvv" type="text" name="cardcvv" class="form-control" placeholder="YY" required="required">
                            </label>
                        </div>
                    </div>
                    <button type="button" id="payment-e" class="btn btn-primary mb-1 ms-1 mt-1" onclick="editPayment()">Edit</button>
                </div>
                <!--------------- Payment Information COPY -------------->
                <div name="payment-form_copy" id="payment-form_copy" hidden>
                    <div class="mb-3">
                        <label for="cardholder-name">Cardholder Name
                            <input value="<?php echo htmlentities($accQuery["user_PaymentCardholderName"]) ?>" id="cardholdername_copy" name="cardholdername_copy" type="text" class="form-control" required="required">
                        </label>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label>Card Number
                            <input value="<?php $accInfo->redactPaymentCardNo($accQuery['user_PaymentCardNo']) ?>" id="cardno_copy" name="cardno_copy" type="text" class="form-control" required="required">
                        </label>
                    </div>
                    <div class="row mb-3">
                        <div class="col-2">
                            <label id="cardmonthlabel_copy">Month
                                <input id="cardmonth_copy" name="cardmonth_copy" type="text" class="form-control" placeholder="MM" required="required">
                            </label>
                        </div>
                        <div class="col-2">
                            <label id="cardyearlabel_copy">Year
                                <input id="cardyear_copy" name="cardyear_copy" type="text" class="form-control" placeholder="YY" required="required">
                            </label>
                        </div>
                        <div class="col-2">
                            <label id="cardcvvlabel_copy">CVV
                                <input id="cardcvv_copy" type="text" name="cardcvv_copy" class="form-control" placeholder="YY" required="required">
                            </label>
                        </div>
                    </div>
                    <div class="btn-group" id="paymentsavecancel">
                    <input type="submit" id="paymentsave" name="paymentsave" onclick="saveEdit()" value="Save" class="btn btn-primary m-1"></input>
                        <button type="button" id="paymentcancel" onclick="cancelEdit()" class="btn btn-secondary m-1">Cancel</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Transaction History TAB -->
        <div id="Transaction History" class="tabcontent">
        <h4>Transaction History</h4>
            <div class="container px-4 mb-3 gap-3">
                <div class="d-grid gap-3 border border-dark border-2 bg-light p-3">
                    <?php foreach ($transactions as $transaction): ?>
                    <div class="">
                        <div class="p-3 border border-info bg-info">
                            <span class="fw-bold fs-3">Order #: <?=$transaction['order_ID']?></span>
                            <br>
                            <span class="fs-6"><?=$transaction['order_Date']?> | $<?=$transaction['order_Total']?> | <?=$transaction['order_status']?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>      <!-- main container -->
    
<?=template_footer()?>