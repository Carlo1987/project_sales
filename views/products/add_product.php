<?php 
Utils::isIdentity();
Utils::isAdmin(); 
?>

<?php if(isset($_GET['id'])) {
      $product_class = new Product();
      $product = $product_class -> getOneProducts($_GET['id']);
    
      $title = 'Modifica Prodotto'; 
      $url = url('add-product?id='.$product->id);  
      $submit = 'Modifica prodotto';
      $text = "modificare";

      if($_SESSION['identity']->id != 1 && $product->id <= 48){
         url('home');
      }

} else {
      $title = 'Aggiungi Prodotto';
      $submit = 'Aggiungi prodotto';
      $url = url('add-product');
      $text = "aggiungere";
}  ?>


<h2> <?=$title?> </h2>

<form action="<?=$url?>" method="POST" enctype="multipart/form-data" class="type">

    <div>
        <label for="type">Categoria:</label>
        <select name="type" style="height: 22px;"> 
            <?php  $types_class = new Type();
                   $types = $types_class->getAllTypes();
                  
               while($type = $types->fetch_object()) : ?>    
            <option value="<?=$type->id?>" <?php if(isset($_GET['id']) && $type->id == $product->type_id) { echo 'selected'; } ?>> 
                  <?=$type->name?>
            </option>
              <?php endwhile; ?>
        </select>
    </div>

    <div>
        <label for="name">Nome: </label>
        <input type="text" name="name" require <?php if(isset($_GET['id'])) : ?> value="<?=$product->name?>" <?php endif;?> > 
    </div>

    <div>
        <label for="description">Descrizione:</label>
        <textarea name="description" style="width: 60%;" require><?php if(isset($_GET['id'])) {    $description = $product->description;
                                              $description = str_replace("%","'",$description);
                                              echo $description; } ?></textarea>  
    </div>

    <div>
        <label for="price"> Prezzo €</label>
        <input type="number" step="0.01" name="price" placeholder="esempio: 25.80" require <?php if(isset($_GET['id'])) : ?> value="<?=$product->price?>" <?php endif;?>>
    </div>

    <div>
        <label for="discount">Sconto %</label>
        <input type="number" name="discount" <?php if(isset($_GET['id'])) : ?> value="<?=$product->discount?>" <?php else : ?> placeholder="metti 0 se non vuoi applicare sconti" <?php endif;?>>
    </div>

    <div>
        <label for="stock">Quantità:</label>
        <input type="number" name="stock" require <?php if(isset($_GET['id'])) : ?> value="<?=$product->stock?>" <?php endif;?>>  
    </div>

    <div>
        <p> Immagine:</p>
        <input type="file" name="image">
    </div>

    <?php  if(!isset($_SESSION['cart'])) :  ?>
        <input type="submit" value="<?=$submit?>" name="product">
    <?php  else :  ?>
         <div class="noResult_search">Per <?=$text?> un prodotto devi avere il carrello degli acquisti vuoto!</div>
    <?php endif; 
    ?>
  
</form>