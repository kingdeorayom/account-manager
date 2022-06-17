<?php

include './connection.php';

session_start();

$statement = $connection->prepare('DELETE FROM records WHERE record_id = ?');
$statement->bind_param('s', $_SESSION['recordId']);
$statement->execute();

$arr = array('response' => "success");
header('Content-Type: application/json');
echo json_encode($arr);

$connection->close();
