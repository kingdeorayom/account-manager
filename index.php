<?php
session_start();
if (isset($_SESSION['loggedin'])) {
    header("Location: ./src/pages/home.php");
}

$pagecssVersion = filemtime('styles/custom/pages/login-style.css');

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Manager</title>
    <?php include_once './assets/fonts/google-fonts.php' ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles/bootstrap/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="styles/custom/pages/login-style.css" type="text/css">
    <link rel="stylesheet" href="<?php echo 'styles/custom/pages/login-style.css?id=' . $pagecssVersion ?>" type="text/css">
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
                        <a href="./src/pages/login/forgot-password.php" class="login-text forgot-password">I forgot my password</a>
                        <hr class="my-4">
                        <label class="login-text">No account yet? <a href="src/pages/login/registration.php" class="no-account">Click here to create</a></label>
                    </div>
                </div>
            </div>
        </div>
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
                http.open("POST", "./src/process/login.php");
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
    <script src="https://kit.fontawesome.com/dab8986b00.js" crossorigin="anonymous"></script>
    <script src="./scripts/bootstrap/bootstrap.js"></script>
</body>

</html>