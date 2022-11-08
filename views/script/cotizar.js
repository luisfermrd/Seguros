$(document).ready(function () {
    fechaActual("#fecha_inicio");
    fechaActual("#fecha_fin");
    $('#formulario').on("submit",function (e) { 
        e.preventDefault();
        cotizar();
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

async function cotizar() {

    let form = $("#formulario")[0];
    $data = new FormData(form);
    await $.ajax({
        type: "post",
        url: "../ajax/seguros_validar.php?opcion=cotizar",
        data: $data,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status == 1) {
                $("#num_personas").html(response.numero);
                $("#dias_agregados").html(response.dias);
                $("#plan_seleccionado").html(response.plan);
                $("#total").html(response.total);
            }else{
                alert(response.message);
            }
        }
    });

    //form.reset();
}