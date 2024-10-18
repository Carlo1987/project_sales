<?php


require 'config/private.php';


$my_email = $email_datas['my_email'];

$mail->isSMTP();
$mail->Host = $email_datas['host'];
$mail->SMTPAuth = $email_datas['SMTPAuth'];
$mail->Username = $email_datas['username'];
$mail->Password = $email_datas['password'];
$mail->Port = $email_datas['port'];




$style_title = " color: rgb(147, 191, 81); text-align: center; font-size:24px; margin-bottom:8px;";
$style_message = "width: 100%; padding:10px; text-align: justify; font-size:18px;";


