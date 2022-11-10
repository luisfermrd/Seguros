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
                <h1 class="fs-3 text-primary">Formulario de seguro de vida</h1>
            </div>
            <div class="container p-4">
                <form id="formulario" method="post" class="row">
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nombres y apellidos(*)</label>
                            <input type="text" name="nombres"  class="form-control" value="<?php echo $_SESSION['names']?>" required minlength="5">
                         </div>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <div class="mb-3">
                            <label for="nit" class="form-label fw-semibold">Tipo de documento(*)</label>
                            <select name="tipo_documento" class="form-select" required value="<?php $_SESSION['tipo_documento'] ?>">
                                <option value="Cedula de ciudadania" <?php $a = ($_SESSION['tipo_documento'] == "Cedula de ciudadania")? "selected":""; echo $a; ?>>Cedula de ciudadanía</option>
                                <option value="Cedula de extranjeria" <?php $a = ($_SESSION['tipo_documento'] == "Cedula de extranjeria")? "selected":""; echo $a; ?>>Cedula de extranjería</option>
                                <option value="Tarjeta de identidad" <?php $a = ($_SESSION['tipo_documento'] == "Tarjeta de identidad")? "selected":""; echo $a; ?>>Tarjeta de identidad</option>
                                <option value="Pasaporte" <?php $a = ($_SESSION['tipo_documento'] == "Pasaporte")? "selected":""; echo $a; ?>>Pasaporte</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Numero de documento(*)</label>
                            <input  type="number" name="num_documento" class="form-control" value="<?php echo $_SESSION['id']?>" required maxlength="10">
                        </div>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Fecha de nacimiento(*)</label>
                            <input  type="date" name="fecha_nacimiento" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <label for="ciudad" class="form-label fw-semibold">Sexo(*)</label>
                        <div>
                            <input type="radio" name="sexo" value="Femenino" required> <label>Femenino</label><br>
                            <input type="radio" name="sexo" value="Masculino"> <label>Masculino</label>
                        </div>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <label for="ciudad" class="form-label fw-semibold">Estado civil (*)</label>
                        <div class="row">
                            <div class="col-6">
                                <input type="radio" name="estado_civil" value="Soltero" required> <label>Soltero</label><br>
                                <input type="radio" name="estado_civil" value="Separado"> <label>Separado</label>
                            </div>
                            <div class="col-6">
                                <input type="radio" name="estado_civil" value="Union libre"> <label>Union libre</label><br>
                                <input type="radio" name="estado_civil" value="Casado"> <label>Casado</label>
                            </div>
                            <div class="col-6">
                                <input type="radio" name="estado_civil" value="Divorciado"> <label>Divorciado</label><br>
                                <input type="radio" name="estado_civil" value="Viudo"> <label>Viudo</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email(*)</label>
                            <input  type="email" name="email" class="form-control" value="<?php echo $_SESSION['email']?>" required>
                        </div>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Celular</label>
                            <input  type="number" name="celular" class="form-control">
                        </div>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Direccion de domicilio</label>
                            <input type="text" name="direccion" class="form-control" minlength="5" required>
                        </div>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <label for="ciudad" class="form-label fw-semibold">Ciudad/Municipio (*)</label>
                        <input type="text" name="ciudad" class="form-control" minlength="5" required>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <label for="ciudad" class="form-label fw-semibold">Ingreso mensual(*)</label>
                        <input type="number" name="ingreso" class="form-control" required>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <label for="ciudad" class="form-label fw-semibold">Profesion</label>
                        <input type="text" name="profesion" class="form-control">
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <label for="ciudad" class="form-label fw-semibold">Consume actualmente algún medicamento?</label>
                        <div>
                            <input type="radio" name="medicamento" value="Si"> <label>Si</label><br>
                            <input type="radio" name="medicamento" value="No"> <label>No</label>
                        </div>
                    </div> 
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <label for="ciudad" class="form-label fw-semibold">En caso de consumir medicamento cual?</label>
                        <input type="text" name="cual" class="form-control">
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <label for="ciudad" class="form-label fw-semibold">A que EPS e IPS está afiliado? (*)</label>
                        <input type="text" name="eps_ips" class="form-control" required>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <label for="ciudad" class="form-label fw-semibold">Fecha de inicio del seguro</label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control">
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <label for="ciudad" class="form-label fw-semibold">Fecha de finalización del seguro</label>
                        <input type="date" name="fecha_fin" id="fecha_fin" class="form-control">
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-2">
                        <label for="tipo_seguro" class="form-label fw-semibold">Seleccione un plan</label>
                        <select name="tipo_seguro" class="form-select" required>
                            <option value="basico">Básico</option>
                            <option value="estandar">Estándar</option>
                            <option value="premiun">Premiun</option>
                        </select>
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


    <!--jquey -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <script src="script/form_vida.js"></script>
<?php
include_once('footer.php');

}
ob_end_flush();
?>