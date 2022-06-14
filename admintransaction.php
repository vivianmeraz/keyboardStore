<?php

if ($_SESSION['admin_flag'] != '1' && $_SESSION['signedin'] != 'true'){
    header("Location: index.php");
    exit();
}

$sortby = isset($_GET['sortby']) ? $_GET['sortby'] : 'orderdate';

$catstr = '';
if ($sortby == 'customer'){
    $catstr = 'Customer ID';
    $stmt = $pdo->prepare('SELECT * FROM ORDER_TABLE ORDER BY user_ID ASC');
    $stmt->execute();
    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
else if ($sortby == 'size'){
    $catstr = 'Total Sale Value';
    $stmt = $pdo->prepare('SELECT * FROM ORDER_TABLE ORDER BY order_Total DESC');
    $stmt->execute();
    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
else if ($sortby == 'current'){
    $catstr = 'Active Orders';
    $stmt = $pdo->prepare('SELECT * FROM ORDER_TABLE WHERE NOT order_status = ? ORDER BY order_Date ASC');
    $stmt->bindValue(1, 'filled', PDO::PARAM_STR);
    $stmt->execute();
    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
else{
    $catstr = 'Order Date';
    $stmt = $pdo->prepare('SELECT * FROM ORDER_TABLE ORDER BY order_Date ASC');
    $stmt->execute();
    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<?=template_header('admintransaction');?>

<div class="container">
    <div class="row pt-5">
        <div class="col-sm-2">
            <a class="dropdown-item" href="index.php?page=admin">Create Products</a>
            <a class="dropdown-item" href="index.php?page=adminmodifyproduct">Modify Products</a>
            <a class="dropdown-item" href="index.php?page=adminmodifyuser">Modify Users</a>
            <a class="dropdown-item" href="index.php?page=admintransaction">Transactions</a>
            <a class="dropdown-item" href="index.php?page=admincoupon">Coupons</a>
            <a class="dropdown-item" href="index.php?page=admincreatediscount">Product Discounts</a>
        </div>
        <div class="col-sm-2">
            <div class="row">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Sort by:
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="index.php?page=admintransaction">Order Date</a></li>
                        <li><a class="dropdown-item" href="index.php?page=admintransaction&sortby=current">Active Orders</a></li>
                        <li><a class="dropdown-item" href="index.php?page=admintransaction&sortby=size">Total Sale Value</a></li>
                        <li><a class="dropdown-item" href="index.php?page=admintransaction&sortby=customer">Customer ID</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="row">
                <div class="h5"><?php echo 'Sorting by ' . $catstr?></div>
                <?php foreach ($transactions as $transaction): ?>
                    <div class="row pt-5">
                        <span class="name">Order Number: <?=$transaction['order_ID']?></span>
                        <span class="name">User ID: <?=$transaction['user_ID']?></span>
                        <span class="name">Order Status: <?=$transaction['order_status']?></span>
                        <span class="name">Total Price: <?=$transaction['order_Total']?></span>
                        <span class="name">Date Ordered: <?=$transaction['order_Date']?></span>
                    </div>
                    <br>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?=template_footer()?>

