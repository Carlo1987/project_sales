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
                <?php  include './views/products/card_product.php'; ?>
            </div>

           
        <?php endwhile; ?>
    </div>
<?php endif; ?>