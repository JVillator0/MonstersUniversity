$(document).ready(function(){
    cargar();
});

//metodo para cargar la informacion del usuario online
function cargar(){
    //obtiene la informacion del usuario online
    online();
    //espera 100 milisegundos para setear la informacion dentro de los inputs del sitio
    window.setTimeout(function(){    
        llenar_perfil(info_usuario);
    }, 100);
}

function llenar_perfil(info_usuario){
    //setea los valores en los inputs
    $("#id_usuario").val(info_usuario.Id_Usuario);
    $("#e_nombres").val(info_usuario.Nombres);
    $("#e_apellidos").val(info_usuario.Apellidos);
    $("#e_correo").val(info_usuario.Correo);
    $("#e_alias").val(info_usuario.Alias);
}

//funcion para modificar la informacion del perfil con lo nuevo que haya escrito
function editar_perfil(){
    //obteniendo la informacion del frm
    var datos = $("#frm_perfil").serialize();
    $.ajax({
        type: "POST",
        data: datos,
        url: "../../core/controllers/scripts/usuarios.php?accion=editar_perfil",
        success: function (respuesta) {
            if(respuesta.resultado){
                //mensaje de exito, reseteando y volviendo a cargar
                swal({title: "Aviso!", text: "Operación realizada con éxito", icon: "success", button: "Aceptar", closeOnClickOutside: false});
                $('#frm_perfil')[0].reset();
                cargar();
            }else{
                //si el mensaje ES DIFERENTE de indefinido o nulo, mostrara el mensaje que viene desde el servidor
                //si el mensaje SI ES nulo o indefinido, dira que ocurrio un error, esto sucede cuando las consultas fallan
                if(respuesta.mensaje != undefined || respuesta.mensaje != null){
                    swal({ title: "Información!", text: respuesta.mensaje, icon: "info", button: "Aceptar", closeOnClickOutside: false });
                }else{
                    swal({ title: "Error!", text: "Ocurrió un error al realizar la operación.", icon: "error", button: "Aceptar", closeOnClickOutside: false });
                }
            }
        }, error: function(respuesta){
            console.log("Error:");
            console.log(respuesta);
        }
    });
}

function editar_clave(){
    //uniendo la informacion del frm de clave y el frm del perfil
    var datos = $("#frm_editar_clave").serialize() + "&" + $("#frm_perfil").serialize();
    $.ajax({
        type: "POST",
        data: datos,
        url: "../../core/controllers/scripts/usuarios.php?accion=editar_clave",
        success: function (respuesta) {
            if(respuesta.resultado){
                //mensaje de exito y reseteando el form de cambio de clave
                swal({title: "Aviso!", text: "Operación realizada con éxito", icon: "success", button: "Aceptar", closeOnClickOutside: false});
                $('#frm_editar_clave')[0].reset();
            }else{
                //si el mensaje ES DIFERENTE de indefinido o nulo, mostrara el mensaje que viene desde el servidor
                //si el mensaje SI ES nulo o indefinido, dira que ocurrio un error, esto sucede cuando las consultas fallan
                if(respuesta.mensaje != undefined || respuesta.mensaje != null){
                    swal({ title: "Información!", text: respuesta.mensaje, icon: "info", button: "Aceptar", closeOnClickOutside: false });
                }else{
                    swal({ title: "Error!", text: "Ocurrió un error al realizar la operación.", icon: "error", button: "Aceptar", closeOnClickOutside: false });
                }
            }
        }, error: function(respuesta){
            console.log("Error:");
            console.log(respuesta);
        }
    });
}