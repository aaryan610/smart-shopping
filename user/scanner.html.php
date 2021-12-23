<?php
    error_reporting(0);
    session_start();

    include("../includes/connection.inc.php");
    include("../includes/functions.inc.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scanner</title>

    <?php include "../header.html.php"; ?>
    
    <style>
        .row {
            display: grid;
            place-items: center;
        }
    </style>
</head>
<body>
    <?php include "../navbar.html.php"; ?>

    <div class="container">
        <div class="row mt-5 pt-5">
            <div class="col-lg-6 col-md-12">
                <div id="reader"></div>
            </div>
        </div>
    </div>

    <?php include "../scripts.html.php"; ?>

    <script src="https://reeteshghimire.com.np/wp-content/uploads/2021/05/html5-qrcode.min_.js"></script>
    <script type="text/javascript">
        var urlString = window.location.href; //window.location.href
        var url = new URL(urlString);
        var type = url.searchParams.get("type");

        function onScanSuccess(dataString) {
            if(type === "product")
                window.location.href = "product-display.html.php?code=" + dataString;
            else if(type === "cart")
                window.location.href = "link-cart.html.php?code=" + dataString;
        }

        function onScanError(errorMessage) {
            //handle scan error
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", { fps: 10, qrbox: 250 });
            html5QrcodeScanner.render(onScanSuccess, onScanError
        );
    </script>
</body>
</html>