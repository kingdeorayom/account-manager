<?php

session_start();

if (!isset($_SESSION['resetPassword'])) {
    echo '<div style="font-family: arial; padding: 3%; font-size: 30px; text-align: center;">
    <p style="font-size: 50px; font-weight: bold">Oops!</p>
    <p>If you are seeing this message, it means you accessed a page outside of the normal process intended by the developers.</p>
    <p>Please click <a href="../../../index.php">here</a> to return to the login page, or to the homepage if already logged in.</p>
    <br><br><br>
    <p style="font-size: 20px; color: grey;">SALIKSIK: UPHSL Research Repository</p>
</div>';
    die();
    // echo '<a href="../../../index.php">go back</a><br><br>';
    // die('If you are seeing this message, it means you accessed this page outside of the normal process intended by the developers.<br>Please click the link above to return to the login page, or to the homepage if already logged in.');
}

$pagecssVersion = filemtime('../../../styles/custom/pages/login-style.css');


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an account</title>
    <?php include_once '../../../assets/fonts/google-fonts.php' ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../../../styles/bootstrap/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="<?php echo '../../../styles/custom/pages/login-style.css?id=' . $pagecssVersion ?>" type="text/css">
</head>

<body>

    <!--Main Section-->
    <main class="main">
        <div class="container">
            <div class="row mx-auto">
                <div class="col-sm-12 col-md-9 col-lg-5 mx-auto p-5">
                    <!-- <div class="row py-2 text-center">
                        <i class="fas fa-key text-warning fa-2x mb-1"></i>
                        <h3 class="login-text">Account Manager</h3>
                        <p class="login-text">Register for an account</p>
                    </div> -->
                    <div class="row py-2" id="alert-container-register">
                        <?php

                        if (isset($_SESSION['emptyInput'])) { ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Invalid input!</strong> Please fill up all the fields.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
                            unset($_SESSION['emptyInput']);
                        }

                        if (isset($_SESSION['mismatchedPassword'])) { ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Invalid input!</strong> <code>Password</code> and <code>Confirm Password</code> does not match.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
                            unset($_SESSION['mismatchedPassword']);
                        }

                        ?>
                    </div>
                    <form action="../../process/reset-password-actual.php" method="POST">
                        <h3 class="login-text">Reset your password</h3>
                        <label class="login-text my-2">Enter new password</label>
                        <input type="password" class="form-control" name="textFieldPassword" id="textFieldPassword">
                        <label class="login-text my-2">Confirm password</label>
                        <input type="password" class="form-control mb-3" name="textFieldConfirmPassword" id="textFieldConfirmPassword">
                        <div class="form-check">
                            <input onclick="showHidePasswordReset();" class="form-check-input" type="checkbox" value="" id="checkBoxShowHidePassword">
                            <label class="form-check-label" for="checkBoxShowHidePassword">Show/Hide Password</label>
                        </div>
                        <button class="btn text-white w-100 mt-3 mb-2 bg-success" type="submit" name="buttonRegister" id="buttonRegister">Reset password</button>
                        <a href="../../process/logout.php"> <button class="btn text-white w-100 bg-secondary button-cancel" type="button" name="buttonCancel" id="buttonCancel">Cancel</button></a>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script>
        $(document).ready(function() {
            $("#checkBoxShowHidePassword").change(function() {
                if ($(this).is(':checked')) {
                    $("#textFieldPassword, #textFieldConfirmPassword").attr("type", "text");
                } else {
                    $("#textFieldPassword, #textFieldConfirmPassword").attr("type", "password");
                }
            });
        });
    </script>
    <script src="https://kit.fontawesome.com/dab8986b00.js" crossorigin="anonymous"></script>
    <script src="../../../scripts/bootstrap/bootstrap.js"></script>
</body>

</html>