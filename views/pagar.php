<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["names"]) || $_SESSION['rol'] != 0){
  header("Location: login.php");
}
else{

    if(!isset($_GET["ref"])){
        header("Location: principal.php");
    }

    $ref_pago = $_GET["ref"];


include_once('header.php');
?>


<main class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">

    <div class="rounded m-4" style="width: 500px; height: 580px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);">
        <h2 class="text-center p-3" id="tipo"></h2>
        <p class="ms-4">Referencia de pago N° <?php echo $ref_pago ?></p>
        <p class="ms-4">Total a pagar: $ <span id="valor"></span> pesos.</p>
        <div>
            <form id="formulario2" method="post">
                <input type="hidden" value="<?php echo $ref_pago ?>" name="ref_pago">
            </form>
            <form id="formulario" method="post" >
                <div>
                    <input type="hidden" value="<?php echo $ref_pago ?>" name="ref_pago">
                </div>
                <div class="form-group col-10 mt-2 ms-4 me-4">
                    <div class="mb-3">
                        <label class="form-label">Numero de tarjeta(*)</label>
                        <input type="text" name="tarjeta"  class="form-control" required placeholder="0000-0000-0000-0000">
                        </div>
                </div>
                <div class="row ms-3 me-5">
                    <div class="form-group col-6 mt-2">
                        <div class="mb-3">
                            <label class="form-label">Fecha de expiracion(*)</label>
                            <input  type="text" name="fecha" class="form-control"  required placeholder="00/00" >
                        </div>
                    </div>
                    <div class="form-group col-6 mt-2">
                        <div class="mb-3">
                            <label class="form-label">Codigo de seguridad(*)</label>
                            <input  type="number" name="cvv" class="form-control"  required placeholder="123" >
                        </div>
                    </div>
                </div>
                
                <div class="form-group col-10 mt-2 ms-4 me-4">
                    <div class="mb-3">
                        <input type="text" name="nombres" class="form-control"required placeholder="Nombres">
                    </div>
                </div>
                <div class="form-group col-10 mt-2 ms-4 me-4">
                    <div class="mb-3">
                        <input type="text" name="direccion" class="form-control" required placeholder="Direccion">
                    </div>
                </div>
                <div class="form-group col-10 mt-2 ms-4 me-4">
                    <div class="mb-3">
                        <input type="number" name="identificacion" class="form-control" required placeholder="N° identificación">
                    </div>
                </div>
                
                <div class="form-group d-flex justify-content-between ms-3 me-5">
                    <button type="submit"  class="btn btn-success row-3 mt-2"> Pagar </button>
                    <a href="mis_seguros.php">
                        <button type="button"  class="btn btn-danger row-3 mt-2"> Regresar </button>
                    </a>
                </div>
            </form>
        </div>
    </div>

</main>

    <script>
        async function cargarInfo() {
            let form = $("#formulario2")[0];
            $data = new FormData(form);
            await $.ajax({
                type: "post",
                url: "../ajax/seguros_usuario.php?opcion=info_ref",
                data: $data,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.status == 1) {
                        $("#tipo").html(response.tipo);
                        $("#valor").html(response.valor);
                    }else{
                        alert(response.message);
                        document.location.href = `principal.php`;
                    }
                }
            });
        }
        setTimeout(() => {
            cargarInfo();
        }, 100);
    </script>

    <!--jquey -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <script src="script/pagar.js"></script>

<?php
include_once('footer.php');

}
ob_end_flush();
?>