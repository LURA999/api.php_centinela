<?php
include "../../Application/Services/rs.php";

class rsControllers {
	
   private $obj;

    function __construct(){
        $this->obj = new rs();
    }

    	function createRS($input){ 
	 try{
        $this->obj = $this->obj->insertRS($input);
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

	function showRS($cve){
	 $this->obj = $this->obj->selectRS($cve);
        if(count($this->obj)==0){
        return json_encode(array(
            "info" => "not found",
            "status" => "not there RS",
            "container" => []
        ));
        }else{
        return json_encode(array(
            "info" => "found",
            "status" =>"there RS",
            "container" => $this->obj
        ));
        }
    }

    function showRSOnly($cve){
        $this->obj = $this->obj->selectRSOnly($cve);
           if(count($this->obj)==0){
           return json_encode(array(
               "info" => "not found",
               "status" => "not there RS",
               "container" => []
           ));
           }else{
           return json_encode(array(
               "info" => "found",
               "status" =>"there RS",
               "container" => $this->obj
           ));
           }
       }
	function changeRS($input){
	   try{
        $this->obj = $this->obj -> updateRS($input);
        echo json_encode(array(
            'status' => 'ok',
            'info' => 'RS deleted',
            'container' => null
        ));
    }catch(Exception $e){
        return  json_encode(array('status'=>"error",
        'info'=>$e->getMessage(),
        'container'=>null));
    }
  }
	
	function deleteChangeRS($cve){
    	   try{
        $this->obj = $this->obj -> deleteRS($cve);
        echo json_encode(array(
            'status' => 'ok',
            'info' => 'RS deleted',
            'container' => null
        ));
    }catch(Exception $e){
        return  json_encode(array('status'=>"error",
        'info'=>$e->getMessage(),
        'container'=>null));
    }
  }  

}
    
