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
                console.log(response.data)
            }
        }
    });
}