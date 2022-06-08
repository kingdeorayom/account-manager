<?php
session_start();

include './connection.php';

if (mysqli_connect_errno()) {
    exit("Failed to connect to the database: " . mysqli_connect_error());
}

if (!isset($_POST['textFieldName'], $_POST['textFieldEmail'], $_POST['textFieldPassword'], $_POST['textFieldConfirmPassword'])) {

    header("location: ../login/registration.php");
    exit();
}

if (empty($_POST['textFieldName'] && $_POST['textFieldEmail'] && $_POST['textFieldPassword'] && $_POST['textFieldConfirmPassword'])) {
    // $_SESSION['emptyInput'] = "Invalid input. Fill up all fields.";
    // header("location: ../pages/login/registration.php");
    $arr = array('response' => "empty_fields");
    header('Content-Type: application/json');
    echo json_encode($arr);
    exit();
} else if (!empty($_POST['textFieldName'] && $_POST['textFieldEmail'] && $_POST['textFieldPassword'] && $_POST['textFieldConfirmPassword'])) {
    if ($_POST['textFieldPassword'] !== $_POST['textFieldConfirmPassword']) {
        // $_SESSION['mismatchedPassword'] = "Password and confirm password does not match.";
        // header("location: ../pages/login/registration.php");
        $arr = array('response' => "passwords_mismatch");
        header('Content-Type: application/json');
        echo json_encode($arr);
        exit();
    }
}


if (!filter_var($_POST['textFieldEmail'], FILTER_VALIDATE_EMAIL)) {
    // $_SESSION['invalidEmail'] = "Invalid email.";
    // header("location: ../pages/login/registration.php");
    $arr = array('response' => "invalid_email");
    header('Content-Type: application/json');
    echo json_encode($arr);
    exit();
}

$email = $_POST['textFieldEmail'];

if ($statement = $connection->prepare('SELECT user_id, password FROM users WHERE email = ?')) {
    $statement->bind_param('s', $_POST['textFieldEmail']);
    $statement->execute();
    $statement->store_result();

    if ($statement->num_rows > 0) {
        // $_SESSION['emailExists'] = "Duplicate email.";
        // header("location: ../pages/login/registration.php");
        $arr = array('response' => "email_exists");
        header('Content-Type: application/json');
        echo json_encode($arr);
    } else {
        $_SESSION['name'] = $_POST['textFieldName'];
        $_SESSION['email'] = $_POST['textFieldEmail'];
        $_SESSION['password'] = $_POST['textFieldPassword'];
        $_SESSION['toVerifyAccountCreation'] = true;

        // header("location: ../pages/login/account-verification.php");
        $arr = array('response' => "success");
        header('Content-Type: application/json');
        echo json_encode($arr);
        exit();
    }
    $statement->close();
} else {
    echo 'Could not prepare statement!';
}

$connection->close();
