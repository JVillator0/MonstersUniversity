<?php
//titulo de la tab
$_POST["titulo_tab"] = "Detalles del postulante";
//mandando a llamar las dependencias que utilizaremos en este reporte
require_once("_master_online.php");
require_once("../../helpers/php/conexion.class.php");
require_once("../../helpers/php/validator.class.php");
require_once("../../models/detalles.class.php");
//instanciando el pdf de forma vertical (P), en milimetros (mm), y tama;o de pagina Letter osea Carta
$pdf = new PDF("P", "mm", "Letter");
$pdf->AddPage(); 
$pdf->setY(45);

//iniciando las variables de sesion si es que no estan iniciadas antes
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

//obtenemos la informacion del postulante que especificamso en la url
$id_postulante = $_SESSION["info_postulante"][0]["Id_Postulante"];;
//instanciamos la clase
$cls_detalles = new cls_detalles;
//seteamos la id
$cls_detalles->setId_postulante($id_postulante);
//obtenemos la informacion
$postulante = $cls_detalles->seleccionar_especifico();
//reordenamos la informacion
$postulante = $postulante[0];

//iniciamos la easytable del header, especificamos las medidas de las columnas en %
$tb_header = new easyTable($pdf, "%{20, 20, 20, 20, 20}");
//especificamos el estilo de la fila
$tb_header->rowStyle("valign:M; align:{L}; border:; font-family:courier; font-size:15; font-style:B;");
//escribimos
$tb_header->easyCell("Ficha de postulante", "border:; colspan:5;"); 
//imprimimos la fila
$tb_header->printRow();
//terminamos la tabla
$tb_header->endTable(5);

//iniciamos la easytable de la informacion del postulante, especificamos las medidas de las columnas en %
$tb_postulante = new easyTable($pdf, "%{20, 20, 20, 20, 20}");
//imprimimos una fila que abarca las 5 columnas donde especificamos la informacion que sera presentada a continuacion
$tb_postulante->rowStyle("valign:M; align:{CCCCC}; border:; font-family:courier;");
$tb_postulante->easyCell("~Información personal~", "border:TRL; colspan:5; font-size:15; font-style:I;"); 
$tb_postulante->printRow();

//verificamos si encuentra la imagen
if(!is_file("../../../resource/img/postulantes/". $postulante["Imagen"])){
    //si no la encuentra, para evitar ver el error feo ahi, sobreescribimos la posicion del arreglo a una que si existe.
    $postulante["Imagen"] = "notFound.png";
}

//imprimimos la imagen, el w35, especifica el width de la imagen!
$tb_postulante->easyCell("", "border:TL; rowspan:5; colspan:1; img:../../../resource/img/postulantes/". $postulante["Imagen"] . ", w35;");
//comenzamos a poner la informacion general y normal
$tb_postulante->easyCell("Nombre completo:", 'border:TLB; font-style:B; colspan:2; font-family:courier;');
$tb_postulante->easyCell($postulante["Nombres"] . " " . $postulante["Apellidos"], 'border:TRB; colspan:2; font-family:courier;');
$tb_postulante->printRow();
$tb_postulante->easyCell("Fecha de nacimiento:", 'border:LB; font-style:B; colspan:2; font-family:courier;');
$tb_postulante->easyCell($postulante["Fecha_Nacimiento"], 'border:RB; colspan:2; font-family:courier;');
$tb_postulante->printRow();
$tb_postulante->easyCell("Correo electrónico:", 'border:LB; font-style:B; colspan:2; font-family:courier;');
$tb_postulante->easyCell($postulante["Correo"], 'border:RB; colspan:2; font-family:courier;');
$tb_postulante->printRow();
$tb_postulante->easyCell("Teléfonos:", 'border:LB; font-style:B; colspan:2; font-family:courier;');
$tb_postulante->easyCell($postulante["Telefonos"], 'border:RB; colspan:2; font-family:courier;');
$tb_postulante->printRow();
$tb_postulante->easyCell("DUI:", 'border:L; font-style:B; colspan:1; font-family:courier;');
$tb_postulante->easyCell($postulante["DUI"], 'border:; colspan:1; font-family:courier;');
$tb_postulante->easyCell("NIT:", 'border:L; font-style:B; colspan:1; font-family:courier;');
$tb_postulante->easyCell($postulante["NIT"], 'border:R; colspan:1; font-family:courier;');
$tb_postulante->printRow();

//imprimimos una fila que abarca las 5 columnas donde especificamos la informacion que sera presentada a continuacion
$tb_postulante->rowStyle("valign:M; align:{CCCCC}; border:; font-family:courier;");
$tb_postulante->easyCell("~Información de bachillerato~", "border:1; colspan:5; font-size:15; font-style:I;"); 
$tb_postulante->printRow();

//escribimos la informacion respectiva al bachillerato
$tb_postulante->easyCell("Institución:", 'border:BL; font-style:B; colspan:1; font-family:courier;');
$tb_postulante->easyCell($postulante["Institucion_Procedencia"], 'border:BR; colspan:2; font-family:courier;');
$tb_postulante->easyCell("Inicio:", 'border:B; font-style:B; colspan:1; font-family:courier;');
$tb_postulante->easyCell($postulante["Anio_Inicio_B"], 'border:RB; colspan:1; font-family:courier;');
$tb_postulante->printRow();
$tb_postulante->easyCell("Especialidad:", 'border:BL; font-style:B; colspan:1; font-family:courier;');
$tb_postulante->easyCell($postulante["Especialidad"], 'border:BR; colspan:2; font-family:courier;');
$tb_postulante->easyCell("Finalización:", 'border:B; font-style:B; colspan:1; font-family:courier;');
$tb_postulante->easyCell($postulante["Anio_Fin_B"], 'border:RB; colspan:1; font-family:courier;');
$tb_postulante->printRow();

//imprimimos una fila que abarca las 5 columnas donde especificamos la informacion que sera presentada a continuacion
$tb_postulante->rowStyle("valign:M; align:{CCCCC}; border:; font-family:courier;");
$tb_postulante->easyCell("~Información de la solicitud~", "border:RLB; colspan:5; font-size:15; font-style:I;"); 
$tb_postulante->printRow();

//escribimos la informacion respectiva a la carrera que eligio en la universidad con su descripcion
$tb_postulante->easyCell("Carrera:", 'border:BL; font-style:B; colspan:1; font-family:courier;');
$tb_postulante->easyCell($postulante["Carrera"], 'border:BR; colspan:4; font-family:courier;');
$tb_postulante->printRow();
$tb_postulante->easyCell("Descripción:", 'border:LB; font-style:B; colspan:1; font-family:courier;');
$tb_postulante->easyCell($postulante["Descripcion"], 'border:RB; colspan:4; font-family:courier;');
$tb_postulante->printRow();

//por ultimo, mostramos el estado de la solicitud al momento de generarla
$tb_postulante->rowStyle("valign:M; align:{LLLLL}; border:; font-family:courier; font-size:12; font-style:B; font-color:#005282;");
$tb_postulante->easyCell("Estado:", "border:LB; colspan:1;"); 
$tb_postulante->easyCell($postulante["Estado_Str"], "border:RB; colspan:4;"); 
$tb_postulante->printRow();

//terminamos la tabla finalmente
$tb_postulante->endTable(5);

//cerramos el pdf y especificamos el nombre del mismo
$pdf->close();
$pdf->Output("", "Detalles postulante.pdf"); 

?>