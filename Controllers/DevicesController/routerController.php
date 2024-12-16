<?php
include "../../Application/Devices/router.php";

class routerController {
	private $obj;

	function __construct(){
	   $this->obj = new router();    
	}
	function createRouter2($input){
		try{
			$this->obj = $this->obj->insertRouter2($input);
			return  json_encode(
			 array("status"=> "acepted",
				"info"=> "router add"));
	 
			}catch(Exception $e){
			return json_encode(array("status"=> "error",
				"info"=> "error"));
		}
	}

	function updateRouter2($input){
		try{
			$this->obj = $this->obj->updateRouter2($input);
			return  json_encode(
			 array("status"=> "acepted",
				"info"=> "router delete"));
	 
			}catch(Exception $e){
			return json_encode(array("status"=> "error",
				"info"=> "error"));
		}
	}
	
	function createRouter($input){
	   try{
	   $this->obj = $this->obj->insertRouter($input);
	   return  json_encode(
		array("status"=> "acepted",
	   	"info"=> "router add",
		"container" => $this->obj));

	   }catch(Exception $e){
	   return json_encode(array("status"=> "error",
	   	"info"=> "error"));
	   }
	}

	function showRouter($identificador, $contador,$condicion,$iddevice){
	$this->obj = $this->obj->selectRouter($identificador, $contador,$condicion,$iddevice);
	if(count($this->obj) == 0){
	    return json_encode(array("status"=> "not found",
	   "info"=> "not there router",
	   "container"=> []));
	}else{
	    return json_encode(array("status"=> "found",
	   "info"=> "yes there router",
	   "container"=> $this->obj));
	}
 		
      }

	  function showRouterOnly($cve){
		$this->obj = $this->obj->selectRouterOnly($cve);
		if(count($this->obj) == 0){
			return json_encode(array("status"=> "not found",
		   "info"=> "not there router",
		   "container"=> []));
		}else{
			return json_encode(array("status"=> "found",
		   "info"=> "yes there router",
		   "container"=> $this->obj));
		}
			 
		  }

 	
	function changeRouter($input){
	try{
	   $this->obj = $this->obj->updateRouter($input);
	   return  json_encode(
		array("status"=> "update",
	   	"info"=> "router update"));
	   }catch(Exception $e){
	   return json_encode(array("status"=> "error",
	   	"info"=> "error"));
	   }
	}

	function removeRouter($cve){
		try{
			$this->obj = $this->obj->deleteRouter($cve);
			return  json_encode(
			 array("status"=> "remove",
				"info"=> "router remove"));
			}catch(Exception $e){
			return json_encode(array("status"=> "error",
				"info"=> "error"));
			}
		}


		function showAutoIncrement(){
			$this->obj = $this->obj->selectAutoIncrement();
			if(count($this->obj) == 0){
				return json_encode(array("status"=> "not found",
			   "info"=> "not there router",
			   "container"=> []));
			}else{
				return json_encode(array("status"=> "found",
			   "info"=> "yes there router",
			   "container"=> $this->obj));
			}
				 
			  }

}
