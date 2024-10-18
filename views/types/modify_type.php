<?php
Utils::isIdentity();
Utils::isAdmin(); 
?>


<h2>Modifica una Categoria</h2>

<?php if($_SESSION['identity']->id != 1) :  ?>
      <p class="rules">Per evitare di compromettere esageratamente il progetto, potrai modificare le categorie aggiunte da te o da altri utenti,
         ma non quelle già presenti di default <span class="hidden_words">(quelle inserite in fase di programmazione)</span> </p>
<?php endif; ?>

<form action="add-type" method="POST" class="type">

    <div>
        <p>Categoria da cambiare:</p>
        <select name="old_type" class="old_type">

            <?php $types_class = new Type();
            $types = $types_class->getAllTypes();

            while ($type = $types->fetch_object()) : 
                if($_SESSION['identity']->id != 1) :
                 if($type->id > 14) :   ?>
                <option value="<?= $type->id.'/'.$type->name ?>"> <?= $type->name ?> </option>
            <?php  endif;    else : ?>
                <option value="<?= $type->id.'/'.$type->name ?>"> <?= $type->name ?> </option>
            <?php    endif;
         endwhile; ?>
        </select>
    </div>

    <div>
        <label for="type_name">La nuova categoria sarà:</label>
        <input type="text" name="type_name">
    </div>

    <?php  if(!isset($_SESSION['cart'])) :  ?>
         <input type="submit" value="Modifica categoria" name="modify_type">
    <?php  else :  ?>
         <div class="noResult_search">Per modificare una categoria devi avere il carrello degli acquisti vuoto!</div>
    <?php endif; ?>
</form>