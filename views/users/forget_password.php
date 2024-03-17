<h2>Inserisci la tua email</h2>

<form method="POST" action="index.php?controller=Users_controller&action=send_token" class="form_forget_password">

    <input type="email" name="email" placeholder="Inserisci qui la tua email..." required>

    <?php if(isset($_SESSION['token_error'])) {   echo $_SESSION['token_error'];  } ?>

    <input type="submit" value="Invia link">

</form>

<?php  Utils::delete_token_error();   ?>

