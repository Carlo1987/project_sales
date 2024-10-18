<?php Utils::isIdentity();
      Utils::isAdmin(); 
      
if(isset($_GET['delete'])) :     if($_SESSION['identity']->id != 1) :    ?>
      <h2>Elimina una categoria</h2>
      <p class="rules">Per evitare di compromettere esageratamente il progetto, potrai eliminare le categorie aggiunte da te o da altri utenti,
        ma non quelle già presenti di default <span class="hidden_words">(quelle inserite in fase di programmazione)</span></p>

      <p style="text-decoration: underline; color:red;" class="rules">Se cancelli un categoria, in automatico cancellerai anche tutti i prodotti di quella categoria...<br>
       Se hai capito, procedi pure!! </p>
  
<?php   endif;
    $url = url('delete-type');;
    $button = "Elimina categoria";
    $text = "eliminare";

    $types_class = new Type();
    $types = $types_class->getAllTypes();
else :   ?>
      <h2><span class="hidden_words">Aggiungi una </span> nuova Categoria</h2>    
<?php
 $url = url('add-type');;
 $button = "Crea categoria";
 $text = "aggiungere";
endif;  ?>



<form action="<?= $url ?>" method="POST" class="type">

<?php  if(isset($_GET['delete'])) :  ?>    <!-- funzione per cancellare categoria -->
      <div>
        <p>Scegli la categoria che vuoi eliminare:</p>
        <select name="type_id" class="old_type">
            <?php    while ($type = $types->fetch_object()) :
                      if($_SESSION['identity']->id != 1) :
                        if($type->id > 14) : ?> ?>
                <option value="<?= $type->id.'/'.$type->name ?>"> <?= $type->name ?> </option>
                <?php endif;   else :  ?>
                <option value="<?= $type->id.'/'.$type->name ?>"> <?= $type->name ?> </option>
     <?php endif;  endwhile; ?>
        </select>
    </div>

<?php else : ?>    <!--   funzione per aggiungere categoria   -->
      
      <div>
        <label for="type_name">La nuova categoria è:</label>
        <input type="text" name="type_name">
      </div>
<?php endif; ?>

    <?php  if(!isset($_SESSION['cart'])) :  ?>
      <input type="submit" value="<?= $button ?>" name="type">
    <?php  else :  ?>
         <div class="noResult_search">Per <?=$text?> una categoria devi avere il carrello degli acquisti vuoto!</div>
    <?php endif; ?>
</form>