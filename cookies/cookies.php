<?php
  //action="index.php?controller=Cookies_controller&action=setMarketing"
if (!isset($_COOKIE['marketing']) && !isset($_COOKIE['identity'])) :  ?>

<div id="divCookie">

   <div id="message_cookie">
      <h3>Questo progetto utilizza dei cookies per agevolarti la navigazione!!</h3>
      <p>I cookies tecnici sono obbligatori, se vuoi sperimentare i cookies di profilazione, allora spunta anche la casella "marketing"!! </p>
      <p><U>Dureranno solo 10 minuti</U>, circa ogni 5 minuti di navigazione nel sito ti arriverà una email con dei consigli in base agli ordini che hai fatto. </p>   
      <p>A te la scelta &#128521;!!</p>
   </div>

   <div id="choise_cookie">

       <form class="formCookies">

          <div>
            <label for="technician">Tecnici</label>
            <input type="checkbox" name="technician" checked disabled>
          </div>

          <div>
            <label for="marketing">Marketing</label>
            <input type="checkbox" name="marketing" class="marketing">
          </div>
        
          <div id="button_cookie">
            <input type="submit" value="Ok" name="formCookies">
          </div>

       </form>
   </div>

</div>



<?php endif; 

?>