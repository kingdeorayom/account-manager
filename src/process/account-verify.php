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
        if ($statement = $connection->prepare('INSERT into users (name, email, password) VALUES(?, ?, ?)')) {
            // $_SESSION['password'] = password_hash($_SESSION['password'], PASSWORD_DEFAULT);
            $statement->bind_param('sss', $_SESSION['name'], $_SESSION['email'], $_SESSION['password']);
            $statement->execute();

            $_SESSION['registrationSuccessful'] = "Data inserted successfully";

            unset($_SESSION['name']);
            unset($_SESSION['email']);
            unset($_SESSION['password']);
            unset($_SESSION['toVerify']);

            header("location: ../../index.php");
        } else {
            echo 'Could not prepare statement';
        }
    } else {
        $_SESSION['incorrectVerificationCode'] = "Incorrect verification code.";
        header("location: ../pages/login/account-verification.php");
        exit();
    }
}

$connection->close();
