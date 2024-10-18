

export function translate_products(){


    let boxes = document.querySelectorAll(".products_boxe");

    let arrow_right = document.querySelectorAll(".right");
    let arrow_left = document.querySelectorAll(".left");
    
     
     function translate(element,number) {   //  traslare immagini 
          for (let i = 0; i < element.children.length; i++) {
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
    
    


}