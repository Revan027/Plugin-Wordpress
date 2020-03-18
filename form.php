<?php 
     abstract class Form
      {
            static public function createForm(){
                  $user = get_currentuserinfo();
                  ?>
                  <form class="testForm" enctype='multipart/form-data'>
                        <?PHP  

                        if($user->roles[0] =="administrator" && is_admin()){
                        ?>   
                        <h2>Informations du Trail</h2>
                        <div class="form-group">
                              <label for="nameTrail">Nom de la course</label>
                              <input type="text" class="form-control"  name="nameTrail" id="nameTrail" placeholder="Entrer un nom">
                        </div>   
                        <div class="form-group">
                              <label for="distanceTrail">Distance</label>
                              <input type="number" class="form-control"  name="distanceTrail" id="distanceTrail" placeholder="Entrer une distance(km)">
                        </div> 
                        <div class="form-group">
                              <label for="dateTrail">Date</label>
                              <input type="date" class="form-control"  name="dateTrail" id="dateTrail" placeholder="Choisir une date">
                        </div> 
                        <div class="form-group">
                              <label for="scrImg">Illustration</label>
                              <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="scrImg" id="scrImg">
                                    <label class="custom-file-label" for="scrImg">Choisissez une illustration</label>
                              </div>
                        </div>
                        <div class="testFom-submit">
                              <button type="submit" class="btn btn-info">Ajouter</button>
                        </div> 
                        <?PHP  
                        }
                        ?>   
                  </form>                                        
                  <?php
            }
      } 
?>