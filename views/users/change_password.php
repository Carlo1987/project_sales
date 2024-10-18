<?php Utils::isIdentity(); 

if($_SESSION['identity']->id > 8 || $_SESSION['identity']->id == 1)  :  ?>

<h2>Modifica password</h2>

<form action="user-save?editPassword" method="POST" class="change_datos_user change_password_user">

<div>
        <label for="password">Vecchia password:</label>
        <input type="password" name="old_password">
    </div>

    <div>
        <label for="password">Nuova password:</label>
        <input type="password" name="new_password">
    </div>

    <div>
        <label for="confirm_password">Conferma password:</label>
        <input type="password" name="confirm_password">
    </div>


    <?php if (isset($_SESSION['errors_change']['password'])) : ?> <div class="errors change"><?=$_SESSION['errors_change']['password']?></div> <?php endif; ?>

    <input type="submit" value="Modifica" class="button" name="change">

</form>

<?php else :  ?>
  <h2>I dati di questo Utente non possono essere modificati</h2>
<?php endif; 
Utils::delete_change(); ?>