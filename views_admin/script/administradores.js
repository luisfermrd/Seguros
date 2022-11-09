$(document).ready(function () {
    cargarTabla();
    $('#formulario').on("submit",function (e) { 
        e.preventDefault();
        saveUser();
    });
});

async function cargarTabla(){
    await $.ajax({
        type: "post",
        url: "../ajax/seguros_admin.php?opcion=usuarios",
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status == 1) {
                let html = "";
                response.data.forEach(element => {
                    if(element.rol == 1){
                        let activo, detalle;
                        if(element.active == 0){
                          activo = "<p class='text-light bg-danger text-center rounded ms-1 me-1'>Inactivo</p>";
                          detalle = `<a onclick='activar("${element.id}")' class='text-decoration-none text-light bg-success text-center rounded ms-1 me-1 p-1' role='button'>Activar</a>`;
                        }else{
                          activo = "<p class='text-light bg-success text-center rounded ms-1 me-1'>Activo</p>";
                          detalle = `<a onclick='desactivar("${element.id}")' class='text-decoration-none text-light bg-danger text-center rounded ms-1 me-1 p-1' role='button'>Desactivar</a>`;
                        }
    
                        html +=`<tr>  <td scope="row">${element.id}</td>
                                    <td scope="row">${element.tipo_documento}</td>
                                    <td scope="row">${element.names}</td>
                                    <td scope="row">${element.email}</td>
                                    <td scope="row">${activo}</td>
                                    <td scope="row">${detalle}</td>
                               </tr>`;
                    }
                });

                $("#datosTabla").html(html);
                
            }
        }
    });
}

async function desactivar(id){
    if (confirm("¿Seguro que desea desactivar al usuario?")) {
        await $.ajax({
            type: "post",
            url: '../ajax/seguros_admin.php?opcion=desactivar_user&id='+id,
            data: null,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status == 1) {
                    alert(response.message)
                    window.location.reload()
                }else{
                    alert(response.message)
                }
            }
        });
    }
}

async function activar(id){
    if (confirm("¿Seguro que desea activar al usuario?")) {
        await $.ajax({
            type: "post",
            url: '../ajax/seguros_admin.php?opcion=activar_user&id='+id,
            data: null,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status == 1) {
                    alert(response.message)
                    window.location.reload()
                }else{
                    alert(response.message)
                }
            }
        });
    }
}


async function saveUser() {

    let form = $("#formulario")[0];
    $data = new FormData(form);
    await $.ajax({
        type: "post",
        url: "../ajax/seguros_admin.php?opcion=save_admin",
        data: $data,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status == 1) {
                alert(response.message)
                window.location.reload()
            }else{
                alert(response.message)
            }
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