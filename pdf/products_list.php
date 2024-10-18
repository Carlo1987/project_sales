<?php

require '../config/private.php';
require '../config/database.php';
require '../config/utils.php';
require '../models/product.php';
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
            border: black;
        }


        img{
            width: 45px;
            height: 45px;
            border-radius: 8px;
        }

      
    </style>

</head>

<?php
 $products_class = new Product();
 $products = $products_class -> getProducts();
?>

<!-- ////////////////////////////////   CORPO DEL PDF  //////////////////////////////////// -->

<body>

    <h1>Elenco Prodotti in ordine </h1>

    <h3>I prodotti di tipo "default" non possono essere modificati</h3>
  
    <table border="1px">
        <tr>
            <th>Nome</th>
            <th>Prodotto</th>
            <th>Categoria</th>
            <th>Prezzo base</th>
            <th>Sconto</th>
            <th>Prezzo effettivo</th>
            <th>Quantità in magazzino</th>
            <th>tipo</th>
        </tr>

        <?php while ($product = $products->fetch_object()) :  
            global $host;     ?>
            <tr>
                <td><?= $product->name ?></td>
                <td>
                    <img src="../assets/img/products/<?=$product->type?>/<?=$product->image?>">    
                </td>
                <td><?= $product->type ?></td>
                <td>€<?= $product->price ?></td>
            <?php if($product->discount == 0 || $product->discount == null) : ?>
                <td>0</td>
            <?php else :  ?>
                <td><?= $product->discount ?>%</td>
            <?php endif; ?>
                <td>€<?= number_format($product->price - ($product->price * ($product->discount / 100)), 2)?></td>
                <td><?= $product->stock ?></td>
             <?php if($product->id > 48) :  ?>
                <td style="color: green;">MODIFICABILE</td>
             <?php else :  ?>
                <td style="color: red;">default</td>
            <?php endif; ?>
            </tr>
        <?php endwhile; ?>
    </table>

</body>

</html>

<?php    $html = ob_get_clean();

require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('letter');

$dompdf->render();
$dompdf->stream('Lista Prodotti.pdf', array('Attachment' => false));
?>
