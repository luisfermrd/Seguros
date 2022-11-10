$(document).ready(function () {
    info();
    cargarTabla();
    $('#formulario').on("submit",function (e) { 
        e.preventDefault();
        editar();
    });
});


let datosCotizacion;

async function cargarTabla() {
    await $.ajax({
        type: "post",
        url: "../ajax/seguros_admin.php?opcion=cotizar",
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status == 1) {
                let html = "";
                datosCotizacion = response.data;
                response.data.forEach(element => {
                    html += `<tr>  <td scope="row">${element.id}</td>
                                    <td scope="row">${element.tipo}</td>
                                    <td scope="row">${element.basico}</td>
                                    <td scope="row">${element.estandar}</td>
                                    <td scope="row">${element.premiun}</td>
                                    <td scope="row"><a type="button" data-bs-toggle="modal" data-bs-target="#editarModal" onclick='cargarDatos("${element.id}")' class='btn btn-info' role='button'><i class="bi bi-pencil-square"></i> Modificar</a></td>
                               </tr>`;
                });

                $("#datosTabla").html(html);
                // console.log(response)
            }
        }
    });
}

function cargarDatos(id){
    datosCotizacion.forEach(element => {
        if (element.id == id) {
            $("#id").attr('value', element.id);
            $("#tipo").attr('value', element.tipo);
            $("#basico").attr('value', element.basico);
            $("#estandar").attr('value', element.estandar);
            $("#premiun").attr('value', element.premiun);
        }
    });
}

// terminar editar 
async function editar() {
    
    if (confirm("¿Seguro que desea editar el precio del plan?")) {
        let form = $("#formulario")[0];
        $data = new FormData(form);
        await $.ajax({
            type: "post",
            url: '../ajax/seguros_admin.php?opcion=modificacionPlan',
            data: $data,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status == 1) {
                    alert(response.message)
                    window.location.reload()
                } else {
                    alert(response.message)
                }
            }
        });
    }
}
async function info(){
    await $.ajax({
        type: "post",
        url: "../ajax/seguros_admin.php?opcion=info",
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status == 1) {
                $("#clientes").html(response.data.num_clientes);
                $("#usuarios").html(response.data.num_usuarios);
                $("#admins").html(response.data.num_admin);
                $("#total").html(response.data.total_recuado);
            }
        }
    });
}