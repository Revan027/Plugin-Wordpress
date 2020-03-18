<?php

function callback_upload($dirs) {
      
      $dirs['baseurl'] = network_site_url( '/wp-content/uploads' );
      $dirs['basedir'] = ABSPATH . 'wp-content/uploads'; 
      $dirs['subdir']  = "/Revan27";
      $dirs['path'] = $dirs['basedir'] . $dirs['subdir'];
      $dirs['url'] = $dirs['baseurl'] . $dirs['subdir'];
 
      return $dirs;
}

class File{
      private $data;

      function  __construct($data){
            $this->data = $data;
            $this->create_dir();
            $this->upload_file();
      
      }

      private function create_dir() {
            
            global $current_user;
            get_currentuserinfo();
            $upload_dir = wp_upload_dir(); 
            $user_dirname = $upload_dir['basedir'] . '/' . $current_user->user_login;
            if(!file_exists($user_dirname)) wp_mkdir_p($user_dirname);
      }
      
      private  function upload_file() {
            add_filter( 'upload_dir',  'callback_upload',10,1);
            $upload_overrides = array( 'test_form' => false );
            $movefile = wp_handle_upload( $this->data , $upload_overrides );
      }    
}

?>