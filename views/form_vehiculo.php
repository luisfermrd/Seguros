<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["names"]) || $_SESSION['rol'] != 0){
  header("Location: login.php");
}
else
{

include_once('header.php');
?>


<main>
<div class="container m-sm-5 mt-3 bg-light">
        <div class="row">
            <div class="col ms-3">
                <h1 class="fs-3 text-primary">Formulario de seguro de vehículo</h1>
            </div>
            <div class="container p-4">
                <form action="" method="post" class="row">
                    <div class="form-group col-lg-12">
                        <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                            <div class="mb-3">
                                <label  class="form-label fw-semibold">Cuando le cumple el seguro?(*)</label>
                                <select name="cumple_seguro" class="form-select" required>
                                    <option value="Enero">Enero</option>
                                    <option value="Febrero">Febrero</option>
                                    <option value="Marzo">Marzo</option>
                                    <option value="Abril">Abril</option>
                                    <option value="Mayo">Mayo</option>
                                    <option value="Junio">Junio</option>
                                    <option value="Julio">Julio</option>
                                    <option value="Agosto">Agosto</option>
                                    <option value="Septiembre">Septiembre</option>
                                    <option value="Octubre">Octubre</option>
                                    <option value="Noviembre">Noviembre</option>
                                    <option value="Diciembre">Diciembre</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <h3>Datos del vehículo</h3>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Uso(*)</label>
                            <select name="uso"  class="form-select" required>
                                <option value="Servicio público">Servicio público</option>
                                <option value="Servicio privado">Servicio privado</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tipo de vehículo(*)</label>
                            <select name="tipo_vehiculo"  class="form-select" required>
                                <option value="Turismo">Turismo</option>
                                <option value="Furgoneta">Furgoneta</option>
                                <option value="Camión">Camión</option>
                                <option value="Motocicleta">Motocicleta</option>
                                <option value="Ciclomotor">Ciclomotor</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Marca(*)</label>
                            <select name="marca"  class="form-select">
                                <option value="">Seleccione...</option>
                                <option value="Alfa Romeo">Alfa Romeo</option>
                                <option value="Aprilia">Aprilia</option>
                                <option value="Audi">Audi</option>
                                <option value="Bmw">Bmw</option>
                                <option value="Cagiva">Cagiva</option>
                                <option value="Citroën">Citroën</option>
                                <option value="Dacia">Dacia</option>
                                <option value="Derbi">Derbi</option>
                                <option value="Ducati">Ducati</option>
                                <option value="Fiat">Fiat</option>
                                <option value="Ford">Ford</option>
                                <option value="Gilera">Gilera</option>
                                <option value="Honda">Honda</option>
                                <option value="Hyundai">Hyundai</option>
                                <option value="Kawasaki">Kawasaki</option>
                                <option value="Kia">Kia</option>
                                <option value="Kymco">Kymco</option>
                                <option value="Lancia">Lancia</option>
                                <option value="Land Rover">Land Rover</option>
                                <option value="Lexus">Lexus</option>
                                <option value="Mazda">Mazda</option>
                                <option value="Mercedes">Mercedes</option>
                                <option value="Mini">Mini</option>
                                <option value="Mitsubishi">Mitsubishi</option>
                                <option value="Nissan">Nissan</option>
                                <option value="Opel">Opel</option>
                                <option value="Peugeot">Peugeot</option>
                                <option value="Piaggio">Piaggio</option>
                                <option value="Renault">Renault</option>
                                <option value="Rieju">Rieju</option>
                                <option value="Seat">Seat</option>
                                <option value="Skoda">Skoda</option>
                                <option value="Smart">Smart</option>
                                <option value="SsangYong">SsangYong</option>
                                <option value="Subaru">Subaru</option>
                                <option value="Suzuki">Suzuki</option>
                                <option value="Toyota">Toyota</option>
                                <option value="Vespa">Vespa</option>
                                <option value="Volkswagen">Volkswagen</option>
                                <option value="Volvo">Volvo</option>
                                <option value="Yamaha">Yamaha</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Otra marca</label>
                            <input  type="text" name="otra_marca" class="form-control">
                        </div>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Modelo (*)</label>
                            <input  type="number" name="modelo" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Version</label>
                            <input  type="text" name="version" class="form-control">
                        </div>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Motor</label>
                            <input  type="text" name="motor" class="form-control">
                        </div>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">CV</label>
                            <input  type="text" name="cv" class="form-control">
                        </div>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Carga</label>
                            <select name="carga"class="form-control" >
                                <option value="Con reparto">Con reparto</option>
                                <option value="Sin reparto">Sin reparto</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Matricula (*)</label>
                            <input  type="text" name="matricula" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group col-lg-12">
                        <h3>Datos del conductor</h3>
                    </div>

                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nombres y apellidos(*)</label>
                            <input  type="text" name="nombres" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email(*)</label>
                            <input  type="email" name="email" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Celular(*)</label>
                            <input  type="number" name="celular" class="form-control" required>
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
                            <input  type="number" name="num_documento" class="form-control" required maxlength="10">
                        </div>
                    </div>
                    
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Fecha de nacimiento</olabel>
                            <input type="date" name="fecha_nacimiento" class="form-control">
                        </div>
                    </div>
                    
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Fecha de carnet conducir</olabel>
                            <input type="date" name="fecha_carnet" class="form-control">
                        </div>
                    </div>
                    
                    <br>
                    <br>
                    <div class="form-group d-flex justify-content-between">
                        <button type="submit"  class="btn btn-success row-3 mt-2"> Enviar </button>
                        <a href="principal.php">
                            <button type="button"  class="btn btn-danger row-3 mt-2"> Regresar </button>
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