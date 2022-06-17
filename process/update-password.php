<?php

include './connection.php';

session_start();

if (empty($_POST['textFieldCurrentPassword'] && $_POST['textFieldNewPassword'])) {
    $arr = array('response' => "empty_fields");
    header('Content-Type: application/json');
    echo json_encode($arr);
    exit();
}

if (isset($_POST['textFieldCurrentPassword'], $_POST['textFieldNewPassword'])) {
    // update password
    $statement = $connection->prepare("SELECT password FROM users WHERE user_id = ?");
    $statement->bind_param("i", $_SESSION['id']);
    $statement->execute();
    $result = $statement->get_result();
    $current = $result->fetch_assoc();
    $statement->close();

    if ($_POST['textFieldCurrentPassword'] === $current['password']) {
        $newPassword = $_POST['textFieldNewPassword'];
        $statement = $connection->prepare("UPDATE users SET password = ?  WHERE user_id = ?");
        $statement->bind_param("si", $newPassword, $_SESSION['id']);
        if ($statement->execute()) {
            $arr = array('response' => "success");
            header('Content-Type: application/json');
            echo json_encode($arr);
        }
        $statement->close();
    } else {
        $arr = array('response' => "incorrect_current_password");
        header('Content-Type: application/json');
        echo json_encode($arr);
    }
}
