$(document).ready(function(){
    window.setTimeout(function(){
        online();
    }, 100);
    seleccionar();
});

function click_registro(registro){
    registro = JSON.parse(registro.replace(/@&/g, "\""));
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
                var tabla_cuerpo = "";
                respuesta.registros.forEach(registro => {
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
                $("#tbody_registros").html(tabla_cuerpo);
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
    var datos = $("#frm_agregar").serialize();
    $.ajax({
        type: "POST",
        data: datos,
        url: "../../core/controllers/scripts/instituciones.php?accion=insertar",
        success: function (respuesta) {
            if(respuesta.resultado){
                swal({title: "Aviso!", text: "Operación realizada con éxito", icon: "success", button: "Aceptar", closeOnClickOutside: false});
                seleccionar();
                $('#frm_agregar')[0].reset();
                $("#mdl_agregar").modal("hide");
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

function editar(){
    var datos = $("#frm_editar").serialize();
    $.ajax({
        type: "POST",
        data: datos,
        url: "../../core/controllers/scripts/instituciones.php?accion=editar",
        success: function (respuesta) {
            if(respuesta.resultado){
                swal({title: "Aviso!", text: "Operación realizada con éxito", icon: "success", button: "Aceptar", closeOnClickOutside: false});
                seleccionar();
                $('#frm_editar')[0].reset();
                $("#mdl_editar").modal("hide");
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

function eliminar(id){
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
                    if(respuesta.resultado){
                        swal({title: "Aviso!", text: "Operación realizada con éxito", icon: "success", button: "Aceptar", closeOnClickOutside: false});
                        seleccionar();
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
    });
}