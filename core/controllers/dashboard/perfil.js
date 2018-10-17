$(document).ready(function(){
    cargar();
});

function cargar(){
    window.setTimeout(function(){
        online();
        window.setTimeout(function(){    
            llenar_perfil(info_usuario);
        }, 100);
    }, 100);
}

function llenar_perfil(info_usuario){
    $("#id_usuario").val(info_usuario.Id_Usuario);
    $("#e_nombres").val(info_usuario.Nombres);
    $("#e_apellidos").val(info_usuario.Apellidos);
    $("#e_correo").val(info_usuario.Correo);
    $("#e_alias").val(info_usuario.Alias);
}

function editar_perfil(){
    var datos = $("#frm_perfil").serialize();
    $.ajax({
        type: "POST",
        data: datos,
        url: "../../core/controllers/scripts/usuarios.php?accion=editar_perfil",
        success: function (respuesta) {
            if(respuesta.resultado){
                swal({title: "Aviso!", text: "Operación realizada con éxito", icon: "success", button: "Aceptar", closeOnClickOutside: false});
                $('#frm_perfil')[0].reset();
                cargar();
            }else{
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
    var datos = $("#frm_editar_clave").serialize() + "&" + $("#frm_perfil").serialize();
    $.ajax({
        type: "POST",
        data: datos,
        url: "../../core/controllers/scripts/usuarios.php?accion=editar_clave",
        success: function (respuesta) {
            if(respuesta.resultado){
                swal({title: "Aviso!", text: "Operación realizada con éxito", icon: "success", button: "Aceptar", closeOnClickOutside: false});
                $('#frm_editar_clave')[0].reset();
            }else{
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
    
    if(String($("#nueva").val()) == String($("#confirmar").val())){

    }else{
        swal({ title: "Información!", text: "Las claves no son iguales", icon: "info", button: "Aceptar", closeOnClickOutside: false });
    }
}