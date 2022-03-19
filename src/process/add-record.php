<?php

include '../includes/connection.php';

session_start();

if (empty($_POST['textFieldPasswordRecords'] && $_POST['textFieldTitle'])) {
    $arr = array('response' => "empty_fields");
    header('Content-Type: application/json');
    echo json_encode($arr);
    exit();
}

$id = $_SESSION['id'];
$datetime = date('Y-m-d h:i:s');

$statement = $connection->prepare('INSERT into records (user_id, record_title, account_owner, service_name, username, email, password, description, date_added) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)');
$statement->bind_param('sssssssss', $id, $_POST['textFieldTitle'], $_POST['textFieldAccountOwner'], $_POST['textFieldServiceName'], $_POST['textFieldUsername'], $_POST['textFieldEmailRecords'], $_POST['textFieldPasswordRecords'], $_POST['textFieldDescription'], $datetime);
$statement->execute();

$arr = array('response' => "success");
header('Content-Type: application/json');
echo json_encode($arr);

$connection->close();
