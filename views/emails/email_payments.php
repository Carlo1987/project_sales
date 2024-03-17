<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    require 'structure_email.php';

    $mail->setFrom('email.progetto@gmail.com', 'Progetto vendita');

    $mail->addAddress($last_order->email);   //   posso aggiungere un secondo valore opzionale, inserendo il nome utente per esempio 

    //  $mail->addAttachment('percorso_immagine', 'nome_Opzionale');   se volessi aggiungere un'immagine nell'email/allegato

    //////   corpo dell' email  ////////

    $mail->isHTML(true);
    $mail->Subject = 'Il tuo ordine';  //   oggetto dell'email
    $mail->AltBody = 'testo email non supportato';

    $style_container = "margin: 0 auto; width: 80%;  height: auto; padding: 15px; border: 1px solid #ccc;  border-radius: 5px;  box-shadow: 1px 1px 3px #555;";
    $style_title = " color: rgb(147, 191, 81); text-align: center; margin-top: 8px;";
    $style_message = "width: 70%; margin: 0 auto; padding: 10px;";

    $mail->Body = "
                    <div style='$style_container'>
                       <h2 style='$style_title'> Ordine completato </h2>
                       <div style='$style_message'>
                         Il tuo ordine e' stato completato!! <br>
                         Il numero di riferimento e' il numero $last_order->id, potrai scaricarlo dal tuo storico degli ordini!!  <br>
                         Tra 2 minuti (guarda un po' che rapidita'!!!) riceverai un'email di consegna dell'ordine!!
                       </div>
                    </div>";

    $mail->send();
} catch (Exception $e) {
    echo "Errore durante l'invio dell'email: " . $mail->ErrorInfo;
}
