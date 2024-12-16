<?php
include "../../Application/Services/maps.php";

class mapsControllers {
	
   private $obj;

    function __construct(){
        $this->obj = new maps();
    }

    function changeMaps($input){ 
	 try{
        $this->obj = $this->obj->updateMaps($input);
        return json_encode(array(
            "info" => "inserted",
            "status" => "inserted achieved"
        ));
    }catch(Exception $e){
        return json_encode(array(
            "info" => "fail",
            "status" => "inserted not successful"
        ));
    	}
    }

    function createDetailContact($input){ 
        try{
           $this->obj = $this->obj->insertDetailContact($input);
           return json_encode(array(
               "info" => "inserted",
               "status" => "inserted achieved"
           ));
       }catch(Exception $e){
           return json_encode(array(
               "info" => "fail",
               "status" => "inserted not successful"
           ));
           }
       }

       function showMaps(){
        $this->obj = $this->obj->selectMaps();
        if(count($this->obj) == 0){
            return json_encode(array("status"=> "not found",
           "info"=> "not there Services",
           "container"=> []));
        }else{
            return json_encode(array("status"=> "found",
           "info"=> "yes there Services",
           "container"=> $this->obj));
        }
             
    }

    
}
    
