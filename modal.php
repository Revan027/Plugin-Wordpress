<?php 
      abstract class Modal
      {
            static  public function createModal(){
                
                  $user = get_currentuserinfo();
                  if($user->user_login == "Revan27"){
                         echo "Salut Christophe !!";
                  }

                  ?> 
                  <div class="modalplugin">
                        <button type="button" class="close custom-close">
                              <span aria-hidden="true">&times;</span>
                        </button>

                        <ul class="nav custom-nav">
                              <li class="nav-item">
                                    <a class="nav-link" id="liste"><button type="button" class="btn btn-info">Consulter les courses</button></a>
                              </li>

                              <?PHP   
                                    if($user->roles[0] =="administrator" && is_admin()){ 
                                    ?>   
                                          <li class="nav-item">
                                                <a class="nav-link active" id="formulaire"><button type="button" class="btn btn-info">Ajouter une course</button></a>
                                          </li> 
                                    <?PHP    
                                    }                       
                              ?>

                             
                        </ul>

                        
                      

                        <span id="country">
                              <i class="fa fa-map-marker fa-3x" aria-hidden="true"></i>
                              <span></span>
                        </span> 
                         
                        <div class="info_trail">
                              <span class="date_trail">
                                    <i class="fa fa-calendar fa-2x"></i>
                                    <span></span>
                              </span> 
                              
                              <span class="distance_trail">
                                    <i class="fa fa-flag fa-2x"></i>
                                    <span></span>
                              </span>  
                              
                              <span class="trash_trail">
                                    <i class="fa fa-trash fa-2x trash_icon"></i>                
                              </span>
                        </div>
                       
                        <?PHP   
                              ListTrail::createView();
                              Form::createForm();                         
                        ?>
                  </div>
            <?PHP
            }
      } 
?>