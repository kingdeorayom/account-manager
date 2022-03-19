<?php

session_start();

if (!isset($_SESSION['loggedin'])) {
    header('location: ../../index.php');
}

include '../includes/connection.php';

$sql = "SELECT * FROM records WHERE user_id = " . $_SESSION['id'];
$result = $connection->query($sql);

$pagecssVersion = filemtime('../../styles/custom/pages/home-style.css');

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
                <label id="navLinkRecords" class="py-1">Records</label>
            </div>
            <div class="col-4 navLinkAccount text-center py-2">
                <label id="navLinkAccount" class="py-1">Account</label>
            </div>
            <div class="col-4 navLinkSettings text-center py-2">
                <label id="navLinkSettings" class="py-1">Settings</label>
            </div>
        </div>

        <div class="row my-5">

            <div id="recordsPanel">

                <h2>All Records</h2>

                <div class="row records my-5">
                    <?php

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            echo '<div class="col d-flex justify-content-center my-2">
                                    <a href="#" class="card-link">
                                        <div class="card" style="width: 18rem;">
                                            <div class="card-body">
                                            <h5 class="card-title fw-bold">' . $row['record_title'] . '</h5>
                                            <hr>
                                            <ul>
                                                <li class="fw-bold">Account Owner: </li>
                                                <li> ' . $row['account_owner'] . '</li>
                                                <li class="fw-bold">Service Name: </li>
                                                <li> ' . $row['service_name'] . '</li>
                                                <li class="fw-bold">Date Added: </li>
                                                <li> ' . $row['date_added'] . '</li>
                                                <li class="fw-bold">Date Modified: </li>
                                                <li> ' . $row['date_modified'] . '</li>
                                            </ul>
                                            <hr>
                                            <button class="btn btn-success w-100 my-2">View</button>
                                            </div>
                                        </div>
                                    </a>
                                </div>';
                        }
                    } else {
                        echo '<h3 class="my-4 text-center text-secondary">No records saved yet.</h3>';
                    }
                    $connection->close();
                    ?>
                </div>


                <div class="my-2" id="addNewRecordPanel">

                    <h2 class="my-3">Add a record</h2>

                    <div class="row py-2" id="alert-container-add-record">
                        <!--  -->
                    </div>

                    <div class="addForm">
                        <form onsubmit="submitAddForm(event)" name="add-form">
                            <!-- <form action="../process/add-record.php" method="POST"> -->
                            <div class="row">
                                <div class="col-sm-12 my-1">
                                    <label class="form-label">Title <i class="fas fa-question-circle text-secondary" data-bs-toggle="tooltip" data-bs-placement="right" title="Great titles are clear and concise."></i> <span class="badge bg-danger">Required</span></label>
                                    <input type="text" class="form-control" name="textFieldTitle" id="textFieldTitle" required>
                                </div>
                                <div class="col-sm-12 col-md-6 my-1">
                                    <label class="form-label">Account Owner</label>
                                    <input type="text" class="form-control" name="textFieldAccountOwner" id="textFieldAccountOwner">
                                </div>
                                <div class="col-sm-12 col-md-6 my-1">
                                    <label class="form-label">Service Name</label>
                                    <input type="text" class="form-control" name="textFieldServiceName" id="textFieldServiceName">
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
                <h2>Account</h2>
            </div>
            <div id="settingsPanel" hidden>
                <h2>Settings</h2>
                <button class="btn btn-link"><a href="../process/logout.php">Log out</a></button>
            </div>
        </div>

    </main>

    <script>
        var alertAddRecord = document.getElementById('alert-container-add-record');

        function submitAddForm(event) {
            event.preventDefault();
            var addForm = document.forms.namedItem('add-form');
            var addRecord = new FormData(addForm);
            postAddRecord(addRecord).then(data => checkResponseAddRecord(JSON.parse(data)))
        }

        function postAddRecord(data) {
            return new Promise((resolve, reject) => {
                var http = new XMLHttpRequest();
                http.open("POST", "../process/add-record.php");
                http.onload = () => http.status == 200 ? resolve(http.response) : reject(Error(http.statusText));
                http.onerror = (e) => reject(Error(`Networking error: ${e}`));
                http.send(data)
            })
        }

        function checkResponseAddRecord(data) {
            if (data.response === "success") {
                Swal.fire(
                    'Record saved successfully!',
                    'You may edit your record for any input mistake.',
                    'success'
                )
                // alertAddRecord.innerHTML = `<div class="alert alert-success alert-dismissible fade show" role="alert">Record added successfully!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`
                $("#textFieldTitle, #textFieldAccountOwner, #textFieldServiceName, #textFieldUsername, #textFieldEmailRecords, #textFieldPasswordRecords, #textFieldDescription").val("");
                $(".records").load(location.href + " .records");
            }
            if (data.response === "empty_fields") {
                alertAddRecord.innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Invalid input!</strong> Please fill up all the required fields.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`
            }
        }
    </script>

    <script>
        $(document).ready(function() {

            /* on load */
            $(".navLinkRecords").css({
                "border-bottom": "3px solid green",
            });
            /* on load */

            $("#navLinkRecords, .navLinkRecords").click(function() {
                $("#recordsPanel").prop("hidden", false);
                $("#accountPanel, #settingsPanel").prop("hidden", true);

                $(".navLinkRecords").css({
                    "border-bottom": "3px solid green",
                });
                $(".navLinkAccount, .navLinkSettings").css({
                    "border-bottom": "3px none green",
                });
            });

            $("#navLinkAccount, .navLinkAccount").click(function() {
                $("#accountPanel").prop("hidden", false);
                $("#recordsPanel, #settingsPanel").prop("hidden", true);

                $(".navLinkAccount").css({
                    "border-bottom": "3px solid green",
                });
                $(".navLinkRecords, .navLinkSettings").css({
                    "border-bottom": "3px none green",
                });
            });

            $("#navLinkSettings, .navLinkSettings").click(function() {
                $("#settingsPanel").prop("hidden", false);
                $("#accountPanel, #recordsPanel").prop("hidden", true);

                $(".navLinkSettings").css({
                    "border-bottom": "3px solid green",
                });
                $(".navLinkRecords, .navLinkAccount").css({
                    "border-bottom": "3px none green",
                });
            });

            $("#buttonClearEntries").click(function() {
                $("#textFieldAccountOwner, #textFieldServiceName, #textFieldUsername, #textFieldEmailRecords, #textFieldPasswordRecords, #textFieldDescription").val("");
            });

        });
    </script>

    <script src="https://kit.fontawesome.com/dab8986b00.js" crossorigin="anonymous"></script>
    <script src="../../plugins/sweetalert2/package/dist/sweetalert2.js"></script>
    <script src="../../scripts/popper/popper.min.js"></script>
    <script src="../../scripts/bootstrap/bootstrap.js"></script>
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
</body>

</html>