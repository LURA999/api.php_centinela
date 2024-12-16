<?php
include "../../Application/Devices/others.php";

class othersController {
	private $obj;

	function __construct(){
	   $this->obj = new others();    
	}
	function createOthers2($input){
		try{
			$this->obj = $this->obj->insertOthers2($input);
			return  json_encode(
			 array("status"=> "acepted",
				"info"=> "device add",
			 "container" => $this->obj));
	 
			}catch(Exception $e){
			return json_encode(array("status"=> "error",
				"info"=> "error"));
			}
	}

	function updateOthers2($input){
		try{
			$this->obj = $this->obj->updateOthers2($input);
			return  json_encode(
			 array("status"=> "acepted",
				"info"=> "device delete"));
	 
			}catch(Exception $e){
			return json_encode(array("status"=> "error",
				"info"=> "error"));
			}
	}
	function createOthers($input){
	   try{
	   $this->obj = $this->obj->insertOthers($input);
	   return  json_encode(
		array("status"=> "acepted",
	   	"info"=> "device add",
		"container" => $this->obj));

	   }catch(Exception $e){
	   return json_encode(array("status"=> "error",
	   	"info"=> "error"));
	   }
	}

	function showAutoIncrement(){
		$this->obj = $this->obj->selectAutoIncrement();
		if(count($this->obj) == 0){
			return json_encode(array("status"=> "not found",
		   "info"=> "not there others",
		   "container"=> []));
		}else{
			return json_encode(array("status"=> "found",
		   "info"=> "yes there others",
		   "container"=> $this->obj));
		}	 
	}

	function showOthers($identificador, $contador,$condicion,$iddevice){
	$this->obj = $this->obj->selectOthers($identificador, $contador,$condicion,$iddevice);
	if(count($this->obj) == 0){
	    return json_encode(array("status"=> "not found",
	   "info"=> "not there device",
	   "container"=> []));
	}else{
	    return json_encode(array("status"=> "found",
	   "info"=> "yes there device",
	   "container"=> $this->obj));
	}
 		
      }

	  function showOthersOnly($cve){
		$this->obj = $this->obj->selectOthersOnly($cve);
		if(count($this->obj) == 0){
			return json_encode(array("status"=> "not found",
		   "info"=> "not there device",
		   "container"=> []));
		}else{
			return json_encode(array("status"=> "found",
		   "info"=> "yes there device",
		   "container"=> $this->obj));
		}
			 
		  }

 	
	function changeOthers($input){
	try{
	   $this->obj = $this->obj->updateOthers($input);
	   return  json_encode(
		array("status"=> "update",
	   	"info"=> "device update"));
	   }catch(Exception $e){
	   return json_encode(array("status"=> "error",
	   	"info"=> "error"));
	   }
	}

	function removeOthers($cve){
		try{
			$this->obj = $this->obj->deleteOthers($cve);
			return  json_encode(
			 array("status"=> "remove",
				"info"=> "device remove"));
			}catch(Exception $e){
			return json_encode(array("status"=> "error",
				"info"=> "error"));
			}
		}


}
