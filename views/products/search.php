<h2>Risultato ricerca</h2>

<div class="result_search">
    <?php if ($products->num_rows != 0) :

        while ($product = $products->fetch_object()) :   ?>
            <div class="result_row">

                <div style="display: flex; align-items:center; gap:5px;">

                    <div> <img src="<?= url('assets/img/products/'.$product->type.'/'.$product->image) ?>" alt="img_prodotto"> </div>

                    <div style="width: 100%;">
                        <a href="<?= url('product/'.$product->id) ?>">
                            <?= $product->name ?>
                        </a>
                    </div>

                </div>

                <div> <span>Prezzo base:</span> €<?= $product->price ?> </div>

                <div> <span> Sconto del:</span> <?php if ($product->discount == '' || $product->discount == 0) {
                                                    echo 0;
                                                } else {
                                                    echo $product->discount;
                                                } ?>% </div>

                <div> <span> Prezzo scontato:</span> €<?= number_format($product->price - ($product->price * ($product->discount / 100)), 2) ?> </div>
            </div>
        <?php endwhile;
    else :  ?>
        <div class="noResult_search">Non è stato trovato nessun elemento</div>
    <?php endif; ?>
</div>


<div class="hidden_search">
    <?php if ($products->num_rows != 0) : ?>

        <table border="1px">
            <tr>
                <th>Nome</th>
                <th>Prodotto</th>
                <th class="hidden_table">Prezzo base</th>
                <th class="hidden_table">Sconto</th>
                <th>Prezzo</th>
            </tr>

            <?php    $products = $product_class -> search($name);
            while ($product = $products->fetch_object()) :   ?>
                <tr>

                    <td>
                        <a href="<?= url('product/'.$product->id) ?>">
                            <?= $product->name ?>
                        </a>
                    </td>

                    <td>
                        <img src="<?= url('assets/img/products/'.$product->type.'/'.$product->image) ?>">
                    </td>

                    <td class="hidden_table"> €<?= $product->price ?> </td>

                    <td class="hidden_table">
                        <?php if ($product->discount == '' || $product->discount == 0) {
                            echo 0;
                        } else {
                            echo $product->discount;
                        } ?>%

                    </td>

                    <td>
                        €<?= number_format($product->price - ($product->price * ($product->discount / 100)), 2) ?>
                    </td>

                </tr>
            <?php endwhile; ?>

        </table>

    <?php else :  ?>
        <div class="noResult_search">Non è stato trovato nessun elemento</div>
    <?php endif; ?>
</div>