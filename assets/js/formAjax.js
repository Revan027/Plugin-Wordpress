var locations;

$(document).ready(function(){

      /*
      * get all location when the page is loaded
      */
      get_trail_region();


/**************************************************target**********************************************************************/

      var content =  $("#wpbody-content");
      var formAdd =  $(".testForm");
      let eleArea =  $('.map').children(".areaMap");
      let eleClose =  $( ".modalplugin" ).find('.close');
    
      var location = {target:null,region:null};
    



      
/**************************************************EVENTS**********************************************************************/

      /**************************submit form add*************************************/
     formAdd.submit( function(ev){
            formAdd.find("button").prop("disabled","disabled");
            ev.preventDefault();    

            let form = {
                  name : $("#nameTrail").val(),
                  date : $("#dateTrail").val(),
                  distance : $("#distanceTrail").val(),
                  scrImg : $("#scrImg").prop('files')[0]//accèss aux propriété de l'objet file
            }

            let erreur = controlFormAddTrail(form);

            if(erreur === "" ){
                  setTrail();
            }
            else{
                  animateAlert("warning",erreur);               
            }        
      });  


      /**************************click in a area*************************************/
      eleArea.click(function(ev){  
            ns.showModal();
            location.region = $(this)[0].id;
            location.target = $(this);
       
           $( "#country" ).find("span").text( location.region); //injection des informations régionnales
           let locations = get_trails_by_region( location.region);
      });


      /**************************click in a runner. use delegate because runner's image doesn't exist in loading page*************************************/
      $(".blockImage").delegate(".runner","click",function(ev) { 
            ns.showModal();
            //location.region = $(this)[0].attributes[3].value;
            location.region = $(this).attr("data-id");
            let locations =  get_trails_by_region( location.region);

           $( "#country" ).find("span").text( location.region); //injection des informations régionnales    
      });



      /**************************click in trail's trash*************************************/
      $(".trash_icon").click(function(ev){  
            let region = $(this).parent().parent().prev().text().trim();
            let id = $(this).parent().parent().next().find(".infoSlide").find("img").attr("id");
            delete_trail(id,region);
      });

      
      /**************************close modal*************************************/
      eleClose.click(function(ev){  
            ns.hideModal();
      });

   


/**************************************************AJAX**********************************************************************/

 
      /**************************get one location by region for showing runner's image*************************************/
      function get_trail_region(){
          
            if( $("body").find($(".mapFrance")).length != 0){    //si la map existe pas, évite le lancement de cette fonction               
                  $.ajax({
                        url:ajaxurl,
                        type: 'GET',
                        data:  {"action":'get_trail_region'},
  
                        success: function(data) {	
                              eachTrail(JSON.parse(data));
                        }
            }); 
            }
      }


      /**************************set a new location for a trail*************************************/
      function setTrail(form){
           

            var formData = new FormData();      //pour passer des fichiers
            formData.append('action','add_trail');     //nom de l'action pour wordpress
            formData.append('name', form.name);
            formData.append('country', 'France'); 
            formData.append('region',  location.region);
            formData.append('date',  form.date);
            formData.append('distance',  form.distance);
            formData.append('image', form.scrImg);    //passage de ses propritétées
            
            $.ajax({
                  url:ajaxurl,
                  type: 'POST',
                  data: formData,
                  processData: false, // Don't process the files
                  contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                  success: function(data) {	
                       
                        animateAlert("success","Ajout effectué"); 
                        get_trail_region();
                        get_trails_by_region(location.region);

                        formAdd.find("button").prop("disabled","");

                        if(!ifRunnerExist(location.region)){
                              setRunnerImg(location.target);
                        }
                       
                  }
            });
      }


      /**************************get all data for all trail in a region clicked*************************************/
      function get_trails_by_region(region){
            $.ajax({
                  url:ajaxurl,
                  type: 'GET',
                  data: {"action":'get_trails_by_region',"region":region},
            
                  success: function(data) {
                        locations = JSON.parse(data);

                        toggleModalMenu("liste");                    
                  }
            });
      }


      /**************************delete trail*************************************/
      function delete_trail(id,region){
            var formData = new FormData();      //pour passer des fichiers
            formData.append('action','delete_trail');     //nom de l'action pour wordpress
            formData.append('id', id);

            $.ajax({
                  url:ajaxurl,
                  type: 'POST',
                  data: formData,
                  processData: false, 
                  contentType: false,
                  success: function(data) {
                        get_trail_region();
                        get_trails_by_region(region);
                        animateAlert("success","Suppression effectué");                   
                  }
            });    
      }



/**************************************************FUNCTIONS**********************************************************************/
      /*
      *control data's form
      */
      function controlFormAddTrail(form){
      
            let erreur ="";

            if(form.name == "" || form.name.search( /^[0-9]*$/g) == 0) {
                 
                  $("#nameTrail").attr("placeholder","Entrez un nom, le nom ne doit pas être composé uniquement de chiffre");
                  erreur += "- Entrez un nom, il ne doit pas être composé uniquement de chiffre <br/>" ;
            }
      
            if(form.date == "" || form.date.search( /^([0-9]{4})\-([0]{1}[0-9]{1}|[1]{1}[0-2]{1})\-([0-2]{1}[0-9]{1}|[3]{1}[0-1]{1})$/g) != 0) {
                  erreur += "- Entrez une date valide <br/>" ;
                  console.log(form.date.search( /^([0-9]{4})\-([0]{1}[0-9]{1}|[1]{1}[0-2]{1})\-([0-2]{1}[0-9]{1}|[3]{1}[0-1]{1})$/g));
            }

            if(form.distance == "" || form.distance.search( /^[A-Z]*$/g) == 0){
                  erreur += "- Entrez une distance valide <br/>";
            }

            if(form.scrImg === undefined) {
                  erreur+="- Pas d'image sélectionnée <br/>";

            }else if((form.scrImg.type).search(/png|jpg|jpeg/) == -1){
                  erreur+="- Mauvais format d'image (jpg, png ou jpeg valide) <br/>";
            }

            return erreur;
      }



      /*
      *animate alert
      */
      function animateAlert(type,message){
      
            content.append('<div class="alert alert-'+type+'" role="alert">'+message+'</div>');

            $( ".alert" ).animate({
                  opacity:1,
                  bottom: "+=50%"

            }, 3500, () =>{

                  setTimeout(function(){

                        $( ".alert" ).animate({
                              opacity: 0.5,
                              bottom: "-=50%"
                        }, 3000,function(){
                              formAdd.find("button").prop("disabled","");
                              content.find(".alert").remove();
                        });  
                  },1500);
            });
      } 
});
