<?php
session_start();

include '../../process/sendmail.php';
$pagecssVersion = filemtime('../../../styles/custom/pages/login-style.css');

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify your account</title>
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
                    <div class="row py-2 text-center">
                        <i class="fas fa-key text-warning fa-2x mb-2"></i>
                        <h3 class="login-text">Account Manager</h3>
                        <p class="login-text">Store and manage your accounts—all in one place</p>
                    </div>
                    <div class="row p-2" id="alert-container-verify-account">
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
                    <div class="row py-2">
                        <!-- <i class="fas fa-key text-warning fa-2x mb-2"></i>
                        <h3 class="login-text">Account Manager</h3> -->
                        <p class="login-text">We sent a verification code to the email you used to register. Enter the code below to verify your account.</p>
                    </div>
                    <!-- <form action="../../process/account-verify.php" method="POST"> -->
                    <form onsubmit="submitAccountVerification(event)" name="account-verification-form">
                        <!-- <p class="login-text">We sent a verification code to the email you used to register. Enter the code below to verify your account.</p> -->
                        <input type="text" class="form-control mb-3" name="textFieldVerificationCode" id="textFieldVerificationCode" autofocus>
                        <button class="btn text-white w-100 mb-2 bg-success" type="submit" name="buttonSubmit" id="buttonSubmit">Submit</button>
                        <a href="../../process/logout.php"> <button class="btn text-white w-100 bg-secondary button-cancel" type="button" name="buttonCancel" id="buttonCancel">Cancel</button></a>
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
        var alertAccountVerification = document.getElementById('alert-container-verify-account')

        function submitAccountVerification(event) {
            event.preventDefault();
            var loginForm = document.forms.namedItem('account-verification-form');
            var loginData = new FormData(loginForm)
            postAccountVerification(loginData).then(data => checkAccountVerificationResponse(JSON.parse(data)));
        }

        function postAccountVerification(data) {
            return new Promise((resolve, reject) => {
                var http = new XMLHttpRequest();
                http.open("POST", "../../process/account-verify.php");
                http.onload = () => http.status == 200 ? resolve(http.response) : reject(Error(http.statusText));
                http.onerror = (e) => reject(Error(`Networking error: ${e}`));
                http.send(data)
            })
        }

        function checkAccountVerificationResponse(data) {
            console.log(data)
            if (data.response === "login_success") {
                window.location.href = "../../../index.php";
                console.log("success")
            }
            if (data.response === "empty_fields") {
                alertAccountVerification.innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Invalid input!</strong> Please fill up all the fields.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`
            }
            if (data.response === "incorrect_credentials") {
                alertAccountVerification.innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Incorrect verification code!</strong> Please try again.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`
            }
        }
    </script>

    <script src="https://kit.fontawesome.com/dab8986b00.js" crossorigin="anonymous"></script>
    <script src="../../../scripts/bootstrap/bootstrap.js"></script>
</body>

</html>