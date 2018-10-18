$(document).ready(function () {
    //inicializo los tooltip chidos de bootstrap 
    $('[data-toggle="tooltip"]').tooltip();
    //obtengo las fechas minimas y maximas para el datepicker
    min = getFechaAtras(100, "year", "DD/MM/YYYY");
    max = getFechaAtras(16, "year", "DD/MM/YYYY");
    //inicializo el datepicker
    datepickers("fecha_nacimiento", min, max, max);
});

//metodo para obtener la fecha hace x cantidad de tiempo a partir de la fecha actual
function getFechaAtras(num, tipo, formato) {
    return moment().subtract(num, tipo).format(formato);
}

//metodo para inicializar los datepickers
function datepickers(id, min, max, valor){
    $("#"+id).datepicker({
        uiLibrary: "bootstrap4",
        locale: "es-es",
        format: "dd/mm/yyyy",
        value: valor,
        maxDate: max,
        minDate: min
    });
}

//obtengo la informacion del usuario que este dentro del sistema
var info_usuario = null;
function online(){
    $.ajax({
        type: "POST",
        data: null,
        url: "../../core/controllers/scripts/postulantes.php?accion=online",
        success: function (respuesta) {
            
            //pongo HTML en estos divs de la pagina web, para identificar el usuario dentro si es que lo hay

            $("#btn_acceso").html("");
            $("#btn_cerrar_sesion").html("");
            $("#btn_postulante").html("");

            //dependiendo de si hay o no un usuario online, cambio el DOM para que vea diferentes botones
            if(respuesta.resultado){
                $("#btn_postulante").html('\
                    <a class="btn btn-success btn-sm" data-toggle="modal" href="#mdl_postulacion">\
                        '+respuesta.registro.Correo+'\
                    </a>\
                ');
                $("#btn_cerrar_sesion").html('\
                    <a href="#" class="btn btn-sm btn-danger" onclick="destroy();">\
                        <i class="fa fa-power-off"></i>\
                    </a>\
                ');
            }else{
                $("#btn_acceso").html('\
                    <a class="btn btn-success btn-sm" data-toggle="modal" href="#mdl_acceso">\
                        Postulantes\
                    </a>\
                ');
            }
        }, error: function(respuesta){
            console.log("Error:");
            console.log(respuesta);
        }
    });
}

//metodo para iniciar sesion
function login(){
    var datos = $("#frm_login").serialize();
    $.ajax({
        type: "POST",
        data: datos,
        url: "../../core/controllers/scripts/postulantes.php?accion=login",
        success: function (respuesta) {
            if(respuesta.resultado){
                online();
                swal({title: "Bienvenido!", text: "", icon: "success", button: "Aceptar", closeOnClickOutside: false});
                $('#frm_login')[0].reset();
                $("#mdl_acceso").modal("hide");
                cargar_solicitud();
            }else{
                swal({ title: "Información!", text: respuesta.mensaje, icon: "info", button: "Aceptar", closeOnClickOutside: false });
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
                url: "../../core/controllers/scripts/postulantes.php?accion=destroy",
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