<?php

session_start();

if (!isset($_SESSION['loggedin'])) {
    header('location: ./index.php');
}

include './process/connection.php';

$sql = "SELECT * FROM records WHERE record_id = " . $_GET['id'];
$result = $connection->query($sql);

$_SESSION['recordId'] = $_GET['id'];

$getTitle = "SELECT record_title FROM records WHERE record_id = " . $_GET['id'];
$getTitleResult = $connection->query($getTitle);

$maincssVersion = filemtime('./assets/css/main.css');
$pagecssVersion = filemtime('./assets/css/record.css');
$pageeditFormJSVersion = filemtime('./scripts/editForm.js');
$pagedeleteRecordJSVersion = filemtime('./scripts/deleteRecord.js');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if ($getTitleResult->num_rows > 0) {
                while ($row = $getTitleResult->fetch_assoc()) {
                    echo $row["record_title"];
                }
            }
            ?></title>
    <script src="./node_modules/jquery/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo './assets/css/record.css?v=' . $pagecssVersion ?>" type="text/css">
    <link rel="stylesheet" href="./node_modules/sweetalert2/dist/sweetalert2.min.css">

    <link rel="apple-touch-icon" sizes="180x180" href="./apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon-16x16.png">
    <link rel="manifest" href="./site.webmanifest">
    <link rel="mask-icon" href="./safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

</head>

<body>

    <main class="container p-5">

        <div class="row">
            <div id="recordsPanel">

                <div class="row records">
                    <div class="text-start">
                        <a href="./view.php"><button class="btn btn-link go-back">Go back</button></a>
                    </div>

                    <div id="editRecordPanel" class="my-3">
                        <h2>Edit record</h2>
                        <div class="row py-2" id="alert-container-edit-record">
                            <!--  -->
                        </div>

                        <?php

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {

                                echo '<div class="editForm">
                                <form onsubmit="submitEditForm(event)" name="edit-form">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 my-1">
                                            <label class="form-label">Title <i class="fas fa-question-circle text-secondary" data-bs-toggle="tooltip" data-bs-placement="right" title="Great titles are clear and concise."></i></label>
                                            <input type="text" class="form-control" name="textFieldTitle" id="textFieldTitle" required value="' . $row['record_title'] . '">
                                        </div>
                                        <div class="col-sm-12 col-md-6 my-1">
                                            <label class="form-label">Account Owner</label>
                                            <input type="text" class="form-control" name="textFieldAccountOwner" id="textFieldAccountOwner" required value="' . $row['account_owner'] . '">
                                        </div>
                                        <div class="col-sm-12 col-md-6 my-1">
                                            <label class="form-label">Username</label>
                                            <input type="text" class="form-control" name="textFieldUsername" id="textFieldUsername" value="' . $row['username'] . '">
                                        </div>
                                        <div class="col-sm-12 col-md-6 my-1">
                                            <label class="form-label">Email Address</label>
                                            <input type="text" class="form-control" name="textFieldEmailRecords" id="textFieldEmailRecords" value="' . $row['email'] . '">
                                        </div>
                                        <div class="col-sm-12 col-md-6 my-1">
                                            <label class="form-label">Password</label>
                                            <input type="text" class="form-control" name="textFieldPasswordRecords" id="textFieldPasswordRecords" required value="' . $row['password'] . '">
                                        </div>
                                        <div class="col-sm-12 col-md-6 my-1">
                                            <label class="form-label">Description <i class="fas fa-question-circle text-secondary" data-bs-toggle="tooltip" data-bs-placement="right" title="Great descriptions are clear and concise."></i></label>
                                            <input type="text" class="form-control" name="textFieldDescription" id="textFieldDescription" value="' . $row['description'] . '">
                                        </div>
                                        <div class="col-sm-12 my-4">
                                            <div class="text-end">
                                            <button class="btn btn-link text-danger delete" type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Delete record</button></a>
                                            <button class="btn btn-success my-1" type="submit">Save Changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <form onsubmit="submitDeleteForm(event)" name="delete-form">
                                
                                <!-- Modal -->
                                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Delete this record?</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h4>This action is irreversible!</h4>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-danger">Delete record</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                </form>

                            </div>';
                            }
                        }

                        ?>


                    </div>

                </div>
            </div>
        </div>

    </main>

    <script src="<?php echo './scripts/editForm.js?v=' . $pageeditFormJSVersion ?>"></script>
    <script src="<?php echo './scripts/deleteRecord.js?v=' . $pagedeleteRecordJSVersion ?>"></script>
    <script src="./node_modules/fontawesome/fontawesome.js" crossorigin="anonymous"></script>
    <script src="./node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="./node_modules/@popperjs/core/dist/umd/popper.js"></script>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="./scripts/tooltip.js"></script>
</body>

</html>