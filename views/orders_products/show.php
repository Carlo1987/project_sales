<?php
 
if (isset($_SESSION['cart']) && count($_SESSION['cart']) != 0) :
 
    $cart = $_SESSION['cart']; ?>

    <h2>Prodotti nel carrello:</h2>

    <div id="cart_boxe">


        <table border="1px">
            <tr>
                <th class="hidden_cart">Nome</th>
                <th>Prodotto</th>
                <th class="hidden_cart">Prezzo</th>
                <th class="hidden_cart2">Quantità</th>
                <th>Totale</th>
                <th colspan="2"></th>
                
            </tr>

            <?php $total = 0;

            foreach ($cart as $product) : ?>
                <tr>
                    <td class="hidden_cart">
                        <?php $name = $product['name'];
                        echo substr($name, 0, 13);
                        if (strlen($name) > 13) {
                            echo '...';
                        } ?>
                    </td>

                    <td>
                        <img src="<?= url('assets/img/products/'.$product['type'].'/'.$product['image']) ?>" alt="prodotto" class="img_product_cart">
                    </td>

                    <td class="hidden_cart">
                        €<?= number_format($product['price'], 2) ?>
                    </td>

                    <td class="hidden_cart2">
                        <?= $product['quantity'] ?>
                    </td>

                    <td>
                        €<?= number_format($product['total_cost'], 2) ?>
                    </td>

                    <td>
                        <a href="<?= url('product/'.$product['product_id'].'?edit')?>">
                            <img src="<?= url('assets/img/change_web.png') ?>" alt="modify">
                        </a>
                    </td>

                    <td>
                        <a href="<?= url('delete-order-product/'.$product['product_id']) ?>">
                            <img src="<?= url('assets/img/delete_web.png') ?>" alt="modify">
                        </a>
                    </td>

                    <?php $total +=  $product['total_cost'] ?>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="bill">
            <p>TOTALE: <span>€<?= number_format($total, 2) ?></span></p>
        </div>
    </div>

    <div class="buttons">
        <div class="button buy add_products"><a href="<?= url('home') ?>">Aggiungi prodotti</a></div>
        <div class="button buy procede_order"><a href="<?= url('order-user') ?>">Procedi con l'ordine</a></div>
    </div>

<?php else : ?>   
     <div class="noResult_search">
        Carrello vuoto
     </div>
<?php endif; ?>