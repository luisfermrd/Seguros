async function cargarDatos() {
    let form = $("#formulario")[0];
    $data = new FormData(form);
    await $.ajax({
        type: "post",
        url: "../ajax/seguros_usuario.php?opcion=detalles",
        data: $data,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status == 1) {
                let html = `<div class="col ms-3">
                                <h1 class="fs-3">Datos del  ${response.data.tipo_seguro}</h1>
                            </div>`;
                if (response.data.tipo_seguro == "Seguro de vida") {

                    html += `<div class = "container p-4">
                            <p><strong> Nombres y apellidos: </strong> ${response.data.names} </p>
                            <p><strong> Tipo de docuemnto: </strong> ${response.data.tipo_documento} </p>
                            <p><strong> Numero de docuemento: </strong> ${response.data.id_beneficiario} </p>
                            <p><strong> Fecha de nacimiento: </strong> ${response.data.fecha_nacimineto}</p>
                            <p><strong> Sexo: </strong> ${response.data.sexo} </p>
                            <p><strong> Estado civil: </strong> ${response.data.estado_civil} </p>
                            <p><strong> Email: </strong> ${response.data.email} </p>
                            <p><strong> Celular: </strong> ${response.data.celular}</p>
                            <p><strong> Direccion de domicilio: </strong> ${response.data.direccion}</p>
                            <p><strong> Ciudad/Municipio: </strong> ${response.data.ciudad} </p>
                            <p><strong> Ingreso mensual: </strong> ${response.data.ingresos} </p>
                            <p><strong> Profesion: </strong> ${response.data.profesion} </p>
                            <p><strong> Consume actualmente algún medicamento: </strong> ${response.data.medicamento} </p>
                            <p><strong> En caso de consumir medicamento cual: </strong> ${response.data.cual} </p>
                            <p><strong> A que EPS e IPS está afiliado: </strong> ${response.data.eps_ips} </p>
                            <p><strong> Dias de seguro adquiridos: </strong>${response.data.dif_dias} dias. (${response.data.fecha})</p>
                            <p><strong> Dias de seguro restantes: </strong> ${response.data.dias_restantes} dias</p>
                        </div>`;

                    $("#datos").html(html);

                }
            }
        }
    });
}

setTimeout(() => {
    cargarDatos();
}, 100);