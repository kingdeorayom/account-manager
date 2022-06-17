var alertEditRecord = document.getElementById('alert-container-edit-record');

function submitEditForm(event) {
    event.preventDefault();
    var editForm = document.forms.namedItem('edit-form');
    var editRecord = new FormData(editForm);
    postEditRecord(editRecord).then(data => checkResponseEditRecord(JSON.parse(data)))
}

function postEditRecord(data) {
    return new Promise((resolve, reject) => {
        var http = new XMLHttpRequest();
        http.open("POST", "./process/edit-record.php");
        http.onload = () => http.status == 200 ? resolve(http.response) : reject(Error(http.statusText));
        http.onerror = (e) => reject(Error(`Networking error: ${e}`));
        http.send(data)
    })
}

function checkResponseEditRecord(data) {
    if (data.response === "success") {

        Swal.fire(
            'Changes saved successfully!',
            'You may edit your record for any input mistake.',
            'success'
        ).then(function() {
            location.reload();
        })
    }

    if (data.response === "empty_fields") {
        alertEditRecord.innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Invalid input!</strong> Please fill up all the required fields.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`
    }
}