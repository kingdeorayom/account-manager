<?php

session_start();

include_once '../includes/connection.php';

if (!isset($_POST['textFieldEmail'], $_POST['textFieldPassword'])) {
    exit('Please fill both the username and password fields!');
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

            header('location: ../pages/home.php');
            exit();
        } else {
            // Incorrect password
            echo 'Incorrect password!';
        }
    } else {
        // Incorrect email
        echo 'Incorrect email!';
    }

    $statement->close();
}
