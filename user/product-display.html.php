<?php
    error_reporting(0);
    session_start();

    include("../includes/connection.inc.php");
    include("../includes/functions.inc.php");

    if(isset($_REQUEST['code'])) {
        $dataString = $_REQUEST['code'];

        //Search for product
        $sql = mysqli_query($con, "SELECT * FROM products WHERE dataString='$dataString'");
        $row = mysqli_fetch_assoc($sql);

        if(isset($_POST['addToCart'])) {
            if(isset($_SESSION['cart'])) {
                $addToCart = sanitize_data($con, $_POST['addToCart']);

                $userId = $_SESSION['id'];
                $cartId = $_SESSION['cart'];

                $sqlCheck = mysqli_query($con, "SELECT * FROM user_cart WHERE user='$userId' AND product='$addToCart'");

                if(mysqli_num_rows($sqlCheck) == 0) {
                    if(mysqli_query($con, "INSERT INTO user_cart(user,product,cart,qty) VALUES('$userId','$addToCart','$cartId',1)")) {
                        echo "<script>alert('Product added to cart successfully!')</script>";
                    } else {
                        echo "<script>alert('Product could not be added to cart! Please try again.')</script>";
                    }
                } else {
                    echo "<script>alert('Product is already added to cart!')</script>";
                }
            } else {
                echo "<script>alert('Please link a cart before adding products!')</script>";
                // header('Location:scanner.html.php?type=cart');
                // die();
            }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>

    <?php include "../header.html.php"; ?>
</head>
<body>
    <?php include "../navbar.html.php"; ?>

    <div class="container">
        <div class="row mt-5 pt-5">
            <div class="col-lg-12">
                <?php
                    if(mysqli_num_rows($sql) == 0) {
                ?>
                    <div class="card">
                        <div class="card-header">
                            <h3>Invalid QR Code</h3>
                        </div>
                        <div class="card-body">
                            The QR Code you scanned is invalid and is not linked to any product.
                        </div>
                        <div class="card-footer">
                            <a href="./scanner.html.php?type=product" class="btn btn-primary">Try Again</a>
                        </div>
                    </div>
                <?php
                    } else {
                ?>
                    <div class="card">
                        <div class="card-header">
                            <h3><?php echo $row['name']; ?></h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <strong>Price:</strong> ₹<?php echo $row['price']; ?>
                                </li>
                                <li class="list-group-item">
                                    <strong>Manufacturing Date:</strong> <?php echo date("d-m-Y", strtotime($row['mdate'])); ?>
                                </li>
                                <li class="list-group-item">
                                    <strong>Expiry Date:</strong> <?php echo date("d-m-Y", strtotime($row['edate'])); ?>
                                </li>
                                <li class="list-group-item">
                                    <strong>Weight:</strong> <?php echo $row['weight']; ?>g
                                </li>
                            </ul>
                        </div>
                        <div class="card-footer">
                            <?php
                                if(isset($_SESSION['id'])) {
                            ?>
                                <form method="POST">
                                    <input type="hidden" name="addToCart" value="<?php echo $row['id']; ?>" required />
                                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                                    <a href="./scanner.html.php?type=product" class="btn btn-primary">Scan again</a>
                                </form>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>

    <?php include "../scripts.html.php"; ?>
</body>
</html>
<?php
    } else {
        header('Location:scanner.html.php?type=product');
        die();
    }
?>