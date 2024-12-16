<?php
include "../../Application/Config/config.php";

class configController {
	private $obj;

	function __construct(){
		
	   $this->obj = new config();    
	}

	function createEmpresa($input){
	   try{
	   $this->obj = $this->obj->insertEmpresa($input);
	   return  json_encode(
		array("status"=> "acepted",
	   	"info"=> "empresa add"));

	   }catch(Exception $e){
	   return json_encode(array("status"=> "error",
	   	"info"=> "error"));
	   }
	}

	function showEmpresa(){
	$this->obj = $this->obj->selectEmpresa();
	if(count($this->obj) == 0){
	    return json_encode(array("status"=> "not found",
	   "info"=> "not there empresa",
	   "container"=> []));
	}else{
	    return json_encode(array("status"=> "found",
	   "info"=> "yes there empresa",
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

 	
	function changeEmpresa($input){
	try{
	   $this->obj = $this->obj->updateEmpresa($input);
	   return  json_encode(
		array("status"=> "update",
	   	"info"=> "repeater update"));
	   }catch(Exception $e){
	   return json_encode(array("status"=> "error",
	   	"info"=> "error"));
	   }
	}

	function changeImage($input){
		try{
		   $this->obj = $this->obj->updateImage($input);
		   return  json_encode(
			array("status"=> "update",
			   "info"=> "repeater update"));
		   }catch(Exception $e){
		   return json_encode(array("status"=> "error",
			   "info"=> "error"));
		   }
		}


		function changeLogo($input){
			try{
			   $this->obj = $this->obj->updateLogo($input);
			   return  json_encode(
				array("status"=> "update",
				   "info"=> "repeater update"));
			   }catch(Exception $e){
			   return json_encode(array("status"=> "error",
				   "info"=> "error"));
			   }
			}

	function removeEmpresa($cve){
		try{
			$this->obj = $this->obj->deleteEmpresa($cve);
			return  json_encode(
			 array("status"=> "update",
				"info"=> "repeater update"));
			}catch(Exception $e){
			return json_encode(array("status"=> "error",
				"info"=> "error"));
			}
		}


}
