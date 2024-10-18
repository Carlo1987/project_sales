<?php
Utils::isIdentity();

if (isset($result) && $result) {
    $title = 'Risultato ricerca';
    Utils::isAdmin();
} else {
    $title = "Storico <span class='hidden_words'> dei tuoi </span> ordini";
}
?>

<h2> <?= $title ?> </h2>


<div id="user_orders">

    <?php if ($orders->num_rows != 0) :

        while ($order = $orders->fetch_object()) :     ?>

            <div class="order visible_orders">
                <div>
                    <p><span>Ordine numero:</span> <?= $order->id ?></p>
                </div>

                <div class="time_order">
                    <p><span>Del:</span> <?= Utils::FormatTime($order->hour) ?></p>
                </div>

                <div>
                    <p><span>Spesa totale:</span> €<?= $order->total_cost ?></p>
                </div>

                <div>
                    <a href="#" data-pdf="<?= url('pdf/bill.php?order='.$order->id) ?>" class="pdf">
                        <img src="<?= url('assets/img/documento.jpg') ?>" alt="file">
                    </a>
                </div>
            </div>


      
            <div class="hidden_orders">
                 <table border="1px">
            
                    <tr>
                        <th>Ordine <span class="hidden_words">N°</span></th>
                        <th>Spesa <span class="hidden_words">totale</span></th>
                        <th>pdf</th>
                    </tr>

               
                        <tr>
                            <td><?= $order->id ?></td>
                            <td>€<?= $order->total_cost ?></td>
                            <td>
                                <a href="#" data-pdf="<?= url('pdf/bill.php?order='.$order->id) ?>" class="pdf">
                                    <img src="<?= url('assets/img/documento.jpg') ?>" alt="file">
                                </a>
                            </td>
                        </tr>
                  
                </table> 
            </div>


            <?php endwhile; ?>

        <?php   else :  ?>

        <div class="noResult_search">
            <?php if (isset($result) && $result) : ?>
                <h3>Questo Utente non ha ancora effettuato nessun ordine</h3>
            <?php else : ?>
                <h3>Non hai ancora effettuato nessun ordine</h3>
            <?php endif; ?>
        </div>
    <?php endif; ?>

</div>