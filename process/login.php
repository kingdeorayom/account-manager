<?php

session_start();

include_once './connection.php';

if (!isset($_POST['textFieldEmail'], $_POST['textFieldPassword'])) {
    header("location: ../index.php");
    exit();
}

if (empty($_POST['textFieldEmail'] && $_POST['textFieldPassword'])) {
    // $_SESSION['emptyInput'] = "Invalid input. Fill up all fields.";
    // header("location: ../../index.php");
    $arr = array('response' => "empty_fields");
    header('Content-Type: application/json');
    echo json_encode($arr);
    exit();
}


if ($statement = $connection->prepare('SELECT user_id, password FROM users WHERE email = ?')) {
    $statement->bind_param('s', $_POST['textFieldEmail']);
    $statement->execute();
    $statement->store_result();

    if ($statement->num_rows > 0) {
        $statement->bind_result($id, $password);
        $statement->fetch();

        if ($_POST['textFieldPassword'] === $password) {
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['textFieldEmail'];
            $_SESSION['id'] = $id;

            // header('location: ../pages/home.php');
            // exit();
            $arr = array('response' => "login_success");
            header('Content-Type: application/json');
            echo json_encode($arr);
        } else {
            // Incorrect password
            $arr = array('response' => "incorrect_credentials");
            header('Content-Type: application/json');
            echo json_encode($arr);
        }
    } else {
        // Incorrect email
        $arr = array('response' => "incorrect_credentials");
        header('Content-Type: application/json');
        echo json_encode($arr);
    }

    $statement->close();
}
