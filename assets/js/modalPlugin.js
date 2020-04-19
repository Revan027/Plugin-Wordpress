var indexSlide = 0;
var locationBuffer = null;

$(document).ready(function(){ 
      var namespace;

      $( ".modalplugin" ).hide();

      namespace = {

            showModal : function() {
                  if($( ".modalplugin" ).css("display") != "flex"){
                        
                        $( ".modalplugin" ).fadeIn( "slow", function() {
                                   
                        });
                  }
            },
            hideModal : function() {
                  if($( ".modalplugin" ).css("display") == "flex"){
                        $( ".modalplugin" ).fadeOut( "slow", function() {
            
                        });
                  }
            }
      };
    
    window.ns = namespace;
    


    /******************************************************************EVENTS******************************************************************/
      
      /**
       * changement de contenu 
      */
      $(".custom-nav").find("a").click(function(){  
            if($(this).attr("class") !="nav-link active")  {
                  toggleModalMenu($(this).attr("id"));
            }  
         
      });

      
      /**
       * fermeture du modal 
      */
      $(".custom-close").click(function(){  
            $(".mainSlideTrail").hide();
      });


      
});



/******************************************************************FUNCTIONS******************************************************************/

/**
 * Changement du contenu du modal
*/
function toggleModalMenu(lien){
      
      if( !$(".testForm").is(':animated') && !$(".mainSlideTrail").is(':animated') ) { 

            changeClass(lien);
          
            $("#ajaxLoader").hide(500,()=>{
                  $(".modalplugin").remove("#ajaxLoader"); 
            }); 
            if(lien=="liste"){
                  
                  $(".testForm").fadeOut(400,()=>{
                        showPicture();
                        $(".mainSlideTrail").fadeIn(400);
                  });                           
            }else{
                  $(".mainSlideTrail").fadeOut(400,()=>{
                        $(".testForm").fadeIn(400);    
                  }); 
            }
      } 
}



/**
 * Changement de class des liens du menu
*/
function changeClass(lien){
      if($("#"+lien).attr("class") != "nav-link active"){     
            $(".custom-nav").find("a").toggleClass("active");      
      }        
}



/**
 * Animation du slide
*/
function animationSlide(element){ 
      $(".infoSlide").fadeOut(500,()=>{
            runSlide(); 
      }).fadeIn(500);    
}


/**
 * reset du slide
*/
function resetSlide(){
      indexSlide = 0;  
      locationBuffer = null; 
      $(".date_trail").find("span").empty();
      $(".distance_trail").find("span").empty();
}



/**
 * Affiche la date
*/
function showDate(){
      $(".date_trail").find("span").html(locations[indexSlide].date);
}


/**
 * Affiche la distance
*/
function showDistance(){
      $(".distance_trail").find("span").html(locations[indexSlide].distance+" km");       
}



/**
 * Affiche la list des trails
*/
function showPicture(){
      $("#list-trail").empty();
      var i =  1;
      var className ="";
  
      for(let location of locations){
          
            var newDataTrail =  $(".data-trail").first().clone();
            let img = clonePicture(location.picture);
            if(i%2 != 0 )   newDataTrail.css("backgroundColor","white");
                 
           
            newDataTrail.css("display","block");
            newDataTrail.find(".img-trail").prepend(img)
            newDataTrail.find(".name-trail").append(location.name);
            newDataTrail.find(".date_trail").find("span").append(location.date);
            newDataTrail.find(".distance_trail").find("span").append(location.distance);
            $("#list-trail").append(newDataTrail);
            i++;
      }    
}


/**
 * Clonage de l'image type
*/
function clonePicture(src){
      let img_clone = $("#modelImg").clone();
      let dir = $(img_clone).attr("src");
      let img = $("<img>").attr("src",dir+src);
      return img;
}