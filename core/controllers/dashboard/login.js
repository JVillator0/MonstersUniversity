$(document).ready(function(){
    
});

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

var CODIGO_RESTAURAR = "";
var ID = "";

function restaurar_enviar_email(){
    var datos = $("#frm_alias").serialize();
    $.ajax({
        type: "POST",
        data: datos,
        url: "../../core/controllers/scripts/usuarios.php?accion=restaurar_enviar_email",
        success: function (respuesta) {
            if(respuesta.resultado){
                CODIGO_RESTAURAR = respuesta.codigo;
                ID = respuesta.id;
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
    if(String($("#codigo_verificar").val()) == String(CODIGO_RESTAURAR)){
        $("#frm_codigo_verificar")[0].reset();
        $("#mdl_restaurar_2").modal("hide");
        $("#mdl_restaurar_3").modal("show");
    }else{
        swal({ title: "Información!", text: "Código incorrecto.", icon: "info", button: "Aceptar", closeOnClickOutside: false });
    }
}

function restaurar(){
    var datos = $("#frm_restaurar").serialize() + "&id="+ID;
    $.ajax({
        type: "POST",
        data: datos,
        url: "../../core/controllers/scripts/usuarios.php?accion=restaurar",
        success: function (respuesta) {
            if(respuesta.resultado){
                CODIGO_RESTAURAR = respuesta.codigo;
                ID = respuesta.id;
                $("#frm_restaurar")[0].reset();
                $("#mdl_restaurar_3").modal("hide");
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