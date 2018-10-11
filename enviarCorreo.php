<?php       

require_once("classes/phpmailer.php");

$nombre = $_POST['nombre']; 
$email = $_POST['email'];
$mensaje = $_POST['mensaje'];
$autorizacion = $_POST['autorizacion'];
$emailDestino = "felicidad@100en1diacali.org";


$ArrayEmails    = explode("|", $emailDestino);
for ($i=0; $i<count($ArrayEmails); $i++){
    // echo $ArrayEmails[$i]."<br>";
}

//== 2. Envío a e-mail's mediante la librería PHPMailer. ==================

$Host = "ssl://smtp.ipage.com";
$Email_Emisor = "felicidad@100en1diacali.org";
$NombreEmisor = "100en1día Cali";
$Asunto = 'Alguien quiere ser miembro del Equipo Motor';

$CodHTML = '';
$CodHTML .= '<div style="font-family: Arial; font-size: 12pt; color:#000; margin-left: 10px; margin-top: 15px;">
                Este mensaje fué enviado desde la pagina web 100en1diacali.org <br><br>Nombre: '.$nombre. '<br>Correo: '.$email.'<br><br>Hola!, quiero ser parte del equipo motor.<br>'.$mensaje.'<br><br><strong>Autorización de los tratamiento de datos personales</strong><br>Yo, '.$nombre.' Acepto y autorizo a <strong>100En1Día Cali</strong> el tratamiento de mis datos personales.<br> 
</div>';

for ($i=0; $i<count($ArrayEmails); $i++){

    $email = new PHPMailer();
    $email->IsSMTP();                                      // set mailer to use SMTP
    $email->Host = "ov1.hosting2m.com";
    $email->Port = 465;
    $email->SMTPSecure = "ssl";
    $email->SMTPDebug = 0;
    $email->SetFrom($Email_Emisor,utf8_decode($NombreEmisor));
    // $email->From = $Email_Emisor;
    // $email->FromName = $NombreEmisor;
    $email->AddAddress($ArrayEmails[$i]); // E-mail del receptor.
    $email->AddCC('100en1diacali@gmail.com','Comite de felicidad'); // E-mail del receptor.
    
    $email->Subject  = utf8_decode($Asunto);
        
    $email->AlthBody = "Cuenta";
    $email->MsgHTML(utf8_decode($CodHTML));

    $email->SMTPAuth = true;
    $email->Username   = "felicidad@100en1diacali.org";  
    $email->Password   = "TV!0_zeQL(B7";


    $email->WordWrap = 50;
    if($email->Send())
    {
        echo "Enviado";
    }else{
        echo $email->ErrorInfo;
    }
}



?>
