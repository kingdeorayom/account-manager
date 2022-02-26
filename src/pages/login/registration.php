<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an account</title>
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
                        <i class="fas fa-key text-warning fa-2x mb-1"></i>
                        <h3 class="login-text">Account Manager</h3>
                        <p class="login-text">Register for an account</p>
                    </div>
                    <form action="#" method="POST">
                        <label class="login-text my-2">Name</label>
                        <input type="text" class="form-control " name="textFieldName" id="textFieldName">
                        <label class="login-text my-2">Email</label>
                        <input type="text" class="form-control" name="textFieldEmail" id="textFieldEmail">
                        <label class="login-text my-2">Password</label>
                        <input type="password" class="form-control" name="textFieldPassword" id="textFieldPassword">
                        <label class="login-text my-2">Confirm Password</label>
                        <input type="password" class="form-control mb-3" name="textFieldConfirmPassword" id="textFieldConfirmPassword">
                        <div class="form-check">
                            <input onclick="showHidePasswordRegistration();" class="form-check-input" type="checkbox" value="" id="checkBoxShowHidePassword">
                            <label class="form-check-label" for="checkBoxShowHidePassword">Show/Hide Password</label>
                        </div>
                        <button class="btn text-white w-100 mt-3 bg-success" type="submit" name="buttonRegister" id="buttonRegister">Register</button>
                    </form>
                    <div class="text-center py-2">
                        <hr class="my-4">
                        <label class="login-text">Aready have an account? <a href="../../../index.php" style="text-decoration: none; color: green">Click here to login</a></label>
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