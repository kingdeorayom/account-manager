<?php
session_start();

include '../includes/connection.php';

if (!isset($_SESSION['toVerify'])) {
    header("location: ../../index.php");
    exit();
} else {
    $userInputVerification = $_POST['textFieldVerificationCode'];
    $verificationCode = $_SESSION['verificationCode'];

    if ($userInputVerification == $verificationCode) {
        $_SESSION['resetPassword'] = true;
        header("location: ../pages/login/reset-password.php");
    } else {
        $_SESSION['incorrectVerificationCode'] = "Incorrect verification code.";
        header("location: ../pages/login/password-reset-email-verification.php");
        exit();
    }
}



$connection->close();
