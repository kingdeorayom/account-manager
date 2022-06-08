<?php
session_start();

include '../process/sendmail.php';

$maincssVersion = filemtime('../assets/css/main.css');
$pagecssVersion = filemtime('../assets/css/login.css');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify your email</title>
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo '../assets/css/main.css?v=' . $maincssVersion ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo '../assets/css/login.css?v=' . $pagecssVersion ?>" type="text/css">
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
                    <div class="row p-2" id="alert-container-verification-code">
                        <?php
                        if (isset($_SESSION['incorrectVerificationCode'])) { ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Incorrect verification code</strong>. Please try again.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
                            unset($_SESSION['incorrectVerificationCode']);
                        }
                        ?>
                    </div>
                    <div class="row py-2">
                        <!-- <i class="fas fa-key text-warning fa-2x mb-2"></i> -->
                        <h3 class="login-text">We need to confirm it's really you</h3>
                        <p class="login-text">We sent a one-time verification code to the email address you provided. Please enter the code below to reset your password.</p>
                    </div>
                    <form onsubmit="submitVerificationCode(event)" name="verification-code-form">
                        <!-- <form action="../../process/reset-password-redirect.php" method="POST"> -->
                        <!-- <p class="login-text">We sent a verification code to the email you used to register. Enter the code below to verify your account.</p> -->
                        <input type="text" class="form-control mb-3" name="textFieldVerificationCode" id="textFieldVerificationCode" autofocus>
                        <button class="btn text-white w-100 mb-2 bg-success" type="submit" name="buttonSubmit" id="buttonSubmit">Submit</button>
                        <a href="../process/logout.php"> <button class="btn text-white w-100 bg-secondary button-cancel" type="button" name="buttonCancel" id="buttonCancel">Cancel</button></a>
                    </form>
                    <div class="text-center py-2">
                        <hr class="my-3">
                        <p class="login-text">Didn't receive a code? <span class="resend-verification-code" onclick="fireSweetAlertResendVerificationCode();">Click here to resend</span></p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        var alertVerificationCode = document.getElementById('alert-container-verification-code')

        function submitVerificationCode(event) {
            event.preventDefault();
            var loginForm = document.forms.namedItem('verification-code-form');
            var loginData = new FormData(loginForm)
            postVerificationCode(loginData).then(data => checkVerificationCodeResponse(JSON.parse(data)));
        }

        function postVerificationCode(data) {
            return new Promise((resolve, reject) => {
                var http = new XMLHttpRequest();
                http.open("POST", "../process/reset-password-redirect.php");
                http.onload = () => http.status == 200 ? resolve(http.response) : reject(Error(http.statusText));
                http.onerror = (e) => reject(Error(`Networking error: ${e}`));
                http.send(data)
            })
        }

        function checkVerificationCodeResponse(data) {
            if (data.response === "verification_success") {
                window.location.href = "../login/reset-password.php";
            }
            if (data.response === "empty_fields") {
                alertVerificationCode.innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Invalid input!</strong> Please fill up all the fields.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`
            }
            if (data.response === "incorrect_credentials") {
                alertVerificationCode.innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Incorrect verification code!</strong> Please try again.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`
            }
        }
    </script>

    <script src="../node_modules/fontawesome/fontawesome.js" crossorigin="anonymous"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>