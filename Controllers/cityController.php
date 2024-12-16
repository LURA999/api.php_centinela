<?php
include "../Application/city.php";

class cityController {
	private $obj ;
	function __construct(){
	  $this->obj = new city();    
	}

	function listCities(){
	   $this->obj = $this->obj->selectCities();
	   if(count($this->obj) == 0){
		echo json_encode(array(
			'status' => 'not found',
			'info' => 'city not found',
			'container' => []
		));
	}else{
		echo json_encode(array(
			'status' => 'ok',
			'info' => 'City found',
			'container' => $this->obj
		));
	}
	}

	function listCityOnly( $cve){
		$this->obj = $this->obj->selectCityOnly($cve);
		if(count($this->obj) == 0){
		 echo json_encode(array(
			 'status' => 'not found',
			 'info' => 'city not found',
			 'container' => []
		 ));
	 }else{
		 echo json_encode(array(
			 'status' => 'ok',
			 'info' => 'City found',
			 'container' => $this->obj
		 ));
	 }
}
}
