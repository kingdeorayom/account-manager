<?php

session_start();

if (!isset($_SESSION['loggedin'])) {
    header('location: ./index.php');
}

include './process/connection.php';

$sql = "SELECT * FROM records WHERE user_id = " . $_SESSION['id'] . " ORDER BY record_id DESC";
$result = $connection->query($sql);

$maincssVersion = filemtime('./assets/css/main.css');
$pagecssVersion = filemtime('./assets/css/view.css');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Records</title>
    <script src="./node_modules/jquery/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo './assets/css/view.css?v=' . $pagecssVersion ?>" type="text/css">
    <link rel="stylesheet" href="./node_modules/sweetalert2/dist/sweetalert2.min.css">
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

                            echo '<div class="col-sm-12 col-md-6 d-flex justify-content-center my-2">
                        <div class="card" style="width: 100%;">
                            <div class="card-body">

                            <div class="row">
                            
                                <div class="col d-flex align-items-center">
                                    <h5 class="card-title fw-bold">' . $row['record_title'] . '</h5>
                                </div>
                                <div class="col text-end">
                                <a href="./record.php?id=' . $row['record_id'] . '"><button class="btn btn-link text-secondary edit">Edit</button></a>
                                </div>

                            </div>

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

    <script src="./node_modules/fontawesome/fontawesome.js" crossorigin="anonymous"></script>
    <script src="./node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="./node_modules/@popperjs/core/dist/umd/popper.js"></script>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="./scripts/tooltip.js"></script>
</body>

</html>