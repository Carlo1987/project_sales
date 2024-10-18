<?php

require '../config/private.php';
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
    <title>Lista Utenti</title>

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

    <h1>Utenti fittizzi</h1>

    <p>Puoi entrare e utilizzare anche questi profili se vuoi, ma non potrai cambiarne i dati</p>
  
    <table border="1px">
        <tr>
            <th>Email</th>
            <th>Password</th>
        </tr>

        <?php while ($user = $users->fetch_object()) : 
              if($user->id != 1 && $user->id <= 8) :   ?>
            <tr>
                <td><?= $user->email ?></td>
                <td><?= strtolower($user->name) ?></td>
            </tr>
        <?php   endif;
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

$dompdf->stream('Lista Utenti fittizzi.pdf', array('Attachment' => false));
?>
