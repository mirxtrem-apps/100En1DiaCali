<?php       

require_once("classes/phpmailer.php");

$nombre = $_POST['nombre']; 
$email = $_POST['email'];
$mensaje = $_POST['mensaje'];
$autorizacion = $_POST['autorizacion'];
$emailDestino = "mirxtrem.apps@gmail.com";

$ArrayEmails    = explode("|", $emailDestino);
for ($i=0; $i<count($ArrayEmails); $i++){
    // echo $ArrayEmails[$i]."<br>";
}

//== 2. Envío a e-mail's mediante la librería PHPMailer. ==================

$Host = "smtp.gmail.com";
$Email_Emisor = "mirxtrem.apps@gmail.com";
$NombreEmisor = "100en1día Cali";
$Asunto = 'Alguien quiere ser miembro del Equipo Motor';

$CodHTML = '';
$CodHTML .= '<div style="font-family: Arial; font-size: 12pt; color:#000; margin-left: 10px; margin-top: 15px;">
                Este mensaje fué enviado desde la pagina web 100en1diacali.org <br><br>Nombre: '.$nombre. '<br>Correo: '.$email.'<br><br>Hola!, quiero ser parte del equipo motor.<br>'.$mensaje.'<br><br><strong>Autorización de los tratamiento de datos personales</strong><br>Yo, '.$nombre.' '.$autorizacion.'<br> 
</div>';

for ($i=0; $i<count($ArrayEmails); $i++){

    $email = new PHPMailer();
    $email->IsSMTP();                                      // set mailer to use SMTP
    $email->SMTPDebug = 0;
    $email->Host = "smtp.gmail.com";
    $email->Port = 587;
    $email->SMTPSecure = "tsl";
    $email->SMTPAuth = true;
    $email->Username   = "mirxtrem.apps@gmail.com";  
    $email->Password   = "c200217777";
    // $email->Username   = "100en1diacali@gmail.com";  
    // $email->Password   = "7octubreCALI2017";
    $email->SetFrom($Email_Emisor,$NombreEmisor);
    // $email->From = $Email_Emisor;
    // $email->FromName = $NombreEmisor;
    $email->AddAddress($ArrayEmails[$i]); // E-mail del receptor.
    $email->AddReplyTo('felicidad@100endiacali.org','Comite de felicidad'); // E-mail del receptor.

    $email->Subject  = utf8_decode($Asunto);
    

    
    $email->AlthBody = "Cuenta";
    $email->MsgHTML(utf8_decode($CodHTML));


    $email->WordWrap = 50;
    if($email->Send())
    {
        echo "Enviado";
    }else{
        echo $email->ErrorInfo;
    }
}



?>
