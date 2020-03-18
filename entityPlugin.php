<?php


abstract class EntityPlugin{
      CONST TABLE = "trail";

      /**
       *  create table location
      */
      public static function install()
      {         
            global $wpdb;
             $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}". self::TABLE."(
                  id INT AUTO_INCREMENT PRIMARY KEY, 
                  name VARCHAR(255) NOT NULL,
                  country VARCHAR(255) NOT NULL,
                  region VARCHAR(255) NOT NULL,
                  distance TINYINT NOT NULL,
                  date DATE NOT NULL,
                  picture VARCHAR(255) NOT NULL);");
      }



      /**
       *  delete table location
      */
      public static function uninstall()
      {
            global $wpdb;
            $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}".self::TABLE.";");
      }



      /**
       *  add a location
      */
      public static function addTrail($valName,$country,$region ,$distance,$date,$src)
      {      
            global $wpdb;
            $response = self::getTrail($name);

            if( $response == null){
                  $requete = "INSERT INTO {$wpdb->prefix}".self::TABLE."(name,country,region,distance,date,picture) VALUES(%s,%s,%s,%d,%s,%s)";
                  $sql = $wpdb->prepare( $requete ,$valName,$country,$region ,$distance,$date,$src); 
                  $wpdb->query($sql);
            }
      }



      /**
       * delete a location
      */
      public static function delete_trail($id)
      {
            global $wpdb;      
            $requete = "DELETE FROM {$wpdb->prefix}".self::TABLE." WHERE id = %d";
            $sql = $wpdb->prepare( $requete , $id); 
            $wpdb->query($sql);

      }


      /**
       * get all location
      */
      public static function get_trail_region()
      {
            global $wpdb;   
            $location = $wpdb->get_results("SELECT *, COUNT(region) AS nombreTrail FROM {$wpdb->prefix}".self::TABLE." GROUP BY region");

            return $location;
      }


      /**
       * get data for a location
      */
      public static function get_trails_by_region($region)
      {    
            global $wpdb;   
            $sql = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}".self::TABLE." WHERE region LIKE %s ORDER BY date",$region); 
            $location = $wpdb->get_results($sql);
            return $location;
      }


      /**
       * search if name already exist 
      */
      public static function getTrail($name)
      {
            global $wpdb;   
            $sql = $wpdb->prepare( "SELECT name FROM {$wpdb->prefix}".self::TABLE." WHERE name LIKE %s",$name); 
            $location= $wpdb->get_row($sql);
            return $location;
      }

}
?>