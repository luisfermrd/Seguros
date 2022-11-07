<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["names"]) || $_SESSION['rol'] != 1){
  header("Location: login.php");
}
else
{

  $sql = "SELECT * FROM `usuarios`";

  include_once("../config/conexion.php");

  $result =mysqli_query($conexion,$sql);

include_once('header.php');
?>


<main>

  <div class="m-5 bg-light">
    <h1>Usuarios</h1>
    
    <article class="p-3">
        <?php
          if($result){
        ?>

        <div class="table-responsive rounded">
          <table class="table table-striped table-hover rounded">
            <thead>
              <tr>
                <th scope="col">Id</th>
                <th scope="col">Tipo id</th>
                <th scope="col">Nombres</th>
                <th scope="col">Correo</th>
                <th scope="col">Estado</th>
                <th scope="col">Opciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
                while($row = mysqli_fetch_array($result)){
                  if($row['rol'] == 0){
                    if($row['active'] == 0){
                      $activo = "<p class='text-light bg-danger text-center rounded ms-1 me-1'>Inactivo</p>";
                      $detalle = "<a onclick='activar(".$row['id'].")' class='text-decoration-none text-light bg-success text-center rounded ms-1 me-1 p-1' role='button'>Activar</a>";
                    }else{
                      $activo = "<p class='text-light bg-success text-center rounded ms-1 me-1'>Activo</p>";
                      $detalle = "<a onclick='desactivar(".$row['id'].")' class='text-decoration-none text-light bg-danger text-center rounded ms-1 me-1 p-1' role='button'>Desactivar</a>";
                    }

                    ?>
                        <td scope="row"><?php echo $row['id'] ?></td>
                        <td scope="row"><?php echo $row['tipo_documento'] ?></td>
                        <td scope="row"><?php echo $row['names'] ?></td>
                        <td scope="row"><?php echo $row['email'] ?></td>
                        <td scope="row"><?php echo $activo ?></td>
                        <td scope="row"><?php echo $detalle ?></td>
                        
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
          <p>No tienes solicitudes registradas!</p>
        <?php
        }
        ?>
    </article>
  </div>

</main>

    <!--jquey -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <script src="script/usuarios.js"></script>

<?php
include_once('footer.php');

}
ob_end_flush();
?>