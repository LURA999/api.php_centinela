<?php
include "../../Application/Catalogo/plan.php";

class planController {
	private $obj ;
	function __construct(){
	  $this->obj = new plan();    
	}

	function listPlan(){
	   $this->obj = $this->obj->selectPlan();
	   if(count($this->obj) == 0){
		echo json_encode(array(
			'status' => 'not found',
			'info' => 'plan not found',
			'container' => []
		));
	}else{
		echo json_encode(array(
			'status' => 'ok',
			'info' => 'plan found',
			'container' => $this->obj
		));
	}
}
}