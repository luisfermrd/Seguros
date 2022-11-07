$(document).ready(function () {
    $('#formulario').on("submit",function (e) { 
        e.preventDefault();
        saveUser();
    });
});

async function saveUser() {

    let form = $("#formulario")[0];
    $data = new FormData(form);
    await $.ajax({
        type: "post",
        url: "../controller/registrar.php",
        data: $data,
        contentType: false,
        processData: false,
        success: function (response) {
            alert(response);
        }
    });

    form.reset();
}