$(document).ready(function(){
    window.setTimeout(function(){
        online();
    }, 100);
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
                respuesta.registros.forEach(registro => {
                    reporte = "../../core/reports/dashboard/detalles_postulante.php?id="+registro.Id_Postulante;
                    fila = '\
                    <tr>\
                        <td>'+registro.Nombres+' '+registro.Apellidos+'</td>\
                        <td>'+registro.Institucion_Procedencia+'</td>\
                        <td>'+registro.Telefonos+'</td>\
                        <td>'+registro.Correo+'</td>\
                        <td class="text-center">\
                            <a class="btn btn-info" href="'+reporte+'" target="_blank">\
                                <i class="fa fa-file"></i> Detalles\
                            </a>\
                        </td>\
                    </tr>';

                    if(registro.Estado == 3){//finalizadas
                        tabla_cuerpo_f = tabla_cuerpo_f + fila;
                    }
                    if(registro.Estado == 2){//guardadas
                        tabla_cuerpo_g = tabla_cuerpo_g + fila;
                    }
                });
                $("#tbody_registros_f").html(tabla_cuerpo_f);
                $("#tbody_registros_g").html(tabla_cuerpo_g);
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