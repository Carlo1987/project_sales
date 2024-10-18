<?php

require 'router/router.php';

$nav = nav();

Utils::deleteCookies(); 
Utils::recoverSession();
Utils::cookiesIdentity();

Utils::update_orders();
Utils::update_stock(); 
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Simulatore di vendita e acquisto di prodotti dove tu sarai AMMINISTRATORE e potrai aggiungere o modificare nuovi articoli">
    
    <link rel="icon" href="<?=url('assets/img/logo_dichatleon.webp')?>">
    <link rel="stylesheet" type="text/css" href="<?=url("assets/css/style.css")?>">
    <link rel="stylesheet" type="text/css" href="<?=url('assets/css/mediaQuery.css')?>">
    <script src="https://kit.fontawesome.com/b476d70dd7.js" crossorigin="anonymous"></script>
   
    <title>Dichatleon</title>
   
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "Dichatleon",
        "url": "http://carloloidev.com/Project_Shop",
        "author": "Full Stack Web Developer Carlo Loi",
    }
    </script>
   

</head>

<body>

    <header>
        <div id="title">
            <img src="<?=url('assets/img/icon.jpg')?>" alt="icon_dichatleon" class="icon_web">
            <a href="<?=url('home')?>">
                <h1>Dichatleon</h1>
            </a>
        </div>
    </header>
<?php Utils::cartCookie(); ?>
    <nav>
        <ul>
            <li style=" border-left: none;" class="link_home">
                <a href="<?=url('home')?>" style="color: rgb(147, 191, 81);"> HOME </a>
            </li>



            <li id="menu_types">
                <a href="#"> <?= $nav['categories']['name'] ?> </a>
                <ul>
                    <?php    
                    ob_start();

                    $types_class = new Type();
                    $types = $types_class->getAllTypes();

                    while ($type = $types->fetch_object()) : ?>    
                        <li>
                            <a href="<?= url( $router->generateUrl($nav['categories']['url'] , ['id' => $type->id ]) )  ?>"> <?= $type->name ?> </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </li>

            <li id="contacts">
                <a href="<?= url( $nav['contacts']['url'] ) ?>"> <?= $nav['contacts']['name'] ?> </a>
            </li>
        </ul>

        <div id="search">
            <form action="<?= url('find-product') ?>" method="POST">

                <input type="text" placeholder="Cerca un prodotto..." name="name">

                <button type="submit" name="search">
                     <img src="<?= url('assets/img/glass.png')?>">
                </button>
            </form>
        </div>

        <div id="users_list">
            <a href="#" data-pdf="<?= url($nav['users']['url']) ?>" class="pdf"> <img src="<?= url( $nav['users']['image'] )  ?>" alt="users_list" >  </a>  
        </div>

        <div id="cart">
            <a href="<?= url( $nav['cart']['url'] ) ?>"><img src="<?= url( $nav['cart']['image'] ) ?>" alt="carrello acquisti"></a>
            <p class="quantity_products"><span><?= Utils::quantityCart() ?></span></p>
        </div>





        <div id="menu_hidden">
            <img src="<?= url('assets/img/menu_web.jpg') ?>"  id="hidden_menu_img">
            <ul class="menu_hidden_style">
                <li>
                <div class="hidden_images"> <img src="<?= url( $nav['cart']['image'] ) ?>"> </div>
                 <div>   
                    <a href='<?= url( $nav['cart']['url'] ) ?>'>
                        <?= $nav['cart']['name'] ?> (<span><?= Utils::quantityCart() ?></span>)
                    </a> 
                 </div>
                </li>
                <li class="hidden_menu_types">
                <div class="hidden_images"> <img src="<?= url( $nav['categories']['image'] ) ?>"> </div>
                  <div>  <a href="#"> <?= $nav['categories']['name'] ?> </a> </div>
                    <ul>
                        <?php $types_class = new Type();
                        $types = $types_class->getAllTypes();

                        while ($type = $types->fetch_object()) : ?>
                            <li>
                                <a href="<?= url( $router->generateUrl($nav['categories']['url'] , ['id' => $type->id ]) ) ?>"> <?= $type->name ?> </a>
                            </li>
                        <?php endwhile; ?>
                    </ul> 
                </li>
                <li>
                <div class="hidden_images">  <img src="<?= url( $nav['users']['image'] ) ?>"> </div>
                  <div>  
                    <a href='#' data-pdf="<?= url($nav['users']['url']) ?>" class="pdf">  <?= $nav['users']['name'] ?> </a> 
                  </div>
                </li>
                <li class="hidden_contacts">
                   <div class="hidden_images"> <img src="<?= url( $nav['contacts']['image'] ) ?>"> </div>
                   <div>  <a href='<?= url( $nav['contacts']['url'] ) ?>'>
                   <?= $nav['contacts']['name'] ?>
                    </a> </div>
                </li>
            </ul>
        </div>

    </nav>


    

    <div id="container">

        <div class="loading">                                                 <!--  effetto caricamento   -->
            <img src="<?= url('assets/img/loading.gif') ?>" alt="gif_loading">
        </div>


        <div class="no_loading">                                                <!--  contenuto principale aside e main  -->

            <aside>
                <?php require_once 'views/layouts/aside.php'; ?>
            </aside>


            <main>
                <?php   

                  $router->dispatch($requestMethod, $requestPath);           # Caricamento del main tramite la classe Router 

                  if(isset($_SESSION['error'])) :             ?>    
                        <div class="errors">
                            <?= $_SESSION['error'] ?>
                        </div>  
                  <?php endif; 
                  
                  if(isset($_SESSION['success'])) :   ?>
                       <div class="allerts">
                           <?= $_SESSION['success'] ?>
                       </div>
                   <?php endif; 
                   
                    Utils::delete_error();
                    Utils::delete_success(); 
                   
                   ?>
            </main>

        </div>

    </div>

    <footer>
        <?php 
        require_once 'views/layouts/footer.php'; 
        ob_end_flush();
         ?>
    </footer>

    <script src="<?= url('assets/javascript/main.js') ?>" type="module"></script>

</body>

</html>






