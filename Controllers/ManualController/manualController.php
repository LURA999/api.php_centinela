<?php
include "../../Application/Manual/manual.php";

class manualController {
	private $obj;

	function __construct(){
	   $this->obj = new manual();    
	}

	function createManual($input){
	   try{
	   $this->obj = $this->obj->insertManual($input);
	   return  json_encode(
		array("status"=> "acepted",
	   	"info"=> "Manual add"));

	   }catch(Exception $e){
	   return json_encode(array("status"=> "error",
	   	"info"=> "error"));
	   }
	}

	function showManual(){
	$this->obj = $this->obj->selectManual();
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

	  function showManualby(){
		$this->obj = $this->obj->selectManualbyuser();
		if(count($this->obj) == 0){
			return json_encode(array("status"=> "not found",
		   "info"=> "not there Empresa",
		   "container"=> []));
		}else{
			return json_encode(array("status"=> "found",
		   "info"=> "yes there Empresa",
		   "container"=> $this->obj));
		}
			 
		  }
		  function showManualbycount(){
			$this->obj = $this->obj->selectManualcount();
			if(count($this->obj) == 0){
				return json_encode(array("status"=> "not found",
			   "info"=> "not there Manual",
			   "container"=> []));
			}else{
				return json_encode(array("status"=> "found",
			   "info"=> "yes there Manual",
			   "container"=> $this->obj));
			}
				 
			  }

 	
	function changeManual($input){
	try{
	   $this->obj = $this->obj->updateManual($input);
	   return  json_encode(
		array("status"=> "update",
	   	"info"=> "Notify update"));
	   }catch(Exception $e){
	   return json_encode(array("status"=> "error",
	   	"info"=> "error"));
	   }
	}

	function removeManual($id){
		try{
			$this->obj = $this->obj->deleteManual($id);
			return  json_encode(
			 array("status"=> "remove",
				"info"=> "notfiy remove"));
			}catch(Exception $e){
			return json_encode(array("status"=> "error",
				"info"=> "error"));
			}
		}


}
