<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["names"]) || $_SESSION['rol'] != 1){
  header("Location: login.php");
}
else
{

    $sql = "SELECT * FROM solicitudes as s LEFT JOIN vida as v ON s.ref_pago = v.ref_pago LEFT JOIN clientes as m ON v.id_beneficiario = m.id";

    include_once("../config/conexion.php");

    $result =mysqli_query($conexion,$sql);

include_once('header.php');
?>


<main>

    <div class="m-5 bg-light">
      <h1>Solicitudes</h1>
      
      <article class="p-3">
          <?php
            if($result){
          ?>

          <div class="table-responsive rounded">
            <table class="table table-striped table-hover rounded">
              <thead>
                <tr>
                  <th scope="col">Id</th>
                  <th scope="col">Id beneficiario</th>
                  <th scope="col">Nombres</th>
                  <th scope="col">Tipo de seguro</th>
                  <th scope="col">Fecha de solicitud</th>
                  <th scope="col">Documento</th>
                  <th scope="col">Aprobado</th>
                  <th scope="col">Opciones</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  while($row = mysqli_fetch_array($result)){
                      if($row['estado'] == 0){
                        $activo = "<p class='text-light bg-danger text-center rounded ms-1 me-1'>No</p>";
                      }else{
                        $activo = "<p class='text-light bg-success text-center rounded ms-1 me-1'>Si</p>";
                      }

                      $documento = "<a href='../archivos/".$row['ref_pago'].".pdf'>".$row['ref_pago'].".pdf</a>";

                      $detalle = "<a onclick='aprobar(".$row['ref_pago'].")' class='text-decoration-none text-light bg-success text-center rounded ms-1 me-1 p-1' role='button'>Aprobar</a>";


                      ?>
                          <td scope="row"><?php echo $row['id_solicitud'] ?></td>
                          <td scope="row"><?php echo $row['id_beneficiario'] ?></td>
                          <td scope="row"><?php echo $row['names'] ?></td>
                          <td scope="row"><?php echo $row['tipo']." (".$row['plan'].")" ?></td>
                          <td scope="row"><?php echo $row['fecha_solicitud'] ?></td>
                          <td scope="row"><?php echo $documento ?></td>
                          <td scope="row"><?php echo $activo ?></td>

                          <td scope="row">
                            <?php
                              if($row['estado'] == 0){ 
                                echo $detalle; 
                              } 
                            ?>
                          </td>
                          
                        </tr>
                      <?php
                    }
                  
                ?>
              </tbody>
            </table>
          </div>

          <?php
          }else{
          ?>
            <p>No tienes solicitudes registradas!</p>
          <?php
          }
          ?>
      </article>
    </div>


</main>

    <!--jquey -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <script src="script/solicitudes.js"></script>

<?php
include_once('footer.php');

}
ob_end_flush();
?>