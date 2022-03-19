<?php

session_start();

if (!isset($_SESSION['loggedin'])) {
    header('location: ../../index.php');
}

include '../includes/connection.php';

$sql = "SELECT * FROM records WHERE user_id = " . $_SESSION['id'];
$result = $connection->query($sql);

$pagecssVersion = filemtime('../../styles/custom/pages/view-style.css');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Records</title>
    <?php include_once '../../assets/fonts/google-fonts.php' ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../../styles/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="<?php echo '../../styles/custom/pages/view-style.css?id=' . $pagecssVersion ?>" type="text/css">
    <link rel="stylesheet" href="../../plugins/sweetalert2/package/dist/sweetalert2.css">
</head>

<body>

    <main class="container p-5">

        <div class="row">
            <div id="recordsPanel">

                <div class="row records">
                    <div class="text-start">
                        <a href="./home.php"><button class="btn btn-link go-back">Go back</button></a>
                    </div>
                    <h2 class="my-4">All Records</h2>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            echo '<div class="col d-flex justify-content-center my-2">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                            <h5 class="card-title fw-bold">' . $row['record_title'] . '</h5>
                            <hr>
                            <ul>
                                <li class="fw-bold">Account Owner: </li>
                                <li>' . $row['account_owner'] . '</li>

                                <li class="fw-bold">Username: </li>
                                <li>' . $row['username'] . '</li>

                                <li class="fw-bold">Email: </li>
                                <li>' . $row['email'] . '</li>

                                <li class="fw-bold">Password: </li>
                                <li>' . $row['password'] . '</li>

                                <li class="fw-bold">Description: </li>
                                <li>' . $row['description'] . '</li>

                                <li class="fw-bold">Date Added: </li>
                                <li>' . $row['date_added'] . '</li>
                                <li class="fw-bold">Date Modified: </li>
                                <li>' . $row['date_modified'] . '</li>
                            </ul>
                            <hr>
                            <div class="row text-center">
                                <div class="col">
                                    <i class="fas fa-edit text-secondary h5"></i> Edit
                                </div>
                                <div class="col">
                                    <i class="fas fa-trash-alt text-danger h5"></i> Delete
                                </div>
                            </div>
                            </div>
                        </div>
                </div>';
                        }
                    } else {
                        echo '<h3 class="my-4 text-center text-secondary">No records saved yet.</h3>';
                    }
                    $connection->close();
                    ?>
                </div>
            </div>
        </div>

    </main>

    <script src="https://kit.fontawesome.com/dab8986b00.js" crossorigin="anonymous"></script>
    <script src="../../plugins/sweetalert2/package/dist/sweetalert2.js"></script>
    <script src="../../scripts/popper/popper.min.js"></script>
    <script src="../../scripts/bootstrap/bootstrap.js"></script>
    <script src="../../scripts/custom/tooltip.js"></script>
</body>

</html>