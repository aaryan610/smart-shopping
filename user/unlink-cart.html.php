<?php
    error_reporting(0);
    session_start();

    include("../includes/connection.inc.php");
    include("../includes/functions.inc.php");

    if(isset($_SESSION['id'])) {
        if(isset($_SESSION['cart']) && isset($_POST['unlinkCart'])) {
            $userId = $_SESSION['id'];
            $cartId = $_POST['unlinkCart'];
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
                        if(mysqli_query($con, "UPDATE users SET cart=NULL WHERE cart='$cartId'") && mysqli_query($con, "DELETE FROM user_cart WHERE user='$userId'")) {
                            unset($_SESSION['cart']);
                    ?>
                        <div class="card">
                            <div class="card-header">
                                <h3>Unlink Status</h3>
                            </div>
                            <div class="card-body">
                                Cart is unlinked successfully.
                            </div>
                            <div class="card-footer">
                                <a href="./scanner.html.php?type=cart" class="btn btn-primary">Link again</a>
                            </div>
                        </div>
                    <?php   
                        } else {
                    ?>
                        <div class="card">
                            <div class="card-header">
                                <h3>Unlink Status</h3>
                            </div>
                            <div class="card-body">
                                Oops! The cart could not be unlinked!
                            </div>
                            <div class="card-footer">
                                <form action="unlink-cart.html.php" method="POST">
                                    <input type="hidden" name="unlinkCart" value="<?php echo $cartId; ?>" required />
                                    <button type="submit" class="btn btn-primary">Try Again</button>
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

