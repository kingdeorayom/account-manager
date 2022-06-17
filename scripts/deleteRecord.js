function submitDeleteForm(event) {
    event.preventDefault();
    var deleteForm = document.forms.namedItem('delete-form');
    var deleteRecord = new FormData(deleteForm);
    postDeleteRecord(deleteRecord).then(data => checkResponseDeleteRecord(JSON.parse(data)))
}

function postDeleteRecord(data) {
    return new Promise((resolve, reject) => {
        var http = new XMLHttpRequest();
        http.open("POST", "./process/delete-record.php");
        http.onload = () => http.status == 200 ? resolve(http.response) : reject(Error(http.statusText));
        http.onerror = (e) => reject(Error(`Networking error: ${e}`));
        http.send(data)
    })
}

function checkResponseDeleteRecord(data) {
    if (data.response === "success") {
        
        Swal.fire(
            'Record deleted successfully!',
            'Don\'t worry, it\'s really removed. ',
            'success'
        ).then(function() {
            location.href = './view.php';
        })
    }
}