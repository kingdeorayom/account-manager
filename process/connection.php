<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'u231629948_acctmgr';
$DATABASE_PASS = 'Serkingd28();';
$DATABASE_NAME = 'u231629948_acctmgr';

$connection = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
