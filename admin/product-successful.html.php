<?php
    error_reporting(0);
    session_start();

    include("../includes/connection.inc.php");
    include("../includes/functions.inc.php");

    if(isset($_SESSION['id']) && $_SESSION['role'] == "admin") {

        if(isset($_REQUEST['code'])) {
            $dataString = $_REQUEST['code'];
    
            //Search for product
            $sql = mysqli_query($con, "SELECT * FROM products WHERE dataString='$dataString'");
            $row = mysqli_fetch_assoc($sql);
        ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Product QR Code</title>
            
                <?php include "../header.html.php"; ?>
            </head>
            <body>
                <?php include "../navbar.html.php"; ?>
            
                <div class="container">
                    <div class="row my-5 pt-5">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3><?php echo $row['name']; ?></h3>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-center">
                                        <canvas id="qrCode"></canvas>
                                    </div>
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
                                    Download the QR Code for sharing.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <?php include "../scripts.html.php"; ?>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
                <script>
                    var urlString = window.location.href; //window.location.href
                    var url = new URL(urlString);
                    var code = url.searchParams.get("code");
            
                    let qr;
                    (function () {
                        qr = new QRious({
                            element: document.querySelector("#qrCode"),
                            size: 200,
                            value: code,
                            /*
                            background: "#123456",
                            backgroundAlpha: 0.7,
                            foreground: "darkcyan",
                            foregroundAlpha: 0.5, 
                            padding: 20, 
                            level: "H",
                            */
                        });
                    })();
                </script>
            </body>
            </html>
        <?php
        } else {
            header('Location:../user/scanner.html.php?type=product');
            die();
        }
    } else {
        header('Location:../user/scanner.html.php?type=product');
        die();
    }
?>