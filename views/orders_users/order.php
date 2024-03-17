<?php Utils::isIdentity(); ?>

<h2>Inserisci un indirizzo</h2>

<form action="index.php?controller=Order_user_controller&action=save&order" method="POST" class="confirm">

   <div>
      <label for="region">Regione:</label>
      <input type="text" name="region">
   </div>

   <div>
      <label for="province">Provincia:</label>
      <input type="text" name="province">
   </div>

   <div>
      <label for="city">Città:</label>
      <input type="text" name="city">
   </div>

   <div>
      <label for="adress">Indirizzo:</label>
      <input type="text" name="adress">
   </div>

   <div>
      <label for="cap">CAP:</label>
      <input type="text" name="cap">
   </div>

  <input type="submit" value="Vai al pagamento" name="confirm">

  <?php if(isset( $_SESSION['error_order_user'])){ echo  $_SESSION['error_order_user'];  } 
  
  Utils::delete_errors_order()?>

</form>

