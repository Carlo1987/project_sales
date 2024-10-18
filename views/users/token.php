<h2>Inserisci il codice ricevuto per email</h2>

<div class="form_forget_password">

<input type="hidden" value="<?=$_SESSION['token']['code']?>" class="token">

<input type="number" class="verify" placeholder="inserisci qui il codice..." required>

<input type="submit" value="Invia" class="reset" style="position: relative;" onclick="loading()">

<div class="error_token" style="display: none;"> 
   <div class="errors"> Il codice inserito non è corretto, per riceverne uno nuovo clicca sotto </div>
   <form method="POST" action="user-sendToken" onsubmit="loading()"> 
       <input type="hidden" value="<?=$_SESSION['token']['email']?>" name="email">
       <input type="submit" value="Nuovo codice"> 
   </form>
</div>

<div class="errors error_length" style="display: none;">
    Il codice deve essere di 6 caratteri
</div>

</div>

