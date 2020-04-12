$(document).ready(function(){alert();
      /*
      * resize plugin image map
      */
      $('.map').imageMapResize();   
     

      /**************************************************EVENTS**********************************************************************/
      $(window).resize(()=>{ 
            $('.map').imageMapResize();
            
            $(".runner").each(function(i){
                  let region = $(this).attr("data-id");
                  let coordObjet = setPositionIcon($('#'+region));
                  $(this)[0].style.top=coordObjet.top+"px";
                  $(this)[0].style.left=coordObjet.left+"px";
            });     
      });
      
});   



/**************************************************FUNCTIONS**********************************************************************/
/**
 * Retourne un objet représentant les coordonnées de l'image du runner
 * @param {*} element 
 */
function setPositionIcon(element){
    
      var tabX = [];
      var tabY = [];
      let tabYIndex = 0;

      tabX = element.attr("coords").split(',');
      let taille = tabX.length;

      for(let i =1; i<tabX.length;i++){
            tabY[tabYIndex] = tabX[i];    //capture de la coordonnée en Y depuis le tableau général
            tabX.splice(i, 1);      //suppression de la coordonnée Y dans le tableau général
            tabYIndex++;       
      }
      
      let valX = averageTabCoord(tabX);
      let valY = averageTabCoord(tabY);
      let coordObjet = {top:valY,left:valX};
      return coordObjet;
}



/**
 * Retourne la valeur du milieu des coordonées
 * @param {*} tab 
 */
function averageTabCoord(tab){
      let val = (Math.max(...tab)-Math.min(...tab))/2;   //difference entre valeur max et min et on prend la moitié
      val = Math.max(...tab) - val;   //obtention de la valeur pile au milieu des coordonnées en soustrayant la valeur max a la différence
      val -= 40; //retrait de 40 pixels correspondant au vide de l'image
      return val;
}


/**
 * positionne et créer une image de coureur sur un area
 * @param {*} ele 
 */
function setRunnerImg(ele){

      let coordObjet = setPositionIcon(ele);
    

      let img = $("<img data-trigger='hover'>").attr("src","http://localhost/trail_eure_27/wp-content/plugins/carte-interactive/assets/img/runner.png");
      img.addClass("runner");
      img.attr("data-id",ele.attr("id"));
      img.css({"top":coordObjet.top+"px","left":coordObjet.left+"px" });          
      $(".blockImage").append(img);        
} 


/**
 * parcours les images runner pour savoir si l'une correspond déja avec une region
 * @param {*} region 
 */
function ifRunnerExist(region){ 
      if_exist = false;

      $(".runner").each(function (index){ //parcours des objets runner
          
            if($( this ).attr("data-id") == region){  //si correspondance via l'attribut crée pour la liaison
                  if_exist = true;
            }        
     }); 
     return if_exist;
}


/**
 * parcours la liste des regions enregistrées 
 * 
 */
function eachTrail(resp){  
      $('.runner').remove();
      
      for(let key in resp){
            let eleArea =  $('#'+resp[key].region);
            setRunnerImg(eleArea);
            generatePopovers(key,resp[key].nombreTrail);  //genéré les popovers une fois les images runners placées et crées 
      }
      
}


/**
 * génère les popovers
 * 
 */
function generatePopovers(index,nombreTrail){ 
      $($(".runner")[index]).popover({ title: "Nombre de trail", content: nombreTrail, placement: "right",trigger: "hover" });
}