<?php
include "../../Application/Repeater/contact.php";

class contactController {
	private $obj;

	function __construct(){
	   $this->obj = new contact();    
	}

	function createContact($input){
	   try{
	   $this->obj = $this->obj->insertContact($input);
	   return  json_encode(
		array("status"=> "acepted",
	   	"info"=> "contact add"));

	   }catch(Exception $e){
	   return json_encode(array("status"=> "error",
	   	"info"=> "error"));
	   }
	}

	function showContact($cve){
		$this->obj = $this->obj->selectContact($cve);
		if(count($this->obj) == 0){
			return json_encode(array("status"=> "not found",
			"info"=> "not there contacts",
			"container"=> []));
		}else{
			return json_encode(array("status"=> "found",
			"info"=> "yes there contacts",
			"container"=> $this->obj));
		}	
	}

 	
	function changeContact($input){
	try{
	   $this->obj = $this->obj->updateContact($input);
	   return  json_encode(
		array("status"=> "update",
	   	"info"=> "contact update"));
	   }catch(Exception $e){
	   return json_encode(array("status"=> "error",
	   	"info"=> "error"));
	   }
	}

	function removeContact($cve){
		try{
		$this->obj = $this->obj->deleteContact($cve);
		return  json_encode(
			array("status"=> "update",
			"info"=> "contact update"));
		}catch(Exception $e){
		return json_encode(array("status"=> "error",
			"info"=> "error"));
		}
	}

}
