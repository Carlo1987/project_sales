<?php $value = '';
if (isset($_GET['edit'])) {
    Utils::isIdentity();
    $url =  url('order-products/'.$product->id.'?edit');
    $value = 'Aggiorna prodotto';
} else {
    $url = url('order-products/'.$product->id);
    $value = 'Aggiungi al carrello'; 
}
?>


<div class="product_single">

    <div class="image_product">
        <img src="<?= url('assets/img/products/'.$product->type_name.'/'.$product->image) ?>" alt="immagine_prodotto">
    </div>

    <div class="product_content">

        <div class=" title_product">
            <h2><?= $product->name ?></h2>
        </div>

        <div class="description_product">
            <p><?= $product->description ?></p>
        </div>


        <form action="<?= $url ?>" method="POST">

                <div class="buy_boxe">
                  
                    <div class="product__price">                
                        <?= Utils::issetDiscount($product); ?>      
                    </div>


                    <div class="product__quantity">
                       <div style="padding-top:4px;">
                        Prezzo: <span class="decoration_price"> €<?= Utils::getDiscount($product); ?></span>
                       </div>

                       <div class="quantity">
                        <select name="quantity_number" class="quantity_number">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    </div>


                </div>

                <div class="button_product">
                    <input type="submit" value="<?= $value ?>" name="buy">
                </div>
        </form>
   

    <?php if (!isset($_SESSION['error_stock'])) {
        if ($product->stock < 5 && $product->stock != 1 && $product->stock != 0) : ?>
            <div class="stock">
                <p>Affrettati, ne restano solo <?= $product->stock ?>!!</p>
            </div>
        <?php elseif ($product->stock == 1) : ?>
            <div class="stock">
                <p>Affrettati, ne resta solo <?= $product->stock ?>!!</p>
            </div>
        <?php elseif ($product->stock == 0) : ?>
            <div class="stock">
                <p>Prodotto terminato</p>
            </div>
        <?php endif;
    } else {  #  se esiste il get empty_stock
        ?>
        <div class="stock">
            <p><?= $_SESSION['error_stock'] ?></p>
        </div>
    <?php } ?>

    <?php if (isset($_SESSION['identity']) && $_SESSION['identity']->role == 'admin') : ?>
        <div class="product_admin">
            <?php if ($_SESSION['identity']->id != 1) : ?>
                <p>Per evitare di compromettere esageratamente il progetto, potrai modificare/eliminare i prodotti aggiunti da te o da altri 
                    utenti<span class="hidden_words_product">, ma non quelli già presenti di default (quelli inseriti in fase di programmazione)</span>
                </p>

                <?php if (!isset($_SESSION['cart'])) :
                    if ($product->id > 48) :  ?>
                        <div class="buttons_change">
                            <div>
                                <a href="<?= url('show-product?id='.$product->id) ?>" class="modify_product">Modifica prodotto</a>
                            </div>
                            <div>
                                <a href="#" class="modify_product delete_product" data-id="<?= $product->id ?>">Elimina prodotto</a>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="noResult_search" style="margin-top: 10px;">
                            Questo è un prodotto di default, non può essere modificato o cancellato
                        </div>
                    <?php endif;
                else : ?>
                    <div class="noResult_search" style="margin-top: 10px;">Per modificare/eliminare un prodotto devi avere il carrello degli acquisti vuoto!</div>
                <?php endif; ?>
            <?php else :  ?>
                <div class="buttons_change">
                    <div>
                        <a href="<?= url('show-product?id='.$product->id) ?>" class="modify_product">Modifica prodotto</a>
                    </div>
                    <div>
                        <a href="#" class="modify_product delete_product" data-id="<?= $product->id ?>">Elimina prodotto</a>
                    </div>
                </div>
            <?php endif; ?>

        </div>
       <?php endif; ?>
      </div>
    </div>
</div>

<?php Utils::update_product(); ?>