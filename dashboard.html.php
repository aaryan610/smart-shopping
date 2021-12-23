<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Shopping</title>

    <?php include "./header.html.php"; ?>
</head>
<body>
    <?php include "./navbar.html.php"; ?>

    <div class="jumbotron mb-0">
        <div class="row justify-content-center text-center">
            <div class="col-lg-6 text-white">
                <h1 class="text-white">Smart Shopping</h1>

                <p class="mt-4">
                    Link your cart and scan products to add them to your cart, checkout after adding all the required products.
                </p>

                <p class="mt-4">
                    <a href="./user/scanner.html.php?type=product" class="btn btn-primary btn-lg" role="button">Start Shopping</a>
                </p>
            </div>
        </div>
    </div>
    
    <?php include "./scripts.html.php"; ?>
</body>
</html>