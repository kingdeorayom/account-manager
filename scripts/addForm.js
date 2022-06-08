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
        http.open("POST", "./process/add-record.php");
        http.onload = () => http.status == 200 ? resolve(http.response) : reject(Error(http.statusText));
        http.onerror = (e) => reject(Error(`Networking error: ${e}`));
        http.send(data)
    })
}

function checkResponseAddRecord(data) {
    if (data.response === "success") {
        // Swal.fire(
        //     'Record saved successfully!',
        //     'You may edit your record for any input mistake.',
        //     'success'
        // )
        alertAddRecord.innerHTML = `<div class="alert alert-success alert-dismissible fade show" role="alert">Record added successfully!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`
        
        $("#textFieldTitle, #textFieldAccountOwner, #textFieldServiceName, #textFieldUsername, #textFieldEmailRecords, #textFieldPasswordRecords, #textFieldDescription").val("");
        $(".records").load(location.href + " .records");
    }
    if (data.response === "empty_fields") {
        alertAddRecord.innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Invalid input!</strong> Please fill up all the required fields.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`
    }
}