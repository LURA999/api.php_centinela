<?php
include "../../Application/Devices/radio.php";

class radioController {
	private $obj;

	function __construct(){
	   $this->obj = new radio();    
	}

	function createRadio($input){
	   try{
	   $this->obj = $this->obj->insertRadio($input);
	   return  json_encode(
		array("status"=> "acepted",
	   	"info"=> "radio add"));

	   }catch(Exception $e){
	   return json_encode(array("status"=> "error",
	   	"info"=> "error"));
	   }
	}

	function showRadio($identificador, $contador){
	$this->obj = $this->obj->selectRadio($identificador, $contador);
	if(count($this->obj) == 0){
	    return json_encode(array("status"=> "not found",
	   "info"=> "not there radio",
	   "container"=> []));
	}else{
	    return json_encode(array("status"=> "found",
	   "info"=> "yes there radio",
	   "container"=> $this->obj));
	}
 		
      }

	  function showRadioOnly($cve){
		$this->obj = $this->obj->selectRadioOnly($cve);
		if(count($this->obj) == 0){
			return json_encode(array("status"=> "not found",
		   "info"=> "not there radio",
		   "container"=> []));
		}else{
			return json_encode(array("status"=> "found",
		   "info"=> "yes there radio",
		   "container"=> $this->obj));
		}
			 
		  }

 	
	function changeRadio($input){
	try{
	   $this->obj = $this->obj->updateRadio($input);
	   return  json_encode(
		array("status"=> "update",
	   	"info"=> "radio update"));
	   }catch(Exception $e){
	   return json_encode(array("status"=> "error",
	   	"info"=> "error"));
	   }
	}

	function removeRadio($cve){
		try{
			$this->obj = $this->obj->deleteRadio($cve);
			return  json_encode(
			 array("status"=> "remove",
				"info"=> "radio remove"));
			}catch(Exception $e){
			return json_encode(array("status"=> "error",
				"info"=> "error"));
			}
		}

		function showAutoIncrement(){
			$this->obj = $this->obj->selectAutoIncrement();
			if(count($this->obj) == 0){
				return json_encode(array("status"=> "not found",
			   "info"=> "not there radio",
			   "container"=> []));
			}else{
				return json_encode(array("status"=> "found",
			   "info"=> "yes there radio",
			   "container"=> $this->obj));
			}	 
		}
}
