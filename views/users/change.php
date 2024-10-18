<?php Utils::isIdentity();

$identity = $_SESSION['identity']; 

if($identity->id > 8 || $identity->id == 1)  :   ?>

<h2>Modifica <span class="hidden_words">i tuoi</span> dati</h2>

<form action="user-save" method="POST" enctype="multipart/form-data" class="change_datos_user">
    <div>
        <label for="name">Nome:</label>
        <input type="text" name="name" value="<?=$identity->name?>">
    </div>
    <?php if (isset($_SESSION['errors_change']['name'])) : ?> <div class="errors change"><?= $_SESSION['errors_change']['name'] ?></div> <?php endif; ?>

    <div>
        <label for="surname">Cognome:</label>
        <input type="text" name="surname" value="<?=$identity->surname?>">
    </div>
    <?php if (isset($_SESSION['errors_change']['surname'])) : ?> <div class="errors change"><?= $_SESSION['errors_change']['surname'] ?></div> <?php endif; ?>

    <div class="gender">
        <select name="gender">
        <?php if($identity->gender == 'Male') : ?>
            <option value="Male"  selected >Maschio</option>
            <option value="Female">Femmina</option>
        <?php elseif($identity->gender == 'Female') : ?>
            <option value="Male">Maschio</option>
            <option value="Female" selected>Femmina</option>
        <?php endif; ?> 
        </select>
    </div>

    <div>
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?=$identity->email?>">
    </div>
    <?php if (isset($_SESSION['errors_change']['email'])) : ?> <div class="errors change"><?= $_SESSION['errors_change']['email'] ?></div> <?php endif; ?>

    <p>Inserisci / cambia l'immagine del tuo profilo</p>
    <input type="file" name="image">
   
    <?php if(isset($_SESSION['change'])) : ?> <div class="allerts change"><?=$_SESSION['change']?></div>   <?php endif; ?>
    <input type="submit" value="Modifica" class="button" name="change">
</form>

<?php  else :   ?>
  <h2>I dati di questo Utente non possono essere modificati</h2>
<?php endif;
Utils::delete_change(); ?>