<?php if (!isset($_SESSION['identity'])) : ?>

    <div class="block_aside login">
        <h3>Login</h3>
        <form action="index.php?controller=Users_controller&action=login" method="POST">
            <div>
                <label for="email">Email:</label>
                <input type="email" name="email">
            </div>

            <div>
                <label for="password">Password:</label>
                <input type="password" name="password">
            </div>
            <input type="submit" value="Login" class="button" name="login">
            <?php if (isset($_SESSION['errors']['login'])) : ?> <div class="errors"><?= $_SESSION['errors']['login'] ?></div> <?php endif;
                                                                                                                            if (isset($_SESSION['reset'])) {
                                                                                                                                echo $_SESSION['reset'];
                                                                                                                            }   ?>
        </form>

        <p class="forget_password">Password dimenticata?
            <a href="index.php?controller=Users_controller&action=email_reset">Clicca qui</a>
        </p>
    </div>



    <div class="block_aside register">
        <h3>Registrati</h3>
        <form action="index.php?controller=Users_controller&action=save" method="POST" enctype="multipart/form-data">
            <div>
                <label for="name">Nome:</label>
                <input type="text" name="name">
            </div>
            <?php if (isset($_SESSION['errors']['name'])) : ?> <div class="errors"><?= $_SESSION['errors']['name'] ?></div> <?php endif; ?>

            <div>
                <label for="surname">Cognome:</label>
                <input type="text" name="surname">
            </div>
            <?php if (isset($_SESSION['errors']['surname'])) : ?> <div class="errors"><?= $_SESSION['errors']['surname'] ?></div> <?php endif; ?>

            <div>
                <select class="gender" name="gender">
                    <option value="Male">Maschio</option>
                    <option value="Female">Femmina</option>
                </select>
            </div>

            <div>
                <label for="email">Email:</label>
                <input type="email" name="email">
            </div>
            <?php if (isset($_SESSION['errors']['email'])) : ?> <div class="errors"><?= $_SESSION['errors']['email'] ?></div> <?php endif; ?>

            <div>
                <label for="password">Password:</label>
                <input type="password" name="password">
            </div>

            <div>
                <label for="confirm_password">Conferma:</label>
                <input type="password" name="confirm_password">
            </div>
            <?php if (isset($_SESSION['errors']['password'])) : ?> <div class="errors"><?= $_SESSION['errors']['password'] ?></div> <?php endif; ?>

            <p>Inserisci un' immagine di profilo</p>
            <input type="file" name="image">

            <input type="submit" value="Registrati" class="button button_register" name="register">

            <?php if (isset($_SESSION['register'])) : ?> <div class="allerts"><?= $_SESSION['register'] ?></div> <?php endif; ?>
        </form>
    </div>

<?php else :    #   se esiste la session identity
    $identity = $_SESSION['identity']; ?>

    <div class="block_aside visible_profile">
        <?php if ($identity->gender == 'Male') : ?>
            <h2 class="welcome">Benvenuto <?= $identity->name ?></h2>
        <?php else : ?>
            <h2 class="welcome">Benvenuta <?= $identity->name ?></h2>
        <?php endif; ?>

        <div class="image_login">
            <?php if ($identity->image == '') : ?>
                <img src="assets/img/user_default.png">
            <?php else : ?>
                <img src="assets/img/users/<?= $identity->image ?>">
            <?php endif; ?>
        </div>

        <div class="options">
            <ul>
                <?php if ($identity->id > 8 || $identity->id == 1) :  ?>
                    <li> <a href="index.php?controller=Users_controller&action=change">Cambia dati</a> </li>
                    <li> <a href="index.php?controller=Users_controller&action=change_password">Cambia password </a> </li>
                <?php endif;  ?>
                <li> <a href="index.php?controller=Order_user_controller&action=orders_list">Storico ordini</a></li>

                <?php if ($identity->role == 'admin') : ?>
                    <div class="admin">
                        <h4>AMMINISTRATORE</h4>
                    </div>

                    <li> <a href="pdf/users_list_complete.php" style="color: blue;">Elenco utenti</a> </li>
                    <li> <a href="pdf/orders_list.php" style="color: blue;">Elenco ordini utenti</a> </li>
                    <li> <a href="index.php?controller=Order_user_controller&action=search" style="color:green;">Cerca ordine cliente</a> </li>
                    <li> <a href="index.php?controller=Users_controller&action=role">Nuovi ruoli</a> </li>
                    <li class="manage_elements management_types">
                        <a href="#">Gestischi categorie</a>
                        <ul>
                            <li> <a href="index.php?controller=Types_controller&action=show">Aggiungi categoria</a> </li>
                            <li> <a href="index.php?controller=Types_controller&action=modify">Modifica categoria</a> </li>
                            <li> <a href="index.php?controller=Types_controller&action=show&delete">Elimina categoria</a></li>
                        </ul>
                    </li>
                    <li class="manage_elements management_products">
                        <a href="#">Gestisci prodotti</a>
                        <ul>
                            <li> <a href="pdf/products_list.php">Lista prodotti</a> </li>
                            <li> <a href="index.php?controller=Products_controller&action=show">Aggiungi prodotto</a> </li>
                            <li> <a href="#" class="modify_element" data-change="modify">Modifica prodotto</a></li>
                            <li> <a href="#" class="modify_element" data-change="delete">Elimina prodotto</a></li>
                        </ul>
                    </li>


                    <div class="admin"></div>
                <?php endif; ?>
                <li> <a href="index.php?controller=Users_controller&action=logout" style="color: rgb(205, 47, 47);">Logout</a> </li>
            </ul>
        </div>
    </div>

    
    <div class="block_aside hidden_aside">
        <div class="hidden_avatar">
            <div class="hidden_welcome">
                <?php if ($identity->gender == 'Male') : ?>
                    <h2 class="welcome">Benvenuto <?= $identity->name ?></h2>
                <?php else : ?>
                    <h2 class="welcome">Benvenuta <?= $identity->name ?></h2>
                <?php endif; ?>
            </div>
            <div>
                <?php if ($identity->image == '') : ?>
                    <img src="assets/img/user_default.png">
                <?php else : ?>
                    <img src="assets/img/users/<?= $identity->image ?>">
                <?php endif; ?>
            </div>
        </div>
        <div class="hidden_menu_aside">
            <p class="visible_orders"><a href="index.php?controller=Order_user_controller&action=orders_list">Storico ordini</a></p>
            <p>Menù Utente</p>
            <ul>
                <?php if ($identity->id > 8 || $identity->id == 1) :  ?>
                    <li> <a href="index.php?controller=Users_controller&action=change">Cambia dati</a> </li>
                    <li> <a href="index.php?controller=Users_controller&action=change_password">Cambia password </a> </li>
                <?php endif;  ?>
                <li class="hidden_word_menu"> <a href="index.php?controller=Order_user_controller&action=orders_list">Storico ordini</a></li>

                <?php if ($identity->role == 'admin') : ?>
                    <div class="admin">
                        <h4>AMMINISTRATORE</h4>
                    </div>

                    <li> <a href="pdf/users_list_complete.php" style="color: blue;">Elenco utenti</a> </li>
                    <li> <a href="pdf/orders_list.php" style="color: blue;">Elenco ordini utenti</a> </li>
                    <li> <a href="index.php?controller=Order_user_controller&action=search" style="color:green;">Cerca ordine cliente</a> </li>
                    <li> <a href="index.php?controller=Users_controller&action=role">Nuovi ruoli</a> </li>
                    <li class="hidden_manage_elements hidden_menage_types">
                        <a href="#">Gestischi categorie</a>
                        <ul>
                            <li> <a href="index.php?controller=Types_controller&action=show">Aggiungi categoria</a> </li>
                            <li> <a href="index.php?controller=Types_controller&action=modify">Modifica categoria</a> </li>
                            <li> <a href="index.php?controller=Types_controller&action=show&delete">Elimina categoria</a></li>
                        </ul>
                    </li>
                    <li class="hidden_manage_elements hidden_menage_products">
                        <a href="#">Gestisci prodotti</a>
                        <ul>
                            <li> <a href="pdf/products_list.php">Lista prodotti</a> </li>
                            <li> <a href="index.php?controller=Products_controller&action=show">Aggiungi prodotto</a> </li>
                            <li> <a href="#" class="modify_element" data-change="modify">Modifica prodotto</a></li>
                            <li> <a href="#" class="modify_element" data-change="delete">Elimina prodotto</a></li>
                        </ul>
                    </li>


                    <div class="admin"></div>
                <?php endif; ?>
                <li> <a href="index.php?controller=Users_controller&action=logout" style="color: rgb(205, 47, 47);">Logout</a> </li>
            </ul>
        </div>
    </div>

<?php
endif;
Utils::delete_aside();; ?>