<?php
session_start();

include './connection.php';

if (!isset($_SESSION['toVerifyAccountCreation'])) {
    header("location: ../index.php");
    exit();
} else {

    if (empty($_POST['textFieldVerificationCode'])) {
        $arr = array('response' => "empty_fields");
        header('Content-Type: application/json');
        echo json_encode($arr);
        exit();
    }

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
            unset($_SESSION['toVerifyAccountCreation']);
            unset($_SESSION['verificationCode']);

            $arr = array('response' => "login_success");
            header('Content-Type: application/json');
            echo json_encode($arr);

            // header("location: ../../index.php");
        } else {
            $arr = array('response' => "incorrect_credentials");
            header('Content-Type: application/json');
            echo json_encode($arr);
        }
    } else {
        $arr = array('response' => "incorrect_credentials");
        header('Content-Type: application/json');
        echo json_encode($arr);
    }
}

$connection->close();
