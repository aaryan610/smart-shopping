<?php
    error_reporting(0);
    session_start();

    include("../includes/connection.inc.php");
    include("../includes/functions.inc.php");

    if(isset($_SESSION['id'])) {
        $userId = $_SESSION['id'];

        $sqlCart = mysqli_query($con, "SELECT * FROM user_cart WHERE user='$userId'");

        if(isset($_REQUEST['action']) && $_REQUEST['action'] == "delete") {
            $toDeleteId = $_REQUEST['productId'];

            $sqlDelete = mysqli_query($con, "DELETE FROM user_cart WHERE user='$userId' AND product='$toDeleteId'");

            if($sqlDelete) {
                echo "<script>alert('Product removed from cart successfully!')</script>";
                echo "<script>window.location.href = 'cart.html.php';</script>";
            }
        }
        
        if(isset($_REQUEST['action']) && $_REQUEST['action'] == "checkout") {
            mysqli_query($con, "DELETE FROM user_cart WHERE user='$userId'");

            $cartId = $_SESSION['cart'];
            mysqli_query($con, "UPDATE users SET cart=NULL WHERE cart='$cartId'");
            unset($_SESSION['cart']);

            echo "<script>alert('Checkout successful!')</script>";
            echo "<script>window.location.href = 'cart.html.php';</script>";
        }
        
        if(isset($_REQUEST['action'])) {
            $toChangeId = $_REQUEST['productId'];
            $cartId = $_SESSION['cart'];

            if($_REQUEST['action'] == "decrease") {
                $sqlQty = mysqli_query($con, "SELECT * FROM user_cart WHERE user='$userId' AND product='$toChangeId'");
                $rowQty = mysqli_fetch_assoc($sqlQty);

                if($rowQty['qty'] == 1) {
                    echo "<script>window.location.href = 'cart.html.php?action=delete&productId=" . $toChangeId . "';</script>";
                } else {
                    $sqlDecrease = mysqli_query($con, "UPDATE user_cart SET qty=(qty - 1) WHERE user='$userId' AND product='$toChangeId'");

                    if($sqlDecrease) {
                        echo "<script>alert('Quantity decreased successfully!')</script>";
                        echo "<script>window.location.href = 'cart.html.php';</script>";
                    }
                }
            } else {
                $sqlIncrease = mysqli_query($con, "UPDATE user_cart SET qty=(qty + 1) WHERE user='$userId' AND product='$toChangeId'");

                if($sqlIncrease) {
                    echo "<script>alert('Quantity increased successfully!')</script>";
                    echo "<script>window.location.href = 'cart.html.php';</script>";
                }
            }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>

    <?php include "../header.html.php"; ?>
</head>
<body>
    <?php include "../navbar.html.php"; ?>

    <div class="container mt-5 pt-5">
        <?php
            if(isset($_SESSION['cart'])) {
                if(mysqli_num_rows($sqlCart) == 0) {
                ?>
                    <h2>No Products found!</h2>
                    <form action="unlink-cart.html.php" class="mt-2" method="POST">
                        <input type="hidden" name="unlinkCart" value="<?php echo $_SESSION['cart']; ?>" required />
                        <button type="submit" class="btn btn-primary">Unlink Cart</button>
                    </form>
                <?php
                } else {
                ?>
                    <a href="?action=checkout" class="btn btn-primary">Checkout</a>
                    <form action="unlink-cart.html.php" class="mt-2" method="POST">
                        <input type="hidden" name="unlinkCart" value="<?php echo $_SESSION['cart']; ?>" required />
                        <button type="submit" class="btn btn-primary">Unlink Cart</button>
                    </form>
                    <table class="table table-striped table-responsive-sm mt-3">
                        <thead class="thead-dark">
                            <tr>
                                <th>S.No.</th>
                                <th>Product Name</th>
                                <th>Product Price</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = 1;
                                while($rowCart = mysqli_fetch_assoc($sqlCart)) {
                                    $productId = $rowCart['product'];
                                    $sqlProduct = mysqli_query($con, "SELECT * FROM products WHERE id='$productId'");
                                    $rowProduct = mysqli_fetch_assoc($sqlProduct);

                                    $price = (float)$rowProduct['price'] * (float)$rowCart['qty'];
                            ?>
                                <tr>
                                    <td><?php echo $i . "."; ?></td>
                                    <td><?php echo $rowProduct['name']; ?></td>
                                    <td><?php echo $rowProduct['price']; ?></td>
                                    <td><?php echo $rowCart['qty']; ?></td>
                                    <th>
                                        <div class="row text-center align-items-center">
                                            <form action="" class="col-lg-3" method="POST">
                                                <input type="hidden" name="action" value="decrease" />
                                                <input type="hidden" name="productId" value="<?php echo $productId; ?>" />
                                                <button type="submit" class="btn btn-primary btn-sm">-</button>
                                            </form>
                                            <input type="number" class="form-control col-lg-6" value="<?php echo $rowCart['qty']; ?>" readonly />
                                            <form action="" class="col-lg-3" method="POST">
                                                <input type="hidden" name="action" value="increase" />
                                                <input type="hidden" name="productId" value="<?php echo $productId; ?>" />
                                                <button type="submit" class="btn btn-primary btn-sm">+</button>
                                            </form>
                                        </div>
                                    </th>
                                    <th>₹<?php echo $price; ?></th>
                                    <td>
                                        <a href="?action=delete&productId=<?php echo $productId; ?>" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            <?php
                                    $i++;
                                }
                            ?>
                        </tbody>
                    </table>
                <?php
                }
            } else {
            ?>
                <h2>You have not linked any cart!</h2>
                <a href="./scanner.html.php?type=cart" class="btn btn-primary">Link a Cart</a>
            <?php
            }
        ?>
    </div>

    <?php include "../scripts.html.php"; ?>
</body>
</html>
<?php
    } else {
        header('Location:../login.html.php');
        die();
    }
?>