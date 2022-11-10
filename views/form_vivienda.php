<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["names"]) || $_SESSION['rol'] != 0) {
    header("Location: login.php");
} else {

    include_once('header.php');
?>


    <main>
        <div class="container m-sm-5 mt-3 bg-light">
            <div class="row">
                <div class="col ms-3">
                    <h1 class="fs-3 text-primary">Formulario de seguro de vivienda</h1>
                </div>
                <div class="container p-4">
                    <form action="" method="post" class="row">
                        <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nombre del propietario(*)</label>
                                <input type="text" name="nombres" class="form-control" required minlength="4">
                            </div>
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                            <div class="mb-3">
                                <label for="nit" class="form-label fw-semibold">Tipo de documento(*)</label>
                                <select name="tipo_documento" class="form-select" required>
                                    <option value="Cedula de ciudadania">Cedula de ciudadanía</option>
                                    <option value="Cedula de extranjeria">Cedula de extranjería</option>
                                    <option value="Tarjeta de identidad">Tarjeta de identidad</option>
                                    <option value="Pasaporte">Pasaporte</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Numero de documento(*)</label>
                                <input type="number" name="num_documento" class="form-control" required maxlength="10">
                            </div>
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email(*)</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Celular</label>
                                <input type="number" name="celular" class="form-control">
                            </div>
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Dirección completa del inmueble (*)</label>
                                <input type="text" name="direccion" class="form-control" minlength="5" required>
                            </div>
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                            <label for="ciudad" class="form-label fw-semibold">Ciudad/Municipio (*)</label>
                            <input type="text" name="ciudad" class="form-control" minlength="5" required>
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                            <label for="ciudad" class="form-label fw-semibold">Aseguradora Actual (SI APLICA)</label>
                            <input type="text" name="aseguradora" class="form-control" minlength="5">
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                            <label for="ciudad" class="form-label fw-semibold">Edad aproximada o años de construcción (*)</label>
                            <input type="number" name="construccion" class="form-control" required>
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                            <label for="ciudad" class="form-label fw-semibold">Valor del Inmueble en Millones (*)</label>
                            <input type="number" name="valor" class="form-control" required>
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                            <label for="ciudad" class="form-label fw-semibold">Desea Asegurar contenidos?</label>
                            <div>
                                <input type="radio" name="asegurar" value="Si"> <label>Si</label><br>
                                <input type="radio" name="asegurar" value="No"> <label>No</label>
                            </div>
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                            <label for="ciudad" class="form-label fw-semibold">Tiene acreedor oneroso/hipoteca/leasing?</label>
                            <div>
                                <input type="radio" name="acreedor" value="Si"> <label>Si</label><br>
                                <input type="radio" name="acreedor" value="No"> <label>No</label>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="form-group d-flex justify-content-between">
                            <button type="submit" class="btn btn-success row-3 mt-2"> Enviar </button>
                            <a href="principal.php">
                                <button type="button" class="btn btn-danger row-3 mt-2"> Regresar </button>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>


<?php
    include_once('footer.php');
}
ob_end_flush();
?>