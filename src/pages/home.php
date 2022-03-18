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

                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover text-center my-4" id="recordTable">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Account Owner</th>
                                <th scope="col">Service Name</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Password</th>
                                <th scope="col">Description</th>
                                <th scope="col">Date Added</th>
                                <th scope="col">Date Modified</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr id = " . $row["record_id"];

                                    echo "><td>" . $row["account_owner"] . "</td><td>" . $row["service_name"] . "</td><td>" .  $row["username"] . "</td><td>" . $row["email"] . "</td><td>" . $row["password"] . "</td><td>" .  $row["description"] . "</td><td>" . $row["date_added"] . "</td><td>" . $row["date_modified"] . "</td></tr>";
                                }
                            } else {
                                echo '<tr><td colspan="8">No records saved yet!</td></tr>';
                            }
                            $connection->close();
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="my-4" id="addNewRecordPanel">

                    <h2 class="my-3">Add or edit a record</h2>

                    <div class="row py-2" id="alert-container-add-record">
                        <!--  -->
                    </div>

                    <div class="addForm">
                        <form onsubmit="submitAddForm(event)" name="add-form">
                            <!-- <form action="../process/add-record.php" method="POST"> -->
                            <div class="row">
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
        var table = document.getElementById('recordTable');
        for (var i = 1; i < table.rows.length; i++) {
            table.rows[i].onclick = function() {
                document.getElementById("textFieldAccountOwner").value = this.cells[0].innerHTML;
                document.getElementById("textFieldServiceName").value = this.cells[1].innerHTML;
                document.getElementById("textFieldUsername").value = this.cells[2].innerHTML;
                document.getElementById("textFieldEmailRecords").value = this.cells[3].innerHTML;
                document.getElementById("textFieldPasswordRecords").value = this.cells[4].innerHTML;
                document.getElementById("textFieldDescription").value = this.cells[5].innerHTML;
            };
        }
    </script>

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
                alertAddRecord.innerHTML = `<div class="alert alert-success alert-dismissible fade show" role="alert">Record added successfully!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`
                $("#textFieldAccountOwner, #textFieldServiceName, #textFieldUsername, #textFieldEmailRecords, #textFieldPasswordRecords, #textFieldDescription").val("");
                // $(".table").load(location.href + " .table");
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