<?php

session_start();

if (!isset($_SESSION['loggedin'])) {
    header('location: ./index.php');
}

include './process/connection.php';

$sql = "SELECT * FROM records WHERE user_id = " . $_SESSION['id'];
$result = $connection->query($sql);

$maincssVersion = filemtime('./assets/css/main.css');
$pagecssVersion = filemtime('./assets/css/record.css');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record</title>
    <script src="./node_modules/jquery/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo './assets/css/record.css?v=' . $pagecssVersion ?>" type="text/css">
    <link rel="stylesheet" href="./node_modules/sweetalert2/dist/sweetalert2.min.css">
</head>

<body>

    <main class="container p-5">

    </main>


    <script src="./node_modules/fontawesome/fontawesome.js" crossorigin="anonymous"></script>
    <script src="./node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="./node_modules/@popperjs/core/dist/umd/popper.js"></script>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="./scripts/tooltip.js"></script>
</body>

</html>