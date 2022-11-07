<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["names"]) || $_SESSION['rol'] != 0){
  header("Location: login.php");
}
else{

    if(!isset($_GET["id"])){
        header("Location: principal.php");
    }

    $id = $_GET["id"];

    include_once("../config/conexion.php");

    $sql = "SELECT * FROM vida as v LEFT JOIN clientes as m ON v.id_beneficiario = m.id LEFT JOIN pagos as p ON v.ref_pago = p.ref_pago WHERE v.id_beneficiario = '".$id ."';";

    $result =mysqli_query($conexion,$sql);

    if(!$row = mysqli_fetch_array($result)){
        header("Location: principal.php");
    }

    function diferencia_dias_dos_fechas($fecha_ini , $fecha_fin){
        $ini = new DateTime($fecha_ini);
        $fin = new DateTime($fecha_fin);
        $diferencia = $ini->diff($fin);
        return $diferencia->format("%R%a");
    }

    function diferencia_dias($fecha_ini){
        $ini = new DateTime($fecha_ini);
        $ahora = new DateTime(date("Y-m-d"));
        $diferencia = $ahora->diff($ini);
        return $diferencia->format("%R%a");
    }


include_once('header.php');
?>


<main style="min-height: 100vh;">

    <div class="container p-4 m-2">
    <div class="row">
            <div class="col ms-3">
                <h1 class="fs-3">Datos del  <?php echo $row['tipo']?></h1>
            </div>
            <?php 
                if($row['tipo'] == "Seguro de vida"){
                    ?>
                        <div class = "container p-4">
                            <p><strong> Nombres y apellidos: </strong> <?php echo $row['names'] ?> </p>
                            <p><strong> Tipo de docuemnto: </strong> <?php echo $row['tipo_documento'] ?> </p>
                            <p><strong> Numero de docuemento: </strong> <?php echo $row['id_beneficiario'] ?> </p>
                            <p><strong> Fecha de nacimiento: </strong> <?php echo $row['fecha_nacimineto'] ?> </p>
                            <p><strong> Sexo: </strong> <?php echo $row['sexo'] ?> </p>
                            <p><strong> Estado civil: </strong> <?php echo $row['estado_civil'] ?> </p>
                            <p><strong> Email: </strong> <?php echo $row['email'] ?> </p>
                            <p><strong> Celular: </strong> <?php echo $row['celular'] ?> </p>
                            <p><strong> Direccion de domicilio: </strong> <?php echo $row['direccion'] ?> </p>
                            <p><strong> Ciudad/Municipio: </strong> <?php echo $row['ciudad'] ?> </p>
                            <p><strong> Ingreso mensual: </strong> <?php echo $row['ingresos'] ?> </p>
                            <p><strong> Profesion: </strong> <?php echo $row['profesion'] ?> </p>
                            <p><strong> Consume actualmente algún medicamento: </strong> <?php echo $row['medicamento'] ?> </p>
                            <p><strong> En caso de consumir medicamento cual: </strong> <?php echo $row['cual'] ?> </p>
                            <p><strong> A que EPS e IPS está afiliado: </strong> <?php echo $row['eps_ips'] ?> </p>
                            <p><strong> Dias de seguro adquiridos: </strong> <?php echo diferencia_dias_dos_fechas($row['fecha_inicio'], $row['fecha_fin'])." (".$row['fecha_inicio']." - ".$row['fecha_fin'].")" ?> </p>
                            <p><strong> Dias de seguro restantes: </strong> <?php echo diferencia_dias($row['fecha_fin'])." dias" ?> </p>
                        </div>
                    <?php
                }
            ?>
            
            <div class="form-group d-flex justify-content-between">
                <a href="mis_seguros.php">
                    <button type="button"  class="btn btn-danger row-3 mt-2"> Regresar</button>
                </a>
            </div>
        </div>
    </div>


</main>

    <!--jquey -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <script src="script/pagar.js"></script>

<?php
include_once('footer.php');

}
ob_end_flush();
?>