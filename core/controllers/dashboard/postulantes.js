$(document).ready(function(){
    online();
    seleccionar();
});

function seleccionar(){
    $("#tbody_registros").html("");
    $.ajax({
        type: "POST",
        data: null,
        url: "../../core/controllers/scripts/detalles.php?accion=seleccionar_inners",
        success: function (respuesta) {
            if(respuesta.registros.length > 0){
                var tabla_cuerpo_f = "";
                var tabla_cuerpo_g = "";
                var fila = "";
                var reporte = "";
                //ciclo para armar la tabla
                respuesta.registros.forEach(registro => {
                    if(registro.Tel_Movil == null){
                        registro.Tel_Movil = "";
                    }
                    if(registro.Tel_Fijo == null){
                        registro.Tel_Fijo = "";
                    }
                    //ruta del reporte
                    reporte = "../../core/reports/dashboard/detalles_postulante.php?id="+registro.Id_Postulante;
                    //fila de la tabla
                    fila = '\
                    <tr>\
                        <td>'+registro.Nombres+' '+registro.Apellidos+'</td>\
                        <td>'+registro.Institucion_Procedencia+'</td>\
                        <td>'+registro.Tel_Fijo+', '+registro.Tel_Movil+'</td>\
                        <td>'+registro.Correo+'</td>\
                        <td class="text-center">\
                            <a class="btn btn-info" href="'+reporte+'" target="_blank">\
                                <i class="fa fa-file"></i> Detalles\
                            </a>\
                        </td>\
                    </tr>';

                    //especificando a que tabla ira
                    if(registro.Estado == 3){//finalizadas
                        tabla_cuerpo_f = tabla_cuerpo_f + fila;
                    }
                    if(registro.Estado == 2){//guardadas
                        tabla_cuerpo_g = tabla_cuerpo_g + fila;
                    }
                });
                //llenando los tbody de las tablas
                $("#tbody_registros_f").html(tabla_cuerpo_f);
                $("#tbody_registros_g").html(tabla_cuerpo_g);
                //inicializando las datatables
                window.setTimeout(function(){
                    initTabla("dataTables-registros-f");
                    initTabla("dataTables-registros-g");
                }, 100);
            }
        }, error: function(respuesta){
            console.log("Error:");
            console.log(respuesta);
        }
    });
}