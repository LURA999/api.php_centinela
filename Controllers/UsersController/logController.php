<?php
include "../../Application/Users/log.php";

class logController {

    private $obj;

    function __construct(){
        $this->obj = new log();
    }

    function createLog($input){
    try{
        $this->obj = $this->obj->insertLog($input);
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

   function showLog($cve){
    
        $this->obj = $this->obj->selectLog($cve);
        if(count($this->obj)==0){
        return json_encode(array(
            "info" => "not found",
            "status" => "not there Logs",
            "container" => []
        ));
        }else{
        return json_encode(array(
            "info" => "found",
            "status" =>"there Logs",
            "container" => $this->obj
        ));
        }
    }

    function deleteChangeLog($cve){
    
        try{
        $this->obj = $this->obj -> deleteLog($cve);
        echo json_encode(array(
            'status' => 'ok',
            'info' => 'log deleted',
            'container' => null
        ));
    }catch(Exception $e){
        return  json_encode(array('status'=>"error",
        'info'=>$e->getMessage(),
        'container'=>null));
    }
   }

    function changeLog($input){
       try{
        $this->obj = $this->obj -> updateLog($input);
        echo json_encode(array(
            'status' => 'ok',
            'info' => 'changed log',
            'container' => null
        ));
    }catch(Exception $e){
        return  json_encode(array('status'=>"error",
        'info'=>$e->getMessage(),
        'container'=>null));
    }
   }

}
