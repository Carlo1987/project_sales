<?php

require '../config/private.php';
require '../config/database.php';
require '../config/utils.php';
require '../models/order_user.php';
ob_start();
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Ordini</title>

    <style>
        h1 {
            color: rgb(224, 60, 60);
            letter-spacing: 1px;
            text-align: center;
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
 $orders_class = new Order_user();
 $orders = $orders_class -> list();
?>

<!-- ////////////////////////////////   CORPO DEL PDF  //////////////////////////////////// -->

<body>

    <h1>Elenco Ordini in ordine crescente per cognome</h1>
  
    <table border="1px">
        <tr>
            <th>N° ordine</th>
            <th>Utente</th>
            <th>Spesa totale</th>
        </tr>

        <?php while ($order = $orders->fetch_object()) :  ?>
            <tr>
                <td><?= $order->id ?></td>
                <td><?= $order->user ?></td>
                <td>€<?= $order->total ?></td>
            </tr>
        <?php endwhile; ?>
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

$dompdf->stream('Lista totale ordini.pdf', array('Attachment' => false));
?>
