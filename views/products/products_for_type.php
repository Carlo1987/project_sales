<h2><?= strtoupper($type->name); ?></h2>

<?php if ($products->num_rows == 0) : ?>
    <div class="noResult_search">
        Questa categoria è ancora vuota
    </div>

<?php else : ?>
    <div class="products content_products_type">

        <?php while ($prod = $products->fetch_object()) :
            $name = $prod->name   ?>

            <div class="product visible_products">
                <a href="<?= url('product/'.$prod->id) ?>">
                    <?php if (strlen($name) > 16) : ?>
                        <h3><?= substr($prod->name, 0, 15); ?>...</h3>
                    <?php else : ?>
                        <h3><?= $name ?></h3>
                    <?php endif; ?>

                    <img src="<?= url('assets/img/products/'.$type->name.'/'.$prod->image) ?>" alt="product">
                    <p><?= substr($prod->description, 0, 20) ?>...</p>
                    <?php if ($prod->discount != 0) : ?>
                        <p class="price_total"><span class="discount">Sconto del <span><?= $prod->discount ?></span>%!!</span>€<?= $prod->price ?></p>
                    <?php endif; ?>
                    <p>prezzo: <span class="decoration_price"> €<?= number_format($prod->price - (($prod->price * ($prod->discount / 100))), 2) ?></span></p>
                </a>
            </div>

            <div class="hidden_products">
                <a href="<?= url('product/'.$prod->id) ?>">
                    <div style="display: flex; flex-direction:column; width:45%;">
                        <div style="width:100%; height:20%; text-align:center; line-height:11px; color:red;">
                            <h3><?= substr($prod->name, 0, 10); ?>...</h3>
                        </div>
                        <div style="width: 100%;">
                            <img src="<?= url('assets/img/products/'.$type->name.'/'.$prod->image) ?>" alt="product" style="width: 100%; height:150px; border-radius:10px;">
                        </div>
                    </div>

                    <div style="display: flex; flex-direction:column; gap:15px; width:50%;">
                        <div style="width: 100%; height:auto;">
                            <p><?= substr($prod->description, 0, 60) ?>...</p>
                        </div>
                        <?php if ($prod->discount != 0) : ?>
                            <div>
                                <p class="price_total"><span class="discount">Sconto <span><?= $prod->discount ?></span>%!!</span>€<?= $prod->price ?></p>
                            </div>
                        <?php endif; ?>
                        <div>
                            <p>prezzo:
                                <span class="decoration_price">€<?= number_format($prod->price - (($prod->price * ($prod->discount / 100))), 2) ?></span>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>