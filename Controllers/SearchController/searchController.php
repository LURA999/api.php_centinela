<?php
include "../../Application/Search/search.php";

class searchController {
	private $obj;

	function __construct(){
	   $this->obj = new search();    
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

	function showService($var){
		$this->obj = $this->obj->selectServiceSearch($var);
		if(count($this->obj) == 0){
			return json_encode(array("status"=> "not found",
		"info"=> "not there results",
		"container"=> []));
		}else{
			return json_encode(array("status"=> "found",
		"info"=> "yes there results",
		"container"=> $this->obj));
		}	
	}

	function showServiceEstatus($cve){
		$this->obj = $this->obj->selectServiceEstatus($cve);
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

	function showTicket($var){
		$this->obj = $this->obj->selectTicketSearch($var);
		if(count($this->obj) == 0){
			return json_encode(array("status"=> "not found",
		"info"=> "not there results",
		"container"=> []));
		}else{
			return json_encode(array("status"=> "found",
		"info"=> "yes there results",
		"container"=> $this->obj));
		}	
	}

 	function showTicketEntryAll($var,$opc){
		$this->obj = $this->obj->selectTicketEntryAll($var,$opc);
		if(count($this->obj) == 0){
			return json_encode(array("status"=> "not found",
		"info"=> "not there results",
		"container"=> []));
		}else{
			return json_encode(array("status"=> "found",
		"info"=> "yes there results",
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

	function showIdentifier($var,$cond){
		$this->obj = $this->obj->selectIdentifier($var,$cond);
		if(count($this->obj) == 0){
			return json_encode(array("status"=> "not found",
		   "info"=> "not there identifier",
		   "container"=> []));
		}else{
			return json_encode(array("status"=> "found",
		   "info"=> "yes there identifier",
		   "container"=> $this->obj));
		}
	}

	function showNames($var,$cond){
		$this->obj = $this->obj->selectNames($var,$cond);
		if(count($this->obj) == 0){
			return json_encode(array("status"=> "not found",
		   "info"=> "not there names",
		   "container"=> []));
		}else{
			return json_encode(array("status"=> "found",
		   "info"=> "yes there names",
		   "container"=> $this->obj));
		}
	}

	function showContact($var){
		$this->obj = $this->obj->selectContactSearch($var);
		if(count($this->obj) == 0){
			return json_encode(array("status"=> "not found",
		"info"=> "not there results",
		"container"=> []));
		}else{
			return json_encode(array("status"=> "found",
		"info"=> "yes there results",
		"container"=> $this->obj));
		}	
	}

	function showTicketNav($input){
		$this->obj = $this->obj->selectTicketNav($input);
		if(count($this->obj) == 0){
			return json_encode(array("status"=> "not found",
		"info"=> "not there results",
		"container"=> []));
		}else{
			return json_encode(array("status"=> "found",
		"info"=> "yes there results",
		"container"=> $this->obj));
		}	
	}
}