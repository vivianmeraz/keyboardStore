<?php
    // start session
    session_start();    
    require("assets/config/dbconnection.php");

    // connection info
    $host = 'localhost:3306';
    $db   = 'keyboard_store_schema';
    $user = USERNAME;
    $pass = PASSWORD;
    $charset = 'utf8mb4';
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [    
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false
    ];

    // create connection
    try {
        $conn = new PDO($dsn, $user, $pass, $options);
        echo "Connection successful";

    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    // if submit button exists
    if(isset($_POST['create-button']))
    {
        // retrieve user registration info
        $firstName = !empty($_POST['first-name']) ? trim($_POST['first-name']) : NULL;
        $lastName = !empty($_POST['last-name']) ? trim($_POST['last-name']) : NULL;
        $email = !empty($_POST['email']) ? trim($_POST['email']) : NULL;
        $password = !empty($_POST['password']) ? trim($_POST['password']) : NULL;
        $userID = "000036";

        /**
         * Insert error checking here (refer to the create-account.js file)
         * Make sure you error check BEFORE the prepare() statement is built and executed
         */

        // check if email exists
        // $emailCheck = "SELECT * FROM `USER_TABLE` WHERE `user_Email`='$email'";
        $emailCheck = "SELECT COUNT(user_Email) AS num FROM `USER_TABLE` WHERE `user_Email`='$email'";
        
        // prepare email check
        $emailCheckQuery = $conn->prepare($emailCheck);

        // execute email check
        $emailCheckQuery->execute();

        // fetch row with email
        $row = $emailCheckQuery->fetch(PDO::FETCH_ASSOC);

        /**
         * Error handling for whether email exists.
         */
        if ($row['num'] > 0)
        {
            echo "An account with the email already exists.";
        }

        // Hash password for a layer of security
        $passwordHash = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));

        // INSERT statement
        $sql = "INSERT INTO `USER_TABLE` (`user_ID`, `user_FirstName`, `user_LastName`, `user_Email`, `user_Password`, `user_BillingAddress`, `user_BillingCity`, `user_BillingState`, `user_BillingZipcode`, `user_ShippingAddress`, `user_ShippingCity`, `user_ShippingState`, `user_ShippingZipcode`, `user_Comments`, `user_PaymentCardNo`, `user_PaymentCardExpMM`, `user_PaymentCardExpYY`, `user_PaymentCardCVV`) VALUES ('$userID', '$firstName', '$lastName', '$email', '$passwordHash', '', '', '', '', '', '', '', '', '', '', '', '', '')";

        // prepare INSERT
        $conn->prepare($sql);

        // execute insert query
        if ($conn->exec($sql))
        {
            echo "Account created successfully! Thank you for registering with our website.";
        }
        else
            echo "Unable to create user";
        }
?>