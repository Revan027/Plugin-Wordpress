<?php 
abstract class ListTrail
{      
      static public function createView(){        
            $user = get_currentuserinfo();    
?>         
            <span id="country">
                  <i class="fa fa-map-marker fa-2x" aria-hidden="true"></i>
                  <span></span>
            </span> 

            <div class="data-trail" style="display:none">
                  <div class="header-trail">
                        <div class="img-trail"></div>
                        <div class="name-trail"></div>
                   </div>

                   <hr/>

                  <div class="info_trail">               
                        <span class="date_trail">
                              <i class="fa fa-calendar fa-2x"></i>
                              <span></span>
                        </span> 

                        <span class="distance_trail">
                              <i class="fa fa-flag fa-2x"></i>
                              <span></span>
                        </span>  
                        
                        <?PHP 
                        if($user->roles[0] =="administrator" && is_admin()){ 
                        ?> 
                              <span class="trash_trail">
                                    <i class="fa fa-trash fa-2x trash_icon"></i>                
                              </span>
                        <?PHP   
                        }
                        ?>
                  </div>
   
            </div>
            <div id="list-trail">

            </div>
                  <img  id="modelImg"  style="display:none" src="<?php echo '/trail_eure_27/wp-content/uploads/Revan27/' ?>" class="card-img-top" alt="...">
      <?PHP
      }
} 
?>