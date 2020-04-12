var indexSlide = 0;
var locationBuffer = null;

$(document).ready(function(){

  
      var namespace;

      $( ".modalplugin" ).hide();

      namespace = {

            showModal : function() {
                  resetSlide();
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


      /**
       * navigation du slide
      */
      $(".navSlide").click(function(){    
            handleSlide($(this));
            animationSlide();
      });


      /**
       * click sur les miniatures
      */
      $(".listTrailPicture").delegate("li","click",function(ev) {
           indexSlide =  $(this).attr("data-id");
           animationSlide();
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
            if(lien=="liste" && locations.length!=0){
                  
                  $(".testForm").fadeOut(400,()=>{
                        showPicture();
                        runSlide();
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
 * gestion de l'avancement du slide
*/
function handleSlide(element){
      element.attr("id") == "prev" ?  indexSlide-- :  indexSlide++  ;

      if( indexSlide < 0)  indexSlide=locations.length-1;
      if( indexSlide >=locations.length)  indexSlide=0;      
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
 * Avancement du slide
*/
function runSlide(){
     
      showDistance();
      showDate();
      showImage();
     
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
 * Affiche l'image du trail
*/
function showImage(){
      let img = clonePicture(locations[indexSlide].picture);
      img.attr("id",locations[indexSlide].id);
      let h2 = $("<h2>").text(locations[indexSlide].name);

      $(".infoSlide").empty();
      $(".infoSlide").append(img).append(h2);
      if(locationBuffer!=null) $(locationBuffer).css("opacity","0.5");

      let li = $(".listTrailPicture").find("li")[indexSlide];
      let img_picture =  $(li).find("img");
      locationBuffer = img_picture;
      $(img_picture).css("opacity","1");
}


/**
 * Affiche les miniatures
*/
function showPicture(){
      $(".listTrailPicture").empty();
    
      for(let key in locations){
            let img = clonePicture(locations[key].picture);
            let li =  $("<li data-id='"+key+"'>");
            $(".listTrailPicture").append(li)
            li.append(img);
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