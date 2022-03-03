<?php
session_start();

if (!isset($_SESSION['email'])) {
    echo '<div style="font-family: arial; padding: 3%; font-size: 30px; text-align: center;">
    <p style="font-size: 50px; font-weight: bold">Oops!</p>
    <p>If you are seeing this message, it means you accessed a page outside of the normal process intended by the developers.</p>
    <p>Please click <a href="../../../index.php">here</a> to return to the login page, or to the homepage if already logged in.</p>
    <br><br><br>
    <p style="font-size: 20px; color: grey;">Account Manager</p>
</div>';
    die();
} else if (isset($_SESSION['email'])) {
    $verificationCode = uniqid();
    $_SESSION['verificationCode'] = strtoupper(substr($verificationCode, 7));
    $subject = '[Account Manager] Verification Code';
    $message =  'Hello, ' .  $_SESSION['name'] . '!' . "\n\n" . 'A registration attempt using this email address ' . $_SESSION['email'] . ' was made and requires further verification.' . "\n" . 'To complete the sign up process, enter the verification code given below:' . "\n\n" . 'Verification code: ' . $_SESSION['verificationCode'] . "\n\n" . 'If it wasn\'t you who attempted to register the email in the website, kindly disregard this message. The registration process will be cancelled and the email will not be used.' . 'This is a system generated message. Do not reply.';
    $recipient = $_SESSION['email'];
    mail($recipient, $subject, $message, 'From: noreply@gmail.com');
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify your account</title>
    <?php include_once '../../includes/google-fonts.php' ?>
    <link rel="stylesheet" href="../../../styles/bootstrap/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="../../../styles/custom/pages/login-style.css" type="text/css">
</head>

<body>
    <!--Main Section-->
    <main class="main">
        <div class="container">
            <div class="row mx-auto">
                <div class="col-sm-12 col-md-9 col-lg-5 mx-auto p-5">
                    <div class="row py-2 text-center">
                        <i class="fas fa-key text-warning fa-2x mb-2"></i>
                        <h3 class="login-text">Account Manager</h3>
                        <p class="login-text">Store and manage your account all in one place!</p>
                    </div>
                    <div class="row p-2" id="alert-container-login">
                        <?php
                        if (isset($_SESSION['incorrectVerificationCode'])) { ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Incorrect verification code</strong>. Please try again with the new code sent to your email.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
                            unset($_SESSION['incorrectVerificationCode']);
                        }
                        ?>
                    </div>
                    <form action="../../process/account-verify.php" method="POST">
                        <p class="login-text">We sent a verification code to the email you used to register. Enter the code below to verify your account.</p>
                        <input type="text" class="form-control my-3" name="textFieldVerificationCode" id="textFieldVerificationCode" autofocus>
                        <button class="btn text-white w-100 mb-2 bg-success" type="submit" name="buttonSubmit" id="buttonSubmit">Submit</button>
                        <button class="btn text-white w-100 bg-secondary" type="button" name="buttonCancel" id="buttonCancel"><a href="../../process/logout.php" style="text-decoration: none; color:white;">Cancel</a></button>
                    </form>
                    <div class="text-center py-2">
                        <hr class="my-3">
                        <p class="login-text">Didn't receive a code? <span class="resend-verification-code" onclick="fireSweetAlertResendVerificationCode();">Click here to resend</span></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://kit.fontawesome.com/dab8986b00.js" crossorigin="anonymous"></script>
    <script src="../../../scripts/bootstrap/bootstrap.js"></script>
</body>

</html>