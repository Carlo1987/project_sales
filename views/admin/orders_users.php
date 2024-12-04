<?php 
Utils::isIdentity();
Utils::isAdmin();
 ?>

<h2>Cerca ordine di un cliente</h2>

<div id="user_orders">

    <form action="<?= url('orders-find?search') ?>" method="POST">

        <div>
            <label for="order">Numero d'ordine:</label>
            <input type="number" name="order" placeholder="numero d'ordine">
        </div>


        <div>
            <input type="submit" value="Cerca" name="search_order">
        </div>

    </form>
</div>

