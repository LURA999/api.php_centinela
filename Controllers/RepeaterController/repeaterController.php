<?php
include "../../Application/Repeater/repeater.php";

class repeaterController {
	private $obj;

	function __construct(){
	   $this->obj = new repeater();    
	}

	function createRepeater($input){
	   try{
	   $this->obj = $this->obj->insertRepeater($input);
	   return  json_encode(
		array("status"=> "acepted",
	   	"info"=> "repeater add"));

	   }catch(Exception $e){
	   return json_encode(array("status"=> "error",
	   	"info"=> "error"));
	   }
	}

	function showRepeater($cve){
	$this->obj = $this->obj->selectRepeater($cve);
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

	  function showRepeater2(){
		$this->obj = $this->obj->selectRepeater2();
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

	  function showRepeaterOnly($cve){
		$this->obj = $this->obj->selectRepeaterOnly($cve);
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

 	 function showAllRepeater($cve){
		$this->obj = $this->obj->selectAllRepeater($cve);
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

	function changeRepeater($input){
	try{
	   $this->obj = $this->obj->updateRepeater($input);
	   return  json_encode(
		array("status"=> "update",
	   	"info"=> "repeater update"));
	   }catch(Exception $e){
	   return json_encode(array("status"=> "error",
	   	"info"=> "error"));
	   }
	}

	function removeRepeater($cve){
	try{
		$this->obj = $this->obj->deleteRepeater($cve);
		return  json_encode(
			array("status"=> "update",
			"info"=> "repeater update"));
		}catch(Exception $e){
		return json_encode(array("status"=> "error",
			"info"=> "error"));
		}
	}

	function showSegmentRepeater($cve){
		$this->obj = $this->obj->selectSegmentRepeater($cve);
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
	function showSegmentRepeaterTipo($cve,$tipo){
		$this->obj = $this->obj->selectSegmentRepeaterTipo($cve,$tipo);
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
}
