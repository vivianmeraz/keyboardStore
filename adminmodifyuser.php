<?php

if ($_SESSION['admin_flag'] != '1' && $_SESSION['signedin'] != 'true'){
    header("Location: index.php");
    exit();
}

$user_ID_error_msg = '';
$admin_flag_error_msg = '';
$user_FirstName_error_msg = '';
$user_LastName_error_msg = '';
$user_Email_error_msg = '';
$user_BillingAddress_error_msg = '';
$user_BillingCity_error_msg = '';
$user_BillingState_error_msg = '';
$user_BillingZipcode_error_msg = '';
$user_ShippingAddress_error_msg = '';
$user_ShippingCity_error_msg = '';
$user_ShippingState_error_msg = '';
$user_ShippingZipcode_error_msg = '';
$user_Comments_error_msg = '';
$createstatus = '';
$msg = '';
$filldata = '';
$uid = '';
$aflg = '';
$ufn = '';
$uln = '';
$uem = '';
$uba = '';
$ubc = '';
$ubs = '';
$ubz = '';
$usa = '';
$usc = '';
$uss = '';
$usz = '';
$uc = '';


if (isset($_POST['querysubmit'])){
    $filldata = "true";
    $userID = $_POST['user_ID'];

    #$stmt = $pdo->prepare('SELECT admin_flag, user_FirstName, user_LastName, user_Email, user_BillingAddress, user_BillingCity, user_BillingState, user_BillingZipcode, user_ShippingAddress, user_ShippingCity, user_ShippingState, user_ShippingZipcode, user_Comments FROM USER_TABLE WHERE user_ID = ?');
    $stmt = $pdo->prepare('SELECT * FROM USER_TABLE WHERE user_ID = ?');
    $stmt->bindValue(1, $userID, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $uid = $userID;
    $aflg = $user['admin_flag'];
    $ufn = $user['user_FirstName'];
    $uln = $user['user_LastName'];
    $uem = $user['user_Email'];
    $uba = $user['user_BillingAddress'];
    $ubc = $user['user_BillingCity'];
    $ubs = $user['user_BillingState'];
    $ubz = $user['user_BillingZipcode'];
    $usa = $user['user_ShippingAddress'];
    $usc = $user['user_ShippingCity'];
    $uss = $user['user_ShippingState'];
    $usz = $user['user_ShippingZipcode'];
    $uc = $user['user_Comments'];

    $createstatus = '';
}

if (isset($_POST['submit'])){
    try{
        if (empty($_POST['user_ID'])){
            $user_ID_error_msg = 'user_ID field is required!';
        }
        if (empty($_POST['user_FirstName'])){
            $user_FirstName_error_msg = 'user_FirstName field is required!';
        }
        if (empty($_POST['user_LastName'])){
            $user_LastName_error_msg = 'user_LastName Date field is required!';
        }
        if (empty($_POST['user_Email'])){
            $user_Email_error_msg = 'user_Email field is required!';
        }
        if (empty($_POST['user_BillingAddress'])){
            $user_BillingAddress_error_msg = 'user_BillingAddress field is required!';
        }
        if (empty($_POST['user_BillingCity'])){
            $user_BillingCity_error_msg = 'user_BillingCity field is required!';
        }
        if (empty($_POST['user_BillingState'])){
            $user_BillingState_error_msg = 'user_BillingState field is required!';
        }
        if (empty($_POST['user_BillingZipcode'])){
            $user_BillingZipcode_error_msg = 'user_BillingZipcode field is required!';
        }
        if (empty($_POST['user_ShippingAddress'])){
            $user_ShippingAddress_error_msg = 'user_ShippingAddress field is required!';
        }
        if (empty($_POST['user_ShippingCity'])){
            $user_ShippingCity_error_msg = 'user_ShippingCity field is required!';
        }
        if (empty($_POST['user_ShippingState'])){
            $user_ShippingState_error_msg = 'user_ShippingState field is required!';
        }
        if (empty($_POST['user_ShippingZipcode'])){
            $user_ShippingZipcode_error_msg = 'user_ShippingZipcode field is required!';
        }
        if (empty($user_ID_error_msg) &&
                empty($user_FirstName_error_msg ) &&
                empty($user_LastName_error_msg) &&
                empty($user_Email_error_msg) &&
                empty($user_BillingAddress_error_msg) &&
                empty($user_BillingCity_error_msg) &&
                empty($user_BillingState_error_msg) &&
                empty($user_BillingZipcode_error_msg) &&
                empty($user_ShippingAddress_error_msg) &&
                empty($user_ShippingCity_error_msg) &&
                empty($user_ShippingState_error_msg) &&
                empty($user_ShippingZipcode_error_msg)
                )
        {
            $user_id = $_POST['user_ID'];
            if ($_POST['admin_flag'] != '1'){
                $adminflag = '0';
            }
            if ($_Post['admin_flag'] == '1'){
                $adminflag = $_POST['admin_flag'];
            }
            $userfirstname = $_POST['user_FirstName'];
            $userlastname = $_POST['user_LastName'];
            $useremail = $_POST['user_Email'];
            $userbillingaddress = $_POST['user_BillingAddress'];
            $userbillingcity = $_POST['user_BillingCity'];
            $userbillingstate = $_POST['user_BillingState'];
            $userbillingzipcode = $_POST['user_BillingZipcode'];
            $usershippingaddress = $_POST['user_ShippingAddress'];
            $usershippingcity = $_POST['user_ShippingCity'];
            $usershippingstate = $_POST['user_ShippingState'];
            $usershippingzipcode = $_POST['user_ShippingZipcode'];
            if (isset($_POST['user_Comments'])){
                $usercomments = $_POST['user_Comments'];
            }
            else{
                $usercomments = '';
            }

            $modstmt = $pdo->prepare('UPDATE USER_TABLE SET admin_flag = ?, user_FirstName = ?, user_LastName = ?, user_Email = ?, user_BillingAddress = ?, user_BillingCity = ?, user_BillingState = ?, user_BillingZipcode = ?, user_ShippingAddress = ?, user_ShippingCity = ?, user_ShippingState = ?, user_ShippingZipcode = ?, user_Comments = ? WHERE user_ID = ?');

            $modstmt->bindValue(1, $adminflag, PDO::PARAM_STR);
            $modstmt->bindValue(2, $userfirstname, PDO::PARAM_STR);
            $modstmt->bindValue(3, $userlastname, PDO::PARAM_STR);
            $modstmt->bindValue(4, $useremail, PDO::PARAM_STR);
            $modstmt->bindValue(5, $userbillingaddress, PDO::PARAM_STR);
            $modstmt->bindValue(6, $userbillingcity, PDO::PARAM_STR);
            $modstmt->bindValue(7, $userbillingstate, PDO::PARAM_STR);
            $modstmt->bindValue(8, $userbillingzipcode, PDO::PARAM_STR);
            $modstmt->bindValue(9, $usershippingaddress, PDO::PARAM_STR);
            $modstmt->bindValue(10, $usershippingcity, PDO::PARAM_STR);
            $modstmt->bindValue(11, $usershippingstate, PDO::PARAM_STR);
            $modstmt->bindValue(12, $usershippingzipcode, PDO::PARAM_STR);
            $modstmt->bindValue(13, $usercomments, PDO::PARAM_STR);
            $modstmt->bindValue(14, $user_id, PDO::PARAM_STR);
            $modstmt->execute();

            $createstatus = 'Successfully updated user.';

            $filldata = '';

        }

    }
    catch (PDOException $e) {
        // $error = "Error : " . $e->getMessage();
        $error = "Error modifying product. Please try again.";
        echo '<script type="text/javascript">alert("'.$error.'");</script>';
    }
}



?>

<?=template_header('adminmodifyuser');?>

<div class="container">
    <div class="row pt-5">
        <div class="col-sm-4">
            <a class="dropdown-item" href="index.php?page=admin">Create Products</a>
            <a class="dropdown-item" href="index.php?page=adminmodifyproduct">Modify Products</a>
            <a class="dropdown-item" href="index.php?page=adminmodifyuser">Modify Users</a>
            <a class="dropdown-item" href="index.php?page=admintransaction">Transactions</a>
            <a class="dropdown-item" href="index.php?page=admincoupon">Coupons</a>
            <a class="dropdown-item" href="index.php?page=admincreatediscount">Product Discounts</a>
        </div>
        <div class="col-sm-8">
            <form action="index.php?page=adminmodifyuser" method='post'>
                <div class="mb-3 mt-3">
                    <label for="user_ID" class="form-label">Enter a user ID to change it's values</label>
                    <input type="text" class="form-control" id="user_ID" placeholder="Enter user ID" name="user_ID">
                    <br>
                    <button type="submit" name="querysubmit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            <?php if ($filldata == ""): ?>
                <div class="row">
                    <?php if ($createstatus != ''): ?>
                        <div class="h5"><?php echo $createstatus ?></div>
                    <?php endif; ?>
                    <form action="index.php?page=adminmodifyuser" method='post'>
                        <div class="mb-3 mt-3">
                            <label for="user_ID" class="form-label">User ID:</label>
                            <input type="text" class="form-control" id="user_ID" placeholder="Enter user ID" name="user_ID" disabled>
                        </div>
                        <?php if ($user_ID_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$user_ID_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="admin_flag" class="form-label">User Admin Flag:</label>
                            <input type="text" class="form-control" id="admin_flag" placeholder="Enter admin flag value (0 for non-admin, 1 for admin)" name="admin_flag" disabled>
                        </div>
                        <?php if ($admin_flag_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$admin_flag_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="user_FirstName" class="form-label">User First Name:</label>
                            <input type="text" class="form-control" id="user_FirstName" placeholder="Enter user First Name" name="user_FirstName" disabled>
                        </div>
                        <?php if ($user_FirstName_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$user_FirstName_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="user_LastName" class="form-label">User Last Name:</label>
                            <input type="text" class="form-control" id="user_LastName" placeholder="Enter user Last Name" name="user_LastName" disabled>
                        </div>
                        <?php if ($user_LastName_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$user_LastName_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="user_Email" class="form-label">User Email:</label>
                            <input type="text" class="form-control" id="user_Email" placeholder="Enter user Email Address" name="user_Email" disabled>
                        </div>
                        <?php if ($user_Email_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$user_Email_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="user_BillingAddress" class="form-label">User Billing Address:</label>
                            <input type="text" class="form-control" id="user_BillingAddress" placeholder="Enter user Billing Address" name="user_BillingAddress" disabled>
                        </div>
                        <?php if ($user_BillingAddress_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$user_BillingAddress_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="user_BillingCity" class="form-label">User Billing City:</label>
                            <input type="text" class="form-control" id="user_BillingCity" placeholder="Enter user Billing City" name="user_BillingCity" disabled>
                        </div>
                        <?php if ($user_BillingCity_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$user_BillingCity_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="user_BillingState" class="form-label">User Billing State:</label>
                            <input type="text" class="form-control" id="user_BillingState" placeholder="Enter user Billing State" name="user_BillingState" disabled>
                        </div>
                        <?php if ($user_BillingState_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$user_BillingState_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="user_BillingZipcode" class="form-label">User Billing Zip Code:</label>
                            <input type="text" class="form-control" id="user_BillingZipcode" placeholder="Enter user Billing Zip Code" name="user_BillingZipcode" disabled>
                        </div>
                        <?php if ($user_BillingZipcode_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$user_BillingZipcode_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="user_ShippingAddress" class="form-label">User Shipping Address:</label>
                            <input type="text" class="form-control" id="user_ShippingAddress" placeholder="Enter user Shipping Address" name="user_ShippingAddress" disabled>
                        </div>
                        <?php if ($user_ShippingAddress_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$user_ShippingAddress_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="user_ShippingCity" class="form-label">User Shipping City:</label>
                            <input type="text" class="form-control" id="user_ShippingCity" placeholder="Enter user Shipping City" name="user_ShippingCity" disabled>
                        </div>
                        <?php if ($user_ShippingCity_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$user_ShippingCity_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="user_ShippingState" class="form-label">User Shipping State:</label>
                            <input type="text" class="form-control" id="user_ShippingState" placeholder="Enter user Shipping State" name="user_ShippingState" disabled>
                        </div>
                        <?php if ($user_ShippingState_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$user_ShippingState_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="user_ShippingZipcode" class="form-label">User Shipping Zip Code:</label>
                            <input type="text" class="form-control" id="user_ShippingZipcode" placeholder="Enter user Shipping Zip Code" name="user_ShippingZipcode" disabled>
                        </div>
                        <?php if ($user_ShippingZipcode_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$user_ShippingZipcode_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="user_Comments" class="form-label">User Comments:</label>
                            <input type="text" class="form-control" id="user_Comments" placeholder="Enter user Comments" name="user_Comments" disabled>
                        </div>
                        <br>
                        <button type="submit" name="submit" class="btn btn-primary" disabled>Submit</button>
                    </form>
                </div>
                <div class="row pt-5"></div>
            <?php endif; ?>
            <?php if ($filldata != ""): ?>
                <div class="row">
                    <form action="index.php?page=adminmodifyuser" method='post'>
                        <div class="mb-3 mt-3">
                            <label for="user_ID" class="form-label">User ID:</label>
                            <input type="text" class="form-control" id="user_ID" value="<?=$uid?>" name="user_ID">
                        </div>
                        <?php if ($user_ID_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$user_ID_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="admin_flag" class="form-label">User Admin Flag:</label>
                            <input type="text" class="form-control" id="admin_flag" value="<?=$aflg?>" name="admin_flag">
                        </div>
                        <?php if ($admin_flag_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$admin_flag_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="user_FirstName" class="form-label">User First Name:</label>
                            <input type="text" class="form-control" id="user_FirstName" value="<?=$ufn?>" name="user_FirstName">
                        </div>
                        <?php if ($user_FirstName_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$user_FirstName_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="user_LastName" class="form-label">User Last Name:</label>
                            <input type="text" class="form-control" id="user_LastName" value="<?=$uln?>" name="user_LastName">
                        </div>
                        <?php if ($user_LastName_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$user_LastName_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="user_Email" class="form-label">User Email Address:</label>
                            <input type="text" class="form-control" id="user_Email" value="<?=$uem?>" name="user_Email">
                        </div>
                        <?php if ($user_Email_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$user_Email_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="user_BillingAddress" class="form-label">User Billing Address:</label>
                            <input type="text" class="form-control" id="user_BillingAddress" value="<?=$uba?>" name="user_BillingAddress">
                        </div>
                        <?php if ($user_BillingAddress_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$user_BillingAddress_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="user_BillingCity" class="form-label">User Billing City:</label>
                            <input type="text" class="form-control" id="user_BillingCity" value="<?=$ubc?>" name="user_BillingCity">
                        </div>
                        <?php if ($user_BillingCity_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$user_BillingCity_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="user_BillingState" class="form-label">User Billing State:</label>
                            <input type="text" class="form-control" id="user_BillingState" value="<?=$ubs?>" name="user_BillingState">
                        </div>
                        <?php if ($user_BillingState_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$user_BillingState_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="user_BillingZipcode" class="form-label">User Billing Zip Code:</label>
                            <input type="text" class="form-control" id="user_BillingZipcode" value="<?=$ubz?>" name="user_BillingZipcode">
                        </div>
                        <?php if ($user_BillingZipcode_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$user_BillingZipcode_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="user_ShippingAddress" class="form-label">User Shipping Address:</label>
                            <input type="text" class="form-control" id="user_ShippingAddress" value="<?=$usa?>" name="user_ShippingAddress">
                        </div>
                        <?php if ($user_ShippingAddress_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$user_ShippingAddress_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="user_ShippingCity" class="form-label">User Shipping City:</label>
                            <input type="text" class="form-control" id="user_ShippingCity" value="<?=$usc?>" name="user_ShippingCity">
                        </div>
                        <?php if ($user_ShippingCity_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$user_ShippingCity_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="user_ShippingState" class="form-label">User Shipping State:</label>
                            <input type="text" class="form-control" id="user_ShippingState" value="<?=$uss?>" name="user_ShippingState">
                        </div>
                        <?php if ($user_ShippingState_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$user_ShippingState_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="user_ShippingZipcode" class="form-label">User Shipping Zip Code:</label>
                            <input type="text" class="form-control" id="user_ShippingZipcode" value="<?=$usz?>" name="user_ShippingZipcode">
                        </div>
                        <?php if ($user_ShippingZipcode_error_msg != ""): ?>
                            <div class="text-danger mb3"><?=$user_ShippingZipcode_error_msg?></div>
                        <?php endif; ?>
                        <br>
                        <div class="mb-3">
                            <label for="user_Comments" class="form-label">User Comments:</label>
                            <input type="text" class="form-control" id="user_Comments" value="<?=$uc?>" name="user_Comments">
                        </div>
                        <br>
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="row pt-5"></div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?=template_footer()?>