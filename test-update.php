<?php
    require("assets/config/dbconnection.php");

    //set variables for updating
    // NOTE #1: the variables CANNOT be NULL or blank string (assigning "") or else db will not accept
    // NOTE #2: INT columns CANNOT be left blank, but VARCHAR columns can. Refer to PhpMyAdmin to check the types of columns

    $userID = "1174";

    $firstName = "John";
    $lastName = "Doe";
    $email = "johndoe8@mail.com";
    $password = "#DoeJohn1";

    $billingAddress = "123 Eagle Ave";
    $billingCity = "San Antonio";
    $billingState = "Texas";
    $billingZipcode = "12345";

    $shippingAddress = "456 Hawk Dr.";
    $shippingCity = "Los Angeles";
    $shippingState = "California";
    $shippingZipcode = "22222";

    $comments = "deeznuts";
    
    $paymentCardNo = "1234567890123456";
    $paymentCardholderName = "John Doe";
    $paymentCardExpMM = "08";
    $paymentCardExpYY = "27";
    $paymentCardCVV = "222";


    // create connection
    $conn = pdo_connect_mysql();

    /**
     * Uncomment the template to be used
     */

    // UPDATE statement template (with every column)
    $sql = "UPDATE `USER_TABLE` SET `user_ID` = '$userID', `user_FirstName` = '$firstName', `user_LastName` = '$lastName', `user_Email` = '$email', `user_Password` = '$password', `user_BillingAddress` = '$billingAddress', `user_BillingCity` = '$billingCity', `user_BillingState` = '$billingState', `user_BillingZipcode` = '$billingZipcode', `user_ShippingAddress` = '$shippingAddress', `user_ShippingCity` = '$shippingCity', `user_ShippingState` = '$shippingState', `user_ShippingZipcode` = '$shippingZipcode', `user_Comments` = '$comments', `user_PaymentCardNo` = '$paymentCardNo', `user_PaymentCardExpMM` = '$paymentCardExpMM', `user_PaymentCardExpYY` = '$paymentCardExpYY', `user_PaymentCardCVV` = '$paymentCardCVV' WHERE `user_ID` = '$userID'";
    
    // UPDATE statement template (Both Billing and Shipping Address)
    // $sql = "UPDATE `USER_TABLE` SET `user_BillingAddress` = '$billingAddress', `user_BillingCity` = '$billingCity', `user_BillingState` = '$billingState', `user_BillingZipcode` = '$billingZipcode', `user_ShippingAddress` = '$shippingAddress', `user_ShippingCity` = '$shippingCity', `user_ShippingState` = '$shippingState', `user_ShippingZipcode` = '$shippingZipcode' WHERE `user_ID` = '$userID'";

    // UPDATE statement template (ONLY Billing Address)
    // $sql = "UPDATE `USER_TABLE` SET `user_BillingAddress` = '$billingAddress', `user_BillingCity` = '$billingCity', `user_BillingState` = '$billingState', `user_BillingZipcode` = '$billingZipcode' WHERE `USER_TABLE`.`user_ID` = '$userID'";

    // UPDATE statement template (ONLY Shipping Address)
    // $sql = "UPDATE `USER_TABLE` SET `user_ShippingAddress` = '$shippingAddress', `user_ShippingCity` = '$shippingCity', `user_ShippingState` = '$shippingState', `user_ShippingZipcode` = '$shippingZipcode' WHERE `user_ID` = '$userID'";
    
    // UPDATE statement template (SAME Billing Address and Shipping Address)
    // $sql = "UPDATE `USER_TABLE` SET `user_BillingAddress` = '$billingAddress', `user_BillingCity` = '$billingCity', `user_BillingState` = '$billingState', `user_BillingZipcode` = '$billingZipcode', `user_ShippingAddress` = '$billingAddress', `user_ShippingCity` = '$billingCity', `user_ShippingState` = '$billingState', `user_ShippingZipcode` = '$billingZipcode' WHERE `user_ID` = '$userID'";

    // UPDATE statement template (Payment Information)
    // $sql = "UPDATE `USER_TABLE` SET `user_PaymentCardNo` = '$paymentCardNo', `user_PaymentCardholderName` = '$paymentCardholderName', `user_PaymentCardExpMM` = '$paymentCardExpMM', `user_PaymentCardExpYY` = '$paymentCardExpYY', `user_PaymentCardCVV` = '$paymentCardCVV' WHERE `user_ID` = '$userID'";

    // prepare database object
    $conn->prepare($sql);

    // execute insert query
    if ($conn->exec($sql))
    {
        echo "Updated successfully";
    }
    else
        echo "Unable to update";
?>