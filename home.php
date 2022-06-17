<?php

session_start();

if (!isset($_SESSION['loggedin'])) {
    header('location: ./index.php');
}

include './process/connection.php';

$sql = "SELECT * FROM records WHERE user_id = " . $_SESSION['id'] . " ORDER BY record_id DESC LIMIT 4";
$result = $connection->query($sql);

$getName = "SELECT name FROM users WHERE user_id = '1'";
$getNameResult = $connection->query($getName);

$maincssVersion = filemtime('./assets/css/main.css');
$pagecssVersion = filemtime('./assets/css/home.css');
$pagePanelJSVersion = filemtime('./scripts/panels.js');
$pageaddFormJSVersion = filemtime('./scripts/addForm.js');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Manager</title>
    <script src="./node_modules/jquery/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo './assets/css/home.css?v=' . $pagecssVersion ?>" type="text/css">
    <link rel="stylesheet" href="./node_modules/sweetalert2/dist/sweetalert2.min.css">

</head>

<body>
    <main class="container p-5">

        <div class="row py-2 text-center">
            <i class="fas fa-key text-warning fa-2x mb-2"></i>
            <h3 class="login-text">Account Manager</h3>
            <p class="login-text">Store and manage your accounts—all in one place</p>
        </div>

        <div class="row my-5">
            <div class="col-6 navLinkRecords text-center py-2">
                <label id="navLinkRecords" class="py-1 fw-bold">Records</label>
            </div>
            <div class="col-6 navLinkAccount text-center py-2">
                <label id="navLinkAccount" class="py-1 fw-bold">Account</label>
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
                                                <li class="fw-bold">Date Added: </li>
                                                <li>' . $row['date_added'] . '</li>
                                            </ul>
                                            
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
                            <div class="row">
                                <div class="col-sm-12 col-md-6 my-1">
                                    <label class="form-label">Title <i class="fas fa-question-circle text-secondary" data-bs-toggle="tooltip" data-bs-placement="right" title="Great titles are clear and concise."></i></label>
                                    <input type="text" class="form-control" name="textFieldTitle" id="textFieldTitle" required>
                                </div>
                                <div class="col-sm-12 col-md-6 my-1">
                                    <label class="form-label">Account Owner</label>
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
                                    <label class="form-label">Password</label>
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


                <div class="accountDetails">
                    <h2>Account Details</h2>
                    <div class="row">

                        <div class="col my-1">
                            <label class="form-label my-1">Name</label>
                            <input type="text" class="form-control" value="<?php

                                                                            if ($getNameResult->num_rows > 0) {
                                                                                // output data of each row
                                                                                while ($row = $getNameResult->fetch_assoc()) {
                                                                                    echo $row["name"];
                                                                                }
                                                                            }

                                                                            ?>" disabled>
                            <label class="form-label my-1">Email Address</label>
                            <input type="text" class="form-control" value="<?php echo $_SESSION['email'] ?>" disabled>
                        </div>
                        <div class="col-sm-12 my-4">
                            <div class="text-end">
                                <a href="./process/logout.php" class="button-logout text-danger">Log out</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accountPreferenceForm my-3">
                    <h2>Account Preferences</h2>
                    <form onsubmit="submitAddForm(event)" name="account-preference-form">
                        <div class="row">
                            <div class="col my-1">
                                <label class="form-label my-1">Current Password</label>
                                <input type="text" class="form-control" name="textFieldCurrentPassword" id="textFieldCurrentPassword" required>
                                <label class="form-label my-1">New Password</label>
                                <input type="text" class="form-control" name="textFieldNewPassword" id="textFieldNewPassword" required>
                            </div>
                            <div class="col-sm-12 my-4">
                                <div class="text-end">
                                    <button class="btn btn-secondary my-1" type="button" id="buttonClearEntries">Clear entries</button>
                                    <button class="btn btn-success my-1" type="submit">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>


            </div>

        </div>
    </main>

    <script src="<?php echo './scripts/addForm.js?v=' . $pageaddFormJSVersion ?>"></script>
    <script src="<?php echo './scripts/panels.js?v=' . $pagePanelJSVersion ?>"></script>
    <script src="./node_modules/fontawesome/fontawesome.js" crossorigin="anonymous"></script>
    <script src="./node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="./node_modules/@popperjs/core/dist/umd/popper.js"></script>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="./scripts/tooltip.js"></script>

</body>

</html>