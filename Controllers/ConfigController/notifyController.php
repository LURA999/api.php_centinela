<?php
include "../../Application/Config/notify.php";

class notifyController {
	private $obj;

	function __construct(){
	   $this->obj = new notify();    
	}

	function createNotify($input){
	   try{
	   $this->obj = $this->obj->insertNotify($input);
	   return  json_encode(
		array("status"=> "acepted",
	   	"info"=> "notify add"));

	   }catch(Exception $e){
	   return json_encode(array("status"=> "error",
	   	"info"=> "error"));
	   }
	}

	function showNotify(){
	$this->obj = $this->obj->selectNotification();
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

	  function showEmpresaOnly($cve){
		$this->obj = $this->obj->selectEmpresaOnly($cve);
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

 	
	function changeNotify($input){
	try{
	   $this->obj = $this->obj->updateNotify($input);
	   return  json_encode(
		array("status"=> "update",
	   	"info"=> "Notify update"));
	   }catch(Exception $e){
	   return json_encode(array("status"=> "error",
	   	"info"=> "error"));
	   }
	}

	function changeNotification($input){
		try{
		   $this->obj = $this->obj->updateNotification($input);
		   return  json_encode(
			array("status"=> "update",
			   "info"=> "Notify update"));
		   }catch(Exception $e){
		   return json_encode(array("status"=> "error",
			   "info"=> "error"));
		   }
		}

	function removeNotify($cve){
		try{
			$this->obj = $this->obj->updateNotify($cve);
			return  json_encode(
			 array("status"=> "remove",
				"info"=> "notfiy remove"));
			}catch(Exception $e){
			return json_encode(array("status"=> "error",
				"info"=> "error"));
			}
		}


}
