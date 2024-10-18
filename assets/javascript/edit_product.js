

function delete_product(link,url){

        let div = document.createElement('div');
        div.className = 'message_delete';
    
        let html = `<div><h3>Sei sicuro di voler cancellare il prodotto??</h3></div>
        <div class="buttons_delete_product">
            <div> <input type="submit" value="Ho cambiato idea" class="reject"> </div>
            <div> <input type="submit" value="Sono sicuro!!" class="acept"> </div>
        </div>`;
        div.insertAdjacentHTML('afterbegin',html);
        link.insertAdjacentElement('beforebegin',div);
    
        let reject = document.querySelector('.reject');
        let acept = document.querySelector('.acept');
    
    
        reject.onclick = function(){
            div.remove();
        }
    
        acept.onclick = function(){
            let id = link.getAttribute('data-id');
            window.location.href = url+"/delete-product/"+id;
        }
     
}




function modify_product(link){

    const body = document.querySelector('body');
    
        let data = link.getAttribute('data-change');
        let div = document.createElement('div');
        div.className = 'message_element';
    
    
        function div_message(word){
          html = `<div><h2>${word} un prodotto</h2></div>
          <div><p>${word} un prodotto dalla sua pagina di dettaglio (cliccando sul prodotto stesso)</p></div>
          <div><input type="submit" value="Ho capito!!" class="close"></div>`;
        }
    
        let html = '';
        if(data == 'modify'){
            div_message('Modificare');
    
        }else if(data == 'delete'){
          div_message('Eliminare');
        }
        
        div.insertAdjacentHTML('afterbegin',html);
        body.insertAdjacentElement('beforebegin',div);
      
        let close = document.querySelector('.close');
        close.onclick = function(){
          div.remove();
        }

}


export { delete_product , modify_product }


