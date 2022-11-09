$(document).ready(function () {
    info();
});
async function info(){
    await $.ajax({
        type: "post",
        url: "../ajax/seguros_admin.php?opcion=info",
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status == 1) {
                $("#clientes").html(response.data.num_clientes);
                $("#usuarios").html(response.data.num_usuarios);
                $("#admins").html(response.data.num_admin);
                $("#total").html(response.data.total_recuado);
            }
        }
    });
}