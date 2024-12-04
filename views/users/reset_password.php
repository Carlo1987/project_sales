<h2>Reset della password</h2>

<form action="<?= url('user-newPassword') ?>" method="POST" class="form_forget_password">

<div>
    <label for="password">Inserisci nuova password:</label>
    <input type="password" name="password">
</div>

<div>
    <label for="confirm">Conferma password:</label>
    <input type="password" name="confirm">
</div>

<input type="submit" value="Reset">

</form>