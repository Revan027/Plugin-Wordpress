<?php 
      abstract class ListTrail
      {      

            static public function createView(){ 
                  //add_filter('the_content',"test", 20) ;
                  
?>                <div class="mainSlideTrail">
                        <div class="slideTrail">
                              <div class="navSlide" id="prev">Prev</div> 
                              <div class="infoSlide"></div> 
                              <div class="navSlide" id="next">Next</div>
                        </div>

                        <ul class="listTrailPicture">
                  
                        </ul>
                        <img  id="modelImg"  style="display:none" src="<?php echo '/trail_eure_27/wp-content/uploads/Revan27/' ?>" class="card-img-top" alt="...">
                  </div>  
<?PHP
            }
            static public function test(){
                 
            }

      } 

      
?>