$(document).ready(function () {
    fechaActual("#fecha_inicio");
    fechaActual("#fecha_fin");
    $('#formulario').on("submit",function (e) { 
        e.preventDefault();
        vida();
    });
});

function fechaActual(selector){
    //Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $(selector).val(today);
}

async function vida() {

    let form = $("#formulario")[0];
    $data = new FormData(form);
    await $.ajax({
        type: "post",
        url: "../controller/vida.php",
        data: $data,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status == 1) {
                alert(response.message);
                
                document.location.href = `pagar.php?ref=${response.ref_pago}`;
                
            }else{
                alert(response.message);
            }
        }
    });

    //form.reset();
}