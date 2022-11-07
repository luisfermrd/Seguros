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

async function cancelarSub(ref_pago){
    if (confirm("¿Seguro que desea cancelar este seguro? no tendra devolucion del dinero ya pagado!")) {
        await $.ajax({
            type: "post",
            url: '../controller/cancelar.php?ref='+ref_pago,
            data: null,
            contentType: false,
            processData: false,
            success: function (response) {
                    window.location.reload()
            }
        });
    }
}

function detalles(id){
    document.location.href = `detalles.php?id=${id}`;
}

function reclamar(id){
    document.location.href = `reclamar.php?ref=${id}`;
}

