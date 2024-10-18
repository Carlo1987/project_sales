
import { url } from "./url.js";
import { loading } from "./loading.js";
import { translate_products } from "./translate.js";



//////////////////    URL DI BASE    ///////////////////////////

//const url = url;


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




//////////////////     traslare card dei prodotti    ////////////////////////////

translate_products();



//////////////  SCELTA PAGAMENTO  ///////////////////////////

if(window.location.href.indexOf('payment') > -1){
  const card = document.querySelector('.title_card');
  const bank = document.querySelector('.title_bank');
  const form_card = document.querySelector('.card_debit');
  const form_bank = document.querySelector('.bank');

  const color = '#b9b2b2';
  
  bank.onclick = function(){
      bank.style.backgroundColor = color;
      card.style.backgroundColor = 'white';
      form_card.style.display = 'none';
      form_bank.style.display = 'block';
  }
  
  card.onclick = function(){
    card.style.backgroundColor = color;
    bank.style.backgroundColor = 'white';
    form_bank.style.display = 'none';
    form_card.style.display = 'block';
  }
}




if(window.location.href.indexOf('product') > -1){

  /////////////    aggiorna prezzo in base alla quantità   ////////////////////////////////
  let price = document.querySelector('.price_real span span');
  let quantity = document.querySelector('.quantity_number');
  
  let value_initial = parseFloat(price.textContent);
  
  function getValue(){
    let newPrice = value_initial * parseInt(quantity.value);
    return price.innerHTML = newPrice.toFixed(2);
  }
  
  getValue(); 

}




//////////////////   BOTTONE  RESET  PASSWORD  ///////////////

if(window.location.href.indexOf('user-token') > 1){

  const reset = document.querySelector('.reset');

  reset.onclick = function(){
      let verify = document.querySelector('.verify');
      let token = document.querySelector('.token');
  
      let error_token = document.querySelector('.error_token');
      let error_length = document.querySelector('.error_length');
  
      if(verify.value.length == 6){
        
        if(verify.value == token.value){
          window.location.href  = url+'/user-resetPassword';
       
        }else{          
          error_length.style.display = "none";
          error_token.style.display = "flex";
        }
  
      }else{    
        error_token.style.display = "none";
        error_length.style.display = "block";
      }
  }  
}



/////////////////  FUNZIONE PER LOADING TRA LE PAGINE  ///////////////////////

loading(url);

  
//////////////   login o register schermo medio/piccolo  /////////////////////////////////

const buttons_noLogin = document.querySelectorAll('.button_noLogin');
let open_menu = false;

buttons_noLogin.forEach(button=>{
  button.onclick = function(){
    let action = this.getAttribute('data-button');
    let login = document.querySelector('.login');
    let register = document.querySelector('.register');

    if(!open_menu){
    
      if(action == 'login'){
        login.style.display = 'block';
        register.style.display = 'none';
      }else if(action == 'register'){
        login.style.display = 'none';
        register.style.display = 'block';
      }else if(action == 'general'){
        login.style.display = 'block';
        register.style.display = 'block';      
      }

      open_menu  = true;

    }else{
      login.style.display = 'none';
      register.style.display = 'none';
      open_menu = false;
    }

    
  }
})




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










