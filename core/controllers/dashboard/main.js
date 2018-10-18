$(document).ready(function () {
    errores_conexion();
});

function errores_conexion(){
    $.ajax({
        type: "POST",
        data: null,
        url: "../../core/helpers/php/conexion.php?accion=verificar",
        success: function (respuesta) {
            if(respuesta.estado){//wiu wiu hay errores
                swal({ 
                    title: "Error de conexión!", 
                    text: "Ocurrió un error al conectarse a la base de datos.", 
                    icon: "error", 
                    buttons: "Detalles", 
                    dangerMode: true,
                    closeOnClickOutside: false }).then(function(){
                        swal({ 
                            title: "Información del error de conexión!", 
                            text: "Código:\n" + respuesta.codigo + "\n" +
                            "Mensaje:\n" + respuesta.mensaje + "\n"
                            , 
                            icon: "error", 
                            button: false, 
                            closeOnClickOutside: false 
                        });
                });
            }
        }, error: function(respuesta){
            console.log("Error:");
            console.log(respuesta);
        }
    });
}

var info_usuario = null;
function online(){
    $.ajax({
        type: "POST",
        data: null,
        url: "../../core/controllers/scripts/usuarios.php?accion=online",
        success: function (respuesta) {
            //si viene un usuario
            if(respuesta.resultado){
                //pongo HTML en estos divs de la pagina web, para identificar el usuario dentro
                info_usuario = respuesta.registro;
                $("#info_usuario").html("\
                    <i class='fa fa-user fa-fw'></i>\
                        "+respuesta.registro.Alias+"\
                    <i class='fa fa-angle-down'></i>");
                $("#info_usuario_sidenav").html("\
                    <h4 class='text-center font-white'>\
                        <i class='fa fa-user fa-fw font-green parpadea'></i>\
                        "+respuesta.registro.Alias+"\
                    </h4>");
                $("#header_dashboard").removeClass("hide");
            }else{
                window.location = "login.php";
            }
        }, error: function(respuesta){
            console.log("Error:");
            console.log(respuesta);
        }
    });
}

//pregunto si esta seguro de cerrar sesion
function destroy(){
    swal({
        title: "ADVERTENCIA", text: "Esta apunto de cerrar sesión.\n¿Desea continuar?", icon: "warning", closeOnClickOutside: false,
        buttons: ["Cancelar", "Cerrar sesión"], dangerMode: true
    }).then(function(aceptar) {
        if(aceptar){
            $.ajax({
                type: "POST",
                data: null,
                url: "../../core/controllers/scripts/usuarios.php?accion=destroy",
                success: function (respuesta) {
                    online();
                }, error: function(respuesta){
                    console.log("Error:");
                    console.log(respuesta);
                }
            });
        }
    });
}