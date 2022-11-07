
async function desactivar(id){
    if (confirm("¿Seguro que desea desactivar al usuario?")) {
        await $.ajax({
            type: "post",
            url: '../controller_admin/desactivar_user.php?id='+id,
            data: null,
            contentType: false,
            processData: false,
            success: function (response) {
                window.location.reload()
            }
        });
    }
}

async function activar(id){
    if (confirm("¿Seguro que desea activar al usuario?")) {
        await $.ajax({
            type: "post",
            url: '../controller_admin/activar_user.php?id='+id,
            data: null,
            contentType: false,
            processData: false,
            success: function (response) {
                window.location.reload()
            }
        });
    }
}