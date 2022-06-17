<?php

session_start();

$maincssVersion = filemtime('../assets/css/main.css');
$pagecssVersion = filemtime('../assets/css/login.css');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset your password</title>
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo '../assets/css/main.css?v=' . $maincssVersion ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo '../assets/css/login.css?v=' . $pagecssVersion ?>" type="text/css">

    <link rel="apple-touch-icon" sizes="180x180" href="../apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon-16x16.png">
    <link rel="manifest" href="../site.webmanifest">
    <link rel="mask-icon" href="../safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

</head>

<body>
    <!--Main Section-->
    <main class="main">
        <div class="container">
            <div class="row mx-auto">
                <div class="col-sm-12 col-md-9 col-lg-5 mx-auto p-5">
                    <!-- <div class="row py-2 text-center">
                        <i class="fas fa-key text-warning fa-2x mb-2"></i>
                        <h3 class="login-text">Account Manager</h3>
                        <p class="login-text">Store and manage your accounts—all in one place</p>
                    </div> -->
                    <div class="row p-2" id="alert-container-login">
                        <?php
                        if (isset($_SESSION['emptyInput'])) { ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Invalid input!</strong> Please fill up all the fields.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
                            unset($_SESSION['emptyInput']);
                        }

                        if (isset($_SESSION['invalidEmail'])) { ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Invalid input!</strong> Please enter a valid e-mail.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
                            unset($_SESSION['invalidEmail']);
                        }

                        if (isset($_SESSION['emailDoesNotExists'])) { ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Account not found!</strong> There is no account linked to the email provided.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
                            unset($_SESSION['emailDoesNotExists']);
                        }
                        ?>
                    </div>
                    <form action="../process/forgot-password-email-verify.php" method="POST">
                        <h4 class="login-text">Forgot your password?</h4>
                        <p class="login-text">Enter the email you used to register your account.</p>
                        <input class="form-control my-3" type="text" name="textFieldEmail" id="textFieldEmail" value="<?php if (isset($_SESSION['email'])) {
                                                                                                                            echo $_SESSION['email'];
                                                                                                                            unset($_SESSION['email']);
                                                                                                                        } ?>" autofocus>
                        <!-- <input type="text" class="form-control my-3" name="textFieldEmail" id="textFieldEmail" autofocus> -->
                        <button class="btn text-white w-100 mb-2 bg-success" type="submit" name="buttonSubmit" id="buttonSubmit">Submit</button>
                        <a href="../index.php"><button class="btn text-white w-100 bg-secondary button-cancel" type="button" name="buttonCancel" id="buttonCancel">Cancel</button></a>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script src="../node_modules/fontawesome/fontawesome.js" crossorigin="anonymous"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>