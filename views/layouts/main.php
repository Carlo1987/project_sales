<?php

while ($type = $types->fetch_object()) :

    $products_class = new Product();
    $products = $products_class->getProducts_index($type->id);

    if (!$products || $products->num_rows != 0) : ?>

       <section>

           <h2><?= strtoupper($type->name) ?></h2>

           <div class="products">

               <div class="arrows left">
                   <img src="<?= url('assets/img/double_arrow_left.png') ?>" alt="arrow">
               </div>

               <div class="products_boxe">
                   <?php while ($prod = $products->fetch_object()) :
                        $name = $prod->name   ?>

                       <div class="product list_index">
                           <a href="<?= url('product/'.$prod->id) ?>">
                               <?php if (strlen($name) > 16) : ?>
                                   <h3><?= substr($prod->name, 0, 15); ?>...</h3>
                               <?php else : ?>
                                   <h3><?= $name ?></h3>
                               <?php endif; ?>

                               <img src="<?= url('assets/img/products/'.$type->name.'/'.$prod->image) ?>" alt="product">
                               <p><?= substr($prod->description, 0, 20) ?>...</p>
                               <?php
                                $discount = $prod->discount;
                                $price = $prod->price;
                                if ($discount != 0) : ?>
                                   <p class="price_total" style="margin-top: -10px;"><span class="discount">Sconto del <span><?= $discount ?></span>%!!</span>€<?= $price ?></p>
                               <?php endif; ?>
                               <p class="price_real">prezzo: <span class="decoration_price">€<span><?= number_format($price - ($price * ($discount / 100)), 2) ?></span></span></p>
                           </a>
                       </div>
                   <?php endwhile; ?>
               </div>

               <div class="arrows right">
                   <img src="<?= url('assets/img/double_arrow_right.png') ?>" alt="arrow">
               </div>

           </div>

       </section>

<?php endif;
endwhile;   ?>

<div id="hidden_main">
   <?php $types_class = new Type();
    $types = $types_class->getAllTypes();
    while ($type = $types->fetch_object()) :  ?>
       <div class="query_type">
           <a href="<?= url('type-products/'.$type->id) ?>">
               <div style="width: 100%; height: 10%; text-align:center;">

                   <?php $name =  $type->name;
                       if(strlen($name) <= 16) : ?>
                   <h3 class="visible_title_main"><?= $name ?> </h3>
                      <?php else : ?>
                        <h3 class="visible_title_main"><?= substr($name, 0, 8)?>... </h3>
                      <?php endif;
                       if (strlen($name) < 12) : ?>
                       <h3 class="hidden_title_main"> <?= $name ?> </h3>
                   <?php else :  ?>
                       <h3 class="hidden_title_main"> <?= substr($name, 0, 6) ?>... </h3>
                   <?php endif; ?>

               </div>
               <div style="width: 85%; height: 85%;">
                   <?php $products_class = new Product();
                    $number_products = $products_class->getProducts_index($type->id);
                    $product = $products_class->last_product($type->id);

                    if ($number_products->num_rows > 0) :  ?>
                       <img src="<?= url('assets/img/products/'.$type->name.'/'.$product->image) ?>" alt="product">
                   <?php else : ?>
                       <img src="<?= url('assets/img/insieme_vuoto.png') ?>" alt="product">
                   <?php endif; ?>
               </div>
           </a>
       </div>

   <?php endwhile; ?>
</div>

<div class="paginates">

<div class="arrows" style="width: 18px; height:18px;">
   <a href="<?= $paginate->arrowLeft() ?>">
       <img src="<?= url('assets/img/double_arrow_left.png') ?>" alt="arrow">
    </a>
   </div>

   <?php       $limit = $paginate->linksPaginate('types', 2);

    for ($i = 1; $i <= $limit; $i++) : 
           if($i != 1){
               $url = 'home?page='.$i;
           }else{
               $url = 'home';
           }
           ?>
       <div class="pages">
           <a href="<?= $url ?>">
               <?= $i ?>
           </a>
       </div>
   <?php endfor; ?>

   <div class="arrows" style="width: 18px; height:18px;">
       <a href="<?= $paginate->arrowRight($limit) ?>">
         <img src="<?= url('assets/img/double_arrow_right.png') ?>" alt="arrow">
       </a>
   </div>

  
</div>