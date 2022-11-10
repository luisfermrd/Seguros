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

                    html += `<div class="container p-4">
                                <form id="formulario" class="row">
                                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Nombres y Apellidos(*)</label>
                                            <p class="form-control">${response.data.names}</p>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                                        <div class="mb-3">
                                            <label for="nit" class="form-label fw-semibold">Tipo de documento(*)</label>
                                            <p class="form-control">${response.data.tipo_documento} </p>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Numero de documento(*)</label>
                                            <p class="form-control"> ${response.data.id_beneficiario} </p>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Fecha de nacimiento(*)</label>
                                            <p class="form-control">${response.data.fecha_nacimineto} </p>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                                        <label for="ciudad" class="form-label fw-semibold">Sexo(*)</label>
                                        <p class="form-control">${response.data.sexo} </p>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                                        <label for="ciudad" class="form-label fw-semibold">Estado civil (*)</label>
                                        <p class="form-control">${response.data.estado_civil} </p>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Email(*)</label>
                                            <p class="form-control">${response.data.email} </p>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Celular</label>
                                            <p class="form-control">${response.data.celular} </p>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Dirección de domicilio</label>
                                            <p class="form-control">${response.data.direccion} </p>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                                        <label for="ciudad" class="form-label fw-semibold">Ciudad/Municipio (*)</label>
                                        <p class="form-control">${response.data.ciudad} </p>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                                        <label for="ciudad" class="form-label fw-semibold">Ingreso mensual(*)</label>
                                        <p class="form-control"> ${response.data.ingresos}</p>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                                        <label for="ciudad" class="form-label fw-semibold">Profesión</label>
                                        <p class="form-control">${response.data.profesion}  </p>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                                        <label for="ciudad" class="form-label fw-semibold">Consume actualmente algún medicamento?</label>
                                        <p class="form-control">${response.data.medicamento} </p>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                                        <label for="ciudad" class="form-label fw-semibold">En caso de consumir medicamento cual?</label>
                                        <p class="form-control">${response.data.cual} </p>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                                        <label for="ciudad" class="form-label fw-semibold">A que EPS e IPS está afiliado? (*)</label>
                                        <p class="form-control">${response.data.eps_ips} </p>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                                        <label for="ciudad" class="form-label fw-semibold">Dias de seguro adquiridos:</label>
                                        <p class="form-control">${response.data.dif_dias} dias. (${response.data.fecha}) </p>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                                        <label for="ciudad" class="form-label fw-semibold"> Dias de seguro restantes:</label>
                                        <p class="form-control">${response.data.dias_restantes} dias </p>
                                    </div>
                                </form>
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