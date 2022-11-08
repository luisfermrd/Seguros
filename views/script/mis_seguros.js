$(document).ready(function () {
    cargarTabla();
});

async function cargarTabla(){
    let form = $("#formulario")[0];
    $data = new FormData(form);
    await $.ajax({
        type: "post",
        url: "../ajax/seguros_usuario.php?opcion=mis_seguros",
        data: $data,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status == 1) {
                let html = "";
                response.data.forEach(element => {
                    console.log(element)
                    if (element.cancelado == 0) {
                        let pago, detalle1, activo;
                        if(element.pago == 0){
                            pago = "<p class='text-light bg-danger text-center rounded ms-1 me-1'>No</p>";
                            detalle1 = `<a href='pagar.php?ref=${element.ref_pago}' class='text-decoration-none text-light bg-primary text-center rounded ms-1 me-1 p-1'>Pagar</a>`;
                        }else{
                            detalle1 = `<a onclick='cancelarSub("${element.ref_pago}")' class='text-decoration-none text-light bg-danger text-center rounded ms-1 me-1 p-1' role='button'>Cancelar seguro</a>`;
                            pago = "<p class='text-light bg-success text-center rounded ms-1 me-1'>Si</p>";
                        }

                        if(element.activo == 0){
                            activo = "<p class='text-light bg-danger text-center rounded ms-1 me-1'>No</p>";
                        }else{
                            activo = "<p class='text-light bg-success text-center rounded ms-1 me-1'>Si</p>";
                        }

                        let detalle2 = `<a onclick='detalles("${element.ref_pago}")' class='text-decoration-none text-light bg-warning text-center rounded ms-1 me-1 p-1' role='button'>Detalles</a>`;

                        let detalle3 = `<a onclick='reclamar("${element.ref_pago}")' class='text-decoration-none text-light bg-success text-center rounded ms-1 me-1 p-1' role='button'>Reclamar</a>`;

                        let detalle4 = "<a class='text-decoration-none text-light bg-info text-center rounded ms-1 me-1 p-1'>Reclamando</a>";

                        let detalle5 = "<a class='text-decoration-none text-light bg-success text-center rounded ms-1 me-1 p-1'>Reclamado</a>";


                        let row = `<tr class="">
                          <td scope="row">${element.id_beneficiario}</td>
                          <td scope="row">${element.names}</td>
                          <td scope="row">${element.tipo}</td>
                          <td scope="row">${element.fecha}</td>
                          <td scope="row">${element.valor}</td>
                          <td scope="row">${pago}</td>
                          <td scope="row">`
                            
                        if(element.reclamado != 2){ 
                        row += detalle1; 
                        } 
                        row +=  detalle2; 
                        if(element.pago == 1 && element.reclamado == 0){ 
                        row +=  detalle3;
                        } 
                        if(element.reclamado == 1){ 
                        row += detalle4;
                        } 
                        if(element.reclamado == 2){ 
                        row +=  detalle5;
                        }
                        row +=  `</td> </tr>`

                        html += row;
                    }
                });

                $("#datosTabla").html(html);
                
            }
        }
    });
}

async function cancelarSub(ref_pago){
    if (confirm("¿Seguro que desea cancelar este seguro? no tendra devolucion del dinero ya pagado!")) {
        await $.ajax({
            type: "post",
            url: '../ajax/seguros_usuario.php?opcion=cancelar_seguro&ref='+ref_pago,
            data: null,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status == 1) {
                    alert(response.message);
                    window.location.reload();
                }else{
                    alert(response.message);
                }
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

