<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["names"]) || $_SESSION['rol'] != 0){
  header("Location: login.php");
}
else
{

  $sql = "SELECT * FROM vida as v LEFT JOIN clientes as m ON v.id_beneficiario = m.id LEFT JOIN pagos as p ON v.ref_pago = p.ref_pago WHERE v.id_user = '".$_SESSION['id']."';";

  include_once("../config/conexion.php");

  $result =mysqli_query($conexion,$sql);

include_once('header.php');
?>


<main>

    <div class="m-5 bg-light">
      <h1>Mis seguros</h1>
      
      <article class="p-3">
          <?php
            if($result){
          ?>

          <div class="table-responsive rounded">
            <table class="table table-striped table-hover rounded">
              <thead>
                <tr>
                  <th scope="col">Id beneficiario</th>
                  <th scope="col">Nombres</th>
                  <th scope="col">Tipo de seguro</th>
                  <th scope="col">Fecha inicio - Fecha fin</th>
                  <th scope="col">Valor</th>
                  <th scope="col">Pago</th>
                  <th scope="col">Opciones</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  while($row = mysqli_fetch_array($result)){
                    if($row['cancelado'] == 0){
                      if($row['pago'] == 0){
                        $pago = "<p class='text-light bg-danger text-center rounded ms-1 me-1'>No</p>";
                        $detalle1 = "<a href='pagar.php?ref=".$row['ref_pago']."' class='text-decoration-none text-light bg-primary text-center rounded ms-1 me-1 p-1'>Pagar</a>";
                      }else{
                        $detalle1 = "<a onclick='cancelarSub(".$row['ref_pago'].")' class='text-decoration-none text-light bg-danger text-center rounded ms-1 me-1 p-1' role='button'>Cancelar seguro</a>";
                        $pago = "<p class='text-light bg-success text-center rounded ms-1 me-1'>Si</p>";
                      }
                      if($row['activo'] == 0){
                        $activo = "<p class='text-light bg-danger text-center rounded ms-1 me-1'>No</p>";
                      }else{
                        $activo = "<p class='text-light bg-success text-center rounded ms-1 me-1'>Si</p>";
                      }

                      $detalle2 = "<a onclick='detalles(".$row['id_beneficiario'].")' class='text-decoration-none text-light bg-warning text-center rounded ms-1 me-1 p-1' role='button'>Detalles</a>";

                      $detalle3 = "<a onclick='reclamar(".$row['ref_pago'].")' class='text-decoration-none text-light bg-success text-center rounded ms-1 me-1 p-1' role='button'>Reclamar</a>";
                      $detalle4 = "<a class='text-decoration-none text-light bg-info text-center rounded ms-1 me-1 p-1'>Reclamando</a>";
                      $detalle5 = "<a class='text-decoration-none text-light bg-success text-center rounded ms-1 me-1 p-1'>Reclamado</a>";

                      ?>
                        <tr class="">
                          <td scope="row"><?php echo $row['id_beneficiario'] ?></td>
                          <td scope="row"><?php echo $row['names'] ?></td>
                          <td scope="row"><?php echo $row['tipo']." (".$row['plan'].")" ?></td>
                          <td scope="row"><?php echo $row['fecha_inicio']." - ".$row['fecha_fin'] ?></td>
                          <td scope="row"><?php echo $row['valor'] ?></td>
                          <td scope="row"><?php echo $pago ?></td>
                          <td scope="row">
                            <?php
                              if($row['reclamado'] != 2){ 
                                echo $detalle1; 
                              } 
                              echo $detalle2; 
                              if($row['pago'] == 1 && $row['reclamado'] == 0){ 
                                echo $detalle3;
                              } 
                              if($row['reclamado'] == 1){ 
                                echo $detalle4;
                              } 
                              if($row['reclamado'] == 2){ 
                                echo $detalle5;
                              } 
                            ?>
                          </td>
                          
                        </tr>
                      <?php
                    }
                  }
                ?>
              </tbody>
            </table>
          </div>

          <?php
          }else{
          ?>
            <p>No tienes seguros registrados!</p>
          <?php
          }
          ?>
      </article>
    </div>

  </main>

    <!--jquey -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <script src="script/mis_seguros.js"></script>

<?php
include_once('footer.php');

}
ob_end_flush();
?>