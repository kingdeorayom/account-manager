<?php

session_start();

if (!isset($_SESSION['loggedin'])) {
    header('location: ../../index.php');
}

include '../includes/connection.php';

$sql = "SELECT * FROM records WHERE user_id = " . $_SESSION['id'];
$result = $connection->query($sql);

$pagecssVersion = filemtime('../../styles/custom/pages/record-style.css');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record</title>
    <?php include_once '../../assets/fonts/google-fonts.php' ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../../styles/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="<?php echo '../../styles/custom/pages/record-style.css?id=' . $pagecssVersion ?>" type="text/css">
    <link rel="stylesheet" href="../../plugins/sweetalert2/package/dist/sweetalert2.css">
</head>

<body>

    <main class="container p-5">

    </main>


    <script src="https://kit.fontawesome.com/dab8986b00.js" crossorigin="anonymous"></script>
    <script src="../../plugins/sweetalert2/package/dist/sweetalert2.js"></script>
    <script src="../../scripts/popper/popper.min.js"></script>
    <script src="../../scripts/bootstrap/bootstrap.js"></script>
    <script src="../../scripts/custom/tooltip.js"></script>
</body>

</html>