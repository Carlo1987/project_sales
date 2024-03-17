<?php 
Utils::isIdentity();
Utils::isAdmin();
?>


<h2><span class="hidden_words">Assegna un</span> nuovo ruolo <span class="hidden_words"> un Utente</span></h2>

<p class="rules">Per evitare di rovinare l'esperienza di altri utenti, potrai cambiare ruolo solo agli Utenti fittizzi  <span class="hidden_words">(trovi l'elenco in alto)</span></p>

<form action="index.php?controller=Users_controller&action=new_role" method="POST" class="change_datos_user">

     <div>
        <label for="name">Nome Utente:</label>
        <input type="text" name="name">
     </div>

     <div>
        <label for="surname">Cognome Utente:</label>
        <input type="text" name="surname">
     </div>

     <div>
        <label for="email">Email Utente:</label>
        <input type="text" name="email">
     </div>

     <div>
        <p>Scegli il ruolo da cambiare:</p>
        <select name="chose_role" style="margin-left: 9px;">
            <option value="admin">Amministratore</option>
            <option value="user">Utente</option>
        </select>
     </div>

     
     <?php if(isset($_SESSION['role'])) : ?> <div class="allerts"><?=$_SESSION['role']?></div> <?php endif; 
      if(isset($_SESSION['error_role'])) : ?> <div class="errors"><?=$_SESSION['error_role']?></div> <?php endif; ?>

     <input type="submit" value="Modifica ruolo" class="button" name="role">

</form>

  <?php Utils::delete_role(); ?>

