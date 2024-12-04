
<a href="<?= url('product/'.$prod->id) ?>">

    <div class="product__image">
        <img src="<?= url('assets/img/products/'.$type->name.'/'.$prod->image) ?>" alt="product">
    </div>

    <h3> <?= Utils::title($prod->name); ?> </h3> 

    <div class="product__description">
        <p><?= substr($prod->description, 0, 20) ?>...</p>
    </div>


    <div class="product__price">                
        <?= Utils::issetDiscount($prod); ?>      
        <p>prezzo: <span class="decoration_price"> €<?= Utils::getDiscount($prod); ?></span></p>
    </div>
</a>

