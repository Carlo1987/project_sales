<?php Utils::isIdentity(); ?>

<h2>Inserisci un indirizzo</h2>

<form action="<?= url('save-order-user') ?>" method="POST" class="confirm">

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

</form>

