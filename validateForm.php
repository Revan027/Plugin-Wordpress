<?php 

class ValidateForm
{
      private $error =  [];
      private $code =  0;

      public function getError(){
           return $this->error;
      }

      
      public function getCode(){
            return $this->code;
      }


      private function setError($error,$name){
           array_push( $this->error,["erreur"=>$error,"name"=>$name]);
      }


      private function setCode($code){
            $this->code = $code;
      }

      
      function checkForm($tabData){
            foreach ($tabData as $key => $value) {

                 if( $value["type"] == "string"){ 
                        if (preg_match('/^[0-9]*$/',$value["value"]) == 1){
                              $this->setError(" doit être composé de lettre uniquement",$value["name"]);                       
                        }
      
                  }else if($value["type"]  == "number"){
                        if (preg_match('/^[A-Z]*$/',$value["value"]) == 1){       
                             $this->setError("- doit être composé de valeurs numériques uniquement",$value["name"]);
                        }
   
                  }else if($value["type"]  == "date"){
                        if (!preg_match('/^([0-9]{4})\-([0]{1}[0-9]{1}|[1]{1}[0-2]{1})\-([0-2]{1}[0-9]{1}|[3]{1}[0-1]{1})$/',$value["value"]) == 1){
                              $this->setError(" doit avoir une date valide",$value["name"]);
                        }                       
                  }                  
            }
        
            if(empty($this->getError())){
                  $this->setCode(1);
            }

            $resultat = ["ListeErreur"=>$this->getError(),"Code"=>$this->getCode()];
            return  $resultat;       
      }
}