<?php

require '../config/database.php';
require '../config/utils.php';
require '../models/user.php';
ob_start();
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Utenti completa</title>

    <style>
        h1 {
            color: rgb(224, 60, 60);
            letter-spacing: 1px;
            text-align: center;
        }

        .admin{
            color: rgb(210, 69, 69);
        }

        .user{
            color: rgb(57, 57, 219);
        }

        table {
            width: 100%;
            height: auto;
        }

        table td {
            text-align: center;
        }

      
    </style>

</head>

<?php
 $user_class = new User();
 $users = $user_class -> list();
?>

<!-- ////////////////////////////////   CORPO DEL PDF  //////////////////////////////////// -->

<body>

    <h1>Elenco Utenti completo</h1>
  
    <table border="1px">
        <tr>
            <th>Cognome e Nome</th>
            <th>Email</th>
            <th>Tipo di utente</th>
        </tr>

        <?php while ($user = $users->fetch_object()) : 
                ?>
            <tr>
                <td><?= $user->surname.' '.$user->name ?></td>
                <td><?= $user->email ?></td> 
                <?php if($user->id > 8 || $user->id == 1) :  ?>
                   <td style="color: green;">UTENTE REALE</td>
                <?php else : ?>
                   <td style="color: red;">Utente fittizio</td>
                <?php endif; ?>
            </tr>
        <?php 
                endwhile; ?>
    </table>

</body>

</html>



<?php $html = ob_get_clean();

require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;
$dompdf = new Dompdf();

$dompdf->loadHtml($html);
$dompdf->setPaper('letter');

$dompdf->render();

$dompdf->stream('Lista Utenti completa.pdf', array('Attachment' => false));
?>
