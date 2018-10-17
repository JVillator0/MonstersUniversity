<?php
//titulo de la tab
$_POST["titulo_tab"] = "Postulantes por carrera";
//mandando a llamar las dependencias que utilizaremos en este reporte
require_once("_master.php");
require_once("../../helpers/php/conexion.class.php");
require_once("../../helpers/php/validator.class.php");
require_once("../../models/detalles.class.php");
require_once("../../models/carreras.class.php");
//instanciando el pdf de forma vertical (P), en milimetros (mm), y tama;o de pagina Letter osea Carta
$pdf = new PDF("P", "mm", "Letter");
$pdf->AddPage(); 
$pdf->setY(45);

//obtenemos la informacion del postulante que especificamso en la url
//instanciamos la clase
$cls_detalles = new cls_detalles;
//obtenemos la informacion
$postulantes = $cls_detalles->seleccionar_postulantes_x_carrera();

//instanciamos la clase
$cls_carreras = new cls_carreras;
//obtenemos la informacion
$carreras = $cls_carreras->seleccionar();

//iniciamos la easytable del header, especificamos las medidas de las columnas en %
$tb_header = new easyTable($pdf, "%{20, 20, 20, 20, 20}");
//especificamos el estilo de la fila
$tb_header->rowStyle("valign:M; align:{L}; border:; font-family:arial; font-size:15; font-style:B;");
//escribimos
$tb_header->easyCell("Postulantes por carreras", "border:; colspan:5;"); 
//imprimimos la fila
$tb_header->printRow();
//terminamos la tabla
$tb_header->endTable(5);

//recorremos todas las carreras
for ($i=0; $i < count($carreras); $i++) { 
    //iniciamos la easytable de la informacion del postulante, especificamos las medidas de las columnas en %
    $tb_reporte = new easyTable($pdf, "%{22, 22, 24, 32}");
    //imprimimos una fila que abarca las 5 columnas donde especificamos la informacion que sera presentada a continuacion
    $tb_reporte->rowStyle("valign:M; align:{CCCC}; border:1; font-family:arial; font-size:15; font-style:B;");
    $tb_reporte->easyCell("~".$carreras[$i]["Carrera"]."~", "colspan:5;"); 
    $tb_reporte->printRow();

    //imprimimos los encabezados de la tabla
    $tb_reporte->rowStyle("valign:M; align:{CCCC}; border:1; font-family:arial; font-style:B; font-size:12;");
    $tb_reporte->easyCell("Nombre completo", "border:LB; colspan:1;"); 
    $tb_reporte->easyCell("Institución", "border:LB; colspan:1;"); 
    $tb_reporte->easyCell("Teléfonos", "border:LB; colspan:1;"); 
    $tb_reporte->easyCell("Correo eletrónico", "border:LRB; colspan:1;"); 
    $tb_reporte->printRow();

    //recorremos el arreglo de los postulantes
    for ($j=0; $j < count($postulantes); $j++) {
        //si son de la institucion que esta en curso en el primer ciclo, los pondra 
        if($carreras[$i]["Id_Carrera"] == $postulantes[$j]["Id_Carrera"]){
            $tb_reporte->rowStyle("valign:M; align:{LLLL}; border:1; font-family:arial; font-style:; font-size:10;");
            $tb_reporte->easyCell($postulantes[$j]["Nombres"] . " " . $postulantes[$j]["Apellidos"], "border:LB; colspan:1;"); 
            $tb_reporte->easyCell($postulantes[$j]["Institucion_Procedencia"], "border:LB; colspan:1;"); 
            $tb_reporte->easyCell($postulantes[$j]["Telefonos"], "border:LB; colspan:1;"); 
            $tb_reporte->easyCell($postulantes[$j]["Correo"], "border:LRB; colspan:1;"); 
            $tb_reporte->printRow();
        }
    }
    //terminamos la tabla
    $tb_reporte->endTable(5);
    //nos pasamos a la siguiente pagina
    $pdf->SetY(-17);
}

//cerramos el pdf y especificamos el nombre del mismo
$pdf->close();
$pdf->Output("", "Postulantes por carrera.pdf"); 

?>