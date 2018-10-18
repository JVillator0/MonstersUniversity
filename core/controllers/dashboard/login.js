$(document).ready(function(){
    
});

//metodo con el cual el usuario inicia sesion
function login(){
    var datos = $("#frm_login").serialize();
    $.ajax({
        type: "POST",
        data: datos,
        url: "../../core/controllers/scripts/usuarios.php?accion=login",
        success: function (respuesta) {
            if(respuesta.resultado){
                window.location = "index.php";
            }else{
                swal({ title: "Información!", text: respuesta.mensaje, icon: "info", button: "Aceptar", closeOnClickOutside: false });
            }
        }, error: function(respuesta){
            console.log("Error:");
            console.log(respuesta);
        }
    });
}

//variables para almacenar informacion capturada en el proceso de restaurar la clave
var CODIGO_RESTAURAR = "";
var ID = "";

//envia el correo electronico al usuario y obtiene el id de mismo y su codigo de verificacion
function restaurar_enviar_email(){
    var datos = $("#frm_alias").serialize();
    $.ajax({
        type: "POST",
        data: datos,
        url: "../../core/controllers/scripts/usuarios.php?accion=restaurar_enviar_email",
        success: function (respuesta) {
            if(respuesta.resultado){
                //capturando datos
                CODIGO_RESTAURAR = respuesta.codigo;
                ID = respuesta.id;
                //reseteando y pasando al siguiente paso
                $("#frm_alias")[0].reset();
                $("#mdl_restaurar_1").modal("hide");
                $("#mdl_restaurar_2").modal("show");
            }else{
                swal({ title: "Información!", text: respuesta.mensaje, icon: "info", button: "Aceptar", closeOnClickOutside: false });
            }
        }, error: function(respuesta){
            console.log("Error:");
            console.log(respuesta);
        }
    });
}

function verificar_codigo(){
    //comparando el codigo de entrada con el que fue enviado
    if(String($("#codigo_verificar").val()) == String(CODIGO_RESTAURAR)){
        //reseteando y pasando al siguiente paso
        $("#frm_codigo_verificar")[0].reset();
        $("#mdl_restaurar_2").modal("hide");
        $("#mdl_restaurar_3").modal("show");
    }else{
        swal({ title: "Información!", text: "Código incorrecto.", icon: "info", button: "Aceptar", closeOnClickOutside: false });
    }
}

function restaurar(){
    //obtiene la informacion de las claves para restaurar y agrego la id del que esta restableciendo la clave
    var datos = $("#frm_restaurar").serialize() + "&id="+ID;
    $.ajax({
        type: "POST",
        data: datos,
        url: "../../core/controllers/scripts/usuarios.php?accion=restaurar",
        success: function (respuesta) {
            if(respuesta.resultado){
                $("#frm_restaurar")[0].reset();
                $("#mdl_restaurar_3").modal("hide");
                //reseteo y mensaje de exito
                swal({title: "Aviso!", text: "Operación realizada con éxito", icon: "success", button: "Aceptar", closeOnClickOutside: false});
            }else{
                swal({ title: "Información!", text: respuesta.mensaje, icon: "info", button: "Aceptar", closeOnClickOutside: false });
            }
        }, error: function(respuesta){
            console.log("Error:");
            console.log(respuesta);
        }
    });
}