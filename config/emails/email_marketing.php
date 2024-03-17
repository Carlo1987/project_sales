<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    require 'structure_email.php';

    $mail->setFrom('email.progetto@gmail.com', 'Progetto vendita');

    $mail->addAddress($identity->email);   //   posso aggiungere un secondo valore opzionale, inserendo il nome utente per esempio 

    //  $mail->addAttachment('percorso_immagine', 'nome_Opzionale');   se volessi aggiungere un'immagine nell'email

    //////   corpo dell' email  ////////

    $mail->isHTML(true);
    $mail->Subject = 'Consigli per te';  //   oggetto dell'email
    $mail->AltBody = 'testo email non supportato';

    $style_container_product = "with:60%; margin:0 auto";
    $style_product = "text-decoration:none; width:100%; height:auto; display:flex; flex-direction:column; gap:15px; padding:15px;";
    $style_productName = "width:100%; text-align:center; font-size:20px; color: rgb(147, 191, 81)";
    $style_productImage = "width: 150px; height: 170px; margin:0 auto;";
    $style_productDescription = "width:90%; font-size:18px; color:black; text-align:justify; margin:0 auto;";
    $style_total = "width:40%; text-align:center; text-decoration:underline; font-size:18px; margin:0 auto; color:black;";

    $discount = $random_product_data->discount;
    $price = $random_product_data->price;
    $total = number_format($price - ($price * ($discount / 100)), 2);

    function if_exist_discount($discount){
        if($discount != 0){ 
           return "<div style='width:60%; text-align:center; color:rgb(221, 50, 50); font-size:18px;'>
                        Prodotto con $discount% di sconto!! 
                    </div>";
        }
    }
  
    global $host;
    $nameTypeProduct = strtoupper($random_product_data->type_name);
    $mail->Body = "
                    <div style='$style_container'>
                       <h2 style='$style_title'> Consigli per te!! </h2>
                       <div style='$style_message'>
                          Abbiamo notato che la categoria $nameTypeProduct e' una che ha suscitato molto interesse in te, magari potrebbe interessarti anche questo articolo! <br>
                          Clicca nel prodotto sotto se vuoi dare un'occhiata!
                       </div>

                       <div style='$style_container_product'>

                        <a href='https://$host/progetti/progetto_vendita/index.php?controller=Products_controller&action=product_one&id=$random_product_data->id' style='$style_product'>
                           <div style='$style_productName'>    $random_product_data->name    </div>
                           <div style='$style_productImage'>
                              <img src='https://$host/progetti/progetto_vendita/assets/img/products/$random_product_data->type_name/$random_product_data->image' alt='Prodotto:$random_product_data->name' style='width:100%; height:100%; border-radius:5px;'>
                            </div>
                           <div style='$style_productDescription'> $random_product_data->description </div>"
                           .if_exist_discount($discount)."
                           <div style='$style_total'> Euro $total </div>
                        </a>

                        </div>
                    </div>";

    $mail->send();
} catch (Exception $e) {
    echo "Errore durante l'invio dell'email: " . $mail->ErrorInfo;
}
