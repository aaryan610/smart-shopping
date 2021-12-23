<?php
    error_reporting(0);
    session_start();

    if(isset($_SESSION['id'])) {
        if($_SESSION['role'] == "admin") {
            include("../includes/connection.inc.php");
            include("../includes/functions.inc.php");

            if(isset($_POST['name'])) {
                //Store form values
                $name = sanitize_data($con, $_POST['name']);
                $weight = sanitize_data($con, $_POST['weight']);

                //Function to generate random string
                function generateRandomString($length) {
                    $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
                    $charactersLength = strlen($characters);
                    $randomString = ""
                    ;
                    for ($i = 0; $i < $length; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                    }
                    
                    return $randomString;
                }

                $dataString = generateRandomString(10);

                //Check if dataString already exists or not
                $count = mysqli_num_rows(mysqli_query($con,"SELECT * FROM carts WHERE dataString='$dataString'"));

                while($count != 0) {
                    $dataString = generateRandomString(64);

                    $count = mysqli_num_rows(mysqli_query($con,"SELECT * FROM carts WHERE dataString='$dataString'"));
                }

                //Insert product
                mysqli_query($con, "INSERT INTO carts(name,dataString) VALUES('$name','$dataString')");
                header('Location:cart-successful.html.php?code='.$dataString);
                die();
            }
            ?>
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Add Cart</title>

                    <?php include "../header.html.php"; ?>
                </head>
                <body>
                    <?php include "../navbar.html.php"; ?>

                    <div class="container">
                        <div class="row d-flex justify-content-center mt-5 pt-5">
                            <h3 class="text-center mb-4">Add Cart</h3>
                            <form method="POST">
                                <div class="col-lg-8 m-auto col-md-12 row">
                                    <div class="col-lg-12">
                                        <div class="input-group mb-3">
                                            <input type="text" name="name" class="form-control" placeholder="Cart Name*" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="input-group mb-3">
                                            <button type="submit" class="btn btn-primary form-control">Add Cart</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <?php include "../scripts.html.php"; ?>

                    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
                </body>
                </html>
            <?php
        } else {
            header('Location:../login.html.php');
            die();
        }
    } else {
        header('Location:../login.html.php');
        die();
    }
?>