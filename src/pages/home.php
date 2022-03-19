<?php

session_start();

if (!isset($_SESSION['loggedin'])) {
    header('location: ../../index.php');
}

include '../includes/connection.php';

$sql = "SELECT * FROM records WHERE user_id = " . $_SESSION['id'] . " ORDER BY date_added DESC LIMIT 4";
$result = $connection->query($sql);

$pagecssVersion = filemtime('../../styles/custom/pages/home-style.css');
$pagePanelJSVersion = filemtime('../../scripts/custom/panels.js');
$pageaddFormJSVersion = filemtime('../../scripts/custom/addForm.js');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Manager</title>
    <?php include_once '../../assets/fonts/google-fonts.php' ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../../styles/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="<?php echo '../../styles/custom/pages/home-style.css?id=' . $pagecssVersion ?>" type="text/css">
    <link rel="stylesheet" href="../../plugins/sweetalert2/package/dist/sweetalert2.css">

</head>

<body>
    <main class="container p-5">

        <div class="row py-2 text-center">
            <i class="fas fa-key text-warning fa-2x mb-2"></i>
            <h3 class="login-text">Account Manager</h3>
            <p class="login-text">Store and manage your accounts—all in one place</p>
        </div>

        <div class="row my-5">
            <div class="col-4 navLinkRecords text-center py-2">
                <label id="navLinkRecords" class="py-1 fw-bold">Records</label>
            </div>
            <div class="col-4 navLinkAccount text-center py-2">
                <label id="navLinkAccount" class="py-1 fw-bold">Account</label>
            </div>
            <div class="col-4 navLinkSettings text-center py-2">
                <label id="navLinkSettings" class="py-1 fw-bold">Settings</label>
            </div>
        </div>

        <div class="row my-5">
            <div id="recordsPanel">

                <div class="row records">
                    <h2 class="mb-4">Recently Added</h2>
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
                                                <li class="fw-bold">Date Added: </li>
                                                <li>' . $row['date_added'] . '</li>
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
                    } //<a href="./record.php?id=' . $row['record_id'] . '"><button class="btn btn-success w-100 my-2">View record</button></a>
                    $connection->close();
                    ?>
                    <div class="text-end">
                        <a href="./view.php"><button class="btn btn-link my-2 see-all">See all</button></a>
                    </div>
                </div>

                <div id="addNewRecordPanel" class="my-3">
                    <h2>Add a new record</h2>
                    <div class="row py-2" id="alert-container-add-record">
                        <!--  -->
                    </div>
                    <div class="addForm">
                        <form onsubmit="submitAddForm(event)" name="add-form">
                            <!-- <form action="../process/add-record.php" method="POST"> -->
                            <div class="row">
                                <div class="col-sm-12 col-md-6 my-1">
                                    <label class="form-label">Title <i class="fas fa-question-circle text-secondary" data-bs-toggle="tooltip" data-bs-placement="right" title="Great titles are clear and concise."></i> <span class="badge bg-danger">Required</span></label>
                                    <input type="text" class="form-control" name="textFieldTitle" id="textFieldTitle" required>
                                </div>
                                <div class="col-sm-12 col-md-6 my-1">
                                    <label class="form-label">Account Owner <span class="badge bg-danger">Required</span></label>
                                    <input type="text" class="form-control" name="textFieldAccountOwner" id="textFieldAccountOwner" required>
                                </div>
                                <div class="col-sm-12 col-md-6 my-1">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control" name="textFieldUsername" id="textFieldUsername">
                                </div>
                                <div class="col-sm-12 col-md-6 my-1">
                                    <label class="form-label">Email Address</label>
                                    <input type="text" class="form-control" name="textFieldEmailRecords" id="textFieldEmailRecords">
                                </div>
                                <div class="col-sm-12 col-md-6 my-1">
                                    <label class="form-label">Password <span class="badge bg-danger">Required</span></label>
                                    <input type="text" class="form-control" name="textFieldPasswordRecords" id="textFieldPasswordRecords" required>
                                </div>
                                <div class="col-sm-12 col-md-6 my-1">
                                    <label class="form-label">Description <i class="fas fa-question-circle text-secondary" data-bs-toggle="tooltip" data-bs-placement="right" title="Great descriptions are clear and concise."></i></label>
                                    <input type="text" class="form-control" name="textFieldDescription" id="textFieldDescription">
                                </div>
                                <div class="col-sm-12 my-4">
                                    <div class="text-end">
                                        <button class="btn btn-secondary my-1" type="button" id="buttonClearEntries">Clear entries</button>
                                        <button class="btn btn-success my-1" type="submit">Add Record</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="accountPanel" hidden>
                <h2>Account Details</h2>
            </div>
            <div id="settingsPanel" hidden>
                <h2>Settings</h2>
                <button class="btn btn-link"><a href="../process/logout.php">Log out</a></button>
            </div>
        </div>
    </main>

    <script src="<?php echo '../../scripts/custom/addForm.js?id=' . $pageaddFormJSVersion ?>"></script>
    <script src="<?php echo '../../scripts/custom/panels.js?id=' . $pagePanelJSVersion ?>"></script>
    <script src="https://kit.fontawesome.com/dab8986b00.js" crossorigin="anonymous"></script>
    <script src="../../plugins/sweetalert2/package/dist/sweetalert2.js"></script>
    <script src="../../scripts/popper/popper.min.js"></script>
    <script src="../../scripts/bootstrap/bootstrap.js"></script>
    <script src="../../scripts/custom/tooltip.js"></script>
</body>

</html>