<?php

session_start();

include '../includes/connection.php';

if (!isset($_SESSION['email'])) {
    header("location: ../../index.php");
    exit();
}

if (mysqli_connect_errno()) {
    exit("Failed to connect to the database: " . mysqli_connect_error());
}

if (empty($_POST['textFieldPassword'] && $_POST['textFieldConfirmPassword'])) {
    $_SESSION['emptyInput'] = "Invalid input. Fill up all fields.";
    header("location: ../pages/login/reset-password.php");
    exit();
} else if (!empty($_POST['textFieldPassword'] && $_POST['textFieldConfirmPassword'])) {
    if ($_POST['textFieldPassword'] !== $_POST['textFieldConfirmPassword']) {
        $_SESSION['mismatchedPassword'] = "Password and confirm password does not match.";
        header("location: ../pages/login/reset-password.php");
        exit();
    }
}

if ($statement = $connection->prepare('UPDATE users SET password = ? WHERE email = ?')) {
    $_SESSION['password'] = $_POST['textFieldPassword'];
    // $_SESSION['password'] = password_hash($_POST['textFieldPassword'], PASSWORD_DEFAULT);
    $statement->bind_param('ss', $_SESSION['password'], $_SESSION['email']);
    $statement->execute();

    $_SESSION['passwordResetSuccessful'] = "Password changed successfully";

    unset($_SESSION['email']);
    unset($_SESSION['toVerify']);
    unset($_SESSION['resetPassword']);

    header("location: ../../index.php");
} else {
    echo 'Could not prepare statement';
}



$connection->close();
