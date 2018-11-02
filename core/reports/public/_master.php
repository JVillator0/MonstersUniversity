<?php 
require_once("_validator.php");
//mandando a llamar librerias
require_once("../../../libs/fpdf/fpdf.php");
require_once("../../../libs/fpdf/exfpdf.php");
require_once("../../../libs/fpdf/easyTable.php");
//iniciando las variables de sesion si es que no estan iniciadas antes
if(session_status() == PHP_SESSION_NONE){
    session_start(); 
}
//seteando la zona horaria
date_default_timezone_set("America/El_Salvador");

//clase que extiende de FPDF para poder repetir header y footer en todas las paginas
class PDF extends exFPDF
{
    //encabezado de pagina, se repetira por cada pagina nueva del reporte
    function Header()
    {   
        //seteo de propiedades iniciales
        $this->SetFont("helvetica","",10);
        $this->SetTitle($_POST["titulo_tab"]);
        //margenes de 11 milimetros (porque siempre lo instanciamos en mm), osea 1.1cm
        $this->SetMargins(11, 11, 11); 
        //refljando el logo de la universidad
        $this->Image("../../../resource/img/logo1.png", 11, 11, 90, 25);
        $this->SetX(35);
        $this->SetFont("helvetica","",10);
        $this->SetY($this->GetY() + 27);
    }

    //pie de pagina, se repetira por cada pagina nueva del reporte
    function Footer()
    {
        //seteando la posicion del pie de pagina
        $this->SetY(-17);
        $this->SetX(10);
        //seteando el color del texto
        //poniendo informacion, autor del reporte y el # de pagina, tambien el dia y hora de generacion del reporte
        $this->Cell(105,5, utf8_decode("Autor: " . $_SESSION["info_postulante"][0]["Nombres"] . " ".$_SESSION["info_postulante"][0]["Apellidos"]) ,0,0,"L");
        $this->Cell(91,5, utf8_decode("Página: ".$this->PageNo()),0,0,"R");
        $this->SetY(-12);
        $this->SetX(10);
        $this->Cell(65,5, utf8_decode("Fecha: ".date("d/m/Y") . " a las " . date("h:i a")),0,0,"L");
        
    }
}
?>