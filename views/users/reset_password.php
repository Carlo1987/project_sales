<h2>Reset della password</h2>

<form action="index.php?controller=Users_controller&action=new_password" method="POST" class="form_forget_password">

<div>
    <label for="password">Inserisci nuova password:</label>
    <input type="password" name="password">
</div>

<div>
    <label for="confirm">Conferma password:</label>
    <input type="password" name="confirm">
</div>

<input type="submit" value="Reset">

<?php if(isset($_SESSION['token_error'])) {   echo $_SESSION['token_error'];  } 

Utils::delete_token_error();   ?>

</form>