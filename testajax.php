<?php
    require("assets/config/dbconnection.php");
    session_start();
    $conn = pdo_connect_mysql();

    echo $_POST['total'];

    /************** AJAX TEST *************** */
    $data = array();
    $insertTotal;
    if (isset($_POST['total']))
    {
        // populate $data variable
        $data = $_POST['total'];

        // store $data in php variable (to be used to INSERT query)
        $insertTotal = json_encode($data, JSON_NUMERIC_CHECK);
        echo $insertTotal;
        die();
    }
    else   
        echo "No post :(";
    /************** AJAX TEST *************** */

    //get row count
    $sqlrowcount = "SELECT `order_ID` FROM `ORDER_TABLE`";
    $query = $conn->prepare($sqlrowcount);
    $query->execute();
    $rows = $query->rowCount();
    $rows++;

    //set variables for testing order insert
    $orderID = 0;
    $userID = 1167;
    $sessionID = session_id();
    $orderStatus = "processing";
    $orderSubtotal = 109.92;
    $orderDiscount = 0;
    $orderTax = 0.0825;
    $orderShippingPrice = 5;
    $orderTotal = $insertTotal;
    $orderDate = date("Y-m-d");
    // $orderDate->format('Y-m-d');

    $sql = "INSERT INTO `ORDER_TABLE` (`order_ID`, `user_ID`, `session_ID`, `order_status`, `order_SubTotal`, `order_Discount`, `order_Tax`, `order_ShippingPrice`, `order_Total`, `order_Date`) VALUES ('0', '$userID', '', '$orderStatus', '$orderSubtotal', '$orderDiscount', '$orderTax', '$orderShippingPrice', '$orderTotal', '$orderDate')";

    try {
        if ($conn->exec($sql))
        {
            echo "Order placed successfully";
        }
        else
            echo "Unable to place order";
    } 
    catch (PDOException $e){
        $error = "Error : " . $e->getMessage();
        // $error = "Error creating account. Please try again.";
        echo '<script type="text/javascript">alert("'.$error.'");</script>';
    }

?>
<html>
    <head>
        <script  src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    </head>
<body>
<div id="testDataRetrieval"></div>

<script type="text/javascript">
    $(document).ready (function()
    {
        var total = 156.21;

        $.ajax
        ({
            method: "POST",
            dataType: "json",
            data: {total: total},
            
            // print result to testDataRetrievel div element
            success: function(result) {
                $("#testDataRetrieval").html(result);
            }
        })
    });
</script>
</body>
</html>
