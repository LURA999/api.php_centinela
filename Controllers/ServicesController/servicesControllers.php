<?php
include "../../Application/Services/services.php";

class servicesControllers {
	
   private $obj;

    function __construct(){
        $this->obj = new services();
    }

    	function createService($input){ 
	 try{
        $this->obj = $this->obj->insertService($input);
        return json_encode(array(
            "info" => "inserted",
            "status" => "inserted achieved"
        ));
    }catch(Exception $e){
        return json_encode(array(
            "info" => "fail",
            "status" => "inserted not successful"
        ));
    	}
    }

	function showService($cve){
	 $this->obj = $this->obj->selectService($cve);
        if(count($this->obj)==0){
        return json_encode(array(
            "info" => "not found",
            "status" => "not there Services",
            "container" => []
        ));
        }else{
        return json_encode(array(
            "info" => "found",
            "status" =>"there Services",
            "container" => $this->obj
        ));
        }
    }

    function showServiceIdMax(){
        $this->obj = $this->obj->selectServiceIdMax();
           if(count($this->obj)==0){
           return json_encode(array(
               "info" => "not found",
               "status" => "not there Services",
               "container" => []
           ));
           }else{
           return json_encode(array(
               "info" => "found",
               "status" =>"there Services",
               "container" => $this->obj
           ));
           }
       }

	function changeService($input){
	   try{
        $this->obj = $this->obj -> updateService($input);
        echo json_encode(array(
            'status' => 'ok',
            'info' => 'Service update',
            'container' => null
        ));
        }catch(Exception $e){
            return  json_encode(array('status'=>"error",
            'info'=>$e->getMessage(),
            'container'=>null));
        }
    }
	
	function deleteChangeService($cve){
    	   try{
        $this->obj = $this->obj -> deleteService($cve);
        echo json_encode(array(
            'status' => 'ok',
            'info' => 'Service deleted',
            'container' => null
        ));
    }catch(Exception $e){
        return  json_encode(array('status'=>"error",
        'info'=>$e->getMessage(),
        'container'=>null));
    }
  }
  
  function showViewService($cve,$cve2,$condicion){
    $this->obj = $this->obj->selectViewService($cve,$cve2,$condicion);
    if(count($this->obj)==0){
    return json_encode(array(
        "info" => "not found",
        "status" => "not there Services",
        "container" => []
    ));
    }else{
    return json_encode(array(
        "info" => "found",
        "status" =>"there Services",
        "container" => $this->obj
    ));
    }
}

function showService_maxIdFalso($cve){
    $this->obj = $this->obj->selectServiceIdFalseMax($cve);
    if(count($this->obj)==0){
    return json_encode(array(
        "info" => "not found",
        "status" => "not there Services",
        "container" => []
    ));
    }else{
    return json_encode(array(
        "info" => "found",
        "status" =>"there Services",
        "container" => $this->obj
    ));
    }
}
}
    
