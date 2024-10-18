<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    require 'structure_email.php';

    $mail->setFrom($my_email, 'Progetto vendita');

    $mail->addAddress($last_order->email);   //   posso aggiungere un secondo valore opzionale, inserendo il nome utente per esempio 

    //  $mail->addAttachment('percorso_immagine', 'nome_Opzionale');   se volessi aggiungere un'immagine nell'email/allegato

    //////   corpo dell' email  ////////

    $mail->isHTML(true);
    $mail->Subject = 'Il tuo ordine';  //   oggetto dell'email
    $mail->AltBody = 'testo email non supportato';

    $style_message = "width: 100%; padding:10px; text-align: justify; font-size:18px;";

    $mail->Body = "
                       <h2 style='$style_title'> Ordine completato! </h2>
                       <div style='$style_message'>
                         Il tuo ordine e' stato completato!! <br>
                         Il numero di riferimento e' il numero $last_order->id, potrai scaricarlo dal tuo storico degli ordini!!  <br>
                         Tra 2 minuti (guarda un po' che rapidita'!!!) riceverai un'email di consegna dell'ordine!!
                       </div>
                    ";

    $mail->send();
} catch (Exception $e) {
    echo "Errore durante l'invio dell'email: " . $mail->ErrorInfo;
}
