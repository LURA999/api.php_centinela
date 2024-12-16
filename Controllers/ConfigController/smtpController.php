<?php
include "../../Application/Config/smtp.php";

class smtpController {
	private $obj;

	function __construct(){
	   $this->obj = new smtp();    
	}

	function createSmtp($input){
	   try{
	   $this->obj = $this->obj->insertSmtp($input);
	   return  json_encode(
		array("status"=> "acepted",
	   	"info"=> "notify add"));

	   }catch(Exception $e){
	   return json_encode(array("status"=> "error",
	   	"info"=> "error"));
	   }
	}

	function showSmtp(){
	$this->obj = $this->obj->selectSmtp();
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

	  function showSmtpOnly($cve){
		$this->obj = $this->obj->selectSmtpOnly($cve);
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

 	
	function changeSmtp($input){
	try{
	   $this->obj = $this->obj->updateSmtp($input);
	   return  json_encode(
		array("status"=> "update",
	   	"info"=> "Notify update"));
	   }catch(Exception $e){
	   return json_encode(array("status"=> "error",
	   	"info"=> "error"));
	   }
	}

	function removeSmtp($cve){
		try{
			$this->obj = $this->obj->updateSmtp($cve);
			return  json_encode(
			 array("status"=> "remove",
				"info"=> "notfiy remove"));
			}catch(Exception $e){
			return json_encode(array("status"=> "error",
				"info"=> "error"));
			}
		}


}
