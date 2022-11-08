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
        url: "../ajax/seguros_validar.php?opcion=registrar",
        data: $data,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status == 1) {
                alert(response.message);
                form.reset();
            }else{
                alert(response.message);
            }
        }
    });
}