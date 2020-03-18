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

      new File( $_FILES['image']);

      $location = EntityPlugin::addTrail( $valName,$country,$region ,$distance,$date,$src); 
      echo json_encode($location); 
	die();
}


function get_trail_region() {

      $location = EntityPlugin::get_trail_region();
    
      echo json_encode($location);  //encodage en JSON du tableau de résultat
	die();
}


function get_trails_by_region() {

      $region = $_POST['region'];
 
      $location = EntityPlugin::get_trails_by_region($region);
      echo json_encode($location);  
	die();
}


function delete_trail() {
      $id = $_POST['id'];
      EntityPlugin::delete_trail($id);
	die();
}
?>