$(document).ready(function () {
    cargarTabla();
});

async function cargarTabla(){
    await $.ajax({
        type: "post",
        url: "../ajax/seguros_admin.php?opcion=solicitudes",
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status == 1) {
                let html = "";
                response.data.forEach(element => {
                    let activo, detalle, documento;
                    if(element.estado == 0){
                        activo = "<p class='text-light bg-danger text-center rounded ms-1 me-1'>No</p>";
                    }else{
                        activo = "<p class='text-light bg-success text-center rounded ms-1 me-1'>Si</p>";
                    }

                    documento = `<a href='../archivos/${element.ref_pago}.pdf'>${element.ref_pago}.pdf</a>`;

                    detalle = `<a onclick='aprobar("${element.ref_pago}")' class='text-decoration-none text-light bg-success text-center rounded ms-1 me-1 p-1' role='button'>Aprobar</a>`;
    
                    html +=`<tr>  <td scope="row">${element.id_solicitud}</td>
                                <td scope="row">${element.id_beneficiario}</td>
                                <td scope="row">${element.names}</td>
                                <td scope="row">${element.tipo} (${element.plan})</td>
                                <td scope="row">${element.fecha_solicitud}</td>
                                <td scope="row">${documento}</td>
                                <td scope="row">${activo}</td>
                                <td scope="row">`;
                    if(element.estado == 0){
                        html+= detalle;
                    }

                    html+= `</td>
                    </tr>`;
                    
                });

                $("#datosTabla").html(html);
                
            }
        }
    });
}

async function aprobar(ref_pago){
    if (confirm("¿Seguro que desea aprovar esta solicitud?")) {
        await $.ajax({
            type: "post",
            url: '../ajax/seguros_admin.php?opcion=aprovar&ref='+ref_pago,
            data: null,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status == 1) {
                    alert(response.message)
                    window.location.reload()
                }else{
                    alert(response.message)
                }
            }
        });
    }
}

