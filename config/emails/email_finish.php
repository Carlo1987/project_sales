<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    require 'structure_email.php';

    $mail->setFrom($my_email, 'Progetto vendita');

    $mail->addAddress($email);   //   posso aggiungere un secondo valore opzionale, inserendo il nome utente per esempio 

    //  $mail->addAttachment('percorso_immagine', 'nome_Opzionale');   se volessi aggiungere un'immagine nell'email

    //////   corpo dell' email  ////////

    $mail->isHTML(true);
    $mail->Subject = 'Ordine consegnato';  //   oggetto dell'email
    $mail->AltBody = 'testo email non supportato';

    $mail->Body = "
                       <h2 style='$style_title'> Ordine consegnato! </h2>
                       <div style='$style_message'>
                          L'ordine fittizio e' stato consegnato! Magari gli ordini arivassero cosi' velocemente eh!!<br>
                          Al posto dell'ordine, spero ti accontenterai di ricevere i miei ringraziamenti per aver voluto provare e testare il mio progetto!!<br>
                          Se sei interessato a contattarmi per dei veri progetti, ecco i miei contatti: <br>
                          Web Developer Carlo Loi <br>
                          telefono:  3338416149  <br>
                          email: <a href='mailto:carlo_loi87@yahoo.it'> carlo_loi87@yahoo.it </a> <br>
                          A presto!!!
                       </div>
                    ";

    $mail->send();
} catch (Exception $e) {
    echo "Errore durante l'invio dell'email: " . $mail->ErrorInfo;
}
