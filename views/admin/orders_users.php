<?php 
Utils::isIdentity();
Utils::isAdmin();
 ?>

<h2>Cerca ordine di un cliente</h2>

<div id="user_orders">

    <form action="index.php?controller=Order_user_controller&action=find_order&search" method="POST">

        <div>
            <label for="order">Numero d'ordine:</label>
            <input type="number" name="order" placeholder="numero d'ordine">
        </div>


        <div>
            <input type="submit" value="Cerca" name="search_order">
        </div>

        <?php  if(isset($_SESSION['order']['error'])){  echo $_SESSION['order']['error'];  } 
        
         Utils::delete_orders();  ?>
    </form>
</div>

