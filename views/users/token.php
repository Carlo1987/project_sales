<h2>Inserisci il codice ricevuto per email</h2>

<div class="form_forget_password">

<input type="hidden" value="<?=$_SESSION['token']['code']?>" class="token">

<input type="number" class="verify" placeholder="inserisci qui il codice..." required>

<input type="submit" value="Invia" class="reset" style="position: relative;">

<div class="errors error_token" style="display: none;"> Il codice inserito non è corretto, digitalo correttamente oppure 
    <a href='https://localhost/php&sql/progetti/progetto_vendita/index.php?controller=Users_controller&action=email_reset'>clicca qui</a> per riceverne uno nuovo
</div>

<div class="errors error_length" style="display: none;">
    Il codice deve essere di 6 caratteri
</div>

</div>

