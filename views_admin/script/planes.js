$(document).ready(function () {
    cargarTabla();
});




async function cargarTabla() {
    await $.ajax({
        type: "post",
        url: "../ajax/seguros_admin.php?opcion=cotizar",
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status == 1) {
                let html = "";
                response.data.forEach(element => {
                    html += `<tr>  <td scope="row">${element.id}</td>
                                    <td scope="row">${element.tipo}</td>
                                    <td scope="row">${element.basico}</td>
                                    <td scope="row">${element.estandar}</td>
                                    <td scope="row">${element.premiun}</td>
                                    <td scope="row"><a type="button" data-bs-toggle="modal" data-bs-target="#editarModal" onclick='editar("${element.id}")' class='btn btn-info' role='button'><i class="bi bi-pencil-square"></i> Modificar</a></td>
                               </tr>`;
                });

                $("#datosTabla").html(html);
                // console.log(response)
            }
        }
    });
}

// terminar editar 
async function editar(id) {
    let datos = {};

    datos.id = document.getElementById('id').value;
    datos.tipo = document.getElementById('tipo').value;
    datos.basico = document.getElementById('basico').value;
    datos.estandar = document.getElementById('estandar').value;
    datos.premiun = document.getElementById('premiun').value;
    if (confirm("¿Seguro que desea editar el precio del plan?")) {
        await $.ajax({
            type: "post",
            url: '../ajax/seguros_admin.php?opcion=modificacionPlan&id=' + id,
            data: null,
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