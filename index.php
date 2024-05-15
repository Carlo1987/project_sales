<?php

//    $host = 'carloloidev.com/Project_Shop';
$host = 'localhost/progetti/progetto_vendita/index.php';

require 'config/database.php';
require 'models/type.php';
require 'models/product.php';
require 'models/user.php';
require 'models/order_product.php';
require 'models/order_user.php';
require 'models/payment.php';
require 'config/utils.php';
require 'config/paginate.php';
require 'controllers/products_controller.php';
require 'controllers/users_controller.php';
require 'controllers/types_controller.php';
require 'controllers/orders_prod_controller.php';
require 'controllers/orders_user_controller.php';
require 'controllers/payment_controller.php';

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
    <link rel="stylesheet" type="text/css" href="assets/css/style.css?ts=<?= time() ?>&quot">
    <link rel="stylesheet" type="text/css" href="assets/css/mediaQuery.css?ts=<?= time() ?>&quot">
    <title>Progetto vendita</title>
</head>

<body>

    <header>
        <div id="title">
            <img src="assets/img/icon.jpg" alt="icona sito" class="icon_web">
            <a href="index.php">
                <h1>Progetto vendita</h1>
            </a>
        </div>
    </header>
<?php Utils::cartCookie(); ?>
    <nav>
        <ul>
            <li style=" border-left: none;" class="link_home">
                <a href="index.php" style="color: rgb(147, 191, 81);"> HOME </a>
            </li>

            <li id="menu_types">
                <a href="#"> Categorie </a>
                <ul>
                    <?php $types_class = new Type();
                    $types = $types_class->getAllTypes();

                    while ($type = $types->fetch_object()) : ?>
                        <li>
                            <a href="index.php?controller=Products_controller&action=products_for_type&id=<?= $type->id ?>"> <?= $type->name ?> </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </li>

            <li id="contacts">
                <a href="index.php?controller=Users_controller&action=contacts">Contatti</a>
            </li>
        </ul>

        <div id="search">
            <form action="index.php?controller=Products_controller&action=find" method="POST">

                <input type="text" placeholder="Cerca un prodotto..." name="name">

                <button type="submit" name="search">
                    <img src="assets/img/glass.png">
                </button>
            </form>
        </div>

        <div id="users_list">
            <a href="#"> <img src="assets/img/people_group.png" alt="users_list"> </a>
        </div>

        <div id="cart">
            <a href="index.php?controller=Orders_prod_controller&action=cart"><img src="assets/img/shopping_cart.png" alt="carrello acquisti"></a>
            <p class="quantity_products"><span><?= Utils::quantityCart() ?></span></p>
        </div>



        <div id="menu_hidden">
            <img src="assets/img/menu_web.jpg"  id="hidden_menu_img">
            <ul class="menu_hidden_style">
                <li>
                <div class="hidden_images"> <img src="assets/img/shopping_cart.png"> </div>
                 <div>   <a href='index.php?controller=Orders_prod_controller&action=cart'>
                        Carrello (<span><?= Utils::quantityCart() ?></span>)
                    </a> </div>
                </li>
                <li class="hidden_menu_types">
                <div class="hidden_images"> <img src="assets/img/categories.jpg"> </div>
                  <div>  <a href="#">Categorie</a> </div>
                    <ul>
                        <?php $types_class = new Type();
                        $types = $types_class->getAllTypes();

                        while ($type = $types->fetch_object()) : ?>
                            <li>
                                <a href="index.php?controller=Products_controller&action=products_for_type&id=<?= $type->id ?>"> <?= $type->name ?> </a>
                            </li>
                        <?php endwhile; ?>
                    </ul> 
                </li>
                <li>
                <div class="hidden_images">  <img src="assets/img/people_group.png"> </div>
                  <div>  
                    <a href='#' onclick="pdf('pdf/users_list.php')">  Utenti fittizzi  </a> 
                  </div>
                </li>
                <li class="hidden_contacts">
                   <div class="hidden_images"> <img src="assets/img/phone.png"> </div>
                   <div>  <a href='${url}?controller=Users_controller&action=contacts'>
                        Contatti
                    </a> </div>
                </li>
            </ul>
        </div>

    </nav>


    

    <div id="container">

        <aside>
            <?php require_once 'views/layouts/aside.php'; ?>
        </aside>

        <main>
            <?php
            if (isset($_GET['controller'])) {
                $name_controller = $_GET['controller'];

                $controller = new $name_controller();

                if (isset($_GET['action']) && method_exists($controller, $_GET['action'])) {
                    $action = $_GET['action'];

                    $controller->$action();
                } else {
                    echo 'La pagina che cerchi non esiste';
                }

            } else {
                $controller = new Types_controller();
                $controller->index();
            }
            ?>
        </main>

    </div>

    <footer>
        <?php require_once 'views/layouts/footer.php'; ?>
    </footer>

    <script src="assets/javascript/script.js" type="text/javascript"></script>
</body>

</html>






