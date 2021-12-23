<?php
    error_reporting(0);
    session_start();

    include("../includes/connection.inc.php");
    include("../includes/functions.inc.php");

    if(isset($_SESSION['id'])) {
        if(isset($_REQUEST['code'])) {
            $dataString = $_REQUEST['code'];
    
            //Search for product
            $sql = mysqli_query($con, "SELECT * FROM carts WHERE dataString='$dataString'");
            $row = mysqli_fetch_assoc($sql);
    
            if(mysqli_num_rows($sql) != 0) {
                $userId = $_SESSION['id'];
                $cartId = $row['id'];
    
                //To check whether user has an already linked cart
                $sqlCheckUser = mysqli_query($con, "SELECT * FROM users WHERE id='$userId'");
                $rowCheckUser = mysqli_fetch_assoc($sqlCheckUser);

                //To check whether the cart is linked to another user or not
                $sqlCheckCart = mysqli_query($con, "SELECT * FROM users WHERE cart='$cartId'");
    
                if($rowCheckUser['cart'] == null) {
                    if(mysqli_num_rows($sqlCheckCart) == 0) {
                        if(mysqli_query($con, "UPDATE users SET cart='$cartId' WHERE id='$userId'")) {
                            $_SESSION['cart'] = $cartId;
    
                            echo "<script>alert('Cart has been linked successfully!')</script>";
                        } else {
                            echo "
                                <script>
                                    alert('Cart could not be linked! Please try again.');
                                    window.location.href = './scanner.html.php?type=cart';
                                </script>
                            ";
                        }
                    } else {
                        echo "
                            <script>
                                alert('Cart is linked to some other user! Please try another cart.');
                                window.location.href = './scanner.html.php?type=cart';
                            </script>
                        ";
                    }
                } else {
                    echo "
                        <script>
                            alert('Cart could not be linked! Please checkout existing cart before linking new one.');
                            window.location.href = './scanner.html.php?type=cart';
                        </script>
                    ";
                }
            }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Link Cart</title>
    
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
                                The QR Code you scanned is invalid and is not linked to any cart.
                            </div>
                            <div class="card-footer">
                                <a href="./scanner.html.php?type=cart" class="btn btn-primary">Try Again</a>
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
                                <?php echo $row['name']; ?> has been linked to your account successfully!
                            </div>
                            <div class="card-footer">
                                <form action="unlink-cart.html.php" method="POST">
                                    <input type="hidden" name="unlinkCart" value="<?php echo $row['id']; ?>" required />
                                    <button type="submit" class="btn btn-primary">Unlink Cart</button>
                                </form>
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
            header('Location:scanner.html.php?type=cart');
            die();
        }
    } else {
        header('Location:../login.html.php');
        die();
    }
?>

