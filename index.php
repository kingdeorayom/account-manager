<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Manager</title>
    <?php include_once 'src/includes/google-fonts.php' ?>
    <link rel="stylesheet" href="styles/bootstrap/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="styles/custom/pages/login-style.css" type="text/css">
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
                    <form action="src/process/login.php" method="POST" id="loginForm">
                        <label class="login-text my-1">Email</label>
                        <input type="text" class="form-control mb-2" name="textFieldEmail" id="textFieldEmail">
                        <label class="login-text my-1">Password</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" name="textFieldPassword" id="textFieldPassword">
                            <span onclick="showHidePasswordLogin();" class="input-group-text"><i class="fas fa-eye" id="show_eye"></i><i class="fas fa-eye-slash d-none" id="hide_eye"></i></span>
                        </div>
                        <button class="btn text-white w-100 mt-3 mb-2 bg-success" type="submit" name="buttonLogin" id="buttonLogin">Login</button>
                    </form>
                    <div class="text-center py-2">
                        <a href="#" style="text-decoration: none; color: darkgreen" class="login-text">I forgot my password</a>
                        <hr class="my-4">
                        <label class="login-text">No account yet? <a href="src/pages/login/registration.php" style="text-decoration: none; color: green">Click here to create</a></label>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        function showHidePasswordLogin() {
            var textFieldPasswordInputType = document.getElementById("textFieldPassword");
            var show_eye = document.getElementById("show_eye");
            var hide_eye = document.getElementById("hide_eye");
            hide_eye.classList.remove("d-none");
            if (textFieldPasswordInputType.type === "password") {
                textFieldPasswordInputType.type = "text";
                show_eye.style.display = "none";
                hide_eye.style.display = "block";
            } else {
                textFieldPasswordInputType.type = "password";
                show_eye.style.display = "block";
                hide_eye.style.display = "none";
            }
        }

        function showHidePasswordRegistration() {
            var textFieldPasswordInputType = document.getElementById("textFieldPassword");
            var textFieldConfirmPasswordInputType = document.getElementById("textFieldConfirmPassword");
            if (textFieldPasswordInputType.type === "password") {
                textFieldPasswordInputType.type = "text";
                textFieldConfirmPasswordInputType.type = "text";
            } else {
                textFieldPasswordInputType.type = "password";
                textFieldConfirmPasswordInputType.type = "password";
            }
        }
    </script>
    <script src="https://kit.fontawesome.com/dab8986b00.js" crossorigin="anonymous"></script>
</body>

</html>