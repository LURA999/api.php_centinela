<?php
include "../../Application/Repeater/segment.php";

class segmentController {
	private $obj;
	function __construct(){
	   $this->obj = new segment();    
	}

	function createSegment($input){
	   try{
	   $this->obj = $this->obj->insertSegment($input);
	   return  json_encode(array("status"=> "acepted",
	   	"info"=> "segment add"));
	   }catch(Exception $e){
	   return json_encode(array("status"=> "error",
	   	"info"=> "error"));
	   }
	}

	function showSegment(){
	$this->obj = $this->obj->selectSegment();
	if(count($this->obj) == 0){
	    return json_encode(array("status"=> "not found",
	   "info"=> "not there segment",
	   "container"=>[]));
	}else{
	    return json_encode(array("status"=> "found",
	   "info"=> "yes there segment",
	   "container"=> $this->obj));
	}	
    }

	function showExist($cve){
		$this->obj = $this->obj->selectExist($cve);
		if(count($this->obj) == 0){
			return json_encode(array(
				"info" => "Not found",
				"status" => "Empty",
				"container" => []
			));
		}else{
			return json_encode(array(
				"info" => "Found",
				"status" => "There segments",
				"container" => $this->obj
			));
		}
	}
      
      function updateElimSegment($input){
	try{
	   $this->obj = $this->obj->changeSegment($input);
	   return  json_encode(
		array("status"=> "update",
	   	"info"=> "Segment update"));
	   }catch(Exception $e){
	   return json_encode(array("status"=> "error",
	   	"info"=> "error"));
	   }
	}

	function removeSegment($cve){
	$this->obj = $this->obj->deleteSegment($input);
	   return  json_encode(
		array("status"=> "delete",
	   	"info"=> "Segment delete"));
	}
	function actualizarSegment($input){
        $this->obj->updateSegment($input);
        return  json_encode(array('status'=>"ok",
        'info'=>"Segment updated",
        'container'=>null));

	}

	function lastSegmento(){
		$this->obj = $this->obj->lastSegmento();
		if(count($this->obj) == 0){
			return json_encode(array(
				"info" => "Not found",
				"status" => "Empty",
				"container" => []
			));
		}else{
			return json_encode(array(
				"info" => "Found",
				"status" => "There segments",
				"container" => $this->obj
			));
		}
	}
	


}