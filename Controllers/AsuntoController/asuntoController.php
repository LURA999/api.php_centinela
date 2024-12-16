<?php
include "../../Application/Asunto/asunto.php";

class asuntoController {
	private $obj;

	function __construct(){
	   $this->obj = new asunto();    
	}

	function createAsunto($input){
	   try{
	   $this->obj = $this->obj->insertAsunto($input);
	   return  json_encode(
		array("status"=> "acepted",
	   	"info"=> "Asuto add"));

	   }catch(Exception $e){
	   return json_encode(array("status"=> "error",
	   	"info"=> "error"));
	   }
	}

	function showAsunto(){
	$this->obj = $this->obj->selectAsunto();
	if(count($this->obj) == 0){
	    return json_encode(array("status"=> "not found",
	   "info"=> "not there repeaters",
	   "container"=> []));
	}else{
	    return json_encode(array("status"=> "found",
	   "info"=> "yes there repeaters",
	   "container"=> $this->obj));
	}
 		
      }

	
	function changeAsunto($input){
	try{
	   $this->obj = $this->obj->updateAsunto($input);
	   return  json_encode(
		array("status"=> "update",
	   	"info"=> "Notify update"));
	   }catch(Exception $e){
	   return json_encode(array("status"=> "error",
	   	"info"=> "error"));
	   }
	}

	function removeAsunto($id){
		try{
			$this->obj = $this->obj->deleteAsunto($id);
			return  json_encode(
			 array("status"=> "remove",
				"info"=> "notfiy remove"));
			}catch(Exception $e){
			return json_encode(array("status"=> "error",
				"info"=> "error"));
			}
		}


}
