
//////////////////    URL DI BASE    ///////////////////////////
//   const url = "https://carloloidev";
const url = "https://localhost/progetti/progetto_vendita/index.php";


/////////////////  MESSAGGIO BOTTONE LISTA DEGLI UTENTI FITTIZZI  ///////////////////////

const users_list = document.querySelector('#users_list img');

users_list.addEventListener('mouseover',()=>{
  let div = document.createElement('div');
  div.className = 'message_users_list';
  users_list.style.position = "relative";

  let html = `<p> Guarda i dati di accesso degli utenti fittizzi se vuoi entrare con un loro profilo </p>`;
  
   div.insertAdjacentHTML('afterbegin',html);
   users_list.insertAdjacentElement('afterend',div);

   users_list.addEventListener('mouseout',()=>{
    div.remove();

    users_list.onclick = function(){
      div.remove();
      window.open("pdf/users_list.php");
    }
  })
})




//////////////    notifica per cambiare / eliminare prodotto  /////////////////////////////////

const body = document.querySelector('body');
const modify_products = document.querySelectorAll('.modify_element');

modify_products.forEach(link => {
  link.onclick = function(){

    let data = link.getAttribute('data-change');
    let div = document.createElement('div');
    div.className = 'message_element';

    let html = '';
    if(data == 'modify'){
      html = `<div><h2>Modificare un prodotto</h2></div>
      <div><p>Modificare un prodotto dalla sua pagina di dettaglio (cliccando sul prodotto stesso)</p></div>
      <div><input type="submit" value="Ho capito!!" class="close"></div>`;

    }else if(data == 'delete'){
      html = `<div><h2>Eliminare un prodotto</h2></div>
      <div><p>Eliminare un prodotto dalla sua pagina di dettaglio (cliccando sul prodotto stesso)</p></div>
      <div><input type="submit" value="Ho capito!!" class="close"></div>`;
    }
    
    div.insertAdjacentHTML('afterbegin',html);
    body.insertAdjacentElement('beforebegin',div);
  
    let close = document.querySelector('.close');
    close.onclick = function(){
      div.remove();
    }
  }
})


//////////////////     traslare card dei prodotti    ////////////////////////////

let boxes = document.querySelectorAll(".products_boxe");

let arrow_right = document.querySelectorAll(".right");
let arrow_left = document.querySelectorAll(".left");

 
 function translate(element,number) {   //  traslare immagini 
      for (i = 0; i < element.children.length; i++) {
        element.children[i].style.transform = `translateX(${120 * (i - number)}%)`;
      }
} 

boxes.forEach(boxe => {  
  translate(boxe, 0);
}); 
  
let number = 0;

arrow_right.forEach((arrow, index_arrow) => {   //  FRECCIA DESTRA
  arrow.addEventListener("click", () => {

    boxes.forEach((boxe, index_boxe) => {
      if (index_arrow == index_boxe) {
        if(boxe.children.length >4){
          if (number < boxe.children.length - 4) {
            number++;
          } else {
            number = boxe.children.length - 4;
          }
          translate(boxe,number);
        }
      }
    });
  });
});

arrow_left.forEach((arrow, index_arrow) => {   //   FRECCIA SINISTRA
  arrow.addEventListener("click", () => {

    boxes.forEach((boxe, index_boxe) => {
      if (index_arrow == index_boxe) {
        if(boxe.children.length >4){
          number--;
          if (number < 0) {
            number = 0;
          }
          translate(boxe,number);
        }
      }
    });
  });
});



//////////////  SCELTA PAGAMENTO  ///////////////////////////

if(window.location.href.indexOf('payment') > -1){
  const card = document.querySelector('.title_card');
  const bank = document.querySelector('.title_bank');
  const form_card = document.querySelector('.card_debit');
  const form_bank = document.querySelector('.bank');
  
  bank.onclick = function(){
      bank.style.backgroundColor = '#b9b2b2';
      card.style.backgroundColor = 'white';
      form_card.style.display = 'none';
      form_bank.style.display = 'block';
  }
  
  card.onclick = function(){
    card.style.backgroundColor = '#b9b2b2';
    bank.style.backgroundColor = 'white';
    form_bank.style.display = 'none';
    form_card.style.display = 'block';
  }
}




if(window.location.href.indexOf('product_one') > -1){

  /////////////    aggiorna prezzo in base alla quantità   ////////////////////////////////
  let price = document.querySelector('.price_real span span');
  let quantity = document.querySelector('.quantity_number');
  
  let value_initial = parseFloat(price.textContent);
  
  function getValue(){
    let newPrice = value_initial * parseInt(quantity.value);
    return price.innerHTML = newPrice.toFixed(2);
  }
  
  getValue(); 


  /////////////    messaggio per eliminare un prodotto  ////////////////////////////////
let delete_product = document.querySelector('.delete_product');

delete_product.onclick = function(){
  let div = document.createElement('div');
  div.className = 'message_delete';

  let html = `<div><h3>Sei sicuro di voler cancellare il prodotto??</h3></div>
  <div class="buttons_delete_product">
      <div> <input type="submit" value="Ho cambiato idea" class="reject"> </div>
      <div> <input type="submit" value="Sono sicuro!!" class="acept"> </div>
   </div>`;
   div.insertAdjacentHTML('afterbegin',html);
   delete_product.insertAdjacentElement('beforebegin',div);

   let reject = document.querySelector('.reject');
   let acept = document.querySelector('.acept');

   reject.onclick = function(){
    div.remove();
   }

   acept.onclick = function(){
   
    let id = delete_product.getAttribute('data-id');
     window.location.href = url+"?controller=Products_controller&action=deleteProduct&id="+id;
   }
}
}




/////////////////  CONTAINER RESET PASSWORD  ///////////////////////

const aside = document.querySelector('aside');
const main = document.querySelector('main');

if(window.location.href.indexOf('email_reset') > 1 || window.location.href.indexOf('verify_token') > 1 || window.location.href.indexOf('send_token') > 1 || window.location.href.indexOf('reset_password') > 1){
  aside.style.display = 'none';
  main.style.flexBasis = '100%';
}



//////////////////   BOTTONE  RESET  PASSWORD  ///////////////

if(window.location.href.indexOf('verify_token') > 1){

  const reset = document.querySelector('.reset');

  reset.onclick = function(){
      let verify = document.querySelector('.verify');
      let token = document.querySelector('.token');
  
      let error_token = document.querySelector('.error_token');
      let error_length = document.querySelector('.error_length');
  
      if(verify.value.length == 6){
  
        if(verify.value == token.value){
          window.location.href  = url+'?controller=Users_controller&action=reset_password';
       
        }else{
          error_length.style.display = "none";
          error_token.style.display = "block";
        }
  
      }else{
        error_token.style.display = "none";
        error_length.style.display = "block";
      }
  }  
}



  /////////////////  COLLEGAMENTO FILE PDF /////////////


  function pdf(url){
    window.open(url);
  }



  /////////////////  MESSAGGIO BOTTONE PER REGISTRARSI  ///////////////////////

  const register = document.querySelector('.button_register');

  register.addEventListener('mouseover',()=>{
    let div = document.createElement('div');
    div.className = 'message_register';
  
    let html = `<p> Per farti provare tutte le funzioni, verrai registrato come <U>Amministratore</U>!! </p>`;
    
     div.insertAdjacentHTML('afterbegin',html);
    register.insertAdjacentElement('afterend',div);
  
    register.addEventListener('mouseout',()=>{
      div.remove();
    })
  })










