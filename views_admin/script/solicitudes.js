
async function aprobar(ref_pago){
    if (confirm("¿Seguro que desea aprovar esta solicitud?")) {
        await $.ajax({
            type: "post",
            url: '../controller_admin/aprobar.php?ref='+ref_pago,
            data: null,
            contentType: false,
            processData: false,
            success: function (response) {
                    window.location.reload()
            }
        });
    }
}

