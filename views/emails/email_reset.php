<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try{
    require 'structure_email.php';

    $mail->setFrom('email.progetto@gmail.com','Progetto vendita');

    $mail->addAddress($email);   //   posso aggiungere un secondo valore opzionale, inserendo il nome utente per esempio 

   //  $mail->addAttachment('percorso_immagine', 'nome_Opzionale');   se volessi aggiungere un'immagine nell'email

   //////   corpo dell' email  ////////

    $mail->isHTML(true);
    $mail->Subject = 'Reset password';  //   oggetto dell'email
    $mail->AltBody = 'testo email non supportato';

    $style_container = "margin: 0 auto; width: 80%;  height: auto;  display: flex;  flex-direction: column;  align-items: center;  gap: 10px;  padding: 15px; border: 1px solid #ccc;  border-radius: 5px;  box-shadow: 1px 1px 3px #555;";
    $style_title = " color: rgb(147, 191, 81);";
    $style_token = " padding: 20px;   background-color: #555; color: white; font-size: 20px; border-radius: 10px;";
   
    $mail->Body = "<div style='$style_container'>
                        <div> <h2 style='$style_title'> Reset password </h2> </div>
                        <div> <p> Copia il codice qui sotto e inseriscilo per poter resettare la password </p> </div>
                        <div style='$style_token'> $token </div>
                   </div>";

    $mail->send();

}catch(Exception $e){
    echo "Errore durante l'invio dell'email: ".$mail->ErrorInfo;
}

?>