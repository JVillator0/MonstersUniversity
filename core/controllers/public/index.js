$(document).ready(function () {
    //metodos para obtener los datos que utiliza la pagina
    online();
    seleccionar_carreras();
    seleccionar_especialidades();
    seleccionar_instituciones();
    cargar_solicitud();
    //aplicando mascaras a los inputs que las necesitan
    $("#tel_movil").mask("0000-0000");
    $("#tel_fijo").mask("0000-0000");
    $("#dui").mask("00000000-0");
    $("#nit").mask("0000-000000-000-0");
});

//div del catch es para quitar y poner el recaptcha en diferentes posiciones de la pagina
//esto es porque lo necesito en dos partes del mismo sitio, pero el recaptcha verifica que 
//todos esten chequeados, asi que cuando tengo los dos activos se chocan y no funcionam bien
//los procesos, por lo que preferi controlar cual recaptcha quiero ver segun la opcion que ve el usuario 
function div_catch(caso){
    $("#catch_registrarse").html('');
    $("#catch_restablecer").html('');
    switch (caso) {
        case "registrarse":
            $("#catch_registrarse").html('\
                <div class="g-recaptcha" data-sitekey="6LdP8WYUAAAAAOe1rptxGjJncC41dJQyViDSseiJ"></div>\
                <script src="https://www.google.com/recaptcha/api.js?hl=es"></script>\
            ');
            break;

        case "restablecer":
            $("#catch_restablecer").html('\
                <div class="g-recaptcha" data-sitekey="6LdP8WYUAAAAAOe1rptxGjJncC41dJQyViDSseiJ"></div>\
                <script src="https://www.google.com/recaptcha/api.js?hl=es"></script>\
            ');
            break;
    
        default:
            break;
    }
}

//metodo que carga las carreras de la base de datos, los pone en el cmb de postulacion
//y tambien carga las miasmas carreras en el public para que lo vean todos
function seleccionar_carreras(){
    $.ajax({
        type: "POST", 
        data: null, 
        url: "../../core/controllers/scripts/carreras.php?accion=seleccionar", 
        success: function (respuesta) {
            if(respuesta.registros.length > 0){
                var content_cuerpo = "";
                var cmb_cuerpo = "<option selected value='0'>Seleccionar...</option>";
                //armo la tabla a partir de los registros obtenidos
                respuesta.registros.forEach(registro => {
                    content_cuerpo = content_cuerpo + '\
                    <div class="col-lg-4 col-md-6 text-center">\
                        <div class="service-box mt-5 mx-auto">\
                            <h3 class="mb-3">'+registro.Carrera+'</h3>\
                            <p class="text-muted mb-0">\
                            '+registro.Descripcion+'\
                            </p>\
                        </div>\
                    </div>';
                    cmb_cuerpo = cmb_cuerpo + '<option value="'+registro.Id_Carrera+'">'+registro.Carrera+'</option>';
                });
                //seteo la tabla o select al elemento del dom especificado
                $("#content_carreras").html(content_cuerpo);
                $("#cmb_carreras").html(cmb_cuerpo);
            }
        }, error: function(respuesta){
            console.log("Error:");
            console.log(respuesta);
        }
    });
}

//metodo que carga las especialidades desde la base de datos y las pone en un cmb armando la estructura
function seleccionar_especialidades(){
    $.ajax({
        type: "POST", 
        data: null, 
        url: "../../core/controllers/scripts/especialidades.php?accion=seleccionar", 
        success: function (respuesta) {
            if(respuesta.registros.length > 0){
                //primera opcion del select que se armara
                var cmb_cuerpo = "<option selected value='0'>Seleccionar...</option>";
                //armando cuerpo del select
                respuesta.registros.forEach(registro => {
                    cmb_cuerpo = cmb_cuerpo + '<option value="'+registro.Id_Especialidad+'">'+registro.Especialidad+'</option>';
                });
                //seteando las opciones al select
                $("#cmb_especialidades").html(cmb_cuerpo);
            }
        }, error: function(respuesta){
            console.log("Error:");
            console.log(respuesta);
        }
    });
}

//metodo que carga las instituciones de procedencia desde la base de datos y las pone en un cmb armando la estructura
function seleccionar_instituciones(){
    $.ajax({
        type: "POST", 
        data: null, 
        url: "../../core/controllers/scripts/instituciones.php?accion=seleccionar", 
        success: function (respuesta) {
            if(respuesta.registros.length > 0){
                //primera opcion del select que se armara
                var cmb_cuerpo = "<option selected value='0'>Seleccionar...</option>";
                //armando cuerpo del select
                respuesta.registros.forEach(registro => {
                    cmb_cuerpo = cmb_cuerpo + '<option value="'+registro.Id_Institucion_Procedencia+'">'+registro.Institucion_Procedencia+'</option>';
                });
                //seteando las opciones al select
                $("#cmb_instituciones").html(cmb_cuerpo);
            }
        }, error: function(respuesta){
            console.log("Error:");
            console.log(respuesta);
        }
    });
}

//metodo apra registrar un postulante
function registrar_postulante(){
    //verifico el captcha
    var response = grecaptcha.getResponse();
    if (response.length == 0) {
        swal({ title: "Información!", text: "Por favor verifique el captcha", icon: "info", button: "Aceptar", closeOnClickOutside: false });
    } else {
        //obtengo los datos del formulario
        var datos = $("#frm_registrar").serialize();
        $.ajax({
            type: "POST",
            data: datos,
            url: "../../core/controllers/scripts/postulantes.php?accion=insertar",
            success: function (respuesta) {
                //si todo salio bien, success
                if(respuesta.resultado){
                    swal({title: "Aviso!", text: "Operación realizada con éxito", icon: "success", button: "Aceptar", closeOnClickOutside: false});
                    $('#frm_registrar')[0].reset();
                    $(".nav-tabs a[href=\"#nav-home\"]").tab("show");
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
}

//metodo que llena los inputs de los detalles por postulante
function cargar_solicitud(){
    //controla los botones del modal, primero sin botones
    $("#btns_solicitud").html("");
    $.ajax({
        type: "POST", 
        data: null, 
        url: "../../core/controllers/scripts/detalles.php?accion=seleccionar_online", 
        success: function (respuesta) {
            if(respuesta.resultado){
                if(respuesta.registros.length > 0){

                    //llenando los inputs, siempre y cuando sea != null lo que setearemos
                    var registro = respuesta.registros[0];
                    if(registro.Id_Detalle_Postulante != null){
                        $("#id_detalle_postulante").val(registro.Id_Carrera);
                    }
                    if(registro.Id_Institucion_Procedencia != null){
                        $("#cmb_instituciones").val(registro.Id_Institucion_Procedencia);
                    }
                    if(registro.Id_Especialidad != null){
                        $("#cmb_especialidades").val(registro.Id_Especialidad);
                    }
                    if(registro.Anio_Inicio_B != null){
                        $("#anio_inicio").val(registro.Anio_Inicio_B);
                    }
                    if(registro.Anio_Fin_B != null){
                        $("#anio_fin").val(registro.Anio_Fin_B);
                    }
                    if(registro.Tel_Fijo != null){
                        $("#tel_fijo").val(registro.Tel_Fijo);
                    }
                    if(registro.Tel_Movil != null){
                        $("#tel_movil").val(registro.Tel_Movil);
                    }
                    if(registro.Fecha_Nacimiento != null){
                        $("#fecha_nacimiento").val(registro.Fecha_Nacimiento);
                    }
                    if(registro.DUI != null){
                        $("#dui").val(registro.DUI);
                    }
                    if(registro.NIT != null){
                        $("#nit").val(registro.NIT);
                    }
                    if(registro.Id_Carrera != null){
                        $("#cmb_carreras").val(registro.Id_Carrera);
                    }
                    //modificamos el atributo src de una etiqueta img para mostrar la imagen
                    if(registro.Imagen != null){
                        $("#img_detalle").attr("src", "../../resource/img/postulantes/"+registro.Imagen);
                        //en un input invisible ponemos el nombre de la imagen
                        $("#imagen").val(registro.Imagen);
                    }

                    //segun el estado de la solicitud se dispone de diferentes botones
                    var btns = "";
                    if(registro.Estado == 1){ //sin ingresar detalle
                        btns = '\
                        <a class="btn btn-success font-white" data-toggle="tooltip"\
                            data-placement="bottom" title="Guarda los datos sin finalizar la solicitud, dejando lugar a modificaciones."\
                            onclick="registrar_detalle_postulante();" >\
                            Guardar <i class="fa fa-save"></i>\
                        </a>';
                    }
                    if(registro.Estado == 2){ //ingreso detalles pero aun no ha finalizado
                        btns = '\
                        <a class="btn btn-success font-white" data-toggle="tooltip"\
                            data-placement="bottom" title="Guarda los datos sin finalizar la solicitud, dejando lugar a modificaciones."\
                            onclick="editar_detalle_postulante();" >\
                            Guardar <i class="fa fa-save"></i>\
                        </a>\
                        <a class="btn btn-danger font-white" data-toggle="tooltip"\
                            data-placement="bottom" title="Finaliza la solicitud y ya no podra ser modificada posteriormente."\
                            onclick="finalizar_detalle_postulante();">\
                            Finalizar <i class="fa fa-check"></i>\
                        </a>';
                    }
                    if(registro.Estado == 3){ //finalizo de llenar la informacion de la solicitud
                        btns = '\
                        <a class="btn btn-primary font-white" data-toggle="tooltip"\
                            data-placement="bottom" title="Reporte en PDF con los datos ingresados."\
                            href="../../core/reports/public/detalles_postulante.php" target="_blank">\
                            Solicitud <i class="fa fa-file"></i>\
                        </a>';
                    }
                    //se carga el html en el div respectivo
                    $("#btns_solicitud").html(btns);
                }
            }
        }, error: function(respuesta){
            console.log("Error:");
            console.log(respuesta);
        }
    });
}

//metodo para ingresar la informacion del detalle
function registrar_detalle_postulante(){
    //al contener una imagen, se envia de esta forma, para que por medio de ajax se vaya la imagen al php
    //formData, con document.getElementById, con $("#frm_detalle") no funciona 
    var datos = new FormData(document.getElementById("frm_detalle"));
    $.ajax({
        type: "POST",
        data: datos,
        url: "../../core/controllers/scripts/detalles.php?accion=insertar",
        //parametros extras SUPER necesarios para poder enviar el FILE
        cache: false, 
        contentType: false, 
        processData: false, 
        success: function (respuesta) {
            //ingreso el detalle correctamente?
            if(respuesta.resultado){
                //entonces cambiara el estado del postulante
                $.ajax({
                    type: "POST", data: null, url: "../../core/controllers/scripts/postulantes.php?accion=iniciar",
                    success: function (respuesta) {
                        //ya cambio el estado?
                        if(respuesta.resultado){
                            //apues ahora si, success, vaciamos el form y lo llenamos con info desde la base ya
                            swal({title: "Aviso!", text: "Operación realizada con éxito", icon: "success", button: "Aceptar", closeOnClickOutside: false});
                            $('#frm_detalle')[0].reset();
                            cargar_solicitud();
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

function editar_detalle_postulante(){
    //al contener una imagen, se envia de esta forma, para que por medio de ajax se vaya la imagen al php
    //formData, con document.getElementById, con $("#frm_detalle") no funciona 
    var datos = new FormData(document.getElementById("frm_detalle"));
    $.ajax({
        type: "POST",
        data: datos,
        url: "../../core/controllers/scripts/detalles.php?accion=editar",
        //parametros extras SUPER necesarios para poder enviar el FILE
        cache: false, 
        contentType: false, 
        processData: false, 
        success: function (respuesta) {
            //ingreso el detalle correctamente?
            if(respuesta.resultado){
                //apues ahora si, success, vaciamos el form y lo llenamos con info desde la base ya
                swal({title: "Aviso!", text: "Operación realizada con éxito", icon: "success", button: "Aceptar", closeOnClickOutside: false});
                $('#frm_detalle')[0].reset();
                cargar_solicitud();
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

//se le pregunta al postulante si esta seguro de finalizar
function finalizar_detalle_postulante(){
    swal({
        title: "ADVERTENCIA", text: "Esta apunto de finalizar la solicitud, sin posibilidad de cambiar la información nuevamente.\n¿Desea continuar?", icon: "warning", closeOnClickOutside: false,
        buttons: ["Cancelar", "Eliminar"], dangerMode: true
    }).then(function(aceptar) {
        if(aceptar){
            //si esta seguro, se cambia el estado del postulante y se vuelve a cargar la solicitud para que cambien los botones
            //ya no podra hacer ningun cambio a la informacion que antes lleno
            $.ajax({
                type: "POST", data: null, url: "../../core/controllers/scripts/postulantes.php?accion=finalizar",
                success: function (respuesta) {
                    if(respuesta.resultado){
                        swal({title: "Aviso!", text: "Operación realizada con éxito", icon: "success", button: "Aceptar", closeOnClickOutside: false});
                        cargar_solicitud();
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

var CODIGO_RESTAURAR = "";
var ID = "";

function restaurar_enviar_email(){
    //verifico el captcha
    var response = grecaptcha.getResponse();
    if (response.length == 0) {
        swal({ title: "Información!", text: "Por favor verifique el captcha", icon: "info", button: "Aceptar", closeOnClickOutside: false });
    } else {
        var datos = $("#frm_correo").serialize();
        $.ajax({
            type: "POST",
            data: datos,
            url: "../../core/controllers/scripts/postulantes.php?accion=restaurar_enviar_email",
            success: function (respuesta) {
                if(respuesta.resultado){
                    //si el resultado fue true, guardo el codigo que se envio, y la id del postulante
                    CODIGO_RESTAURAR = respuesta.codigo;
                    ID = respuesta.id;
                    //reseteo y al siguiente paso
                    $("#frm_correo")[0].reset();
                    $("#mdl_restaurar_1").modal("hide");
                    $("#mdl_restaurar_2").modal("show");
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
}

function verificar_codigo(){
    //en la verificacion es basicamente comparar strings y ver que esten correctos
    if(String($("#codigo_verificar").val()) == String(CODIGO_RESTAURAR)){
        $("#frm_codigo_verificar")[0].reset();
        $("#mdl_restaurar_2").modal("hide");
        $("#mdl_restaurar_3").modal("show");
    }else{
        swal({ title: "Información!", text: "Código incorrecto.", icon: "info", button: "Aceptar", closeOnClickOutside: false });
    }
}

function restaurar(){
    //para restaurar obtengo la info del frm y agrego la id del postulante recuperando
    var datos = $("#frm_restaurar").serialize() + "&id="+ID;
    $.ajax({
        type: "POST",
        data: datos,
        url: "../../core/controllers/scripts/postulantes.php?accion=restaurar",
        success: function (respuesta) {
            if(respuesta.resultado){
                $("#frm_restaurar")[0].reset();
                $("#mdl_restaurar_3").modal("hide");
                //reseteo y mensaje de exito
                swal({title: "Aviso!", text: "Operación realizada con éxito", icon: "success", button: "Aceptar", closeOnClickOutside: false});
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