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
                    <div class="row py-2" id="alert-container-register">
                        <!--  -->
                    </div>
                    <form onsubmit="submitRegister(event)" name="register-form">
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
                        <label class="login-text">Already have an account? <a href="../../../index.php" style="text-decoration: none; color: green">Click here to login</a></label>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
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
    <script>
        var alertRegister = document.getElementById('alert-container-register');

        function submitRegister(event) {
            event.preventDefault();
            var registerForm = document.forms.namedItem('register-form');
            var registerData = new FormData(registerForm);
            postRegister(registerData).then(data => checkResponseRegister(JSON.parse(data)))
        }

        function postRegister(data) {
            return new Promise((resolve, reject) => {
                var http = new XMLHttpRequest();
                http.open("POST", "../../process/register.php");
                http.onload = () => http.status == 200 ? resolve(http.response) : reject(Error(http.statusText));
                http.onerror = (e) => reject(Error(`Networking error: ${e}`));
                http.send(data)
            })
        }

        function checkResponseRegister(data) {
            console.log(data)
            if (data.response === "empty_fields") {
                alertRegister.innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Invalid input!</strong> Please fill up all the fields.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`
            }
            if (data.response === "passwords_mismatch") {
                alertRegister.innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Invalid input!</strong> <code>Password</code> and <code>Confirm Password</code> do not match.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`
            }
            if (data.response === "not_school_email") {
                alertRegister.innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Invalid email!</strong> Please use your school email.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`
            }
            if (data.response === "email_exists") {
                alertRegister.innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>An account with this email already exists.</strong> Try another one.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`
            }
            if (data.response === "invalid_email") {
                alertRegister.innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Invalid input!</strong> Please enter a valid e-mail.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`
            }
            if (data.response === "success") {
                window.location = "account-verification.php";
            }
        }
    </script>
    <script src="https://kit.fontawesome.com/dab8986b00.js" crossorigin="anonymous"></script>
</body>

</html>