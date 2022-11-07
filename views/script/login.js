$(document).ready(function () {
    $('#formulario').on("submit",function (e) { 
        e.preventDefault();
        login();
    });
});

async function login() {

    let form = $("#formulario")[0];
    $data = new FormData(form);
    await $.ajax({
        type: "post",
        url: "../ajax/seguros_validar.php?opcion=login",
        data: $data,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status == 1) {
                if(response.rol == 0){
                    $(location).attr("href","principal.php");
                }else{
                    $(location).attr("href","../views_admin/principal.php");
                }
            }else{
                alert(response.message);
            }
        }
    });

    form.reset();
}