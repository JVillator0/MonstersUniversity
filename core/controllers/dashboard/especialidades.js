$(document).ready(function(){
    online();
    seleccionar();
});

//cuando se selecciona un registro, de esta manera se llenan los campos del modal
function click_registro(registro){
    //en la tabla, esta el registro en formato JSON reemplazando las " por @& para poder ponerlo en un
    //solo parametro, al recibirlo aqui, volvemos a hacerlo formato json y posteriormente un arreglo
    registro = JSON.parse(registro.replace(/@&/g, "\""));
    $("#id_especialidad").val(registro.Id_Especialidad);
    $("#e_especialidad").val(registro.Especialidad);
}

function seleccionar(){
    $.ajax({
        type: "POST",
        data: null,
        url: "../../core/controllers/scripts/especialidades.php?accion=seleccionar",
        success: function (respuesta) {
            if(respuesta.registros.length > 0){
                var tabla_cuerpo = "";
                //ciclo para armar la tabla
                respuesta.registros.forEach(registro => {
                    //reemplazando los " por @& en el string json para solo tener un parametro en el editar
                    var parametros = JSON.stringify(registro).replace(/"/g, "@&");
                    tabla_cuerpo = tabla_cuerpo + '\
                    <tr>\
                        <td>'+registro.Especialidad+'</td>\
                        <td class="text-center">\
                            <a href="#mdl_editar" data-toggle="modal" class="btn btn-warning" onclick="click_registro(\''+parametros+'\');">\
                                <i class="fa fa-pencil"></i> Editar\
                            </a>\
                            <a class="btn btn-danger" onclick="eliminar('+registro.Id_Especialidad+')">\
                                <i class="fa fa-trash"></i> Eliminar\
                            </a>\
                        </td>\
                    </tr>';
                });
                //llenando el tbody de la tabla
                $("#tbody_registros").html(tabla_cuerpo);
                //inicializando la datatable
                window.setTimeout(function(){
                    initTabla("dataTables-registros");
                }, 100);
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
        url: "../../core/controllers/scripts/especialidades.php?accion=insertar",
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
        url: "../../core/controllers/scripts/especialidades.php?accion=editar",
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
    //obteniendo los datos del formulario
    swal({
        title: "ADVERTENCIA", text: "Esta apunto de eliminar un registro del sistema.\nEsta operación puede afectar los registros relacionados.\n¿Desea continuar?", icon: "warning", closeOnClickOutside: false,
        buttons: ["Cancelar", "Eliminar"], dangerMode: true
    }).then(function(aceptar) {
        if(aceptar){
            $.ajax({
                type: "POST",
                data: "id_especialidad="+id,
                url: "../../core/controllers/scripts/especialidades.php?accion=eliminar",
                success: function (respuesta) {
                    if(respuesta.resultado){
                        //mensaje de exito y recargando la tabla
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