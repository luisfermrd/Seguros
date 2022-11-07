$(document).ready(function () {
    $('#formulario').on("submit",function (e) { 
        e.preventDefault();
        saveUser();
    });
});

async function saveUser() {

    let form = $("#formulario")[0];
    $data = new FormData(form);
    await $.ajax({
        type: "post",
        url: "../controller_admin/registrar.php",
        data: $data,
        contentType: false,
        processData: false,
        success: function (response) {
            alert(response);
        }
    });

    form.reset();
}


document.querySelector("#nuevoEvento").addEventListener("click", () =>{
    document.querySelector(".modal").classList.toggle("oculto")
})

document.querySelector("#cerrar").addEventListener("click", () =>{
    document.querySelector(".modal").classList.toggle("oculto")
})