<?php

session_start();

include '../includes/connection.php';

if (!isset($_POST['textFieldEmail'])) {
    header("location: ../../index.php");
    exit();
}

if (mysqli_connect_errno()) {
    exit("Failed to connect to the database: " . mysqli_connect_error());
}
$_SESSION['email'] = $_POST['textFieldEmail'];
if (empty($_POST['textFieldEmail'])) {
    $_SESSION['emptyInput'] = "Invalid input. Fill up all fields.";
    header("location: ../pages/login/forgot-password.php");
    exit();
}

if (!filter_var($_POST['textFieldEmail'], FILTER_VALIDATE_EMAIL)) {
    $_SESSION['invalidEmail'] = "Invalid email.";
    header("location: ../pages/login/forgot-password.php");
    exit();
}

$email = $_POST['textFieldEmail'];
if ($statement = $connection->prepare('SELECT user_id, password FROM users WHERE email = ?')) {
    $statement->bind_param('s', $_POST['textFieldEmail']);
    $statement->execute();
    $statement->store_result();

    if ($statement->num_rows > 0) {
        $_SESSION['email'] = $_POST['textFieldEmail'];
        $_SESSION['toVerifyPasswordReset'] = true;
        header("location: ../pages/login/password-reset-email-verification.php");
        exit();
    } else {
        $_SESSION['emailDoesNotExists'] = "Email not found.";
        header("location: ../pages/login/forgot-password.php");
    }
    $statement->close();
} else {
    echo 'Could not prepare statement!';
}

$connection->close();
