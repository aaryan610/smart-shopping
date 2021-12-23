<?php
    error_reporting(0);
    session_start();
    
    include("./includes/connection.inc.php");
    include("./includes/functions.inc.php");

    if(isset($_SESSION['id'])) {
        $userId = $_SESSION['id'];
        $cartId = $_SESSION['cart'];

        mysqli_query($con, "UPDATE users SET cart=NULL WHERE cart='$cartId'");
        mysqli_query($con, "DELETE FROM user_cart WHERE user='$userId'");

        unset($_SESSION['id']);
        unset($_SESSION['role']);
        unset($_SESSION['cart']);
        session_destroy();

        header('Location:login.html.php');
        die();
    } else {
        header('Location:login.html.php');
        die();
    }
?>