<?php 

#
# doc: https://github.com/PHPMailer/PHPMailer
# using example: https://github.com/PHPMailer/PHPMailer/blob/master/examples/gmail.phps
#

use PHPMailer\PHPMailer\PHPMailer;
require("../../../libs/PHPMailer/src/PHPMailer.php");
require("../../../libs/PHPMailer/src/Exception.php");
require("../../../libs/PHPMailer/src/OAuth.php");
require("../../../libs/PHPMailer/src/SMTP.php");
require("../../../libs/PHPMailer/src/POP3.php");

class Clss_Email
{
    function __construct(){
        //se inicializan las variables que no se setearan para enviar el correo
        $this->SMTPDebug = 0;
        $this->Host = "smtp.gmail.com";
        $this->Port = 587;
        $this->SMTPSecure = "tls";
        $this->SMTPAuth = true;
        $this->Username = "SysMonstersUniversity@gmail.com";
        $this->Password = "Sys123456MU";
        $this->NameEmail = "Sys Monsters University";
    }
    
    private $SMTPDebug = null;
    private $Host = null;
    private $Port = null;
    private $SMTPSecure = null;
    private $SMTPAuth = null;
    private $Username = null;
    private $Password = null;
    private $NameEmail = null;

    private $SendAddress = null;
    private $Subject = null;
    private $isHTML = null;
    private $Body = null;
    private $Attachment = null;

    public function setSendAddress($SendAddress){
        $this->SendAddress = $SendAddress;
    }

    public function setSubject($Subject){
        $this->Subject = $Subject;
    }

    public function setIsHTML($isHTML){
        $this->isHTML = $isHTML;
    }

    public function setBody($Body){
        $this->Body = $Body;
    }

    public function setAttachment($Attachment){
        $this->Attachment = $Attachment;
    }

    function generateRandomString($length) {
        //opciones para el codigo random
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        //cuenta la cantidad de caracteres
        $charactersLength = strlen($characters);
        //inicial random string
        $randomString = '';
        //ciclo que arma el codigo random
        for ($i = 0; $i < $length; $i++) {
            //concatenando al azar un caracter de todas las opciones
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        //devolviendo el codigo random
        return $randomString;
    }

    public function SendEmail(){
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = $this->SMTPDebug;
        $mail->Host = $this->Host;
        $mail->Port = $this->Port;
        $mail->SMTPSecure = $this->SMTPSecure;
        $mail->SMTPAuth = $this->SMTPAuth;
        $mail->Username = $this->Username;
        $mail->Password = $this->Password;
        $mail->setFrom($this->Username, $this->NameEmail);
        $mail->addAddress($this->SendAddress);
        $mail->Subject = $this->Subject;
        $mail->isHTML($this->isHTML);
        $mail->Body = $this->Body;

        //$mail->addAttachment("../../../resource/image/ajuste/2.jpg");

        if (!$mail->send()) {
            $retornar['resultado'] = false;
            $retornar['ErrorInfo'] = $mail->ErrorInfo;    
            return $retornar;
        } else {
            $retornar['resultado'] = true;    
            return $retornar;
        }
    }

}
?>