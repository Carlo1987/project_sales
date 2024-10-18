<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try{
    require 'structure_email.php';

    $mail->setFrom($my_email,'Progetto vendita');

    $mail->addAddress($email);   //   posso aggiungere un secondo valore opzionale, inserendo il nome utente per esempio 

   //  $mail->addAttachment('percorso_immagine', 'nome_Opzionale');   se volessi aggiungere un'immagine nell'email

   //////   corpo dell' email  ////////

    $mail->isHTML(true);
    $mail->Subject = 'Reset password';  //   oggetto dell'email
    $mail->AltBody = 'testo email non supportato';

    $style_token = "width:80px; padding: 20px; margin:0 auto; background-color: #555; color: white; font-size: 20px; border-radius: 10px; text-align:center; letter-spacing:1px;";
   
    $mail->Body = "
                         <h2 style='$style_title'> Reset password </h2> 
                         <p style='text-align:center;'> Copia il codice qui sotto e inseriscilo per poter resettare la password </p> 
                        <div style='$style_token'> $token </div>
                  ";

    $mail->send();

}catch(Exception $e){
    echo "Errore durante l'invio dell'email: ".$mail->ErrorInfo;
}

?>



