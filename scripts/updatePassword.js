var alertUpdatePassword = document.getElementById('alert-container-update-password');

function submitUpdatePasswordForm(event) {
    event.preventDefault();
    var updatePasswordForm = document.forms.namedItem('update-password-form');
    var updatePasswordRecord = new FormData(updatePasswordForm);
    postUpdatePassword(updatePasswordRecord).then(data => checkResponseUpdatePassword(JSON.parse(data)))
}

function postUpdatePassword(data) {
    return new Promise((resolve, reject) => {
        var http = new XMLHttpRequest();
        http.open("POST", "./process/update-password.php");
        http.onload = () => http.status == 200 ? resolve(http.response) : reject(Error(http.statusText));
        http.onerror = (e) => reject(Error(`Networking error: ${e}`));
        http.send(data)
    })
}

function checkResponseUpdatePassword(data) {
    if (data.response === "success") {
        
        Swal.fire(
            'Password updated successfully!',
            'You may edit your record for any input mistake.',
            'success'
        )
    }

    if (data.response === "empty_fields") {
        alertUpdatePassword.innerHTML = `<div class="alert alert-danger alert-dismissible fade show my-3" role="alert"><strong>Invalid input!</strong> Please fill up all the required fields.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`
    }

    if (data.response === "incorrect_current_password") {
        alertUpdatePassword.innerHTML = `<div class="alert alert-danger alert-dismissible fade show my-3" role="alert"><strong>Incorrect current password!</strong> Please try again.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`
    }
}