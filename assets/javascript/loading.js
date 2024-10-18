
import { modify_product , delete_product } from "./edit_product.js";

export function loading(url){

    function create_loading(){
        const loading = document.querySelector('.loading');
        const no_loading = document.querySelector('.no_loading');
      
        no_loading.style.display = 'none';
        loading.style.display = 'block';
    } 
    
    
    
    
    let forms = document.querySelectorAll('form');
    let links = document.querySelectorAll('a');


    
    forms.forEach(form=>{
        form.addEventListener(event,()=>{
            create_loading();
        })
    })
    



    links.forEach(link=>{

            link.onclick = function(e){
                if(link.classList.contains('pdf')){
                  e.preventDefault();
                  let data_pdf = link.getAttribute('data-pdf');
                  
                  window.open(data_pdf);

                }else if(link.classList.contains('delete_product')){
                    e.preventDefault();
                    delete_product(link,url);
                
                }else if(link.classList.contains('modify_element')){
                    console.log('ok');
                    
                    e.preventDefault();
                    modify_product(link);

                }else{
                    create_loading();
                }
            }
        
  
    })

    
}




  