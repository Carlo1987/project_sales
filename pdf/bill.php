<?php

require '../config/private.php';
require '../config/database.php';
require '../config/utils.php';
require '../models/order_user.php';
require '../models/order_product.php';
require '../models/type.php';
ob_start();
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordine</title>

    <style>
        header {
            width: 100%;
        }

        .content_icon {
            float: left;
            width: 53%;
            height: 100px;
        }

        .title {
            width: 100%;
            height: 70px;
            background-color: #CCC;
            border-radius: 15px;
            letter-spacing: 1px;
            line-height: 30px;
            padding: 5px;
            text-align: center;
        }

        .contacts {
            width: 38%;
            height: 120px;
            background-color: #CCC;
            font-size: 20px;
            border-radius: 15px;
            text-align: center;
            line-height: 5px;
            padding: 5px;
            float: right;
        }

        .contacts h3 {
            font-size: 25px !important;
            text-transform: uppercase;
        }

        .clearfix {
            clear: both;
        }

        table {
            width: 100%;
            height: auto;
            border-left: transparent;
            border-right: transparent;
            border-top: 1px solid black;
            border-bottom: 1px solid black;
        }

        table td {
            text-align: center;
            border: transparent;
        }

        img {
            width: 55px;
            height: 55px;
            border-radius: 8px;
        }

        .total {
            width: 38%;
            height: 50px;
            float: right;
            text-align: center;
            line-height: 40px;
            letter-spacing: 1px;
            background-color: #CCC;
            font-size: 24px;
            border-radius: 15px;
            margin-top: 15px;
        }

        .payment{
            width: 100%;
            padding: 5px;
            border-top: 1px solid black;
            margin-top: 60px;
        }

    </style>

</head>

<?php
$name_order = new Order_user();
$order = $name_order->number_order($_GET['order']);

$products_class = new Orders_product();
$products = $products_class->list_products($_GET['order']);

$type_class = new Type();
?>

<!-- ////////////////////////////////   CORPO DEL PDF  //////////////////////////////////// -->

<body>

    <header>

        <div class="content_icon">
            <div class="title">
                <h1>PROGETTO VENDITA</h1>
            </div>
            <h3>ORDINE NUMERO : <?= $order->id ?></h3>
        </div>

        <div class="contacts">
            <h3>Contatti</h3>
            <p>emailAzienda@gmail.it</p>
            <p>123456@faxAzienda.it</p>
            <p>Tel: 0123456789</p>
        </div>

        <div class="clearfix"></div>

    </header>

    <h3>Cliente : <?= $order->user ?></h3>

    <table border="1px">
        <tr>
            <th>Prodotto</th>
            <th>foto</th>
            <th>costo prodotto</th>
            <th>quantità</th>
            <th>Totale</th>
        </tr>

        <?php while ($product = $products->fetch_object()) :
            $type = $type_class->getOne_byProduct($product->name);            ?>
            <tr>
                <td><?= $product->name ?></td>
                <td>
                    <img src="../assets/img/products/<?= $type->name ?>/<?= $product->image ?>">
                </td>
                <td>€<?= $product->cost ?></td>
                <td><?= $product->quantity ?></td>
                <td>€<?= $product->total_cost ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <div class="total">
        Totale pagato : €<?= $order->total_cost ?>
    </div>

   <div class="payment">
            <p>Ordine effettuato  il <?= Utils::FormatTime($order->hour) ?></p>
            <?php if ($order->method == 'carta di debito') :     $card = $order->card       ?>
            <p>Pagamento tramite: <?= strtoupper($order->method) ?> numero carta: **** **** **** <?= $card[12] . $card[13] . $card[14] . $card[15] ?></p>
            <?php elseif ($order->method == 'bonifico') :   $iban =  $order->bank  ?>
            <p>Pagamento tramite: <?= strtoupper($order->method) ?> numero conto: ******** <?= $iban[29] . $iban[30] . $iban[31] . $iban[32] ?></p>
            <?php endif; ?>
            <p>Stato ordine : <?= strtoupper($order->state) ?></p>
   </div>

</body>

</html>



<?php $html = ob_get_clean();

require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$dompdf->loadHtml($html);
$dompdf->setPaper('letter');

$dompdf->render();

$dompdf->stream('Ordine.pdf', array('Attachment' => false));
?>