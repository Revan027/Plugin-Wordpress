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
                              <?PHP   
                                    if($user->roles[0] =="administrator" && is_admin()){ 
                              ?> 

                              <li class="nav-item">
                                    <a class="nav-link" id="liste"><button type="button" class="btn btn-info">Consulter les courses</button></a>
                              </li>
                      
                              <li class="nav-item">
                                    <a class="nav-link active" id="formulaire"><button type="button" class="btn btn-info">Ajouter une course</button></a>
                              </li> 

                              <?PHP    
                              }                       
                              ?>                           
                        </ul>
                             
                        <?PHP   
                              ListTrail::createView();
                              Form::createForm();                         
                        ?>
                  </div>
            <?PHP
            }
      } 
?>