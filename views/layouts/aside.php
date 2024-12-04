<?php

$menu_aside = menu_aside();

if (!isset($_SESSION['identity'])) : ?>

    <div class="block_aside no_login_max">
       <h3 class="button_noLogin" data-button="general"> Login / Registrati <i class="fa-solid fa-caret-down"></i></h3>
    </div>

    <div class="block_aside no_login">
       <h3 class="button_noLogin" data-button="login">Login <i class="fa-solid fa-caret-down"></i></h3>  
       <h3 class="button_noLogin" data-button="register"> Registrati <i class="fa-solid fa-caret-down"></i></h3>
    </div>

    <div id="aside_responsive">     <!-- inizio aside_responsive -->

    <div class="block_aside login">
        <h3>Login</h3>
        <form action="<?= url('user-login') ?>" method="POST">
            <div>
                <label for="email">Email:</label>
                <input type="email" name="email">
            </div>

            <div>
                <label for="password">Password:</label>
                <input type="password" name="password">
            </div>
            <input type="submit" value="Login" class="button" name="login">

            <?php 
                if (isset($_SESSION['errors']['login'])) : ?> <div class="errors"><?= $_SESSION['errors']['login'] ?></div> <?php endif;

                if(isset($_SESSION['reset'])) {  echo $_SESSION['reset'];   }   
            ?>
        </form>

        <p class="forget_password">Password dimenticata?  </p>
        <a style="color: blue;" href="<?= url('user-resetEmail') ?>">Clicca qui</a>
    </div>



    <div class="block_aside register">
        <h3>Registrati</h3>
        <form action="<?= url('user-save') ?>" method="POST" enctype="multipart/form-data">
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

    </div>     <!-- fine aside_responsive -->

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
                <img src="<?= url('assets/img/user_default.png') ?>">
            <?php else : ?>
                <img src="<?= url('assets/img/users/'.$identity->image ) ?>">
            <?php endif; ?>
        </div>

        <div class="options">
            <ul>
                <?php if ($identity->id > 8 || $identity->id == 1) :  ?>
                    <li> <a href="<?= url( $menu_aside['edit-datas']['url'] ) ?>"> <?= $menu_aside['edit-datas']['name'] ?> </a> </li>
                    <li> <a href="<?= url( $menu_aside['edit-password']['url'] ) ?>"> <?= $menu_aside['edit-password']['name'] ?>  </a> </li>
                <?php endif;  ?>
                <li> <a href="<?= url( $menu_aside['orders']['url'] ) ?>"> <?= $menu_aside['orders']['name'] ?> </a></li>

                <?php if ($identity->role == 'admin') : ?>
                    <div class="admin">
                        <h4> <?= $menu_aside['admin'] ?> </h4>
                    </div>

                    <li> <a href="#" data-pdf="<?= url($menu_aside['orders-list']['url']) ?>" class="pdf" style="color: blue;"> <?= $menu_aside['orders-list']['name'] ?> </a> </li>
                    <li> <a href="<?= url( $menu_aside['orders-search']['url'] ) ?>" style="color:green;"> <?= $menu_aside['orders-search']['name'] ?> </a> </li>
                    <li class="manage_elements management_types">
                        <a href="#"> <?= $menu_aside['categories'] ?> </a>
                        <ul>
                            <li> <a href="<?= url( $menu_aside['add-category']['url'] ) ?>"> <?= $menu_aside['add-category']['name'] ?> </a> </li>
                            <li> <a href="<?= url( $menu_aside['edit-category']['url'] ) ?>"> <?= $menu_aside['edit-category']['name'] ?> </a> </li>
                            <li> <a href="<?= url( $menu_aside['delete-category']['url'] ) ?>"> <?= $menu_aside['delete-category']['name'] ?> </a></li>
                        </ul>
                    </li>
                    <li class="manage_elements management_products">
                        <a href="#"> <?= $menu_aside['products'] ?> </a>
                        <ul>
                            <li> <a href="#" data-pdf="<?= url($menu_aside['products-list']['url']) ?>" class="pdf" > <?= $menu_aside['products-list']['name'] ?> </a> </li>
                            <li> <a href="<?= url( $menu_aside['add-product']['url'] ) ?>"> <?= $menu_aside['add-product']['name'] ?> </a> </li>
                            <li> <a href="#" class="<?= $menu_aside['edit-product']['class'] ?>" data-change="<?= $menu_aside['edit-product']['data'] ?>"> <?= $menu_aside['edit-product']['name'] ?> </a></li>
                            <li> <a href="#" class="<?= $menu_aside['delete-product']['class'] ?>" data-change="<?= $menu_aside['delete-product']['data'] ?>"> <?= $menu_aside['delete-product']['name'] ?> </a></li>
                        </ul>
                    </li>


                    <div class="admin"></div>
                <?php endif; ?>
                <li> <a href="<?= url('user-logout') ?>" style="color: rgb(205, 47, 47);"> <?= $menu_aside['logout'] ?> </a> </li>
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
                    <img src="<?= url('assets/img/user_default.png') ?> ">
                <?php else : ?>
                    <img src="<?= url('assets/img/users/'.$identity->image ) ?>">
                <?php endif; ?>
            </div>
        </div>
        <div class="hidden_menu_aside">
            <p class="visible_orders"><a href="<?= url( $menu_aside['orders']['url'] ) ?>"> <?= $menu_aside['orders']['name'] ?> </a></p>
            <p>Menù Utente</p>
            <ul>
                <?php if ($identity->id > 8 || $identity->id == 1) :  ?>
                    <li> <a href="<?= url( $menu_aside['edit-datas']['url'] ) ?>"> <?= $menu_aside['edit-datas']['name'] ?> </a> </li>
                    <li> <a href="<?= url( $menu_aside['edit-password']['url'] ) ?>"> <?= $menu_aside['edit-password']['name'] ?>  </a> </li>
                <?php endif;  ?>
                <li class="hidden_word_menu"><a href="<?= url( $menu_aside['orders']['url'] ) ?>"> <?= $menu_aside['orders']['name'] ?> </a> </li>

                <?php if ($identity->role == 'admin') : ?>
                    <div class="admin">
                        <h4> <?= $menu_aside['admin'] ?> </h4>
                    </div>

                    <li> <a href="#"  data-pdf="<?= url($menu_aside['orders-list']['url']) ?>" class="pdf" style="color: blue;"> <?= $menu_aside['orders-list']['name'] ?> </a> </li>
                    <li> <a href="<?= url( $menu_aside['orders-search']['url'] ) ?>" style="color:green;"> <?= $menu_aside['orders-search']['name'] ?> </a> </li>
                    
                    <li class="hidden_manage_elements ">   <!-- hidden_menage_types -->
                        <a href="#"> <?= $menu_aside['categories'] ?> </a>
                        <ul>
                            <li> <a href="<?= url( $menu_aside['add-category']['url'] ) ?>"> <?= $menu_aside['add-category']['name'] ?> </a> </li>
                            <li> <a href="<?= url( $menu_aside['edit-category']['url'] ) ?>"> <?= $menu_aside['edit-category']['name'] ?> </a> </li>
                            <li> <a href="<?= url( $menu_aside['delete-category']['url'] ) ?>"> <?= $menu_aside['delete-category']['name'] ?> </a></li>
                        </ul>
                    </li>
                    <li class="hidden_manage_elements ">  <!-- hidden_menage_products -->
                        <a href="#"> <?= $menu_aside['products'] ?> </a>
                        <ul>
                            <li> <a href="#" data-pdf="<?= url($menu_aside['products-list']['url']) ?>" class="pdf" > <?= $menu_aside['products-list']['name'] ?> </a> </li>
                            <li> <a href="<?= url( $menu_aside['add-product']['url'] ) ?>"> <?= $menu_aside['add-product']['name'] ?> </a> </li>
                            <li> <a href="#" class="<?= $menu_aside['edit-product']['class'] ?>" data-change="<?= $menu_aside['edit-product']['data'] ?>"> <?= $menu_aside['edit-product']['name'] ?> </a></li>
                            <li> <a href="#" class="<?= $menu_aside['delete-product']['class'] ?>" data-change="<?= $menu_aside['delete-product']['data'] ?>"> <?= $menu_aside['delete-product']['name'] ?> </a></li>
                        </ul>
                    </li>


                    <div class="admin"></div>
                <?php endif; ?>
                <li> <a href="<?= url('user-logout') ?>" style="color: rgb(205, 47, 47);"> <?= $menu_aside['logout'] ?> </a> </li>
            </ul>
        </div>
    </div>

<?php
endif;
Utils::delete_aside();; ?>