$(document).ready(function(){
    online();
    seleccionar();
});

//cuando se selecciona un registro, de esta manera se llenan los campos del modal
function click_registro(registro){
    //en la tabla, esta el registro en formato JSON reemplazando las " por @& para poder ponerlo en un
    //solo parametro, al recibirlo aqui, volvemos a hacerlo formato json y posteriormente un arreglo
    registro = JSON.parse(registro.replace(/@&/g, "\""));
    //seteamos los valores
    $("#id_institucion").val(registro.Id_Institucion_Procedencia);
    $("#e_institucion").val(registro.Institucion_Procedencia);
}

function seleccionar(){
    $.ajax({
        type: "POST",
        data: null,
        url: "../../core/controllers/scripts/instituciones.php?accion=seleccionar",
        success: function (respuesta) {
            if(respuesta.registros.length > 0){
                var tabla_cuerpo = '\
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-registros">\
                    <thead>\
                        <tr>\
                            <th class="text-center">Institución</th>\
                            <th class="text-center">Acciones</th>\
                        </tr>\
                    </thead>\
                    <tbody>';
                //ciclo para armar las filas de la tabla
                respuesta.registros.forEach(registro => {
                    //reemplazando los " por @& en el string json para solo tener un parametro en el editar
                    var parametros = JSON.stringify(registro).replace(/"/g, "@&");
                    tabla_cuerpo = tabla_cuerpo + '\
                        <tr>\
                            <td>'+registro.Institucion_Procedencia+'</td>\
                            <td class="text-center">\
                                <a href="#mdl_editar" data-toggle="modal" class="btn btn-warning" onclick="click_registro(\''+parametros+'\');">\
                                    <i class="fa fa-pencil"></i> Editar\
                                </a>\
                                <a class="btn btn-danger" onclick="eliminar('+registro.Id_Institucion_Procedencia+')">\
                                    <i class="fa fa-trash"></i> Eliminar\
                                </a>\
                            </td>\
                        </tr>';
                });
                tabla_cuerpo = tabla_cuerpo + '\
                    </tbody>\
                </table>';
                //llenando el contenedor de la tabla
                $("#content_registros").html(tabla_cuerpo);
                //inicializando la datatable
                window.setTimeout(function(){
                    initTabla("dataTables-registros");
                }, 100);
            }else{
                //mensaje si la consulta devuelve 0 registros
                var mensaje = '\
                <div class="alert alert-info">\
                    <i class="fa fa-info"></i>\
                    No existen registros.\
                </div>';
                $("#content_registros").html(mensaje);
            }
        }, error: function(respuesta){
            console.log("Error:");
            console.log(respuesta);
        }
    });
}

function insertar(){
    //obteniendo los datos del formulario
    var datos = $("#frm_agregar").serialize();
    $.ajax({
        type: "POST",
        data: datos,
        url: "../../core/controllers/scripts/instituciones.php?accion=insertar",
        success: function (respuesta) {
            if(respuesta.resultado){
                //mensaje de exito, recargando tabla, reseteando formulario y cerrando modal
                swal({title: "Aviso!", text: "Operación realizada con éxito", icon: "success", button: "Aceptar", closeOnClickOutside: false});
                seleccionar();
                $('#frm_agregar')[0].reset();
                $("#mdl_agregar").modal("hide");
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

function editar(){
    //obteniendo los datos del formulario
    var datos = $("#frm_editar").serialize();
    $.ajax({
        type: "POST",
        data: datos,
        url: "../../core/controllers/scripts/instituciones.php?accion=editar",
        success: function (respuesta) {
            if(respuesta.resultado){
                //mensaje de exito, recargando tabla, reseteando formulario y cerrando modal
                swal({title: "Aviso!", text: "Operación realizada con éxito", icon: "success", button: "Aceptar", closeOnClickOutside: false});
                seleccionar();
                $('#frm_editar')[0].reset();
                $("#mdl_editar").modal("hide");
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

function eliminar(id){
    //pido confirmacion de la accion
    swal({
        title: "ADVERTENCIA", text: "Esta apunto de eliminar un registro del sistema.\nEsta operación puede afectar los registros relacionados.\n¿Desea continuar?", icon: "warning", closeOnClickOutside: false,
        buttons: ["Cancelar", "Eliminar"], dangerMode: true
    }).then(function(aceptar) {
        if(aceptar){
            $.ajax({
                type: "POST",
                data: "id_institucion="+id,
                url: "../../core/controllers/scripts/instituciones.php?accion=eliminar",
                success: function (respuesta) {
                    //mensaje de exito y recargando la tabla
                    if(respuesta.resultado){
                        swal({title: "Aviso!", text: "Operación realizada con éxito", icon: "success", button: "Aceptar", closeOnClickOutside: false});
                        seleccionar();
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
    });
}