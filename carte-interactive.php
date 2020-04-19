<?php 
/*
Plugin Name: Carte interactive
Plugin URI: 
Description: Une carte de France intéractive, servant à insérer et visualiser des informations sur des activitées réalisées dans les départements de France.
Version: 1.0
Author: Freyss Morgan
Author URI:
License: GPL2
*/

/******************************inclusion des fichiers php deu plugin, partageable et référencé sur wordpress(fonction wordpress utilisable) *************************************/
include_once plugin_dir_path( __FILE__ ).'/entityPlugin.php';
include_once plugin_dir_path( __FILE__ ).'/controllerPlugin.php';
include_once plugin_dir_path( __FILE__ ).'/map.php';
include_once plugin_dir_path( __FILE__ ).'/modal.php';
include_once plugin_dir_path( __FILE__ ).'/listTrail.php';
include_once plugin_dir_path( __FILE__ ).'/form.php';
include_once plugin_dir_path( __FILE__ ).'/file.php';
include_once plugin_dir_path( __FILE__ ).'/validateForm.php';

 

class Carte_interactive
{
      public function __construct()
      {     
            /******************************active la creation de la table à l'installation du plugin *************************************/
            register_activation_hook(__FILE__, array('Carte_interactive', 'install'));


            /******************************active la suppression de la table à la désisntallation du plugin*************************************/
            register_uninstall_hook(__FILE__, array('Carte_interactive', 'uninstall'));

            if($this->IsInPost()){


                  /******************************intégration à l'admin barre*************************************/
                  add_action('admin_menu', array($this, 'add_admin_menu'),20); 
            
      
                  /******************************add action pour l'enregistrement des fichiers css et js du plugin et les ajoutes dans le header admin et du site*************************************/
	              
                  add_action('wp_enqueue_scripts', 'admin_enqueue_scripts',1);    
                  add_action('admin_enqueue_scripts', 'admin_enqueue_scripts',1);
                  
                  
                  /******************************pour que wordpress reconnaisse le shortcode*************************************/
                  add_shortcode('liste_trail', array($this, 'pageAccueil'));

		
                  /******************************enregistrement des fichiers css et js du plugin*************************************/
                  function admin_enqueue_scripts($hook) {
			             
                        wp_register_script( 'lib2', plugins_url('carte-interactive/assets/js/node_modules/jquery/dist/jquery.min.js'),array(), false,false);
                        wp_enqueue_script('lib2');

				if(strpos($hook,'carte-interactive') || strpos(get_the_permalink(),'carte-des-trails')){  //si l'url contient carte-des-trails ou que nous sommes dans le plugin
                              wp_register_style( 'carte-interactive-css', plugins_url('carte-interactive/assets/css/map.css'));
                              wp_enqueue_style('carte-interactive-css');

                              wp_register_style( 'fontawesome', plugins_url('carte-interactive/assets/css/fontAwesome/css/font-awesome.css'));
                              wp_enqueue_style('fontawesome');

                              wp_register_script( 'bootstrap-lib-js', plugins_url('carte-interactive/assets/js/node_modules/bootstrap/dist/js/bootstrap.min.js'));
                              wp_enqueue_script('bootstrap-lib-js'); 

                              wp_register_style( 'bootstrap-lib', plugins_url('carte-interactive/assets/js/node_modules/bootstrap/dist/css/bootstrap.min.css'));
                              wp_enqueue_style('bootstrap-lib'); 

                              wp_register_script( 'bootstrap-bundle', plugins_url('carte-interactive/assets/js/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js'));
                              wp_enqueue_script('bootstrap-bundle'); 

                              wp_register_script( 'resize-map', plugins_url('carte-interactive/assets/js/image-map-resizer-master/js/imageMapResizer.js'));
                              wp_enqueue_script('resize-map'); 


                              wp_register_script( 'coordonnee-js', plugins_url('carte-interactive/assets/js/coordonnee.js'));
                              wp_enqueue_script('coordonnee-js');  
                              
                              wp_register_script( 'modalPlugin-js', plugins_url('carte-interactive/assets/js/modalPlugin.js'));
                              wp_enqueue_script('modalPlugin-js'); 

                              /* Ajax sur wordpress*/
                              wp_register_script( 'formAjax-js', plugins_url('carte-interactive/assets/js/formAjax.js'));
                              wp_enqueue_script('formAjax-js', array('jquery'), '1.0', true );  

                              wp_localize_script('formAjax-js', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
                        }
                  }
            }
      }
     

      /**
      * Integration du menu dans la barre d'administration de wordpress
      */
      public function add_admin_menu()
      {    
            add_menu_page('Carte interactive', 'Carte interactive', 'manage_options', 'carte-interactive', array($this, 'pageAccueil'));  
            add_submenu_page('carte-interactive', 'Apercus', 'Apercus', 'manage_options', 'carte-interactive', array($this, 'pageAccueil'));
            add_submenu_page('carte-interactive', 'Options', 'Options', 'manage_options', 'options', array($this, 'pageOption'));
            add_submenu_page('carte-interactive', 'Test', 'Test', 'manage_options', 'test', array($this, 'pageTest'));
          
      }

 
      /**
      *creation page accueil
      */
      public function pageAccueil()
      {
            $map = new Map();
            echo $map->createImage();
      }     


      
      /**
      *creation page option
      */
      public function pageOption()
      {
            echo"Coming soon";
      }    
      
      
      /**
      *creation page option
      */
      public function pageTest()
      {
            echo"Coming soon";
         
      }   

      /**
      *check si l'url n'est pas celle d'une modification pour éviter un bug lors de l'insertion de la map
      */
      public function IsInPost()
      {
           return !stristr($_SERVER['REQUEST_URI'],"post.php?") ? true :false;
      }   


      /**
      *installation du plugin
      */
      public function install(){
            EntityPlugin::install();
      }


      /**
      *désinstallation du plugin
      */
      public function uninstall(){
            EntityPlugin::uninstall();
      }

      
}
new Carte_interactive();      //instanciation la classe d'initialisation du plugin
?>