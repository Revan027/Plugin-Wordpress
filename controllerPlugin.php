<?php

/******************************droit des utilisateurs et ajout*************************************/
add_action( 'wp_ajax_add_trail', 'add_trail' );//pour admin

add_action( 'wp_ajax_delete_trail', 'delete_trail' );//pour admin

add_action( 'wp_ajax_get_trails_by_region', 'get_trails_by_region' );//pour admin
add_action( 'wp_ajax_nopriv_get_trails_by_region', 'get_trails_by_region' );//pour visiteur

add_action( 'wp_ajax_get_trail_region', 'get_trail_region' );
add_action( 'wp_ajax_nopriv_get_trail_region', 'get_trail_region' );//pour visiteur


function add_trail() {   
      $valName = $_POST['name'];
      $country = $_POST['country'];
      $region = $_POST['region'];
      $date = $_POST['date'];
      $distance = $_POST['distance'];
      $src = $_FILES['image']['name'];
      $temp_name = $_FILES['image']['tmp_name'];

      $validateForm = new ValidateForm();
      $response = null;
      $tabData = [
            ["type"=>"string","value"=>"dfsfd","name"=>"Nom"],
            ["type"=>"string","value"=>42,"name"=>"Pays"],
            ["type"=>"string","value"=>"wdsd","name"=>"Région"],
            ["type"=>"date","value"=>"er","name"=>"Date"],
            ["type"=>"number","value"=>42,"name"=>"Distance"]
      ];  
      $error =  $validateForm->checkForm( $tabData);

      new File( $_FILES['image']);

      $error == null ? $response = EntityPlugin::addTrail( $valName,$country,$region ,$distance,$date,$src) : $response =  $error;

      echo json_encode($response); 
      die();    
}


function get_trail_region() {
      $location = EntityPlugin::get_trail_region();

      echo json_encode($location);  //encodage en JSON du tableau de résultat
	die();
}


function get_trails_by_region() {   
      $region = $_GET['region'];

      $validateForm = new ValidateForm();
      $response = null;
      $tabData = [
            ["type"=>"string","value"=> $region,"name"=>"Region"],
      ];  
      $error =  $validateForm->checkForm( $tabData);

      $error["Code"] == 1 ? $response = EntityPlugin::get_trails_by_region($region) : $response =  $error;
    
      echo json_encode($response);  
      die();
}


function delete_trail() {
      $id = $_POST['id'];
      EntityPlugin::delete_trail($id);
	die();
}
?>