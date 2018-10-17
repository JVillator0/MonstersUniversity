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