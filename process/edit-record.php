<?php

include './connection.php';

session_start();

if (empty($_POST['textFieldPasswordRecords'] && $_POST['textFieldTitle'] && $_POST['textFieldAccountOwner'])) {
    $arr = array('response' => "empty_fields");
    header('Content-Type: application/json');
    echo json_encode($arr);
    exit();
}

$datetime = date('D, M j, Y, h:i:s A');

$statement = $connection->prepare('UPDATE records SET record_title = ?, account_owner = ?, username = ?, email = ?, password = ?, description = ?, date_modified = ? WHERE record_id = ?');
$statement->bind_param('ssssssss', $_POST['textFieldTitle'], $_POST['textFieldAccountOwner'], $_POST['textFieldUsername'], $_POST['textFieldEmailRecords'], $_POST['textFieldPasswordRecords'], $_POST['textFieldDescription'], $datetime, $_SESSION['recordId']);
$statement->execute();

$arr = array('response' => "success");
header('Content-Type: application/json');
echo json_encode($arr);

$connection->close();
