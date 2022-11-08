$(document).ready(function () {
    $('#formulario').on("submit",function (e) { 
        e.preventDefault();
        reclamar();
    });
});


async function reclamar() {

    let form = $("#formulario")[0];
    $data = new FormData(form);
    await $.ajax({
        type: "post",
        url: "../ajax/seguros_usuario.php?opcion=reclamar",
        data: $data,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status == 1) {
                alert(response.message);
                
                document.location.href = `mis_seguros.php`;
                
            }else{
                alert(response.message);
            }
        }
    });
}