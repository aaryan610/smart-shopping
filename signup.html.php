<?php
    error_reporting(0);
    session_start();

    if(isset($_SESSION['id'])) {
        header('Location:user/cart.html.php');
        die();
    } else {
        include("./includes/connection.inc.php");
        include("./includes/functions.inc.php");

        if(isset($_POST['email'])) {
            $email=sanitize_data($con, $_POST['email']);
            $password=sanitize_data($con, $_POST['password']);
            $cPassword=sanitize_data($con, $_POST['cPassword']);

            $count = mysqli_num_rows(mysqli_query($con, "SELECT * FROM users WHERE email='$email'"));

            if($count != 0) {
            ?>
                <div class="alert alert-danger">
                    <strong>Oops!</strong> The Email-Id you entered, already exists. <a href="./login.html.php" style="text-decoration: underline;">Log In</a> here.
                </div>
            <?php
            } else {
                if($password != $cPassword) {
            ?>
                <div class="alert alert-danger">
                    <strong>Oops!</strong> The Passwords don't match. Please retry.
                </div>
            <?php
                } else {
                    $sql=mysqli_query($con, "INSERT INTO users(email,password,cart) VALUES('$email','$password', NULL)");

                    echo "
                        <script>
                            alert('Account created successfully!');
                            window.location.href = './login.html.php';
                        </script>
                    ";
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
    <title>Login</title>

    <?php include "./header.html.php"; ?>
</head>
<body>
    <?php include "./navbar.html.php"; ?>

    <div class="container">
        <div class="row d-flex justify-content-center mt-5 pt-5">
            <form method="POST">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control" placeholder="E-mail*" required />
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-group mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Password*" required />
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-group mb-3">
                            <input type="password" name="cPassword" class="form-control" placeholder="Confirm Password*" required />
                        </div>
                    </div>
                    <div class="col-lg-12 mb-2">
                        Already have an account? <a href="login.html.php">Log In</a> now.
                    </div>
                    <div class="col-lg-3">
                        <div class="input-group mb-3">
                            <button type="submit" class="btn btn-primary form-control">Sign Up</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php include "./scripts.html.php"; ?>
</body>
</html>

<?php } ?>