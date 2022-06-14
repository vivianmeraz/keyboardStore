<?php
    session_start();

    if (isset($_SESSION['user_ID']) && $_SESSION['signedin'] == true)
    {
        $_SESSION['signedin'] = false;
        session_unset($_SESSION['user_ID']);
        session_destroy($_SESSION['user_ID']);

        $_SESSION['admin_flag'] = 0;
        session_unset($_SESSION['admin_flag']);
        session_destroy($_SESSION['admin_flag']);
        
        $_SESSION['cart'] = array();
        session_unset($_SESSION['cart']);
        session_destroy($_SESSION['cart']);

        echo '<script type="text/javascript">alert("Signed out successfully!");</script>';
    
        // header ("Location: index.php?page=home");

        echo '<script>window.location.replace("index.php?page=home")</script>';
    }
?>