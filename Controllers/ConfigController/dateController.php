<?php
include "../../Application/Config/date.php";

class dateController {
	private $obj;

	function __construct(){
	   $this->obj = new date();    
	}

	function createDate($input){
	   try{
	   $this->obj = $this->obj->insertDate($input);
	   return  json_encode(
		array("status"=> "acepted",
	   	"info"=> "notify add"));

	   }catch(Exception $e){
	   return json_encode(array("status"=> "error",
	   	"info"=> "error"));
	   }
	}

	function showDate(){
	$this->obj = $this->obj->selectDate();
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

 	
	function changeDate($input){
	try{
	   $this->obj = $this->obj->updateDate($input);
	   return  json_encode(
		array("status"=> "update",
	   	"info"=> "date update"));
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
