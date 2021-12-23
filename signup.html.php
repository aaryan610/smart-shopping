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

            $count=mysqli_num_rows(mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND password='$password'"));
            $count1=mysqli_num_rows(mysqli_query($con, "SELECT * FROM users WHERE email='$email'"));

            if($count1 == 0) {
            $email="";
            $email_colour="red";
            ?>
            <div class="alert alert-danger">
                <strong>Oops!</strong> The Email-Id you entered, doesn't exist. <a href="signup.php" style="text-decoration: underline;">Sign Up</a> to create an account.
            </div>
            <?php
            } else {
                if($count > 0) {
                    $sql=mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND password='$password'");
                    $row=mysqli_fetch_assoc($sql);

                    $_SESSION['id'] = $row['id'];

                    if($row['id'] == 1) {
                        $_SESSION['role'] = "admin";
                    } else {
                        $_SESSION['role'] = "user";
                    }

                    header('Location:user/cart.html.php');
                    die();
                } else {
                ?>
                    <div class="alert alert-danger">
                        <strong>Oops!</strong> The Email-Id and Password you entered don't match.
                    </div>
                <?php
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
                    <div class="col-lg-12">
                        <div class="input-group mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Password*" required />
                        </div>
                    </div>
                    <div class="col-lg-12 mb-2">
                        Don't have an account? <a href="signup.html.php">Sign up</a> now.
                    </div>
                    <div class="col-lg-12">
                        <div class="input-group mb-3">
                            <button type="submit" class="btn btn-primary form-control">Login</button>
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