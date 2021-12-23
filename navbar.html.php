<?php
    error_reporting(0);
    session_start();
?>
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <a href=".." class="navbar-brand">Smart Shopping</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="../user/scanner.html.php?type=product">Scan Product</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../user/cart.html.php">Cart</a>
            </li>
            <?php
                if(isset($_SESSION['role']) && $_SESSION['role'] == "admin") {
            ?>
            <li class="nav-item">
                <a class="nav-link" href="../admin/add-product.html.php">Add Product</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../admin/add-cart.html.php">Add Cart</a>
            </li>
            <?php
                }
                if(isset($_SESSION['id'])) {
            ?>
            <li class="nav-item">
                <a class="nav-link" href="../logout.html.php">Log out</a>
            </li>
            <?php
                } else {
            ?>
            <li class="nav-item">
                <a class="nav-link" href="../login.html.php">Log in</a>
            </li>
            <?php
                }
            ?>
        </ul>
    </div>  
</nav>