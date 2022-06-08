<?php
session_start();

include './connection.php';

if (!isset($_SESSION['toVerifyPasswordReset'])) {
    header("location: ../index.php");
    exit();
}

if (empty($_POST['textFieldVerificationCode'])) {
    $arr = array('response' => "empty_fields");
    header('Content-Type: application/json');
    echo json_encode($arr);
    exit();
} else {
    $userInputVerification = $_POST['textFieldVerificationCode'];
    $verificationCode = $_SESSION['verificationCode'];

    if ($userInputVerification == $verificationCode) {
        $_SESSION['resetPassword'] = true;

        $arr = array('response' => "verification_success");
        header('Content-Type: application/json');
        echo json_encode($arr);
        // header("location: ../pages/login/reset-password.php");
    } else {
        $_SESSION['incorrectVerificationCode'] = "Incorrect verification code.";
        $arr = array('response' => "incorrect_credentials");
        header('Content-Type: application/json');
        echo json_encode($arr);
        // header("location: ../pages/login/password-reset-email-verification.php");
        // exit();
    }
}



$connection->close();
