<?php

$my_email = 'carlo87_dev@carloloidev.com';

$mail->isSMTP();
$mail->Host = 'sandbox.smtp.mailtrap.io';
$mail->SMTPAuth = true;
$mail->Username = 'xxx';
$mail->Password = 'xxx';
$mail->Port = 2525;
 


$style_title = " color: rgb(147, 191, 81); text-align: center; font-size:24px; margin-bottom:8px;";
$style_message = "width: 100%; padding:10px; text-align: justify; font-size:18px;";