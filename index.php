<?php

session_start();

if (isset($_SESSION['loggedin'])) {
    header("Location: ./home.php");
}

$maincssVersion = filemtime('./assets/css/main.css');
$pagecssVersion = filemtime('./assets/css/login.css');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Manager</title>
    <link rel="stylesheet" href="./node_modules/animate.css/animate.min.css">
    <script src="./node_modules/jquery/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo './assets/css/main.css?v=' . $maincssVersion ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo './assets/css/login.css?v=' . $pagecssVersion ?>" type="text/css">

    <link rel="apple-touch-icon" sizes="180x180" href="./apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon-16x16.png">
    <link rel="manifest" href="./site.webmanifest">
    <link rel="mask-icon" href="./safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <meta property="og:image" content="./assets/img/key-icon.png" />
    <meta name="keywords" content="account manager, accountmanager, serking de orayom, serking">
    <meta property="og:description" content="A web-based application to store and manage your accounts all in one place." />
    <meta property="og:url" content="https://account-manager.online" />
    <meta property="og:title" content="Account Manager" />

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
                        <p class="login-text">Sign-in to access and manage your accounts</p>
                    </div>
                    <div class="row p-2" id="alert-container-login">
                        <?php
                        if (isset($_SESSION['registrationSuccessful'])) { ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Account successfully created!</strong> Log-in with your email and password below.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
                            unset($_SESSION['registrationSuccessful']);
                        } else if (isset($_SESSION['incorrectUsernamePassword'])) { ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Incorrect email or password!</strong> Please try again.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
                            unset($_SESSION['incorrectUsernamePassword']);
                        } else if (isset($_SESSION['passwordResetSuccessful'])) { ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Password Reset Successful!</strong> Login with your email and new password below.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
                            unset($_SESSION['passwordResetSuccessful']);
                        } else if (isset($_SESSION['incorrectUsernamePassword'])) { ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Incorrect email or password!</strong> Please try again.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
                            unset($_SESSION['incorrectUsernamePassword']);
                        } else if (isset($_SESSION['emptyInput'])) { ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Invalid input!</strong> Please fill up all the fields.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
                            unset($_SESSION['emptyInput']);
                        }
                        ?>
                    </div>
                    <form onsubmit="submitLogin(event)" name="login-form">
                        <label class="login-text my-1">Email</label>
                        <input type="text" class="form-control mb-2" name="textFieldEmail" id="textFieldEmail">
                        <label class="login-text my-1">Password</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" name="textFieldPassword" id="textFieldPassword">
                            <span class="input-group-text"><i class="fas fa-eye" id="show_eye"></i><i class="fas fa-eye-slash" id="hide_eye" hidden></i></span>
                        </div>
                        <button class="btn text-white w-100 mt-3 mb-2 bg-success" type="submit" name="buttonLogin" id="buttonLogin">Login</button>
                    </form>
                    <div class="text-center py-2">
                        <a href="./login/forgot-password.php" class="login-text forgot-password">I forgot my password</a>
                        <hr class="my-4">
                        <label class="login-text">No account yet? <a href="./login/registration.php" class="no-account">Click here to create</a></label>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer-basic">

            <div class="social">

                <!-- <h6 class="fw-normal">For concerns and inquiries, contact me through:</h6> -->

                <a href="https://www.facebook.com/kingdeorayom" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="Facebook"><i class="fab fa-facebook"></i></a>
                <a href="https://www.twitter.com/kingdeorayom" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="https://www.instagram.com/kingdeorayom" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="https://www.github.com/kingdeorayom" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="GitHub"><i class="fab fa-github"></i></a>
                <a href="https://www.linkedin.com/in/serking-de-orayom-599927218/" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
            </div>
            <p class="copyright">Serking de Orayom © 2022</p>
        </footer>

    </main>


    <script>
        $(document).ready(function() {
            $("#show_eye").click(function() {
                $("#textFieldPassword").attr("type", "text");
                $("#show_eye").prop("hidden", true);
                $("#hide_eye").prop("hidden", false);
            });
            $("#hide_eye").click(function() {
                $("#textFieldPassword").attr("type", "password");
                $("#show_eye").prop("hidden", false);
                $("#hide_eye").prop("hidden", true);
            });
        });
    </script>
    <script>
        var alertLogin = document.getElementById('alert-container-login')

        function submitLogin(event) {
            event.preventDefault();
            var loginForm = document.forms.namedItem('login-form');
            var loginData = new FormData(loginForm)
            postLogin(loginData).then(data => checkLoginResponse(JSON.parse(data)));
        }

        function postLogin(data) {
            return new Promise((resolve, reject) => {
                var http = new XMLHttpRequest();
                http.open("POST", "./process/login.php");
                http.onload = () => http.status == 200 ? resolve(http.response) : reject(Error(http.statusText));
                http.onerror = (e) => reject(Error(`Networking error: ${e}`));
                http.send(data)
            })
        }

        function checkLoginResponse(data) {
            console.log(data)
            if (data.response === "login_success") {
                window.location.reload();
                console.log("success")
            }
            if (data.response === "empty_fields") {
                alertLogin.innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Invalid input!</strong> Please fill up all the fields.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`
            }
            if (data.response === "incorrect_credentials") {
                alertLogin.innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Incorrect email or password!</strong> Please try again.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`
            }
        }
    </script>

    <script src="./node_modules/fontawesome/fontawesome.js" crossorigin="anonymous"></script>
    <script src="./node_modules/@popperjs/core/dist/umd/popper.js"></script>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="./scripts/tooltip.js"></script>

</body>

</html>